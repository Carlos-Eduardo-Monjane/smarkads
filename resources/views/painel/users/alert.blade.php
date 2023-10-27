@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Notificação</h4>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="/{{$principal}}/{{$rota}}/alert/{{$idUser}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="">Mensagens Padrões</label>
                    <select class="form-control" id="messageDefault">
                      <option value="">Selecione</option>
                      @foreach($messageDefault as $message)
                      <option value="{{$message->message}}">{{$message->subject}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Titulo</label>
                    <input type="text" id="subject" class="form-control" name="title" @if(old('title') != null) value="{{ old('title') }}" @elseif(isset($data->title)) value="{{$data->title}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-2" style="display: none">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="inputEmail4">Status</label>
                    <div class="checkbox checbox-switch switch-success">
                      <label>
                        <input type="hidden" name="status" value="0" />
                        <input type="checkbox" name="status"  @if(isset($data->status)) @if($data->status == 1) checked="checked" @endif @endif value="1"/>
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Texto</label>
                <textarea type="title" class="form-control" name="text" id="message">
                  @if(old('text') != null) {{ old('text') }} @elseif(isset($data->text)) {{$data->text}}  @endif
                </textarea>
              </div>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="card card-statistics">
        <div class="card-header">
          <div class="card-heading">
            <h4 class="card-title">Notificações</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Titulo</th>
                  <th scope="col">Data/Hora</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $dado)
                <tr>
                  <td>
                    {{$dado->title}}
                  </td>
                  <td>
                    {{date('d-m-Y H:i', strtotime($dado->created_at))}}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="100">Nenhum resultado encontrado</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('scripts')
  <script>
  $("#messageDefault").change(function(){
    let valor = $(this).val();
    var selectedText = $("#messageDefault option:selected").html();
    $("#subject").val(selectedText);
    CKEDITOR.instances['message'].setData(valor);
  });
  </script>

  <script>
    var textarea = document.getElementById('message');
    CKEDITOR.replace(textarea);
  </script>
  @endsection
