<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkingSpace extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parking_spaces';

    public $fillable = [
        "level_id",
        "name",
        "status",
    ];

    public function parkingLevel(): BelongsTo
    {
        return $this->belongsTo(ParkingLevel::class, 'level_id', 'id');
    }
}
