@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Prebid Bids</h4>
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
              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Nome</label>
                    <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Bidder</label>
                    <input type="text" class="form-control" name="bidder" @if(old('bidder') != null) value="{{ old('bidder') }}" @elseif(isset($data->bidder)) value="{{$data->bidder}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Network</label>
                    <input type="text" class="form-control" name="network" @if(old('network') != null) value="{{ old('network') }}" @elseif(isset($data->network)) value="{{$data->network}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Bid Floor</label>
                    <input type="text" class="form-control" name="bid_floor" @if(old('bid_floor') != null) value="{{ old('bid_floor') }}" @elseif(isset($data->bid_floor)) value="{{$data->bid_floor}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Reserve</label>
                    <input type="text" class="form-control" name="reserve" @if(old('reserve') != null) value="{{ old('reserve') }}" @elseif(isset($data->reserve)) value="{{$data->reserve}}"  @endif>
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
