@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-2">
  </div>
  <div class="col-md-8">
    @if($data->type == 1)
    <a href="{{$data->link}}" @if($data->open_page == 1) target="_blank" @endif>
      <img src="{{URL('assets/painel/uploads/pages')}}/{{$data->image}}" class="img-fluid" alt="">
    </a>
    @else
      <iframe width="100%" height="500" src="{{$data->link}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @endif
  </div>
</div>



@endsection
