<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionAssignment extends Model
{
    protected $fillable = [
        'defence_session_id',
        'user_id',
        'scores_json',
        'total_score',
        'remarks',
        'submitted_at',
    ];

    protected $casts = [
        'scores_json' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(DefenceSession::class, 'defence_session_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isSubmitted(): bool
    {
        return !is_null($this->submitted_at);
    }
}