<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable=['original_name','file_name','size','mime_type', 'ext'];

}
