<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    public $fillable = [
        "license_plate",
        "status",
        "type"
    ];
    
    public function vehicleType(): HasOne
    {
        return $this->hasOne(VehicleType::class, 'id', 'type');
    }

    public function parkingSpaceVehicle(): HasOne
    {
        return $this->hasOne(ParkingSpaceVehicle::class, 'vehicle_id', 'id');
    }
}
