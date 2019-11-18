<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $attributes = [
        'status' => 3,
        'priority' => 1,
        'tracker' => 1
    ];

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'status',
        'priority',
        'due_date',
        'tracker',
        ];

    public function getStatusAttribute($attribute)
    {
        return $this->statusOptions()[$attribute];
    }

    public function getPriorityAttribute($attribute)
    {
        return $this->priorityOptions()[$attribute];
    }

    public function getTrackerAttribute($attribute)
    {
        return $this->trackerOptions()[$attribute];
    }

    public function statusOptions()
    {
        return [
            0 => 'New',
            1 => 'Open',
            2 => 'Pending',
            3 => 'On-hold',
            4 => 'Solved'
        ];
    }

    public function trackerOptions()
    {
        return [
            0 => 'Bug',
            1 => 'Feature',
            2 => 'Support',
        ];
    }

    public function priorityOptions()
    {
        return [
            0 => 'Low',
            1 => 'Normal',
            2 => 'High',
            3 => 'Very High'
        ];
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
