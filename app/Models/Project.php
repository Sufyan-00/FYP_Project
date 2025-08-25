<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supervisor_id',
        'title',
        'description',
        'status',
        'rejection_reason',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get ALL scope document versions for the project, ordered by newest first.
     */
    public function scopeDocuments(): HasMany
    {
        return $this->hasMany(ScopeDocument::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get only the MOST RECENT scope document for the project.
     * This is perfect for dashboards and simple views.
     */
    public function latestScopeDocument(): HasOne
    {
        return $this->hasOne(ScopeDocument::class)->latestOfMany();
    }
}