<?php

namespace App\Http\Middleware;

use App\Contracts\CSVReportServiceInterface;
use App\services\CSVReports\CSVReportEmployeeService;
use App\services\CSVReports\CSVReportPrincipalService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttachServiceBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // user have to be logged
        if (!$request->user()) {
            abort(403);
        }

        app()->bind(
            CSVReportServiceInterface::class,
            match ($request->user()->roles->first()->name) {
                'principal' => CSVReportPrincipalService::class,
                'employee' => CSVReportEmployeeService::class,
            }
        );

        return $next($request);
    }
}
