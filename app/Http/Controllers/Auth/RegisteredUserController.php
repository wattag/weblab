<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UserRegisterRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $groups = Group::orderBy('name')->get();

        return view('auth.register', compact('groups'));
    }

    public function store(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
