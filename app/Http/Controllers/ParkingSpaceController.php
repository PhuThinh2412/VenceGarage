<?php

namespace App\Http\Controllers;

use App\Enum\ParkingSpaceStatusEnum;
use App\Enum\VehicleStatusEnum;
use App\Models\ParkingLevel;
use App\Models\ParkingSpace;
use App\Models\ParkingSpaceVehicle;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ParkingSpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::where('status', VehicleStatusEnum::IN_GARAGE)->get();
        $parkingLevels = ParkingLevel::all();
        return view('parking.space', ['vehicles' => $vehicles, 'parkingLevels' => $parkingLevels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) : RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|unique:vehicles|max:255',
        ]);
 

        
        $slot = ParkingSpace::where('status', ParkingSpaceStatusEnum::FREE)->first();
        // check available slot
        if ($slot == null) {
            $validator->errors()->add(
                'license_plate',
                'No parking space left!'
            );
            return redirect('slots')
                ->withErrors($validator);
        }

        if ($validator->fails()) {
            return redirect('slots')
                ->withErrors($validator);
        }
        
        DB::beginTransaction();
        try {
            $newVehicle = Vehicle::create([
                'license_plate' => $request->license_plate,
                'type' => $request->type,
                'status' => VehicleStatusEnum::IN_GARAGE
            ]);

            $newVehicle->parkingSpaceVehicle()->create([
                'parking_space_id' => $slot->id
            ]);

            $slot->status = ParkingSpaceStatusEnum::USING;
            $slot->save();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        return redirect('/slots');
    }

    /**
     * Add another level
     */
    public function storeLevel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_name' => 'required|max:255',
            'capacity' => 'required|numeric|max:2000',
        ]);
 
        if ($validator->fails()) {
            return redirect('slots')
                ->withErrors($validator);
        }
        try {
            $parkingLevel = ParkingLevel::create(
                [
                    'name' => $request->level_name,
                    'capacity' => $request->capacity,
                ]
            );

            $parkingSpaces = [];
            for ($i=1; $i<=$parkingLevel->capacity; $i++) {
                $parkingSpaces[] = [
                    'level_id' => $parkingLevel->id,
                    'name' => Str::random(6),
                    'status' => ParkingSpaceStatusEnum::FREE,
                ];
            }
            ParkingSpace::insert($parkingSpaces);
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        return redirect('/slots');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $listSpcace = ParkingSpace::with(['parkingLevel'])->get();
        $listLevel = ParkingLevel::all();
        $data = [];
        foreach($listLevel as $level) {
            $data[$level->id] = [
                'parkingLevel' => $level->name,
                'value' => $level->capacity,
                'name' => $level->name,
                'children' => [],
                'status' => ''
            ];
        }
        foreach($listSpcace as $space) {
            $data[$space->parkingLevel->id]['children'][] = [
                'parkingLevel' => $space->parkingLevel->name,
                'value' => $space->status == ParkingSpaceStatusEnum::USING->value ? 100 : 40,
                'name' => $space->name,
                'chidren' => [],
                'status' => $space->status == ParkingSpaceStatusEnum::USING->value ? 'In used' : 'Free'
            ];
        }
        return response()->json(array_values($data));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_parking_level' => 'required',
            'edit_capacity' => 'required|numeric|max:2000',
        ]);
 

        $parkingLevel = ParkingLevel::where('id', $request->edit_parking_level)->first();
        if ($parkingLevel == null) {
            $validator->errors()->add(
                'edit_parking_level',
                'Undefined parking level. Please try again.'
            );
            return redirect('slots')
                ->withErrors($validator);
        }
         if ($parkingLevel->capacity >= $request->edit_capacity) {
            $validator->errors()->add(
                'edit_capacity',
                'New capacity must be greater than old capacity.'
            );
            return redirect('slots')
                ->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            return redirect('slots')
                ->withErrors($validator)->withInput();
        }
        
        try {
            $leftSpace = $request->edit_capacity - $parkingLevel->capacity;
            $parkingLevel->capacity = $request->edit_capacity;
            $parkingLevel->save();
            for ($i=1; $i<=$leftSpace; $i++) {
                $parkingSpaces[] = [
                    'level_id' => $parkingLevel->id,
                    'name' => Str::random(6),
                    'status' => ParkingSpaceStatusEnum::FREE,
                ];
            }
            ParkingSpace::insert($parkingSpaces);
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        return redirect('/slots');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $vehicle = Vehicle::with(['parkingSpaceVehicle'])->where('license_plate', $request->license_plate)->first();
            $parkingSpace = ParkingSpace::where('id', $vehicle->parkingSpaceVehicle->id)->first();
            $parkingSpace->status = ParkingSpaceStatusEnum::FREE;
            $parkingSpace->save();
            $vehicle->parkingSpaceVehicle()->delete();
            $vehicle->delete();
            DB::commit();

            return redirect('/slots');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
