<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function authenticated(Request $request, $user)
    {
        // Check if the user is an admin
        if ($user->is_admin) {
            // Set a cookie for admins
            Cookie::queue('admin_cookie', 'admin_value', 60); // 60 minutes expiration
        }

        // Redirect to the welcome page after login
        return redirect('/');
    }
}
