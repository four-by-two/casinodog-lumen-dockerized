<?php

namespace App\Http\Controllers\Casinodog\API\ParentSessions;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Casinodog\Game\GameKernelTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GetParentSessionByToken extends BaseController
{
    use GameKernelTrait;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /*
    *   Get existing parent session details
    */
    public function handle(Request $request)
    {
        $this->validate($request, [
            'parent_sid' => Rule::requiredIf(!$request->player),
        ]);
        
        return $this->get_parent_session($request->internal_token);
    }
}
