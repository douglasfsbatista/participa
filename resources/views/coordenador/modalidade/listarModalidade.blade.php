@extends('coordenador.detalhesEvento')

@section('menu')
    @error('excluirModalidade')
        @include('componentes.mensagens')
    @enderror
    <div id="divListarModalidades" class="modalidades" style="display: block">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listar Modalidades</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            {{-- table modalidades --}}
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Modalidades</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Modalidades cadastradas no seu evento</h6>
                      <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col" style="text-align:center">Editar</th>
                                <th scope="col" style="text-align:center">Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($modalidades as $modalidade)
                                <tr>
                                    <td>{{$modalidade->nome}}</td>
                                    <td style="text-align:center">
                                        <a href="#" data-toggle="modal" data-target="#modalEditarModalidade{{$modalidade->id}}"><img src="{{asset('img/icons/edit-regular.svg')}}" style="width:20px"></a>
                                    </td>
                                    <td style="text-align:center">
                                        <a href="" data-toggle="modal" data-target="#modalExcluirModalidade{{$modalidade->id}}"><img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt=""></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </p>
                    </div>
                  </div>

            </div>{{-- end table--}}

            {{-- table modalidades Área--}}
            {{-- <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Áreas por Modalidade</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Áreas correspondentes à cada modalidade do seu evento</h6>
                      <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                              <tr>
                                <th scope="col">Modalidade</th>
                                <th scope="col">Área</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($areaModalidades as $areaModalidade)
                                  <tr>
                                    <td>{{$areaModalidade->modalidade->nome}}</td>
                                    <td>{{$areaModalidade->area->nome}}</td>
                                  </tr>
                                @endforeach


                            </tbody>
                          </table>
                      </p>
                    </div>
                  </div>

            </div> --}}
            {{-- end table área --}}
        </div>
    </div>
        <div id="divClassificacao" class="classificacao">
            <h1>Classificação</h1>
        </div>
        <div id="divAtividades" class="atividades">
            <h1>Atividades</h1>
        </div>


        @foreach ($modalidades as $modalidade)
        <!-- Modal excluir modalida -->

        <!-- Modal de exclusão da área -->
        <div class="modal fade" id="modalExcluirModalidade{{$modalidade->id}}" tabindex="-1" role="dialog" aria-labelledby="#label" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #114048ff; color: white;">
                <h5 class="modal-title" id="#label">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{route('modalidade.destroy', ['id' => $modalidade->id])}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        Tem certeza que deseja excluir essa modalidade?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-primary">Sim</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        <!-- Modal editar modalidade -->
            <div class="modal fade" id="modalEditarModalidade{{$modalidade->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEditarModalidade" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #114048ff; color: white;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar {{$modalidade->nome}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            @error('marcarextensao')
                                                @include('componentes.mensagens')
                                            @enderror
                                        </div>
                                        <form method="POST" action="{{route('modalidade.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <p class="card-text">
                                            <input type="hidden" name="modalidadeEditId" value="{{$modalidade->id}}">
                                            <input type="hidden" name="eventoId" value="{{$evento->id}}">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="nomeModalidadeEdit" class="col-form-label">*{{ __('Nome') }}</label>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-12">
                                                <input id="nomeModalidadeEdit" type="text" class="form-control @error('nome'.$modalidade->id) is-invalid @enderror" name="nome{{$modalidade->id}}" value="@if(old('nome'.$modalidade->id)!=null){{old('nome'.$modalidade->id)}}@else{{$modalidade->nome}}@endif" required autocomplete="nomes" autofocus>

                                                    @error('nome'.$modalidade->id)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>{{-- end row--}}

                                        </p>

                                        {{-- Data: inicioSubmissao | fimSubmissao --}}
                                        <div class="row justify-content-center">

                                            <div class="col-sm-6">
                                                <label for="inicioSubmissaoEdit" class="col-form-label">{{ __('Início da Submissão') }}</label>
                                                <input id="inicioSubmissaoEdit" type="datetime-local" class="form-control @error('inícioSubmissão'.$modalidade->id) is-invalid @enderror" name="inícioSubmissão{{$modalidade->id}}" value="@if(old('inícioSubmissão'.$modalidade->id)!=null){{old('inícioSubmissão'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->inicioSubmissao))}}@endif" autocomplete="inícioSubmissão" autofocus>

                                                @error('inícioSubmissão'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fimSubmissaoEdit" class="col-form-label">{{ __('Fim da Submissão') }}</label>
                                                <input id="fimSubmissaoEdit" type="datetime-local" class="form-control @error('fimSubmissão'.$modalidade->id) is-invalid @enderror" name="fimSubmissão{{$modalidade->id}}" value="@if(old('fimSubmissão'.$modalidade->id)!=null){{old('fimSubmissão'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->fimSubmissao))}}@endif" autocomplete="fimSubmissão" autofocus>

                                                @error('fimSubmissão'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- end Data: inicioSubmissao | fimSubmissao --}}

                                        {{-- Data: inicioRevisao | fimRevisao --}}
                                        <div class="row justify-content-center">

                                            <div class="col-sm-6">
                                                <label for="inicioRevisaoEdit" class="col-form-label">{{ __('Início da Revisão') }}</label>
                                                <input id="inicioRevisaoEdit" type="datetime-local" class="form-control @error('inícioRevisão'.$modalidade->id) is-invalid @enderror" name="inícioRevisão{{$modalidade->id}}" value="@if(old('inícioRevisão'.$modalidade->id)!=null){{old('inícioRevisão'.$modalidade->id)}}@else @if($modalidade->inicioRevisao != null){{date('Y-m-d\TH:i',strtotime($modalidade->inicioRevisao))}} @endif @endif" autocomplete="inícioRevisão" autofocus>

                                                @error('inícioRevisão'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fimRevisaoEdit" class="col-form-label">{{ __('Fim da Revisão') }}</label>
                                                <input id="fimRevisaoEdit" type="datetime-local" class="form-control @error('fimRevisão'.$modalidade->id) is-invalid @enderror" name="fimRevisão{{$modalidade->id}}" value="@if(old('fimRevisão'.$modalidade->id)!=null){{old('fimRevisão'.$modalidade->id)}}@else @if($modalidade->fimRevisao != null){{date('Y-m-d\TH:i',strtotime($modalidade->fimRevisao))}} @endif @endif" autocomplete="fimRevisão" autofocus>

                                                @error('fimRevisão'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- end Data: inicioRevisão | fimRevisao --}}

                                        {{-- Data: inicioCorrecao | fimCorrecao --}}
                                        @if($modalidade->inicioCorrecao && $modalidade->fimCorrecao)
                                        <div class="row justify-content-center">

                                            <div class="col-sm-6">
                                                <label for="inicioCorrecao" class="col-form-label">{{ __('Início da Correcao') }}</label>
                                                <input id="inicioCorrecao" type="datetime-local" class="form-control @error('inícioCorreção'.$modalidade->id) is-invalid @enderror" name="inícioCorreção{{$modalidade->id}}" value="@if(old('inícioCorreção'.$modalidade->id)!=null){{old('inícioCorreção'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->inicioCorrecao))}}@endif" autocomplete="inicioCorrecao" autofocus>

                                                @error('inícioCorreção'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fimCorrecao" class="col-form-label">{{ __('Fim da Correção') }}</label>
                                                <input id="fimCorrecao" type="datetime-local" class="form-control @error('fimCorreção'.$modalidade->id) is-invalid @enderror" name="fimCorreção{{$modalidade->id}}" value="@if(old('fimCorreção'.$modalidade->id)!=null){{old('fimCorreção'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->fimCorrecao))}}@endif" autocomplete="fimCorrecao" autofocus>

                                                @error('fimCorreção'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        {{-- end Data: inicioCorrecao | fimCorrecao --}}


                                        {{-- Data: inicioValidacao | fimValidacao --}}
                                        @if($modalidade->inicioValidacao && $modalidade->fimValidacao)
                                        <div class="row justify-content-center">

                                            <div class="col-sm-6">
                                                <label for="inicioValidacao" class="col-form-label">{{ __('Início da Validação') }}</label>
                                                <input id="inicioValidacao" type="datetime-local" class="form-control @error('inícioValidação'.$modalidade->id) is-invalid @enderror" name="inícioValidação{{$modalidade->id}}" value="@if(old('inícioValidação'.$modalidade->id)!=null){{old('inícioValidação'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->inicioValidacao))}}@endif" autocomplete="inicioValidacao" autofocus>

                                                @error('inícioValidação'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fimValidacao" class="col-form-label">{{ __('Fim da Correção') }}</label>
                                                <input id="fimValidacao" type="datetime-local" class="form-control @error('fimValidação'.$modalidade->id) is-invalid @enderror" name="fimValidação{{$modalidade->id}}" value="@if(old('fimValidação'.$modalidade->id)!=null){{old('fimValidação'.$modalidade->id)}}@else{{date('Y-m-d\TH:i',strtotime($modalidade->fimValidacao))}}@endif" autocomplete="fimValidacao" autofocus>

                                                @error('fimValidação'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        {{-- end Data: inicioValidacao | fimValidacao --}}

                                        {{-- Data: resultado --}}
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <label for="inicioResultado" class="col-form-label">{{ __('Resultado') }}</label>
                                                <input id="inicioResultado" type="datetime-local" class="form-control @error('resultado'.$modalidade->id) is-invalid @enderror" name="resultado{{$modalidade->id}}" value="@if(old('resultado'.$modalidade->id)){{old('resultado'.$modalidade->id)}}@else{{ date('Y-m-d\TH:i',strtotime($modalidade->inicioResultado))}}@endif" autocomplete="inicioResultado" autofocus>

                                                @error('resultado'.$modalidade->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- end Data: resultado --}}

                                        {{-- Inicio - Tipo de submissão --}}
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-check" style="margin-top: 10px">
                                                    <input class="form-check-input incluir-resumo-edit" type="checkbox" name="texto{{$modalidade->id}}" id="id-custom_field-account-1-2" @if(old('texto'.$modalidade->id)) checked @elseif(old('texto'.$modalidade->id) == null && $modalidade->texto) checked @endif>
                                                    <label class="form-check-label" for="resumo">
                                                        Adicionar campo resumo por texto
                                                    </label>
                                                    @error('resumo'.$modalidade->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div id="restricoes-resumo-texto-edit{{$modalidade->id}}" @if(old('texto'.$modalidade->id)) style="display: block;" @elseif(old('texto'.$modalidade->id) == null && $modalidade->texto) style="display: block;"@else style="display: none;" @endif>
                                                    <label class="col-form-label">*{{ __('Restrições de resumo:') }}</label>

                                                    <div class="form-check">
                                                        <input class="form-check-input limit" type="radio" name="limit{{$modalidade->id}}" value="limit-option1" id="id-limit-custom_field-accountEdit-1-1" @if (old('limit'.$modalidade->id) == 'limit-option1') checked @elseif(old('limit'.$modalidade->id) == null && $modalidade->caracteres) checked @endif>
                                                        <label class="form-check-label" for="texto">
                                                            Quantidade de caracteres
                                                        </label>
                                                        </div>
                                                        <div class="form-check">
                                                        <input class="form-check-input limit" type="radio" name="limit{{$modalidade->id}}" value="limit-option2" id="id-limit-custom_field-accountEdit-1-2" @if (old('limit'.$modalidade->id) == 'limit-option2') checked @elseif(old('limit'.$modalidade->id) == null && $modalidade->palavras) checked @endif>
                                                        <label class="form-check-label" for="arquivo">
                                                            Quantidade de palavras
                                                        </label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6" id="min-max-caracteres" style="@if (old('limit'.$modalidade->id) == 'limit-option1')display:block;@elseif($modalidade->caracteres && old('limit'.$modalidade->id) == null)display:block;@else display:none; @endif">
                                                            <div class="form-group">
                                                                <label class="col-form-label">{{ __('Mínimo') }}</label>
                                                                <div>
                                                                <input class="form-control" type="number" id="min_caracteres" name="mincaracteres{{$modalidade->id}}" value="@if(old('mincaracteres'.$modalidade->id)!=null){{old('mincaracteres'.$modalidade->id)}}@else{{$modalidade->mincaracteres}}@endif">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-form-label">{{ __('Máximo') }}</label>
                                                                <div>
                                                                <input class="form-control" type="number" id="max_caracteres" name="maxcaracteres{{$modalidade->id}}" value="@if(old('maxcaracteres'.$modalidade->id)!=null){{old('maxcaracteres'.$modalidade->id)}}@else{{$modalidade->maxcaracteres}}@endif">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6" id="min-max-palavras" style="@if (old('limit'.$modalidade->id) == 'limit-option2')display:block;@elseif($modalidade->palavras && old('limit'.$modalidade->id) == null)display:block;@else display:none; @endif">
                                                            <div class="form-group">
                                                                <label class="col-form-label">{{ __('Mínimo') }}</label>
                                                                <div>
                                                                <input class="form-control" type="number" id="min_palavras" name="minpalavras{{$modalidade->id}}" value="@if(old('minpalavras'.$modalidade->id)!=null){{old('minpalavras'.$modalidade->id)}}@else{{$modalidade->minpalavras}}@endif">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-form-label">{{ __('Máximo') }}</label>
                                                                <div>
                                                                <input class="form-control" type="number" id="max_palavras" name="maxpalavras{{$modalidade->id}}" value="@if(old('maxpalavras'.$modalidade->id)!=null){{old('maxpalavras'.$modalidade->id)}}@else{{$modalidade->maxpalavras}}@endif">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check" style="margin-top: 10px">
                                                    <input class="form-check-input incluirarquivoEdit" type="checkbox" onchange="exibirTiposArquivo({{$modalidade->id}},this)" name="arquivoEdit{{$modalidade->id}}" id="id-custom_field-accountEdit-1-2" @if(old('arquivoEdit'.$modalidade->id) == "on") checked @elseif (old('arquivoEdit'.$modalidade->id) == null && $modalidade->arquivo == true) checked @endif>
                                                    <label class="form-check-label" for="arquivoEdit">
                                                        Incluir submissão por arquivo
                                                    </label>
                                                    @error('arquivoEdit'.$modalidade->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row tiposDeArquivos{{$modalidade->id}}" style="@if(old('arquivoEdit'.$modalidade->id)=="on") display: block @elseif(old('arquivoEdit'.$modalidade->id) == null && $modalidade->arquivo == true) display: block @else display: none @endif">
                                            <div class="col-sm-6" id="tipo-arquivoEdit">

                                                <div class="titulo-detalhes" style="margin-top: 10px"></div>
                                                <label class="col-form-label">{{ __('Tipos de extensão aceitas') }}</label>

                                                <div class="form-check" style="margin-top: 10px">
                                                    <input class="form-check-input" type="checkbox" id="pdfEdit" name="pdf{{$modalidade->id}}" @if(old('pdf'.$modalidade->id) == "on") checked @elseif (old('pdf'.$modalidade->id) == null && $modalidade->pdf == true) checked @endif>
                                                    <label class="form-check-label" for="pdfEdit">
                                                        .pdf
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="jpgEdit" name="jpg{{$modalidade->id}}" @if(old('jpg'.$modalidade->id) == "on") checked @elseif (old('jpg'.$modalidade->id) == null && $modalidade->jpg == true) checked @endif>
                                                    <label class="form-check-label" for="jpgEdit">
                                                        .jpg
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="jpegEdit" name="jpeg{{$modalidade->id}}" @if(old('jpeg'.$modalidade->id) == "on") checked @elseif (old('jpeg'.$modalidade->id) == null && $modalidade->jpeg == true) checked @endif>
                                                    <label class="form-check-label" for="jpegEdit">
                                                        .jpeg
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="pngEdit" name="png{{$modalidade->id}}" @if(old('png'.$modalidade->id) == "on") checked @elseif (old('png'.$modalidade->id) == null && $modalidade->png == true) checked @endif>
                                                    <label class="form-check-label" for="pngEdit">
                                                        .png
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="docxEdit" name="docx{{$modalidade->id}}" @if(old('docx'.$modalidade->id) == "on") checked @elseif (old('docx'.$modalidade->id) == null && $modalidade->docx == true) checked @endif>
                                                    <label class="form-check-label" for="docxEdit">
                                                        .docx
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="odtEdit" name="odt{{$modalidade->id}}" @if(old('odt'.$modalidade->id) == "on") checked @elseif (old('odt'.$modalidade->id) == null && $modalidade->odt == true) checked @endif>
                                                    <label class="form-check-label" for="odtEdit">
                                                        .odt
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="zipEdit" name="zip{{$modalidade->id}}" @if(old('zip'.$modalidade->id) == "on") checked @elseif (old('zip'.$modalidade->id) == null && $modalidade->zip == true) checked @endif>
                                                    <label class="form-check-label" for="zipEdit">
                                                        .zip
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="svgEdit" name="svg{{$modalidade->id}}" @if(old('svg'.$modalidade->id) == "on") checked @elseif (old('svg'.$modalidade->id) == null && $modalidade->svg == true) checked @endif>
                                                    <label class="form-check-label" for="svgEdit">
                                                        .svg
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            {{-- Arquivo de Modelos  --}}
                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <label for="arquivoModelos" class="col-form-label">{{ __('Enviar modelo de apresentação:') }}</label> @if ($modalidade->modelo_apresentacao != null) <a href="{{route('modalidade.modelos.download', ['id' => $modalidade->id])}}">Arquivo atual</a> @endif

                                            <div class="custom-file">
                                                <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivoModelos{{$modalidade->id}}">
                                            </div>
                                            <small>O arquivo selecionado deve ser no formato ODT, OTT, DOCX, DOC, RTF ou PDF de até 2 MB.</small><br>
                                            <small>Se deseja alterar o arquivo, envie a nova versão.</small>
                                            @error('arquivoModelos')
                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            </div>
                                            {{-- Arquivo de Regras  --}}
                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <label for="arquivoRegras" class="col-form-label">{{ __('Enviar regras:') }}</label> @if ($modalidade->regra != null) <a href="{{route('modalidade.regras.download', ['id' => $modalidade->id])}}">Arquivo atual</a> @endif

                                            <div class="custom-file">
                                                <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivoRegras{{$modalidade->id}}">
                                            </div>
                                            <small>O arquivo Selecionado deve ser no formato PDF de até 2mb.</small><br>
                                            <small>Se deseja alterar o arquivo, envie a nova versão.</small>
                                            @error('arquivoRegras')
                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            </div>
                                            {{-- Arquivo de Templates --}}
                                            <div class="col-sm-12 tiposDeArquivos{{$modalidade->id}}" id="area-templateEdit" style="@if(old('arquivoEdit'.$modalidade->id)=="on") display: block @elseif(old('arquivoEdit'.$modalidade->id) == null && $modalidade->arquivo == true) display: block; @else display: none; @endif">
                                                <label for="nomeTrabalho" class="col-form-label">{{ __('Enviar template:') }}</label> @if ($modalidade->template != null) <a href="{{route('modalidade.template.download', ['id' => $modalidade->id])}}">Arquivo atual</a> @endif

                                                <div class="custom-file">
                                                <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivoTemplates{{$modalidade->id}}">
                                                </div>
                                                <small>O arquivo Selecionado deve ser no formato ODT, OTT, DOCX, DOC, RTF, TXT ou PDF de até 2mb.</small><br>
                                                <small>Se deseja alterar o arquivo, envie a nova versão.</small>
                                                @error('arquivoTemplates')
                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" style="width:100%">
                                                    {{ __('Finalizar') }}
                                                </button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>{{-- end row card --}}


                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
                </div>
            </div>
        @endforeach
        {{-- Fim Modal --}}
@endsection
