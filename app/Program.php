<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //

    protected $fillable = ['title', 'section_count', 'interval_type', 'interval_count', 'type', 'level', 'diseases', 'bmi'];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function sections()
    {
        return $this->hasMany(ProgramSection::class, 'program_id');
    }

    /*public function translations()
    {
        return $this->hasMany(ProgramSection::class, 'program_id');
    }*/

     public static function getProgramsIdType($program_id=0){
        //this will return which type of program this.
        if($program_id !=0){
            $type = Program::select('type')->where('id',$program_id)->first();
            return $type;
        }
      }
    
}
