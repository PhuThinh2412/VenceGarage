<?php

namespace App\Enum;

enum ParkingSpaceStatusEnum: int {
    case USING = 1;
    case FREE = 0;
}