<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramType extends Model
{
      protected $table = 'program_type';

      protected $fillable = ['name', 'description', 'status','type_value'];

      public static function getCurrentProgramType(){
      	//this will return the current program type which is active(Regular,Ramadan)
      
  		$type = ProgramType::select('type_value')->where('status', 'Active')->first();
  		return $type;
      	
      }

}
