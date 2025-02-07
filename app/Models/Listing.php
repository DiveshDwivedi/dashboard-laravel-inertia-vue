<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters) {
        if (isset($filters['search'])) {
           $query->where(function ($q) use ($filters) {
               $q
               ->where('title', 'like', '%' . $filters['search'] . '%')
               ->where('desc', 'like', '%' . $filters['search'] . '%');
           });
        }

        if (isset($filters['user_id'])) {
            $query
           ->where('user_id', $filters['user_id']);
        }

        if (isset($filters['tag'])) {
            $query
           ->where('tags', 'like', '%' . $filters['tag'] . '%');
        }
    }

    public function scopeActive($query) {
        return $query->where('status', 1);
    }
}
