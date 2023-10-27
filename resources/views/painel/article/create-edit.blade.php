@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Artigo</h4>
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
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Assunto</label>
                    <input type="text" class="form-control" name="subject" @if(old('subject') != null) value="{{ old('subject') }}" @elseif(isset($data->subject)) value="{{$data->subject}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Descrição</label>
                    <textarea class="form-control" name="description" id="text">
                      @if(old('description') != null) {{ old('description') }} @elseif(isset($data->description)) {{$data->description}}  @endif
                    </textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Grupo</label>
                    <select class="form-control js-basic-multiple"  name="id_role[]" multiple>
                      @foreach($groups as $group)
                      <option value="{{$group->id}}" @if(isset($groupsSelected)) @if(in_array($group->id, $groupsSelected)) selected="true" @endif @endif>{{$group->name}} </option>
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
    var textarea = document.getElementById('text');
    CKEDITOR.replace(textarea);
  </script>
  @endsection
