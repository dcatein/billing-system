<?php

namespace App\Domains\Tenancy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'slug',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Usuários pertencentes ao tenant
     */
    public function users()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'tenant_users',
            'tenant_id',
            'user_id'
        )->withPivot('role')
         ->withTimestamps();
    }

    /**
     * Produtos do tenant
     */
    public function products()
    {
        return $this->hasMany(
            \App\Domains\Products\Models\Product::class,
            'tenant_id'
        );
    }
 
    /**
     * Clientes do tenant
     */
 //   public function customers()
    // {
       //  return $this->hasMany(
          //   \App\Domains\Customers\Models\Customer::class,
 //            'tenant_id'
 //        );
  //   }

    /**
     * Orders do tenant
     */
 //    public function orders()
  //   {
  //       return $this->hasMany(
  //           \App\Domains\Orders\Models\Order::class,
  //           'tenant_id'
  //       );
  //   }


}