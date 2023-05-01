<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParkingSpaceVehicle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parking_space_vehicles';

    public $fillable = [
        "vehicle_id",
        "parking_space_id"
    ];

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function parkingSpace(): HasOne
    {
        return $this->hasOne(ParkingSpace::class, 'id', 'parking_spaces_id');
    }
}
