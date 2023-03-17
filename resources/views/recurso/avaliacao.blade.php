@extends('layouts.app')

@section('content')

<div class="container">
	
	@if (session('sucesso'))
		<div class="alert alert-success" role="alert">
			{{ session('sucesso') }}
		</div>
	@endif

    <div class="row justify-content-center titulo-menu mb-0">
		<h2> Recurso </h2>
	</div>
	@foreach($recursos as $recurso)
		@php
			$trabalho = App\Trabalho::find($recurso->trabalhoId);
			$evento = App\Evento::find($trabalho->evento_id);
			$hoje = date('Y-m-d');
		@endphp
	<div style=" !important;margin: auto;">
			<table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:400px; text-align: center;">Projeto</th>
						<th scope="col" style="width:400px; text-align: center;">Proponente</th>
						<th scope="col" style="width:400px; text-align: center;">Nome do Edital</th>
						<th scope="col" style="width:200px; text-align: center;">Ação</th>
                    </tr>
				</thead>

                        <tbody>
						
						<td style="text-align: center;" title="{{$trabalho->titulo}}">{{$trabalho->titulo}}</td>
						<td style="text-align: center;" title="{{$trabalho->proponente->user->name}}">{{$trabalho->proponente->user->name}}</td>
						<td style="text-align: center;" title="{{$evento->nome}}">{{$evento->nome}}</td>

						<td style="text-align: center;">
								
							@if($recurso->statusAvaliacao == "enviado")
								<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRecurso">Avaliar</button>
							@elseif($recurso->statusAvaliacao == "aprovado")
								<button type="button"  class="btn btn-success" data-toggle="modal" data-target="#modalRecurso">Aprovado</button>
							@elseif($recurso->statusAvaliacao == "reprovado")
								<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRecurso">Reprovado</button>
							@endif

						</td>

						<!-- Modal Recurso-->
						<div class="modal fade" id="modalRecurso" tabindex="-1" role="dialog" aria-labelledby="modalRecursoLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Avaliação do Recurso</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="inicio_recurso" class="col-form-label">{{ __('Início do período de Recurso:') }}</label>
                                                <input id="inicio_recurso" type="date" class="form-control" name="inicio_recurso" value="{{$evento->inicio_recurso}}" required autocomplete="inicio_recurso" disabled autofocus>

                                            </div>
                                            <div class="col-6">
                                                <label for="fim_recurso" class="col-form-label">{{ __('Fim do período de Recurso:') }}</label>
                                                <input id="fim_recurso" type="date" class="form-control" name="fim_recurso" value="{{$evento->fim_recurso}}" required autocomplete="fim_recurso" disabled autofocus>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
									<div class="modal-body">
									<form id="formRecurso" method="post" action="{{route('admin.avaliarRecurso')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $recurso->id }}" name="recurso_id">
										<div class="col-12">
											<div class="row">
													<div class="col-sm-2">Arquivo: </div>
													<div class="col-sm-2">
														<a href="{{ route('recurso.baixar', ['id' => $recurso->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
													<div class="col-4">
														<input type="radio" class="input-group-text" value="aprovado" name="statusAvaliacao" accept=".pdf" id="statusAvaliacaoAprovado" @if($recurso->statusAvaliacao == "aprovado") checked @endif onchange="displayStatusAvaliacao('aprovado')"/>
														<label for="statusAvaliacao" class="col-form-label">{{ __('Aprovado') }}</label>
													</div>
													<div class="col-4">
														<input type="radio" class="input-group-text" value="reprovado" name="statusAvaliacao" accept=".pdf" id="statusAvaliacaoReprovado" @if($recurso->statusAvaliacao == "reprovado") checked @endif onchange="displayStatusAvaliacao('reprovado')"/>
														<label for="statusAvaliacao" class="col-form-label">{{ __('Reprovado') }}</label>
													</div>
													@error('statusAvaliacao')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
											</div>
											<div class="row">
												<a class="col-md-12 text-left"
                           style="padding-left: 0px;color: #234B8B; font-weight: bold;">Justificativa <span style="color: red;">*</span></a>
												<textarea class="col-md-12" id="justificativa" name="justificativa" minlength="20"
																	style="border-radius:5px 5px 0 0;height: 71px;" required
												></textarea>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            @if(($evento->inicio_recurso <= $hoje))
												<button type="submit" class="btn btn-success" @if(false) disabled @endif >Salvar</button>
											@endif
										</div>

									</form>
								</div>
							</div>
						</div>

			</table>

			<div id="btn-cancelar">
				<a class="btn btn-primary" href="{{ url()->previous() }}">Cancelar</a> 
			</div>
	</div>
@endforeach

</div>

	<style>
		td {
			max-width: 25ch;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		#td-nomeAluno {
			max-width: 25ch;
		}

		#btn-cancelar {
			margin-top: 10px;
			text-align: right;
		}

	</style>


@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		displayStatusAvaliacao("''")
  });
	function displayStatusAvaliacao(valor) {
		if (valor == "aprovado") {
			document.getElementById("statusAvaliacaoAprovado").checked = true;
			document.getElementById("statusAvaliacaoReprovado").checked = false;
		} else if (valor == "reprovado") {
			document.getElementById("statusAvaliacaoReprovado").checked = true;
			document.getElementById("statusAvaliacaoAprovado").checked = false;
		} else {
			document.getElementById("statusAvaliacaoAprovado").checked = true;
			document.getElementById("statusAvaliacaoReprovado").checked = false;
		}
	}
</script>
@endsection