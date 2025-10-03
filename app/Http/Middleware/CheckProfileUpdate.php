<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Include the Log facade
use Symfony\Component\HttpFoundation\Response;

class CheckProfileUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Log the authenticated user details for debugging
        Log::debug('Authenticated user: ', ['user' => $user]);

        // Check if the user exists and if the profile is updated
        if ($user && !$this->profileUpdated($user) && !$this->isProfileEditRoute($request)) {
            Log::debug('User profile is not updated, redirecting to profile.edit');
            return redirect()->route('profile.edit');
        }

        // Log that the profile is updated and proceed
        Log::debug('Profile is updated or user is on the profile edit route, continuing request.');
        return $next($request);
    }

    /**
     * Check if the user's profile is complete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    protected function profileUpdated($user): bool
    {
        $profile = $user->profile;

        // Log the profile details to ensure we are checking the correct fields
        Log::debug('User profile fields:', [
            'phone_number' => $profile->phone_number ?? 'not set',
            'profile_picture' => $profile->profile_picture ?? 'not set',
            'description' => $profile->description ?? 'not set',
            'health_goals' => $profile->health_goals ?? 'not set',
        ]);

        return $profile &&
               !empty($profile->phone_number) &&
               !empty($profile->profile_picture) &&
               !empty($profile->description) && // Check if the description field is populated
               !empty($profile->health_goals);  // Check if the health_goals field is populated
    }

    /**
     * Determine if the current route is related to profile editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isProfileEditRoute(Request $request): bool
    {
        // Log the current route for debugging
        Log::debug('Current route: ', ['route' => $request->route()->getName()]);

        return $request->routeIs('profile.edit') || $request->routeIs('profile.update');
    }
}