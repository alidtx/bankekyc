<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use App\Modules\User\Models\ClientSession;
use Closure;

/**
 * Description of UserAuthenticate
 *
 * @author muhtasim.sakib
 */
class UserAuthenticate {

    use ApiResponseTrait;

    public function handle($request, Closure $next) {
        if (ClientSession::where('session_key', $request->headers->get('session-key'))->first()) {
            return $next($request);
        }
        return $this->invalidResponse('Unauthorized ');
    }

}
