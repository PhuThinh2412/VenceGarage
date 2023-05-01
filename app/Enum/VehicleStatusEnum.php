<?php

namespace App\Enum;

enum VehicleStatusEnum: int {
    case IN_GARAGE = 1;
    case NOT_IN_GARAGE = 0;
}