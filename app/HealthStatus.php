<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthStatus extends Model
{

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'shoulder_width',
        'chest_circumference',
        'middle_circumference',
        'arm_circumference',
        'hip_circumference',
        'diseases'
    ];

    protected static $measures = [
        'weight',
        'height',
        'shoulder_width',
        'chest_circumference',
        'middle_circumference',
        'arm_circumference',
        'hip_circumference',
    ];

    public static function isValidMeasure($measure)
    {
        if (in_array($measure, static::$measures)) {
            return true;
        }
        return false;
    }

    public static function getDiseaseString($diseases)
    {
        $diseaseArray = [0, 0, 0, 0, 0];
        foreach ($diseases as $disease) {
            $diseaseArray[$disease] = 1;
        }
        return implode(',', $diseaseArray);
    }

}
