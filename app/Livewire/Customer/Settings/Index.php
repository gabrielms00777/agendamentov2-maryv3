<?php

namespace App\Livewire\Customer\Settings;

use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Index extends Component
{
    use Toast, WithFileUploads;

    public $selectedTab = 'company';
    public $company;
    public $logo;
    public $tabs = [
        'company' => ['label' => 'Empresa', 'icon' => 'o-building-office'],
        'users' => ['label' => 'Usuários', 'icon' => 'o-users'],
        'whatsapp' => ['label' => 'WhatsApp', 'icon' => 'o-chat-bubble-left-ellipsis'],
        'permissions' => ['label' => 'Permissões', 'icon' => 'o-shield-check'],
    ];

    // Dados da empresa
    public $name;
    public $email;
    public $phone;
    public $address;

    // Novo usuário
    public $newUser = [
        'name' => '',
        'email' => '',
        'role' => 'user',
        'password' => '',
    ];

    public function mount()
    {
        $this->company = Company::find(Auth::user()->company_id);
        $this->loadCompanyData();
    }

    protected function loadCompanyData()
    {
        $this->name = $this->company->name;
        $this->email = $this->company->email;
        $this->phone = $this->company->phone;
        $this->address = $this->company->address;
    }

    public function saveCompany()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'nullable',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $validated['logo_url'] = Storage::url($path);
        }

        $this->company->update($validated);
        $this->success('Dados da empresa atualizados!');
    }

    public function createUser()
    {
        $validated = $this->validate([
            'newUser.name' => 'required|min:3',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.role' => 'required|in:admin,user',
            'newUser.password' => 'required|min:6',
        ]);

        User::create([
            'company_id' => $this->company->id,
            ...$validated['newUser'],
            'password' => bcrypt($validated['newUser']['password']),
        ]);

        $this->reset('newUser');
        $this->success('Usuário criado com sucesso!');
    }

    public function render()
    {
        return view('livewire.customer.settings.index');
    }
}
