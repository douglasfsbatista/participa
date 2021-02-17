@extends('coordenador.detalhesEvento')

@section('menu')

    <div id="divListarRevisores" style="display: block">
        @error('removerRevisor')
          @include('componentes.mensagens')
        @enderror
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listar Revisores</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Revisores</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Revisores cadastrados no seu evento</h6>
                      <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                              <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Área</th>
                                <th scope="col">Modalidade</th>
                                <th scope="col" style="text-align:center">Em Andamento</th>
                                <th scope="col" style="text-align:center">Finalizados</th>
                                <th scope="col" style="text-align:center">Visualizar</th>
                                <th scope="col" style="text-align:center">Remover</th>
                                <th scope="col" style="text-align:center">Lembrar</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($revisores as $revisor)
                                <tr>
                                  <td>{{$revisor->user->email}}</td>
                                  <td>{{$revisor->area->nome}}</td>
                                  <td>{{$revisor->modalidade->nome}}</td>
                                  <td style="text-align:center">{{$revisor->correcoesEmAndamento}}</td>
                                  <td style="text-align:center">{{$revisor->trabalhosCorrigidos}}</td>
                                  <td style="text-align:center">
                                    <a href="#" data-toggle="modal" data-target="#modalRevisor{{$revisor->id}}">
                                      <img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px">
                                    </a>
                                  </td>
                                  <td style="text-align:center">
                                    <form id="removerRevisor{{$revisor->id}}" action="{{route('remover.revisor', ['id' => $revisor->id])}}" method="POST">
                                      @csrf
                                      <a href="#" data-toggle="modal" data-target="#modalRemoverRevisor{{$revisor->id}}">
                                        <img src="{{asset('img/icons/user-times-solid.svg')}}" class="icon-card" style="width:25px">
                                      </a>
                                    </form>
                                  </td>
                                  <td style="text-align:center">
                                      <form action="{{route('revisor.email')}}" method="POST" >
                                        @csrf
                                          <input type="hidden" name="user" value= '@json($revisor->user)'>
                                          <button class="btn btn-primary btn-sm" type="submit">
                                              Enviar e-mail
                                          </button>
                                      </form>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                          @if(count($revs) > 0 && isset($revs))
                            <form action="{{route('revisor.emailTodos')}}" method="POST" >
                                @csrf
                                  <input type="hidden" name="revisores" value='@json($revs)'>
                                  <button class="btn btn-primary btn-sm" type="submit">
                                      Lembrar todos
                                  </button>
                              </form>
                          @endif

                      </p>

                    </div>
                  </div>
            </div>
        </div>
    </div>
    @foreach($revisores as $revisor)
      <!-- Modal de exclusão do evento -->
        <div class="modal fade" id="modalRemoverRevisor{{$revisor->id}}" tabindex="-1" role="dialog" aria-labelledby="#label" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #114048ff; color: white;">
              <h5 class="modal-title" id="#label">Confirmação</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
                  <div class="modal-body">
                      Tem certeza que deseja remover esse revisor do evento?
                  </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                  <button type="submit" class="btn btn-primary" form="removerRevisor{{$revisor->id}}">Sim</button>
              </div>
          </div>
          </div>
        </div>
      <!-- fim do modal -->
      <!-- Modal Revisor -->
      <div class="modal fade" id="modalRevisor{{$revisor->id}}" tabindex="-1" role="dialog" aria-labelledby="modalRevisor{{$revisor->id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #114048ff; color: white;">
              <h5 class="modal-title" id="exampleModalCenterTitle">Visualizar revisor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <label for="">Nome</label>
                  <h5>{{$revisor->user->name}}</h5>
                </div>
                <div class="col-sm-6">
                  <label for="">E-mail</label>
                  <h5>{{$revisor->user->email}}</h5>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <label for="">Área</label>
                  <h5>{{$revisor->area->nome}}</h5>
                </div>
                <div class="col-sm-6">
                  <label for="">Instituição</label>
                  <h5>{{$revisor->user->instituicao}}</h5>
                </div>
              </div>

              <div class="row justify-content-center" style="margin-top:20px">
                <div class="col-sm-12">
                  <h4>Trabalhos</h4>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  @if (count($revisor->trabalhosAtribuidos) > 0)
                    <table class="table table-hover table-responsive-lg table-sm">
                      <thead>
                        <tr>
                          <th scope="col">Título</th>
                          <th scope="col">Status</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($revisor->trabalhosAtribuidos()->orderBy('titulo')->get() as $trabalho)
                          <tr>
                            <td>{{$trabalho->titulo}}</td>
                            <td>{{$trabalho->avaliado}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  @else 
                    <h5>Nenhum trabalho atríbuido</h5>
                  @endif
                </div>
              </div>
              </div>
          </div>
        </div>
      </div>
    @endforeach

@endsection