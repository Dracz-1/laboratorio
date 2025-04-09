<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Responsavel;

class CrudResponsavel extends Component
{
    public $responsaveis, $nome, $email, $departamento, $responsavel_id;
    public $isOpen = false;

    public function render()
    {
        $this->responsaveis = Responsavel::all();
        return view('livewire.crud-responsavel');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:responsaveis,email',
            'departamento' => 'nullable|string|max:255',
        ]);

        Responsavel::create([
            'nome' => $this->nome,
            'email' => $this->email,
            'departamento' => $this->departamento,
        ]);

        session()->flash('message', 'Responsável criado com sucesso.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $responsavel = Responsavel::findOrFail($id);
        $this->responsavel_id = $id;
        $this->nome = $responsavel->nome;
        $this->email = $responsavel->email;
        $this->departamento = $responsavel->departamento;

        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'email' => "required|email|unique:responsaveis,email,{$this->responsavel_id}",
            'departamento' => 'nullable|string|max:255',
        ]);

        $responsavel = Responsavel::findOrFail($this->responsavel_id);
        $responsavel->update([
            'nome' => $this->nome,
            'email' => $this->email,
            'departamento' => $this->departamento,
        ]);

        session()->flash('message', 'Responsável atualizado com sucesso.');

        $this->closeModal();
    }

    public function delete($id)
    {
        Responsavel::findOrFail($id)->delete();
        session()->flash('message', 'Responsável excluído com sucesso.');
    }

    private function resetInputFields()
    {
        $this->nome = '';
        $this->email = '';
        $this->departamento = '';
        $this->responsavel_id = null;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isOpen = false;
    }
}
