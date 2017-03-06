<?php

namespace App;

use App\Custom\UserCapabilities;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Metable;

class User extends Authenticatable
{
    use Notifiable;
    use Metable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name', 'country', 'gender', 'birth_date', 'role', 'avatar', 'language'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $dates = ['birth_date'];

    public static $roles = [
        'admin' => 'Admin',
        'content-manager' => 'Content Manager',
        'doctor' => 'Doctor',
        'marketer' => 'Marketer',
        'seller' => 'Seller',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class, 'author');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'user_messages');
    }

    public function healthStatuses()
    {
        return $this->hasMany(HealthStatus::class);
    }

    public function healthHistory($measure)
    {
        return $this->healthStatuses()->select($measure, 'created_at')->oldest()->get();
    }

    public function diseases()
    {
        return $this->hasMany(Disease::class);
    }

    public function scopeOfRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeLast24Hours($query)
    {
        $yesterday = Carbon::now()->subDay()->toDateTimeString();
        return $query->where('created_at', '>', $yesterday);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('username', 'LIKE', "%$search%");
    }

    public function did($description)
    {
        $activity = new Activity(['ip_address' => request()->ip(), 'description' => $description]);
        $this->activities()->save($activity);
    }

    public function getIsAdminAttribute()
    {
        return $this->role == 'admin';
    }

    public function getIsDoctorAttribute()
    {
        return $this->role == 'doctor';
    }

    public function getIsSellerAttribute()
    {
        return $this->role == 'seller';
    }

    public function getIsContentManagerAttribute()
    {
        return $this->role == 'content-manager';
    }

    public static function diseaseString($diseases)
    {
        $diseaseArray = [0, 0, 0, 0, 0];
        foreach ($diseases as $disease) {
            $diseaseArray[$disease] = 1;
        }
        return implode(',', $diseaseArray);
    }

    public function hasUpdatedMeasuresAtLeastOnce()
    {
        return $this->metaFor('last_health_status_update');
    }

    public function daysSinceLastUpdate()
    {
        $last = $this->metaFor('last_health_status_update');
        if (!$last) {
            return false;
        }
        $then = Carbon::createFromTimestamp($last->value);
        return $then->diffInDays(Carbon::now());
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function lastLogin()
    {
        return $this->logins()->latest()->first();
    }

    public function hasLoggedIn()
    {
        return $this->lastLogin() ? true : false;
    }
}
