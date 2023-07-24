<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    protected $table = 'parser_status';


    protected $fillable = [
        'date',
        'state',
    ];


}
