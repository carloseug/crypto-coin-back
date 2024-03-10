<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinGroup extends Model
{
    use HasFactory;

    protected $table = 'coin_groups'; // Definindo o nome da tabela

    protected $fillable = [
        'coin_id',
        'group_id',
    ];

    protected $primaryKey = ['group_id','coin_id'];

    public $incrementing = false;

    public $timestamps = false;

    /**
     * Define a relação de pertencimento (belongsTo) com a model Coin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    /**
     * Define a relação de pertencimento (belongsTo) com a model Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
