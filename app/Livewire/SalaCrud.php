<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Sala;

class SalaCrud extends Component
{
    public $salas, $nome, $sala_id;
    public $isEditing = false;

    public function mount()
    {
        $this->salas = Sala::all();
    }

    public function save()
    {
        $this->validate(['nome' => 'required|string|max:255']);

        Sala::create(['nome' => $this->nome]);

        session()->flash('message', 'Sala adicionada com sucesso!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $sala = Sala::findOrFail($id);
        $this->sala_id = $sala->id;
        $this->nome = $sala->nome;
        $this->isEditing = true;
    }
    public function cancelEdit()
    {
    $this->reset(['nome', 'isEditing']);
    }


    public function update()
    {
        $this->validate(['nome' => 'required|string|max:255']);

        Sala::findOrFail($this->sala_id)->update(['nome' => $this->nome]);

        session()->flash('message', 'Sala atualizada com sucesso!');
        $this->resetForm();
    }

    public function delete($id)
    {
        Sala::findOrFail($id)->delete();
        session()->flash('message', 'Sala eliminada com sucesso!');
        $this->salas = Sala::all();
    }

    private function resetForm()
    {
        $this->nome = '';
        $this->sala_id = null;
        $this->isEditing = false;
        $this->salas = Sala::all();
    }

    public function render()
    {
        return view('livewire.sala-crud');
    }
}
