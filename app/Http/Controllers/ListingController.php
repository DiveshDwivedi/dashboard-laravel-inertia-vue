<?php

namespace App\Http\Controllers;

use App\Http\Middleware\InactiveMiddleware;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function middleware()
    {
        return [new Middleware(['auth', 'verified', InactiveMiddleware::class], except: ['index', 'show'])];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listing::with('user:id,name')
            ->whereHas('user', function ($q) {
                $q->where('role', 'user');
            })
            ->active()
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Home', [
            'listings' => $listings,
            'searchItem' => request(['search'])['search'] ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);
        $validated = $this->hasValidInputs($request);

        if ($request->hasFile('image')) {
            $validated['image'] = Storage::disk('public')->put('images/listing', $request->image);
        }

        $validated['tags'] = $this->formatTags($validated['tags']);

        $request->user()->listings()->create($validated);

        return redirect()->route('dashboard')->with('message', 'Listing created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return Inertia::render('Listing/Show', [
            'listing' => $listing,
            'user' => $listing->user,
            'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
     
        Gate::authorize('modify', $listing);
        
        return Inertia::render('Listing/Edit', [
            'listing' => $listing,
            'message' => session('message'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);

        $validated = $this->hasValidInputs($request);

        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $validated['image'] = Storage::disk('public')->put('images/listing', $request->image);
        } else {
            $validated['image'] = $listing->image;
        }

        $validated['tags'] = $this->formatTags($validated['tags']);

        $listing->update([...$validated, 'status' => false]);

        return redirect()->route('listing.edit', [$listing->id])->with('message', 'Listing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('dashboard')->with('message', 'Listing deleted successfully');
    }

    /**
     * Validate Input Fields for Create and Update
     *
     * @param [type] $payload
     * @return boolean|mixed
     */
    protected function hasValidInputs($payload)
    {
        return $payload->validate([
            'title' => ['required', 'max:221'],
            'desc' => ['required', 'max:121'],
            'tags' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'image' => ['nullable', 'file', 'max:5242880', 'mimes:jpeg,jpg,png,webp,pdf'],
        ]);
    }

    /**
     * Formate tags and make it unique
     *
     * @param [type] $tags
     * @return void
     */
    protected function formatTags($tags)
    {
        // formating random tag entry 
        // $tagdata = $request->tags;
        // $tagArr = explode(',', $tagdata);
        // $tagTrim = array_map('trim', $tagArr);
        // $arrayUnique = array_unique($tagTrim)
        // $hasTag = array_filter($arrayUnique);

        return implode(',', array_filter(array_map('trim', array_unique(explode(',', $tags)))));
    }
}
