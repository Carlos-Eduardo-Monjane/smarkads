@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Ticket</h4>
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
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Descrição</label>
                  <textarea class="form-control textarea" name="description" rows="8" id="ckeditor">
                    @if(old('description') != null) {{ old('description') }} @elseif(isset($data->description)) {{$data->description}}  @endif
                  </textarea>
                </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Domínio </label>
                    <select class="form-control" name="id_domain">
                      <option value="">Selecione</option>
                      @foreach($domains as $domain)
                      <option value="{{$domain->id_domain}}" @if(isset($domainSelected->id_domain)) @if($domainSelected->id_domain == $domain->id_domain) selected="true" @endif @endif>{{$domain->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
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
              <input type="hidden" name="id_ticket_status" value="1">

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
          var textarea = document.getElementById('ckeditor');
          CKEDITOR.replace(textarea);
    </script>

  @endsection
