@extends('painel.layouts.app')
@section('content')

      <div class="row">
         <div class="col-md-12">
            <div class="card card-statistics">
               <div class="card-header">
                  <div class="card-heading">
                     <h4 class="card-title">Página</h4>
                  </div>
               </div>
               <div class="card-body">
                  @if(isset($data->$primaryKey))
                  <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
                     @else
                     <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="form-row">
                           <div class="form-group col-md-2">
                              <label for="inputEmail4">Icone</label>
                              <input type="text" class="form-control" name="icon" @if(old('icon') != null) value="{{ old('icon') }}" @elseif(isset($data->icon)) value="{{$data->icon}}"  @endif>
                           </div>
                           <div class="form-group col-md-4">
                              <label for="inputEmail4">Nome</label>
                              <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                           </div>
                           <div class="form-group col-md-2">
                              <label for="inputEmail4">Posição</label>
                              <input type="text" class="form-control" name="position" @if(old('position') != null) value="{{ old('position') }}" @elseif(isset($data->position)) value="{{$data->position}}"  @endif>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="inputEmail4">Novo?</label>
                                 <div class="checkbox checbox-switch switch-success">
                                    <label>
                                       <input type="hidden" name="new" value="0" />
                                       <input type="checkbox" name="new"  @if(isset($data->new)) @if($data->new == 1) checked="checked" @endif @endif value="1"/>
                                       <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-2">
                              <div class="form-group">
                                <label for="inputEmail4">Nova Aba</label>
                                 <div class="checkbox checbox-switch switch-success">
                                    <label>
                                       <input type="hidden" name="open_page" value="0" />
                                       <input type="checkbox" name="open_page"  @if(isset($data->open_page)) @if($data->open_page == 1) checked="checked" @endif @endif value="1"/>
                                       <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-8">
                             <label for="inputEmail4">Url</label>
                             <input type="text" class="form-control" name="link" @if(old('link') != null) value="{{ old('link') }}" @elseif(isset($data->link)) value="{{$data->link}}"  @endif>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group col-md-12">
                              <label for="inputState">Tipo</label>
                              <select name="type" class="form-control">
                                <option value="">Selecione</option>
                                <option value="1" @if(isset($data->type)) @if($data->type == 1) selected="true" @endif @endif>Imagem</option>
                                <option value="2" @if(isset($data->type)) @if($data->type == 2) selected="true" @endif @endif>Video</option>
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="input-group mb-12">
                           <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                           </div>
                           <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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
