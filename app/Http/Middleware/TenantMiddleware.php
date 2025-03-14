<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is authenticated and has a tenant_id
        if (!$request->user() || !$request->user()->tenant_id) {
            abort(403, 'Tenant not found.');
        }

        // For route model binding, ensure the model belongs to the current tenant
        $route = $request->route();
        if ($route) {
            $parameters = $route->parameters();
            foreach ($parameters as $parameter) {
                if ($parameter && method_exists($parameter, 'getTenantId')) {
                    if ($parameter->getTenantId() !== $request->user()->tenant_id) {
                        abort(403, 'This resource belongs to a different tenant.');
                    }
                }
            }
        }

        return $next($request);
    }
}
