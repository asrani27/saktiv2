<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Handle logout request.
     */
    public function __invoke(Request $request)
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login');
    }
}