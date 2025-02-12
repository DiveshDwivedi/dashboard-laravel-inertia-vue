<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Admin's Dashboard 
     *
     * @return void
     */
    public function index() {
        $users = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(15)
            ->withQueryString();
            
        return Inertia::render('Admin/AdminDashboard', [
            'users' => $users,
            'status' => session('status'),
        ]);
    }

    public function show(User $user) {
        $user_listings = $user->listings()
            ->latest()
            ->filter(request(['search', 'inactive']))
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/UserDetails', [
            'user' => $user,
            'listings' => $user_listings,
            'status' => session('status'),
        ]);
    }
    /**
     * Role update by admin
     *
     * @param Request $request
     * @param User $user
     */
    public function role(Request $request, User $user) {
        Gate::authorize('admin', $user);

        $request->validate(['role' => 'required|string|min:4|max:11']);

        if (Auth::user()->role === 'admin' && $user->id !== Auth::user()->id) {
            
            $user->update(['role' => $request->role]);

            return redirect()->route('index')->with(['status' => 'Role updated successfully']);
        } 

        return redirect()->route('index')->with(['status' => 'Admin role cann\'t change by self']);  
    }

    /**
     * 
     *
     * @param Listing $listing
     * @return void
     */
    public function updateStatus(Listing $listing) {
        Gate::authorize('admin', $listing);
    
        $listing->update(['status' => !$listing->status]);

        $msg = $listing->status ? 'Active' : 'Inactive';
        
        return back()->with(['status' => "Listing status updated to {$msg} successfully"]);
    }
}
