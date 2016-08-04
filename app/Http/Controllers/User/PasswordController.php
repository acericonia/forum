<?php

namespace Forum\Http\Controllers\User;

use Forum\Http\Controllers\Controller;
use Forum\Http\Requests\User\UpdateUserPasswordFormRequest;
use Forum\Models\User;

class PasswordController extends Controller
{
    /**
     * Update user's password.
     *
     * @param int                           $id
     * @param UpdateUserPasswordFormRequest $request
     * @param Forum\Models\User             $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateUserPasswordFormRequest $request, User $user)
    {
        $user = $user->findOrFail($id);

        $user->password = bcrypt($request->input('password'));

        $user->update();

        notify()->flash('Success', 'success', [
            'text'  => 'User\'s password has been updated.',
            'timer' => 2000,
        ]);

        return redirect()->back();
    }
}
