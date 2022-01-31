<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'company', 'email', 'status'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['company',];

    /**
     * Scope a query to only include filter employees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['name'] ?? false, function($query, $search) {
            return $query->where('name', 'LIKE',  '%' . $search. '%');
        });
        
        $query->when($filters['company'] ?? false, function($query, $search) {
            return $query->where('company', 'LIKE',  '%' . $search. '%');
        });
        
        $query->when($filters['email'] ?? false, function($query, $search) {
            return $query->where('email', 'LIKE',  '%' . $search. '%');
        });
    }

    /**
     * Get the company that owns the employee.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company', 'name');
    }
}
