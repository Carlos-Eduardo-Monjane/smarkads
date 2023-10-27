@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Padrão de Blocos</h4>
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
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Página </label>
                    <select class="form-control" name="page">
                      <option value="">Página</option>
                      <option value="Home" @if(isset($data->page)) @if($data->page == 'Home') selected @endif @endif>Home</option>
                      <option value="Pages" @if(isset($data->page)) @if($data->page == 'Pages') selected @endif @endif>Pages</option>
                      <option value="Posts" @if(isset($data->page)) @if($data->page == 'Posts') selected @endif @endif>Posts</option>
                      <option value="Internal" @if(isset($data->page)) @if($data->page == 'Internal') selected @endif @endif>Internal</option>
                      <option value="Content" @if(isset($data->page)) @if($data->page == 'Content') selected @endif @endif>Content</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Nome</label>
                    <input type="title" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Quantidade</label>
                    <input type="title" class="form-control" name="quantity" @if(old('quantity') != null) value="{{ old('quantity') }}" @elseif(isset($data->quantity)) value="{{$data->quantity}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Tamanhos </label>
                    <select class="form-control js-basic-multiple" name="sizes[]" multiple>
                      <option value="">Select Size</option>
                      <option value="728x90" @if(isset($sizes)) @if(in_array('728x90', $sizes)) selected @endif @endif >(728x90)</option>
                      <option value="468x60" @if(isset($sizes)) @if(in_array('468x60', $sizes)) selected @endif @endif >(468x60)</option>
                      <option value="234x60" @if(isset($sizes)) @if(in_array('234x60', $sizes)) selected @endif @endif >(234x60)</option>
                      <option value="125x125" @if(isset($sizes)) @if(in_array('125x125', $sizes)) selected @endif @endif >(125x125)</option>
                      <option value="120x600" @if(isset($sizes)) @if(in_array('120x600', $sizes)) selected @endif @endif >(120x600)</option>
                      <option value="160x600" @if(isset($sizes)) @if(in_array('160x600', $sizes)) selected @endif @endif >(160x600)</option>
                      <option value="180x150" @if(isset($sizes)) @if(in_array('180x150', $sizes)) selected @endif @endif >(180x150)</option>
                      <option value="120x240" @if(isset($sizes)) @if(in_array('120x240', $sizes)) selected @endif @endif >(120x240)</option>
                      <option value="200x200" @if(isset($sizes)) @if(in_array('200x200', $sizes)) selected @endif @endif >(200x200)</option>
                      <option value="250x250" @if(isset($sizes)) @if(in_array('250x250', $sizes)) selected @endif @endif >(250x250)</option>
                      <option value="200x50" @if(isset($sizes)) @if(in_array('200x50', $sizes)) selected @endif @endif >(200x50)</option>
                      <option value="300x250" @if(isset($sizes)) @if(in_array('300x250', $sizes)) selected @endif @endif >(300x250)</option>
                      <option value="336x280" @if(isset($sizes)) @if(in_array('336x280', $sizes)) selected @endif @endif >(336x280)</option>
                      <option value="300x600" @if(isset($sizes)) @if(in_array('300x600', $sizes)) selected @endif @endif >(300x600)</option>
                      <option value="300x1050" @if(isset($sizes)) @if(in_array('300x1050', $sizes)) selected @endif @endif >(300x1050)</option>
                      <option value="320x50" @if(isset($sizes)) @if(in_array('320x50', $sizes)) selected @endif @endif >(320x50)</option>
                      <option value="320x100" @if(isset($sizes)) @if(in_array('320x100', $sizes)) selected @endif @endif >(320x100)</option>
                      <option value="970x90" @if(isset($sizes)) @if(in_array('970x90', $sizes)) selected @endif @endif >(970x90)</option>
                      <option value="970x250" @if(isset($sizes)) @if(in_array('970x250', $sizes)) selected @endif @endif >(970x250)</option>
                      <option value="728x20" @if(isset($sizes)) @if(in_array('728x20', $sizes)) selected @endif @endif >(728x20)</option>
                      <option value="600x120" @if(isset($sizes)) @if(in_array('600x120', $sizes)) selected @endif @endif >(600x120)</option>
                      <option value="300x50" @if(isset($sizes)) @if(in_array('300x50', $sizes)) selected @endif @endif >(300x50)</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Dispositivos </label>
                    <select class="form-control" name="device">
                      <option value="">Dispositivos</option>
                      <option value="1" @if(isset($data->device)) @if($data->device == 1) selected @endif @endif>Desktop</option>
                      <option value="2" @if(isset($data->device)) @if($data->device == 2) selected @endif @endif>Mobile</option>
                      <option value="3" @if(isset($data->device)) @if($data->device == 3) selected @endif @endif>AMP</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Posição </label>
                    <select class="form-control" name="position">
                      <option value="">Posição</option>
                      <option value="paragraph" @if(isset($data->position)) @if($data->position == 'paragraph') selected @endif @endif>Parágrafos</option>
                      <option value="after_the_content" @if(isset($data->position)) @if($data->position == 'after_the_content') selected @endif @endif>Final do Conteúdo Post</option>
                      <option value="before_the_home" @if(isset($data->position)) @if($data->position == 'before_the_home') selected @endif @endif> Antes do Conteúdo Home</option>
                      <option value="before_the_pages" @if(isset($data->position)) @if($data->position == 'before_the_pages') selected @endif @endif> Antes do Conteúdo Pages</option>
                      <option value="before_the_content" @if(isset($data->position)) @if($data->position == 'before_the_content') selected @endif @endif> Antes do Conteúdo Post</option>
                      <option value="ad_shortcode" @if(isset($data->position)) @if($data->position == 'ad_shortcode') selected @endif @endif> Shortcode </option>
                      <option value="fixedMobile" @if(isset($data->position)) @if($data->position == 'fixedMobile') selected @endif @endif> Fixed Mobile </option>
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
  @endsection
