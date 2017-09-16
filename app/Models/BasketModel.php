<?php

namespace App\Models;

use App\Http\Controllers\Classes\BasketClass;
use Illuminate\Database\Eloquent\Model;

class BasketModel extends Model
{
    protected $table = BasketClass::TABLE_NAME;
    protected $primaryKey = BasketClass::ID;
    public $timestamps= false;
}
