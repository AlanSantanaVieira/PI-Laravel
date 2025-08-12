<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCadastro;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Dotme;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DotmeController extends Controller
{
    public function create(FormRequestCadastro $request){
        if($request->method() == "POST"){
            $data = $request->all();

            Dotme::create($data);

            return redirect('log');
        }

        return view('log');
    }

    public function login(Request $request)
    {
        $user = DB::table('cadastro')->where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // Login bem-sucedido
                // return redirect()->route('index');
                return redirect('/');

            } else {
                return back()->with('error', 'Senha incorreta.');
            }
        } else {
            return back()->with('error', 'E-mail não encontrado.');
        }
    }
}
