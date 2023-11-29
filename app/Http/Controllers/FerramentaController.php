<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Ferramenta;
use Illuminate\Http\Request;

class FerramentaController extends Controller {
    
    public function index() {

        $data = Ferramenta::all();
        return view('ferramentas.index', compact('data'));
    }

    public function create() {
        
        return view('ferramentas.create');
    }

    public function store(Request $request) {

        $regras = [
            'nome' => 'required',
            'tipo' => 'required',
            'marca' => 'required',
        ];

        $msgs = [
            "required" => 'O preenchimento do campo :attribute é obrigatório!',
        ];

        $request->validate($regras, $msgs);

        Ferramenta::create([
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'quantidadeDisponivel' => $request->quantidade,
            'quantidadeEmprestada' => 0,
            'quantidadeReservada' => 0
        ]);

        return redirect()->route('ferramentas.index');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
        $data = Ferramenta::find($id);

        if (!isset($data)) {return "<h1>ID: $id não encontrado!</h1>";}

        return view('ferramentas.edit', compact('data'));
    }

    public function update(Request $request, $id) {

        $regras = [
            'nome' => 'required',
            'tipo' => 'required',
            'marca' => 'required',
        ];

        $msgs = [
            "required" => 'O preenchimento do campo :attribute é obrigatório!',
        ];

        $request->validate($regras, $msgs);
        
        $obj = Ferramenta::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $obj->fill([
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'quantidadeDisponivel' => $request->quantidade
        ]);

        $obj->save();

        return redirect()->route('ferramentas.index');
    }

    public function destroy($id) {
        
        $obj = Ferramenta::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $obj->destroy($id);

        return redirect()->route('ferramentas.index');
    }

}
