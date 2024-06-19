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
        'user-auth/register',
        'user-auth/login',
        'admin/design/tool-save',
        'admin/save-profile-image',
        'admin/save-profile-cover-image',
        'admin/login',
        'admin',
    ];
}
