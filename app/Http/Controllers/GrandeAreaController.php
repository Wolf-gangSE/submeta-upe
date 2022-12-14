<?php

namespace App\Http\Controllers;

use App\AreaTematica;
use Illuminate\Http\Request;
use App\GrandeArea;
use App\Area;
use App\ObjetivoDeDesenvolvimentoSustentavel;

class GrandeAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grandesAreas = GrandeArea::orderBy('nome')->get();
        $areasTematicas = AreaTematica::orderBy('nome')->get();
        $ODSs = ObjetivoDeDesenvolvimentoSustentavel::orderBy('nome')->get();
        return view('naturezas.grandeArea.index')->with(['grandesAreas' => $grandesAreas, 'areasTematicas' => $areasTematicas, 'odss' => $ODSs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('naturezas.grandeArea.nova_grande_area');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome'  =>  'required',
        ]);

        $GrandeArea = new GrandeArea();
        $GrandeArea->nome = $request->nome;
        $GrandeArea->save();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área cadastrada com sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grandeArea = GrandeArea::find($id);
        $areas = Area::where('grande_area_id', '=', $id)->orderBy('nome')->get();

        return view('naturezas.grandeArea.detalhes')->with(['grandeArea' => $grandeArea, 'areas' => $areas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grandeArea = GrandeArea::find($id);
        return view('naturezas.grandeArea.editar_grande_area')->with(['grandeArea' => $grandeArea]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $grandeArea = GrandeArea::find($id);
        $grandeArea->nome = $request->nome;
        $grandeArea->update();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área editada com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grandeArea = GrandeArea::find($id);
        $grandeArea->delete();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área excluida com sucesso']);
    }
}