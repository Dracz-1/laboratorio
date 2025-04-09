<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'sala';
    public $timestamps = false; // Desativa os timestamps

    protected $fillable = ['nome'];

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'localizacao');
    }
}
