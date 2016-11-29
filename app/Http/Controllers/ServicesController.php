<?php

namespace App\Http\Controllers;

use App\Entities\Proposal\Proposal;
use App\Entities\Views\Publisher;
use App\Entities\Views\Space;
use App\Http\Requests;
use Illuminate\Http\Request;

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
}
