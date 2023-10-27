@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Bidder Placement</h4>
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf
            <input type="hidden" name="id_prebid_bids" value="{{session('id_prebid_bids')}}">
            <div class="row">
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Placement</label>
                    <input type="text" class="form-control" name="placement" @if(old('placement') != null) value="{{ old('placement') }}" @elseif(isset($data->placement)) value="{{$data->placement}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Slot Sizes</label>
                    <input type="text" class="form-control" name="slot_sizes" @if(old('slot_sizes') != null) value="{{ old('slot_sizes') }}" @elseif(isset($data->slot_sizes)) value="{{$data->slot_sizes}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">placementId</label>
                    <input type="text" class="form-control" name="placementId" @if(old('placementId') != null) value="{{ old('placementId') }}" @elseif(isset($data->placementId)) value="{{$data->placementId}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">publisherId</label>
                    <input type="text" class="form-control" name="publisherId" @if(old('publisherId') != null) value="{{ old('publisherId') }}" @elseif(isset($data->publisherId)) value="{{$data->publisherId}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">zoneId</label>
                    <input type="text" class="form-control" name="zoneId" @if(old('zoneId') != null) value="{{ old('zoneId') }}" @elseif(isset($data->zoneId)) value="{{$data->zoneId}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Região</label>
                    <input type="text" class="form-control" name="region" @if(old('region') != null) value="{{ old('region') }}" @elseif(isset($data->region)) value="{{$data->region}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">pageId</label>
                    <input type="text" class="form-control" name="pageId" @if(old('pageId') != null) value="{{ old('pageId') }}" @elseif(isset($data->pageId)) value="{{$data->pageId}}"  @endif>
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
