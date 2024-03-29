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
	<div style=" !important;margin: auto;">
			<table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:400px; text-align: center;">Projeto</th>
						<th scope="col" style="width:400px; text-align: center;">Proponente</th>
						<th scope="col" style="width:400px; text-align: center;">Nome do Edital</th>
						<th scope="col" style="width:200px; text-align: center;">Documento Recurso</th>
                    </tr>
				</thead>

                        <tbody>
						<td style="text-align: center;" title="{{$trabalho->titulo}}">{{$trabalho->titulo}}</td>
						<td style="text-align: center;" title="{{$trabalho->proponente->user->name}}">{{$trabalho->proponente->user->name}}</td>
						<td style="text-align: center;" title="{{$evento->nome}}">{{$evento->nome}}</td>

						<td style="text-align: center;">
							@php 
								$hoje = date('Y-m-d');
							@endphp
								
							@if(
 								($evento->inicio_recurso <= $hoje) && ($hoje <= $evento->fim_recurso))
								<!-- Button trigger modal -->
							@if ($recurso == null)
								<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRecurso">Enviar</button>
								@else
								<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRecurso">Visualizar</button>
								@endif
							@else
								<!-- Button trigger modal -->
								@if($recurso == null)
									<button type="button"  class="btn btn-primary" data-toggle="modal" disabled> Indisponível </button>
								@else
									@if($recurso->statusAvaliacao == "enviado")
										<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRecurso"> Visualizar </button>
									@elseif($recurso->statusAvaliacao == "aprovado")
										<button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#modalRecurso"> Aprovado </button>
									@elseif($recurso->statusAvaliacao == "reprovado")
										<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRecurso">Reprovado</button>
									@else
										<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRecurso"> Pendente </button>
									@endif
								@endif
							@endif
						</td>

						<!-- Modal Recurso-->
						<div class="modal fade" id="modalRecurso" tabindex="-1" role="dialog" aria-labelledby="modalRecursoLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Recurso (.pdf)</h5>
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
									<form id="formRecurso" method="post" action="{{route('recurso.criar')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $trabalho->id }}" name="trabalho_id">
										<div class="col-12">
											<div class="row">
												@if($recurso)
													<div class="col-sm-2">Arquivo: </div>
													<div class="col-sm-1">
														<a href="{{ route('recurso.baixar', ['id' => $recurso->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
												@else
													<label class="control-label col-6">Nenhum arquivo carregado</label>
												@endif
											</div>
											<br>

                        @if((Auth::user()->proponentes != null) && ($evento->inicio_recurso <= $hoje) && ($hoje <= $evento->fim_recurso) && ($recurso == null))
												<input type="file" class="input-group-text" value="" name="pdfRecurso" accept=".pdf" placeholder="Recurso" id="pdfRecurso" required @if(false) disabled @endif/>
												@error('pdfRecurso')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											@endif
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            @if((Auth::user()->proponentes != null) &&
                                                ($evento->inicio_recurso <= $hoje) && ($hoje <= $evento->fim_recurso))
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
