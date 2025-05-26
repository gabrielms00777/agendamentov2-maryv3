<?php

namespace App\Livewire\Auth;

use App\Models\Company;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

#[Title('Login')]
#[Layout('components.layouts.auth')]
class Register extends Component
{
    // Dados da Empresa
    #[Rule('required|min:3')]
    public string $company_name = '';

    #[Rule('required')]
    public string $company_phone = '';

    // Dados do Usuário Admin
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('required|email|unique:users,email')]
    public string $email = '';

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    #[Rule('required')]
    public string $password_confirmation = '';

    public function mount()
    {
        // It is logged in
        if (Auth::check()) {
            return redirect('/');
        }
    }

    public function register()
    {
        $validated = $this->validate();

        try {
            DB::transaction(function () use ($validated) {
                // Cria a empresa
                $company = Company::create([
                    'name' => $validated['company_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['company_phone'],
                ]);

                // Cria o usuário admin
                $user = User::create([
                    'company_id' => $company->id,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'admin',
                ]);

                Auth::login($user);

                request()->session()->regenerate();
            });

            return redirect()->route('onboarding');
        } catch (\Exception $e) {
            $this->addError('registration', 'Ocorreu um erro durante o registro. Por favor, tente novamente.');
            // Log::error('Registration error: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
