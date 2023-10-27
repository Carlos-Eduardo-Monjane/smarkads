@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Prospecção</h4>
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf

            <div class="row">
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Nome</label>
                    <input type="title" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Email</label>
                    <input type="title" class="form-control" name="email" @if(old('email') != null) value="{{ old('email') }}" @elseif(isset($data->email)) value="{{$data->email}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Dominio</label>
                    <input type="title" class="form-control" name="domain" @if(old('domain') != null) value="{{ old('domain') }}" @elseif(isset($data->domain)) value="{{$data->domain}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Template Email </label>
                    <select class="form-control"  name="id_emails_template">
                      <option value=""> Selecione </option>
                      @foreach($templates as $template)
                      <option value="{{$template->id_emails_template}}">{{$template->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

                <div class="col-md-2">
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
                    <label for="inputEmail4">Assunto</label>
                    <input type="title" class="form-control" id="subject" name="subject" @if(old('subject') != null) value="{{ old('subject') }}" @elseif(isset($data->subject)) value="{{$data->subject}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Mensagem</label>
                <textarea type="title" class="form-control" name="message" id="text">
                  <img src="{{URL('/assets/painel/uploads/signature/1.png')}}" alt="" width="300">
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

  @endsection

  @section('scripts')

  <script>
  $("#messageDefault").change(function(){
    let valor = $(this).val();
    var selectedText = $("#messageDefault option:selected").html();
    var image = "{{URL('/assets/painel/uploads/signature/1.png')}}";
    $("#subject").val(selectedText);
    CKEDITOR.instances['text'].setData(valor+'<br> <img src="'+image+'" alt="" width="300">');
  });
  </script>

  <script>
    var textarea = document.getElementById('text');
    CKEDITOR.replace(textarea);
  </script>
  @endsection
