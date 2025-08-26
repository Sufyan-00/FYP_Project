<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DefenceSession extends Model
{
    protected $fillable = [
        'committee_id',
        'project_id',
        'scheduled_at',
        'venue',
        'status',
        'scheduled_by_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(SessionAssignment::class);
    }
}