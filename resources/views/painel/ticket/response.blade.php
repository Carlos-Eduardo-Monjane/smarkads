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
          <div class="col-md-4 col-xxl-2 col-md-4">
            <div class="mail-sidebar">
              <div class="row justify-content-center">
                <div class="col-12">
                  <div class="text-center mail-sidebar-title px-4">
                    <a href="/{{$principal}}/ticket/create" class="btn btn-primary btn-block py-3 font-weight-bold font-18">Ticket <i class="fa fa-plus pl-2"></i></a>
                  </div>
                </div>
                <div class="col-12">
                  <div class="px-4 py-4">
                    <ul class="pl-0">
                      @foreach($ticketStatuss as $ticketStatus)
                      <li class="py-2">
                        <a href="/{{$principal}}/{{$rota}}/response/{{$ticketStatus->id_ticket_status}}">
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
          <div class="col-md-8  col-xxl-4 border-md-t">
            <div class="mail-content  border-right border-n h-100">
              <!-- <div class="mail-search border-bottom">
                <div class="row align-items-center mx-0">
                  <div class="col-12">
                    <div class="form-group pt-3">
                      <input type="text" class="form-control" id="search" placeholder="Search..">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
              </div> -->
              <?php if(empty($idStatus)){ $idStatus = 1; } ?>
              @if(empty($responses[0]) && empty($ticketSelected->description))
              <div class="mail-msg scrollbar scroll_dark">
                @foreach($tickets as $ticket)
                <div class="mail-msg-item">
                  <a href="/{{$principal}}/{{$rota}}/response/{{$idStatus}}/{{$ticket->id_ticket}}">
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

              <div class="col-xl-12 col-xxl-12 border-md-t">
                <div class="app-chat-msg">
                  <div class="d-flex align-items-center justify-content-between p-3 px-4 border-bottom">
                    <div class="app-chat-msg-title">
                      <h4 class="mb-0">{{$ticketSelected->name}}</h4>
                      <!-- <p class="text-success">
                        Online
                      </p> -->
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
                        <div class="chat-msg-content">
                          {!! $ticketSelected->description !!}
                        </div>
                      </div>
                    </div>
                    <div class="text-center py-4">
                      <h6>30 May</h6>
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
                        <div class="chat-msg-content">
                          {!! $response->response !!}
                        </div>
                      </div>
                    </div>
                    @else
                    <div class="chat chat-left justify-content-end">
                      <div class="chat-msg">
                        <div class="chat-msg-content" style="color: #fff !important">
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
                            <input name="type" value="1" type="hidden">
                            <input name="status" value="{{$idStatus}}" type="hidden">
                            <input name="redirect" value="response" type="hidden">
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
