<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::firstOrCreate([
            'fb_id' => $fbUser->getId(),
        ], [
            'name' => $fbUser->getName(),
            'email' => $fbUser->getEmail(),
            'fb_id' => $fbUser->getId(),
            'profile_photo_path' => $fbUser->getAvatar(),
            'current_team_id' => env('CUSTOMER_ID'),
        ]);

        // $user = User::where('fb_id', $fbUser->id)->first();

        // if (!$user) {
        //     $user = User::create([
        //         'name' => $fbUser->name,
        //         'email' => $fbUser->email,
        //         'fb_id' => $fbUser->id,
        //         'current_team_id' => env('CUSTOMER_ID'),
        //     ]);
        // }

        auth()->login($user, true);

        return redirect('dashboard');
    }
}
