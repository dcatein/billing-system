<?php

namespace App\Support\Tenancy;

use Closure;
use Illuminate\Http\Request;
use App\Domains\Tenancy\Models\Tenant;

class ResolveTenant
{
    public function handle(Request $request, Closure $next)
    {
        $tenantId = $request->header('X-Tenant');

        if (!$tenantId) {
            abort(400, 'Tenant not provided');
        }

        $tenant = Tenant::findOrFail($tenantId);

        app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}