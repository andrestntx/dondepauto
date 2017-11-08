<?php

namespace App\Http\Controllers;

use App\Entities\Platform\ConfigModule;
use App\Entities\Views\Publisher;
use App\Http\Requests;
use App\Http\Requests\ConfigModuleRequest;

class ServicesController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function logos()
    {
        return ['logos' => Publisher::select(['id'])->get()->filter(function($publisher){
            return $publisher->has_logo;
        })->lists('full_logo', 'id')];
    }

    public function startConfig(ConfigModuleRequest $request)
    {
        $config = ConfigModule::setStartConfig($request->input('name'), $request->input('start'));

        return response()->json([
            'success' => true,
            'start' => $config->start
        ]);
    }
}
