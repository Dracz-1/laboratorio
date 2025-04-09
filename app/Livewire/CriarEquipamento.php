<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Sala;
use App\Models\Responsavel;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class CriarEquipamento extends Component
{
    use WithFileUploads; // Adiciona este trait

    public $equipamento;
    public $caracteristicas;
    public $condicao_de_emprestimo;
    public $localizacao;
    public $responsavel;
    public $salas;
    public $responsaveis;
    public $quantidade;
    public $calibrado;
    public $manual_url;
    public $fotografia; // Novo campo para a imagem

    public function mount()
    {
        $this->salas = Sala::all();
        $this->responsaveis = Responsavel::all();
    }

    public function guardar()
    {
        $this->validate([
            'equipamento' => 'required|string',
            'caracteristicas' => 'nullable|string',
            'condicao_de_emprestimo' => 'nullable|string',
            'localizacao' => 'required|exists:sala,id',
            'responsavel' => 'required|exists:responsaveis,id',
            'quantidade' => 'nullable|integer|min:0',
            'calibrado' => 'nullable|string',
            'manual_url' => 'nullable|url',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // Validação da imagem
        ]);
        
        if ($this->fotografia) {
            $this->validate([
                'fotografia' => 'image|max:10240', // Verificar tipo e tamanho da imagem
            ]);
    
            // Convertendo a imagem para base64
            $fotografia_base64 = base64_encode(file_get_contents($this->fotografia->getRealPath()));
        } else {
            $fotografia_base64 = null;
        }

        // Guardando o equipamento com a imagem em base64
        Equipamento::create([
            'equipamento' => $this->equipamento,
            'caracteristicas' => $this->caracteristicas,
            'condicao_de_emprestimo' => $this->condicao_de_emprestimo,
            'localizacao' => $this->localizacao,
            'responsavel' => $this->responsavel,
            'quantidade' => $this->quantidade,
            'calibrado' => $this->calibrado,
            'manual_url' => $this->manual_url,
            'fotografia_base64' => $fotografia_base64, // Salvando a imagem em base64
        ]);

        session()->flash('message', 'Equipamento criado com sucesso!');
        $this->reset([
            'equipamento', 'caracteristicas', 'condicao_de_emprestimo',
            'localizacao', 'responsavel', 'quantidade', 'calibrado', 'manual_url', 'fotografia',
        ]);
    }

    public function render()
    {
        return view('livewire.criar-equipamento');
    }
}
