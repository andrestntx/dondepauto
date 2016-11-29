<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 11/29/16
 * Time: 11:23 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin/documents');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(Request $request)
    {
        if($request->file('rut')) {
            $request->file('rut')->move('documents/publishers', 'rut_donde_pauto.pdf');
        }

        if($request->file('commerce')) {
            $request->file('commerce')->move('documents/publishers', 'camara_comercio.pdf');
        }

        if($request->file('bank')) {
            $request->file('bank')->move('documents/publishers', 'certificacion_bancaria.pdf');
        }

        return redirect()->route('documents');
    }
}