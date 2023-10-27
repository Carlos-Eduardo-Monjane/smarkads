@extends('painel.layouts.app')
@section('content')

      <div class="row">
         <div class="col-md-12">
            <div class="card card-statistics">
               <div class="card-header">
                  <div class="card-heading">
                     <h4 class="card-title">Modal</h4>
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
                           <div class="col-md-2">
                              <div class="form-group">
                                 <div class="checkbox checbox-switch switch-success">
                                    <label>
                                       <input type="hidden" name="status" value="0" />
                                       <input type="checkbox" name="status"  @if(isset($data->status)) @if($data->status == 1) checked="checked" @endif @endif value="1"/>
                                       <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-10">
                              <div class="custom-file">
                                 <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                 <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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
