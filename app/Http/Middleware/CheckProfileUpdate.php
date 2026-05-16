<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
     * ONLY requires city and phone_number to be filled.
     * All other fields (country, description, health_goals, profile_picture) are optional.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    protected function profileUpdated($user): bool
    {
        $profile = $user->profile;

        // If no profile exists, it's not updated
        if (!$profile) {
            Log::debug('No profile found for user');
            return false;
        }

        // Log the profile details for debugging
        Log::debug('User profile fields:', [
            'city' => $profile->city ?? 'not set',
            'phone_number' => $profile->phone_number ?? 'not set',
            'country' => $profile->country ?? 'not set',
            'description' => $profile->description ?? 'not set',
            'health_goals' => $profile->health_goals ?? 'not set',
            'profile_picture' => $profile->profile_picture ?? 'not set',
        ]);

        // ONLY check for REQUIRED fields: city AND phone_number
        // Description, health_goals, profile_picture, and country are OPTIONAL
        $isUpdated = !empty($profile->city) && !empty($profile->phone_number);

        Log::debug('Profile updated check result:', [
            'city_present' => !empty($profile->city),
            'phone_present' => !empty($profile->phone_number),
            'is_updated' => $isUpdated
        ]);

        return $isUpdated;
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
