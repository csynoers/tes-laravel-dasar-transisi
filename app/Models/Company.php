<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'email', 'logo', 'website'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['employees',];

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
        
        $query->when($filters['email'] ?? false, function($query, $search) {
            return $query->where('email', 'LIKE',  '%' . $search. '%');
        });

        $query->when($filters['website'] ?? false, function($query, $search) {
            return $query->where('website', 'LIKE',  '%' . $search. '%');
        });
    }

     /**
     * Get the employees for the company.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company', 'name');
    }
}
