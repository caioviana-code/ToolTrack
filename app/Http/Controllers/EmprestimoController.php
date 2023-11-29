<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Ferramenta;
use DateInterval;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmprestimoController extends Controller {

    public function index() {
        
        $data = Emprestimo::with('ferramenta')->get();

        $dataAtual = Carbon::now();

        foreach ($data as $emprestimo) {
            $dataDevolucaoPrevista = Carbon::parse($emprestimo->dataDevolucaoPrevista);

            if ($dataDevolucaoPrevista->isPast()) {
                $emprestimo->status = 'atrasado';
            }
        }

        return view('emprestimos.index', compact('data'));
    }

    public function create() {
        
        $ferramentas = Ferramenta::all();

        return view('emprestimos.create', compact('ferramentas'));
    }

    public function store(Request $request) {

        $ferramenta = Ferramenta::find($request->ferramenta_id);
        $quantidadeEmprestada = $request->quantidade;

        if ($ferramenta->quantidadeDisponivel < $quantidadeEmprestada) {
            return redirect()->route('emprestimos.create')->withErrors(['mensagem' => 'Estoque indisponível!']);
        }
        
        $emprestimo = new Emprestimo;
        $emprestimo->ferramenta_id = $request->ferramenta_id;
        $emprestimo->funcionario = $request->funcionario;
        $emprestimo->quantidade = $request->quantidade;

        $dataAtual = Carbon::now();
        
        $dataDevolucaoPrevista = $request->dataDevolucao;
        $emprestimo->dataEmprestimo = $dataAtual;
        $emprestimo->dataDevolucaoPrevista = $dataDevolucaoPrevista;
        $emprestimo->status = 'Em uso';
        $emprestimo->save();

        $ferramenta->quantidadeEmprestada += $quantidadeEmprestada;
        $ferramenta->quantidadeDisponivel -= $quantidadeEmprestada;
        $ferramenta->save();

        return redirect()->route('emprestimos.index');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
        $emprestimo = Emprestimo::find($id);
        $emprestimo->dataDevolucao = Carbon::now();
        $emprestimo->status = 'finalizado';
        $emprestimo->save();

        $ferramenta = Ferramenta::find($emprestimo->ferramenta_id);
        $quantidadeEmprestada = $emprestimo->quantidade;

        $ferramenta->quantidadeDisponivel += $quantidadeEmprestada;
        $ferramenta->quantidadeEmprestada -= $quantidadeEmprestada;
        $ferramenta->save();

        return redirect()->route('emprestimos.index');
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        
        $obj = Emprestimo::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $ferramenta = Ferramenta::find($obj->ferramenta_id);
        $quantidadeEmprestada = $obj->quantidade;

        $ferramenta->quantidadeDisponivel += $quantidadeEmprestada;
        $ferramenta->quantidadeEmprestada -= $quantidadeEmprestada;
        $ferramenta->save();

        $obj->destroy($id);

        return redirect()->route('emprestimos.index');
    }
}
