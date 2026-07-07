<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Staff extends Model
{
    use HasFactory, HasUuids;
    
    protected $table = 'staff';

    protected $fillable = [
    'user_id',
    'bio',
    'avatar_url',
    'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'staff_service');
    }

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function timeOff()
    {
        return $this->hasMany(StaffTimeOff::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
