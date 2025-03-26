<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request){
        $usersResetToken =  DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->where('expires_in', '>=', Carbon::now('asia/manila'));

        $resetTokenExist = $usersResetToken->first();
           
        if(!$resetTokenExist){
            return $this->unauthorized('Expired or Invalid Token');
        }

        User::where('email', $resetTokenExist->email)
            ->update(['password' => Hash::make($request->password)]);

        $usersResetToken->delete();

        return $this->ok('Successfully Reset Password');

    }
    public function resetPasswordForm(string $token){
        return (
            "<form>
            <input type='text' value='$token'/>
            </form>"
        );
    }
}
