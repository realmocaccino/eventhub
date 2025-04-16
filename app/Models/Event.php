<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'starts_at',
        'ends_at',
        'location',
        'price',
        'capacity',
        'image',
    ];

    protected $casts = [
        'starts_at' => 'datetime:Y-m-d H:i',
        'ends_at' => 'datetime:Y-m-d H:i',
    ];

    /**
     * The users attending the event.
     *
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
