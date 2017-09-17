<?php

namespace App\Models;

use App\Http\Controllers\Classes\FeedbackClass;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    protected $table = FeedbackClass::TABLE_NAME;
    protected $primaryKey = FeedbackClass::ID;
    public $timestamps = true;
}
