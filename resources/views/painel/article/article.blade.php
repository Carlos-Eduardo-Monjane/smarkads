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
