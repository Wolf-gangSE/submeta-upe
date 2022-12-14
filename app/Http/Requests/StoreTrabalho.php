<?php

namespace App\Http\Requests;

use App\Evento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrabalho extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        //dd($this->all());
        $evento = Evento::find($this->editalId);
        $rules = [];
        
        if(!($this->has('marcado'))){
            $rules['erro'] = ['required'];
        }
        if($this->has('marcado')){
            foreach ($this->get('marcado') as $key => $value) {
                if( intval($value)  == $key){
                    //user
                    $rules['name.'.$value] = ['required', 'string'];
                    $rules['email.'.$value] = ['required', 'string'];
                    $rules['instituicao.'.$value] = ['required', 'string'];
                    $rules['cpf.'.$value] = ['required', 'string'];
                    $rules['celular.'.$value] = ['required', 'string'];
                    //endereco
                    $rules['rua.'.$value] = ['required', 'string'];
                    $rules['numero.'.$value] = ['required', 'string'];
                    $rules['bairro.'.$value] = ['required', 'string'];
                    $rules['cidade.'.$value] = ['required', 'string'];
                    $rules['uf.'.$value] = ['required', 'string'];
                    $rules['cep.'.$value] = ['required', 'string'];
                    //participante
                    $rules['rg.'.$value] = ['required', 'string'];
                    $rules['data_de_nascimento.'.$value] = ['required', 'string'];
                    $rules['curso.'.$value] = ['required', 'string'];
                    $rules['turno.'.$value] = ['required', 'string'];
                    $rules['ordem_prioridade.'.$value] = ['required', 'string'];
                    $rules['periodo_atual.'.$value] = ['required', 'string'];
                    $rules['total_periodos.'.$value] = ['required', 'string'];
                    if($evento->tipo != "PIBEX") {
                        $rules['media_do_curso.' . $value] = ['required', 'string'];
                    }
                    $rules['anexoPlanoTrabalho.'.$value] = ['required'];
                    $rules['nomePlanoTrabalho.'.$value] = ['required', 'string'];
    
                }
            }

        }

        if($this->has('rascunho')) {
            $rules = [];
            return $rules;
        }else{
            if($evento->nome_docExtra != null ){
                $rules['anexo_docExtra']               = [Rule::requiredIf($evento->obrigatoriedade_docExtra == true),'file', 'mimes:zip,doc,docx,pdf', 'max:2048'];
            }
            if($evento->tipo!="PIBEX"){
                $rules['anexoPlanilhaPontuacao']       = ['required'];
                $rules['anexoLattesCoordenador']       = ['required', 'mimes:pdf'];
                $rules['anexoGrupoPesquisa']           = ['required', 'mimes:pdf'];
                $rules['anexoAutorizacaoComiteEtica']  = [Rule::requiredIf($this->autorizacaoFlag == 'sim')];
                $rules['justificativaAutorizacaoEtica']= [Rule::requiredIf($this->autorizacaoFlag == 'nao')];
                $rules['pontuacaoPlanilha']            = ['required', 'string'];
                $rules['linkGrupoPesquisa']            = ['required', 'string'];
            }

            $rules['editalId']                     = ['required', 'string'];
            $rules['marcado.*']                    = ['required'];
            $rules['titulo']                       = ['required', 'string'];
            $rules['grande_area_id']               = [Rule::requiredIf($evento->natureza_id != 3), 'string'];
            $rules['area_id']                      = [Rule::requiredIf($evento->natureza_id != 3), 'string'];
            if($evento->natureza_id == 3){
                $rules['area_tematica_id']          = ['required', 'string'];
                $rules['ods']                    = ['required'];
                
            }
            $rules['linkLattesEstudante']          = ['required', 'string'];

            $rules['anexoProjeto']                 = ['required', 'mimes:pdf'];
            $rules['anexoDecisaoCONSU']            = [Rule::requiredIf($evento->consu), 'mimes:pdf'];

            return $rules;
        }
        
    }

    public function messages()
    {
        
        return [
            'titulo.required' => 'O :attribute ?? obrigat??rio',
            'marcado.*.required' => 'Por favor selcione algum participante, ?? obrigat??rio',
            'grande_area_id.required' => 'O campo grande ??rea ?? obrigat??rio',
            'anexoPlanoTrabalho.*.required' => 'O :attribute ?? obrigat??rio',
            'anexoProjeto.required' => 'O :attribute ?? obrigat??rio',
            'cpf.*.required'  => 'O cpf ?? obrigat??rio',
            'name.*.required'  => 'O :attribute ?? obrigat??rio',
            'email.*.required'  => 'O :attribute ?? obrigat??rio',
            'instituicao.*.required'  => 'O :attribute ?? obrigat??rio',
            'emailParticipante.*.required'  => 'O :attribute ?? obrigat??rio',
            'celular.*.required'  => 'O :attribute ?? obrigat??rio',
            'rua.*.required'  => 'O :attribute ?? obrigat??rio',
            'numero.*.required'  => 'O :attribute ?? obrigat??rio',
            'bairro.*.required'  => 'O :attribute ?? obrigat??rio',
            'cidade.*.required'  => 'O :attribute ?? obrigat??rio',
            'uf.*.required'  => 'O :attribute ?? obrigat??rio',
            'cep.*.required'  => 'O :attribute ?? obrigat??rio',
            'complemento.*.required'  => 'O :attribute ?? obrigat??rio',
            'rg.*.required'  => 'O :attribute ?? obrigat??rio',
            'data_de_nascimento.*.required'  => 'O :attribute ?? obrigat??rio',
            'curso.*.required'  => 'O :attribute ?? obrigat??rio',
            'turno.*.required'  => 'O :attribute ?? obrigat??rio',
            'ordem_prioridade.*.required'  => 'O :attribute ?? obrigat??rio',
            'periodo_atual.*.required'  => 'O :attribute ?? obrigat??rio',
            'total_periodos.*.required'  => 'O :attribute ?? obrigat??rio',
            'media_do_curso.*.required'  => 'O :attribute ?? obrigat??rio',
            'anexoPlanoTrabalho.*.required'  => 'O :attribute ?? obrigat??rio',
            'nomePlanoTrabalho.*.required'  => 'O :attribute ?? obrigat??rio',
        ];
    }
}