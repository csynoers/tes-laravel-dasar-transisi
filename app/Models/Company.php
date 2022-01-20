<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'email', 'logo', 'website'];

    /**
     * Scope a query to only include filter companies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['term'] ?? false, function($query, $term) {
            return $query->where('name', 'LIKE',  '%' . $term. '%')->orderBy('name');
        });
    }
}
