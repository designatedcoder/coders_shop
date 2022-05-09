<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'min:3', 'max:100', Rule::unique('users')->ignore($user->id)],
            'address' =>  ['required', 'string', 'min:3', 'max:50'],
            'city' =>  ['required', 'string', 'min:2', 'max:20'],
            'state' =>  ['required', 'string', 'min:2', 'max:20'],
            'zip_code' =>  ['required', 'string', 'min:5', 'max:15'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
            $user->billingDetails->forceFill([
                'address' => $input['address'],
                'city' => $input['city'],
                'state' => $input['state'],
                'zip_code' => $input['zip_code'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();
        $user->billingDetails->forceFill([
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'zip_code' => $input['zip_code'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
