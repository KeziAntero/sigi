<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Owner extends Model
{
    protected $fillable = [
        'name_owner','cpf',
     ];

    use HasFactory;
    
        /**
         * Get the imovel that owns the Owner
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function imoveis() {
            #Um Proprietário pode ter vários imóveis
            #em vez de belongsTo (Pertence á) é hasMany (Tem muitos)
            return $this->hasMany(Imovel::class);
        }
   /**
 * 
 *
 * @param  int  $ownerId
 * @return \Illuminate\Database\Eloquent\Collection
 */
public static function searchByCpf($cpf)
{
    return static::where('cpf', $cpf)->firstOrFail();
}


}
