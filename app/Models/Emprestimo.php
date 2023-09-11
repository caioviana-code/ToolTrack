<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emprestimo extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ferramenta_id',
        'funcionario',
        'quantidade',
        'status'
    ];

    public function ferramenta() {
        return $this->belongsTo('App\Models\Ferramenta');
    }
}
