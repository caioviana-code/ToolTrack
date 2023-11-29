<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Ferramenta;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller {
    
    public function index() {
        
        $data = Reserva::with('ferramenta')->get();

        return view('reservas.index', compact('data'));
    }
 
    public function create() {
        
        $ferramentas = Ferramenta::all();

        return view('reservas.create', compact('ferramentas'));
    }

    public function store(Request $request) {
        
        $ferramenta = Ferramenta::find($request->ferramenta_id);
        $quantidadeReservada = $request->quantidade;

        if ($ferramenta->quantidadeDisponivel < $quantidadeReservada) {
            return redirect()->route('reservas.create')->withErrors(['mensagem' => 'Estoque indisponível!']);
        }

        $reserva = new Reserva;
        $reserva->ferramenta_id = $request->ferramenta_id;
        $reserva->funcionario = $request->funcionario;
        $reserva->quantidade = $request->quantidade;
        $dataAtual = Carbon::now();
        $reserva->dataReserva = $dataAtual;
        $reserva->dataRetirada = $request->dataRetirada;
        $reserva->dataDevolucao = $request->dataDevolucao;
        $reserva->status = 'Em espera';
        $reserva->save();

        $ferramenta->quantidadeReservada += $quantidadeReservada;
        $ferramenta->quantidadeDisponivel -= $quantidadeReservada;
        $ferramenta->save();

        return redirect()->route('reservas.index');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
        $reserva = Reserva::find($id);
        $ferramenta = Ferramenta::find($reserva->ferramenta_id);
        $quantidadeEmprestada = $reserva->quantidade;

        $emprestimo = new Emprestimo;
        $emprestimo->ferramenta_id = $reserva->ferramenta_id;
        $emprestimo->funcionario = $reserva->funcionario;
        $emprestimo->quantidade = $reserva->quantidade;

        $dataAtual = Carbon::now();

        $emprestimo->dataEmprestimo = $dataAtual;
        $emprestimo->dataDevolucaoPrevista = $reserva->dataDevolucao;
        $emprestimo->status = 'Em uso';
        $emprestimo->save();

        $ferramenta->quantidadeEmprestada += $quantidadeEmprestada;
        $ferramenta->quantidadeReservada -= $quantidadeEmprestada;
        $ferramenta->save();

        $reserva->destroy($id);

        return redirect()->route('reservas.index');
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        
        $obj = Reserva::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $ferramenta = Ferramenta::find($obj->ferramenta_id);
        $quantidadeReservada = $obj->quantidade;

        $ferramenta->quantidadeDisponivel += $quantidadeReservada;
        $ferramenta->quantidadeReservada -= $quantidadeReservada;
        $ferramenta->save();

        $obj->destroy($id);

        return redirect()->route('reserva.index');
    }
}