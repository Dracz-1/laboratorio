<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';

    protected $fillable = [
        'carimbo_de_data_hora', 'equipamento', 'caracteristicas',
        'fotografia_url', 'fotografia_base64', 'quantidade',
        'localizacao', 'calibrado', 'manual_url', 'responsavel',
        'condicao_de_emprestimo', 'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function responsaveis()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel');
    }
    
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'localizacao');
    }
}

