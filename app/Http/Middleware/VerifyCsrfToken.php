<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'login_user', 'register', 'search', 'sendrequest', 'cancelrequest', 'acceptfrequest', 'change_password', 'success', 'failed', 'privacy_update', 'searchfilter', 'profile_update', 'upload_pic', 'refine_candidate_list', 'aadhar_upload','search_advance','search_side','create-category','profile_update_admin'
    ];
}
