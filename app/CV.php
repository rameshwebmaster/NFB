<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
   protected $table = 'cv_info';

   protected $fillable = ['name', 'description', 'role','avatar'];

   public static $roles = [
        'Doctor' => 'Doctor',
        'Trainer' => 'Trainer',
    
    ];
}
