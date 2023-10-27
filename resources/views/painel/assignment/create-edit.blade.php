@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Tarefa</h4>
          <br>
          @if(isset($data->id_ticket))
            <a href="/painel/ticket/manager/3/{{$data->id_ticket}}" class="btn btn-primary">Ticket</a>
          @endif
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf

            @if(isset($ticketResponse->id_ticket))
              <input type="hidden" name="id_ticket" value="{{$ticketResponse->id_ticket}}">
            @endif

            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Assunto</label>
                    <input type="text" class="form-control" name="subject"  @if(isset($ticketResponse->id_ticket_response)) value="{{$ticketResponse->subject}}" @elseif(old('subject') != null) value="{{ old('subject') }}" @elseif(isset($data->subject)) value="{{$data->subject}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Descrição</label>
                  <textarea class="form-control textarea" name="description" rows="8" id="ckeditor">
                    @if(isset($ticketResponse->id_ticket_response))
                      {{ $ticketResponse->response }}
                    @elseif(old('description') != null)
                      {{ old('description') }}
                    @elseif(isset($data->description))
                      {{ $data->description }}
                    @endif
                  </textarea>
                </div>
            </div>

            <div class="row">

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Inicio</label>
                    <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="text" name="start_date" @if(old('start_date') != null) value="{{ old('start_date') }}" @elseif(isset($data->start_date)) value="{{date('d-m-Y', strtotime($data->start_date))}}"  @endif  >
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Termino</label>
                    <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="text" name="end_date" @if(old('end_date') != null) value="{{ old('end_date') }}" @elseif(isset($data->end_date)) value="{{date('d-m-Y', strtotime($data->end_date))}}"  @endif  >
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Departamento </label>
                    <select class="form-control" name="id_department">
                      <option value="">Selecione</option>
                      @foreach($departments as $department)
                      <option value="{{$department->id_department}}" @if(isset($departmentSelected->id_department)) @if($departmentSelected->id_department == $department->id_department) selected="true" @endif @endif>{{$department->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Status </label>
                    <select class="form-control" name="id_assignment_status">
                      @foreach($status as $s)
                      <option value="{{$s->id_assignment_status}}" @if(isset($statusSelected->id_assignment_status)) @if($statusSelected->id_assignment_status == $s->id_assignment_status) selected="true" @endif @endif>{{$s->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Cliente </label>
                    <select class="form-control js-basic-multiple" name="id_client" id="clients">
                      <option value="">Selecione</option>
                      @foreach($clients as $client)
                      <option value="{{$client->id}}"  @if(isset($ticketResponse->id_ticket_response)) @if($ticketResponse->id_user == $client->id) selected @endif @elseif(isset($clientSelected->id)) @if($clientSelected->id == $client->id) selected="true" @endif @endif>{{$client->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Domínio </label>
                    <select class="form-control" name="id_domain" id="id_domain">
                      <option value="">Selecione</option>
                      @foreach($domains as $domain)
                      <option value="{{$domain->id_domain}}" @if(isset($ticketResponse->id_ticket_response)) @if($ticketResponse->id_domain == $domain->id_domain) selected @endif @elseif(isset($domainSelected->id_domain)) @if($domainSelected->id_domain == $domain->id_domain) selected="true" @endif @endif>{{$domain->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Responsável </label>
                    <select class="form-control js-basic-multiple" name="id_user[]" multiple>
                      <option value="">Selecione</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}" @if(isset($usersSelected)) @if(in_array($user->id,$usersSelected)) selected="true" @endif @elseif(Auth::user()->id == $user->id) selected="true" @endif>{{$user->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('scripts')
    <script>
    $('.js-basic-multiple').select2();
    </script>

    <script>
      $("#clients").change(function(){
        var client = $("#clients").val();
        if(client != ""){
          $.get("/{{$principal}}/{{$rota}}/domain-client/"+client, function(data, status){
            $("#id_domain").html(data);
          });
        }else{
          $("#id_domain").html('<option value="">Nenhum</option>');
        }
      });
    </script>
    <script>
          var textarea = document.getElementById('ckeditor');
          CKEDITOR.replace(textarea);
    </script>

  @endsection
