<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutritionGuide extends Model
{
   
    protected $table = 'neutrition_guide';

    protected $fillable = ['title','arabic_title','description','arabic_description'];
}
