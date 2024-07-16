<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'vendor/upload-image',
        'admin/upload-image',
        'vendor/products/*',
        'vendor/orders/*',
        'vendor/users/*',
        'vendor/roles/*',
    ];
}
