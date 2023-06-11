<?php

namespace App\Http\Middleware;

use App\Contracts\CSVReportServiceInterface;
use App\services\CSVReports\CSVReportEmployeeService;
use App\services\CSVReports\CSVReportPrincipalService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            return redirect('home');
        }

        return $next($request);
    }
}
