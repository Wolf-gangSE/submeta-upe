<?php

namespace App\Http\Controllers;

use App\Recurso;
use App\Proponente;
use App\Trabalho;
use App\Notificacao;
use App\Avaliador;
use App\Administrador;
use App\User;
use App\Notifications\RecebimentoRecursoNotification;
use App\Notifications\AprovacaoDeRecurso;
use App\Notifications\ResultadoDoRecurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($trabalho_id)
    {   
        $user = Auth()->user();
        $user_id = $user->id;
        $proponente = Proponente::where('user_id', $user_id)->first();
        $trabalho = Trabalho::where('id', $trabalho_id)->first();
        $evento = $trabalho->evento;
        $recurso = Recurso::where('trabalhoId', $trabalho_id)->first();
        return view('recurso.listar')->with(['proponente' => $proponente, 'trabalho'=> $trabalho, 'evento' => $evento, 'recurso' => $recurso]);
    }

    public function indexAvaliacao($evento_id)
    {   
        $user = Auth()->user();
        $user_id = $user->id;
        $trabalhos = Trabalho::where('evento_id', $evento_id)->get();
        $recursos = Recurso::whereIn('trabalhoId', $trabalhos->pluck('id'))->get();
        return view('recurso.avaliacao')->with(['recursos' => $recursos]);
    }

    public function avaliar(Request $request)
    {
        $recurso = Recurso::where('id', $request->recurso_id)->first();
        $trabalho = Trabalho::where('id', $recurso->trabalhoId)->first();;
        $proponenteUser = User::find($trabalho->proponente->user_id);
        $evento = $trabalho->evento;
        $avaliadores = Avaliador::whereHas('trabalhos', function ($query) use ($trabalho) {
            $query->where('trabalho_id', $trabalho->id);
        })->get();
        
        if ($request->justificativa != null) {
            $trabalho->comentario = $request->justificativa;
            $trabalho->save();
        }

        $recurso['statusAvaliacao'] = $request->statusAvaliacao;
        $recurso->save();

        if ($request->statusAvaliacao == "aprovado") {
            foreach ($avaliadores as $avaliador) {
                $userTemp = User::find($avaliador->user->id);

                $notificacao = Notificacao::create([
                    'remetente_id' => Auth::user()->id,
                    'destinatario_id' => $avaliador->user_id,
                    'trabalho_id' => $trabalho->id,
                    'lido' => false,
                    'tipo' => 8,
                ]);
                $notificacao->save();

                Notification::send($userTemp, new RecebimentoRecursoNotification($userTemp, $trabalho, $avaliador->trabalhos()->where('trabalho_id', $trabalho->id)->first()->pivot->acesso, $evento->tipoAvaliacao));
            }
        }

        Notification::send($proponenteUser, new ResultadoDoRecurso($trabalho, $evento, $request->statusAvaliacao));

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = Auth()->user()->id;
        $adm = Administrador::all()->first();
        $admUser = User::find($adm->user_id);
        $proponente = Proponente::where('user_id', $user_id)->first();
        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();
        $recurso = Recurso::where('trabalhoId', $request->trabalho_id)->first();

        $request->validate([
            'pdfRecurso' => 'required|mimes:pdf|max:10000',
        ]);

        if ($recurso == null) {
            $recurso = Recurso::create();

            $recurso['statusAvaliacao'] = "enviado";
            $recurso['trabalhoId'] = $request->trabalho_id;

            if(isset($request->pdfRecurso)){
                $pdfRecurso = $request->pdfRecurso;
                $extension = $pdfRecurso->extension();
                $path = 'pdfRecurso/' . $trabalho->id . '/';
                $nome = "recurso" . "." . $extension;
                Storage::putFileAs($path, $pdfRecurso, $nome);
                $recurso['pdfRecurso'] = $path . $nome;
            }

            $recurso->save();
            
        } else {
            $recurso->statusAvaliacao = "enviado";
            $recurso->trabalhoId = $request->trabalho_id;

            if(isset($request->pdfRecurso)){
                $pdfRecurso = $request->pdfRecurso;
                $extension = $pdfRecurso->extension();
                $path = 'pdfRecurso/' . $trabalho->id . '/';
                $nome = "recurso.pdf";
                Storage::putFileAs($path, $pdfRecurso, $nome);
                $recurso->pdfRecurso = $path . $nome;
            }

            $recurso->save();
        }

        Notification::send($admUser, new AprovacaoDeRecurso($trabalho, $trabalho->evento));

        return redirect()->route('recurso.listar', ['id' => $trabalho->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show(Recurso $recurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurso $recurso)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurso $recurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recurso $recurso)
    {
        //
    }

    public function baixar($id) {
        $recurso = Recurso::find($id);

        if (Storage::disk()->exists($recurso->pdfRecurso)) {
            ob_end_clean();
            return Storage::download($recurso->pdfRecurso);
        }
        return abort(404);
    }
}
