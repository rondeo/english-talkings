<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    protected $table = 'facts';

    protected $guarded = ['id'];
}
