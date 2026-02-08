<?php
namespace App\Traits;

use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->company_id = Auth::user()->company_id;
            }
        });
    }
}