<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isPublisher()) {
            $publisher = auth()->user()->publisher;

            /*if($publisher->complete_data && $publisher->spaces()->count() == 0) {
                return view('publisher.home-no-spaces')->with('publisher', $publisher);
            }
            else if(! $publisher->complete_data) {
                return redirect()->route('medios.account', $publisher);
            }*/

            if(! $publisher->complete_data) {
                return redirect()->route('medios.account', $publisher);
            }

            //var_dump($publisher->user->password);
            //dd($publisher->password);

            return view('publisher.dashboard')->with('publisher', $publisher);
        }

        return view('home');
    }
}
