<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Equipamento;
use App\Models\Sala;
use App\Models\Responsavel;


class InventarioEquipamentos extends Component
{
    use WithPagination, WithFileUploads;

    public $modoEdicao = false;
    public $novaImagem;
    public $dadosEdicao = [];

    public $search = '';
    public $selectedLocation = [];
    public $selectedResponsavel = [];
    public $locations;
    public $responsaveis;
    public $equipamentoSelecionado = null;
    public $novaFotografia = null; // Campo para a nova imagem

    protected $queryString = ['search', 'selectedLocation', 'selectedResponsavel'];

    public function mount()
    {
        $this->locations = Sala::all();
        $this->responsaveis = Responsavel::all();
    }

    public function buscarEquipamentos()
    {
        $this->resetPage();
    }

    public function limparProcura()
    {
        $this->search = '';
        $this->selectedLocation = [];
        $this->selectedResponsavel = [];
        $this->resetPage();
    }

    // Método para selecionar o equipamento


        public function selecionarEquipamento($equipamentoId)
    {
        $this->equipamentoSelecionado = Equipamento::with(['sala', 'responsaveis'])->find($equipamentoId);
        $this->dadosEdicao = $this->equipamentoSelecionado->toArray();
        $this->modoEdicao = false;
    }

    public function editarEquipamento()
    {
        $this->modoEdicao = true;
    }

    public function cancelarEdicao()
    {
        $this->modoEdicao = false;
        $this->dadosEdicao = $this->equipamentoSelecionado->toArray(); // Repor os valores
        $this->novaImagem = null;
    }

    public function guardarEdicao()
    {
        $equipamento = $this->equipamentoSelecionado;

        $equipamento->update($this->dadosEdicao);

        if ($this->novaImagem) {
            $imagemBase64 = base64_encode(file_get_contents($this->novaImagem->getRealPath()));
            $equipamento->fotografia_base64 = $imagemBase64;
            $equipamento->save();
        }

        $this->equipamentoSelecionado = $equipamento->fresh(['sala', 'responsaveis']);
        $this->modoEdicao = false;
    }

    // Método para editar o equipamento
    public function editar()
    {
        $this->validate([
            'equipamentoSelecionado.equipamento' => 'required|string',
            'equipamentoSelecionado.caracteristicas' => 'nullable|string',
            'equipamentoSelecionado.condicao_de_emprestimo' => 'nullable|string',
            'equipamentoSelecionado.localizacao' => 'required|exists:sala,id',
            'equipamentoSelecionado.responsavel' => 'required|exists:responsaveis,id',
            'novaFotografia' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // Validação da imagem
        ]);

        if ($this->novaFotografia) {
            $fotografiaBase64 = base64_encode(file_get_contents($this->novaFotografia->getRealPath()));
            $this->equipamentoSelecionado->fotografia_base64 = $fotografiaBase64;
        }

        $this->equipamentoSelecionado->save();

        session()->flash('message', 'Equipamento atualizado com sucesso!');
        $this->fecharModal(); // Fechar o modal após salvar
    }

    // Método para fechar o modal
    public function fecharModal()
    {
        $this->equipamentoSelecionado = null; // Reseta a variável para fechar o modal
    }

    public function render()
    {
        $query = Equipamento::with(['sala', 'responsaveis']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('equipamento', 'like', '%' . $this->search . '%')
                  ->orWhere('caracteristicas', 'like', '%' . $this->search . '%')
                  ->orWhere('condicao_de_emprestimo', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedLocation)) {
            $query->whereIn('localizacao', $this->selectedLocation);
        }

        if (!empty($this->selectedResponsavel)) {
            $query->whereIn('responsavel', $this->selectedResponsavel);
        }

        $equipamentos = $query->paginate(10);

        return view('livewire.inventario-equipamentos', compact('equipamentos'));
    }
}
