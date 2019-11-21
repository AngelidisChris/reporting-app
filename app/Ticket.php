<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use \Venturecraft\Revisionable\RevisionableTrait;

class Ticket extends Model
{
    use RevisionableTrait;
    use Sortable;

    protected $revisionCreationsEnabled = true;


    public $sortable = ['id','title','body', 'status','priority','created_at', 'due_date', 'tracker', 'assigned_to'];


    protected $dates = [
        'created_at',
        'updated_at',
        'due_date'
    ];

    public function setDueDateAttribute($due_date)
    {
        $this->attributes['due_date'] = $due_date ? Carbon::parse($due_date) : null;
    }

    public function setCreatedAtAttribute($created_at)
    {
        $this->attributes['created_at'] = Carbon::parse($created_at);
    }

    public function setUpdatedAtAttribute($updated_at)
    {
        $this->attributes['updated_at'] = Carbon::parse($updated_at);
    }

    protected $attributes = [
        'status' => 0,
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
        'assigned_to'
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

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
