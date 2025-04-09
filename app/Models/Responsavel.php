<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';

    protected $fillable = ['nome', 'email', 'departamento', 'data_criacao'];

    public $timestamps = false;

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'responsavel');
    }
}