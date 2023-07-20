<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';


    protected $fillable = [
        'date',
        'currency_id',
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value',
    ];


}
