<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::all();
        return response()->json($tarefas);
    }

    public function store(Request $request)
    {
        $tarefa = new Tarefa;
        $tarefa->titulo = $request->input('titulo');
        $tarefa->descricao = $request->input('descricao');
        $tarefa->concluido = false;
        $tarefa->save();

        return response()->json(['id' => $tarefa['id']]);
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->titulo = $request->input('titulo');
        $tarefa->descricao = $request->input('descricao');
        $tarefa->concluido = $request->input('concluido');
        $tarefa->save();

        return response()->json(['message' => 'Tarefa alterada com sucesso']);
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return response()->json(['message' => 'Tarefa excluída com sucesso']);
    }

}
