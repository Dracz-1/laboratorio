<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CrudUser extends Component
{
    public $users, $name, $email, $password, $user_id;
    public $isOpen = false;

    public function render()
    {
        $this->users = User::all();
        return view('livewire.crud-user');
    }

    public function criar()
    {
        $this->resetCampos();
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->isOpen = true;
    }

    public function fecharModal()
    {
        $this->isOpen = false;
    }

    public function resetCampos()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->user_id = null;
    }

    public function guardar()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'Utilizador criado com sucesso.');
        $this->fecharModal();
        $this->resetCampos();
    }

    public function editar($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->abrirModal();
    }

    public function atualizar()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
        ]);

        $user = User::findOrFail($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $this->validate(['password' => 'min:6']);
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'Utilizador atualizado com sucesso.');
        $this->fecharModal();
        $this->resetCampos();
    }

    public function eliminar($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Utilizador eliminado com sucesso.');
    }
}
