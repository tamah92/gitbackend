<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sources;
use App\Models\Catagories;
use App\Models\UserSettings;
use App\Models\UserSettingsCatagories;

class UserSettingsController extends Controller
{

    function getSources() {
        try {
            $data = Sources::select('id', 'label')->get();

            $args = [];

            foreach ($data as $row) {
                $args[] = ['label' => $row->label, 'value' => $row->id];
            }

            return response()->json([
                "data" => $args,
                "message" => "Data successfully retrieved",
                "status" => 200,
                ], 
            200);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'trace' => $th->getTrace(),
                'status' =>  422
            ], 422);
        }
    }

    function getCatagories(Request $request) {
        try {
            $data = Catagories::select('id', 'label')->where('source_id', $request->source_id)->get();
            
            $args = [];

            foreach ($data as $row) {
                $args[] = ['label' => $row->label, 'value' => $row->id];
            }

            return response()->json([
                "data" => $args,
                "message" => "Data successfully retrieved",
                "status" => 200,
                ], 
            200);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'trace' => $th->getTrace(),
                'status' =>  422
            ], 422);
        }
    }

    function saveUserSettings(Request $request) {
        try {
            $userSettings = UserSettings::updateOrCreate(
                ['user_id' => $request->user_id],
                ['source_id' => $request->source_id]
            );

            $deleted = UserSettingsCatagories::where('settings_id', $userSettings->id)->delete();

            foreach ($request->catagories_ids as $catagory) {
                $addSettingsCatagory = new UserSettingsCatagories;
                $addSettingsCatagory->settings_id = $userSettings->id;
                $addSettingsCatagory->catagory_id = $catagory;
                $addSettingsCatagory->save();
            }

            return response()->json([
                "data" => [],
                "message" => "Data successfully added",
                "status" => 200,
                ], 
            200);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'trace' => $th->getTrace(),
                'status' =>  422
            ], 422);
        }
    }
}
