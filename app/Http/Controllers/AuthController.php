<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Ingresa tu correo electrónico.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'Ingresa tu contraseña.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('posts.index'))
                ->with('success', 'Sesión iniciada como ' . Auth::user()->name . '.');
        }

        return back()->withErrors([
            'email' => 'El correo electrónico o la contraseña no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
            'role' => ['required', 'in:admin,user'],
        ], [
            'name.required' => 'Ingresa tu nombre completo.',
            'email.required' => 'Ingresa un correo electrónico.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'Ingresa una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            'role.required' => 'Selecciona el tipo de cuenta.',
            'role.in' => 'El rol seleccionado no es válido.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Cuenta creada correctamente. Bienvenido, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
