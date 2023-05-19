<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImovelImage extends Model
{
    use HasFactory;

     protected $fillable = [
        'imovel_id', 'path',
    ];


    public function images()
    {
        return $this->hasMany(ImovelImage::class);
    }

    public function imovel()
    {
        return $this->belongsTo(Imovel::class);
    }

}