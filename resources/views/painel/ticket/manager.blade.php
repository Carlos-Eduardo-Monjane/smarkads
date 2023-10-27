@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12 m-b-30">
    <div class="d-block d-sm-flex flex-nowrap align-items-center">
      <div class="page-title mb-2 mb-sm-0">
        <h1>Tickets</h1>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card card-statistics mail-contant">
      <div class="card-body p-0">
        <div class="row no-gutters">
          <div class="col-md-4">
            <div class="mail-sidebar">
              <div class="row justify-content-center">
                <div class="col-12">
                  <div class="text-center mail-sidebar-title px-4">
                    <a href="/{{$principal}}/assignment" class="btn btn-primary btn-block py-3 font-weight-bold font-18">Tarefa <i class="fa fa-plus pl-2"></i></a>
                  </div>
                </div>
                <div class="col-12">
                  <div class="px-4 py-4">
                    <ul class="pl-0">
                      @foreach($ticketStatuss as $ticketStatus)
                      <li class="py-2">
                        <a href="/{{$principal}}/{{$rota}}/manager/{{$ticketStatus->id_ticket_status}}">
                          <span class="nav align-items-center">
                            <span>
                              <i class="fa fa-envelope-o text-primary pr-4"></i>
                            </span>
                            <span>
                              <span>{{$ticketStatus->name}}</span>
                            </span>
                            <span class="nav-item ml-auto text-right">
                              <span class="badge badge-pill badge-primary float-right">{{$ticketStatus->total}}</span>
                            </span>
                          </span>
                        </a>
                      </li>
                      <hr>
                      @endforeach
                    </ul>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 border-md-t">
            <div class="mail-content  border-right border-n h-100">
              <?php if(empty($idStatus)){ $idStatus = 1; } ?>
              @if(empty($responses[0]) && empty($ticketSelected->description))
              <div class="mail-msg scrollbar scroll_dark">
                @foreach($tickets as $ticket)
                <div class="mail-msg-item">
                  <a href="/{{$principal}}/{{$rota}}/manager/{{$idStatus}}/{{$ticket->id_ticket}}">
                    <div class="media align-items-center">
                      <div class="mr-3">
                        <div class="bg-img">
                          <img src="{{URL('assets/painel')}}/img/avtar/02.jpg" class="img-fluid" alt="user">
                        </div>
                      </div>
                      <div class="w-100">
                        <div class="mail-msg-item-titel justify-content-between">
                          <p>{{$ticket->name}} ({{$ticket->domain}})</p>
                          <p class="d-none d-xl-block"> {{date('d/m/Y H:i', strtotime($ticket->created_at))}} </p>
                        </div>
                        <h5 class="mb-0 my-2">{{$ticket->subject}}</h5>
                        <p>{!! substr(strip_tags($ticket->description), 0, 140) !!} ...</p>
                        <p class="d-xl-none"> {{date('d/m/Y H:i', strtotime($ticket->created_at))}} </p>
                      </div>
                    </div>
                  </a>
                </div>
                @endforeach
              </div>

              @else

              <div class="col-md-12 border-md-t">
                <div class="app-chat-msg">
                  <div class="d-flex align-items-center justify-content-between p-3 px-4 border-bottom">
                    <div class="app-chat-msg-title">
                        <h4 class="mb-0"><a href="/painel/users/clients/{{$ticketSelected->id}}">{{$ticketSelected->name}}</a></h4>
                    </div>
                    <div class="col-md-4">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for=""> Status </label>
                          <select class="form-control" name="id_ticket_status" id="status">
                            @foreach($status as $s)
                            <option value="{{$s->id_ticket_status}}" @if(isset($idStatus)) @if($idStatus == $s->id_ticket_status) selected="true" @endif @endif>{{$s->name}} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="scrollbar scroll_dark app-chat-msg-chat p-4">

                  <div class="chat">
                    <div class="chat-img">
                      <a data-placement="left" data-toggle="tooltip" href="javascript:void(0)">
                        <div class="bg-img">
                          <img class="img-fluid" src="{{URL('assets/painel')}}/img/avtar/02.jpg" alt="user">
                        </div>
                      </a>
                    </div>
                    <div class="chat-msg">
                      <small>{{Helper::formatDateTime($ticketSelected->created_at)}}</small>
                        <div class="chat-msg-content">
                          <small>{{$ticketSelected->usuario}} diz:</small><br />
                          {!! $ticketSelected->description !!}
                        </div>
                    </div>
                  </div>
                  
                  @foreach($responses as $response)
                  @if($response->type == 1)
                  <div class="chat">
                    <div class="chat-img">
                      <a data-placement="left" data-toggle="tooltip" href="javascript:void(0)">
                        <div class="bg-img">
                          <img class="img-fluid" src="{{URL('assets/painel')}}/img/avtar/02.jpg" alt="user">
                        </div>
                      </a>
                    </div>
                    <div class="chat-msg">
                      <a href="/{{$principal}}/assignment/create/{{$response->id_ticket_response}}">
                      <small>{{Helper::formatDateTime($response->created_at)}}</small>
                        <div class="chat-msg-content">
                        <small>{{$response->usuario}} diz:</small><br />
                          {!! $response->response !!}
                        </div>
                      </a>
                    </div>
                  </div>
                  @else
                  <div class="chat chat-left justify-content-end">
                    <div class="chat-msg">
                    <small>{{Helper::formatDateTime($response->created_at)}}</small>
                      <div class="chat-msg-content" style="color: #fff !important">
                      <small>{{$response->usuario}} diz:</small><br />
                        {!! $response->response !!}
                      </div>
                    </div>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
              <div class="app-chat-type">
                <div class="input-group mb-0 ">
                  <div class="input-group-prepend d-none d-sm-flex">
                    <span class="input-group-text">
                      <i class="fa fa-smile-o">
                      </i>
                    </span>
                  </div>

                  <form method="POST" action="/{{$principal}}/{{$rota}}/response" accept-charset="UTF-8" enctype="multipart/form-data" style="width: 75%;" id="myForm">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <input class="form-control" name="response" type="text">
                        <input name="id_ticket" value="{{$ticketSelected->id_ticket}}" type="hidden">
                        <input name="type" value="2" type="hidden">
                        <input name="status" value="{{$idStatus}}" type="hidden">
                        <input name="redirect" value="manager" type="hidden">
                      </div>
                    </div>
                  </form>

                  <div class="input-group-prepend">
                    <button type="submit" class="btn input-group-text" onclick="document.getElementById('myForm').submit();">
                      <i class="fa fa-paper-plane"></i>
                    </button>
                  </div>

                </div>
              </div>
            </div>
            @endif

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
  $("#status").change(function(){
    $.get("/{{$principal}}/{{$rota}}/change-status/"+{{$ticket}}+"/"+$("#status").val());
  });
</script>
@endsection
