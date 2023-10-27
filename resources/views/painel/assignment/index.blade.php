@extends('painel.layouts.app')
@section('content')

<style>
<?php $class = ""; ?>
@foreach($status as $s)
<?php $class .= "#sortable_$s->id_assignment_status, "; ?>
@endforeach

{{rtrim($class, ', ')}} {
  border: 1px solid #eee;
  width: 300px;
  min-height: 20px;
  list-style-type: none;
  margin: 0;
  padding: 5px 0 0 0;
  float: left;
  margin-right: 10px;
}
<?php $class_li = ""; ?>
@foreach($status as $s)
<?php $class_li .= "#sortable_$s->id_assignment_status li,"; ?>
@endforeach
{{rtrim($class_li, ', ')}} {
  margin: 0 5px 5px 5px;
  padding: 5px;
  font-size: 1.2em;
  width: 300px;
}
</style>


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Tarefas</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
          <br>
          <form method="post" action="/{{$principal}}/{{$rota}}/filter{{$page}}"  style="margin-top:20px">
            {!! csrf_field() !!}
            <div class="row">
              <div class="col-md-3">
                <select class="form-control" name="status">
                  <option value="" @if(session('id_assignment_status') == '') selected @endif> Status</option>
                  @foreach($status as $s)
                  <option value="{{$s->id_assignment_status}}" @if(session('id_assignment_status') == $s->id_assignment_status) selected @endif> {{$s->name}} </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="department">
                  <option value="" @if(session('id_department') == '') selected @endif> Departamento</option>
                  @foreach($departments as $department)
                  <option value="{{$department->id_department}}" @if(session('id_department') == $department->id_department) selected @endif> {{$department->name}} </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="user_id">
                  <option value="" @if(session('user_id') == '') selected @endif> Responsável</option>
                  @foreach($users as $user)
                  <option value="{{$user->id}}" @if(session('user_id') == $user->id) selected @endif> {{$user->name}} </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="subject" @if(session('subject')) value="{{session('subject')}}" @else value="" @endif placeholder="Assunto">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card-body">

        <!-- <div class="table-responsive">
        <table class="table mb-0">
        <thead class="thead-light">
        <tr>
        <th scope="col">Assunto</th>
        <th scope="col">Cliente</th>
        <th scope="col">Domínio</th>
        <th scope="col">Cronômetro</th>
        <th scope="col">Status</th>
        <th scope="col">Data/Hora</th>
        <th scope="col">Alterar</th>
        <th scope="col">Apagar</th>
      </tr>
    </thead>

    <tbody>
    @forelse($data as $dado)
    <tr>
    <td>
    <a href="#" data-toggle="modal" data-target="#modalAssignment-{{$dado->id_assignment}}">
    {{$dado->subject}}
  </a>
</td>
<td>
@if(!empty($dado->clientName))
<p class="list-group-item-text">
<a href="/{{$principal}}/users/show/{{$dado->id_client}}">
<span class="label label-info">{{$dado->clientName}}</span>
</a>
</p>
@endif
</td>
<td>
{{$dado->domainName}}
</td>
<td>
<button id="start-{{$dado->$primaryKey}}" href="/painel/assignment/show/6" class="font-40 btn btn-icon btn-round btn-danger" title="Atualizar/Visualizar" onclick="start({{$dado->$primaryKey}})"  @if($dado->statusWork == 0) style="display:block" @else style="display:none" @endif>
<i class="fa fa-clock-o"></i>
</button>
<div class="row">
<div id="timer-{{$dado->$primaryKey}}"  class="col-md-3" style="width: 50px; height: 50px; vertical-align: middle; line-height: 40px; @if($dado->statusWork == 0) display:none @else display:block @endif "  >
<span class="label label-info" id="count-{{$dado->$primaryKey}}">
@if($dado->statusWork == 1)
<?php
$date1 = strtotime($dado->start);
$date2 = strtotime(date('Y-m-d H:i:s'));
$diff = abs($date2 - $date1);
$hours = floor(($diff) / (60*60));
$minutes = floor(($diff - $hours*60*60)/ 60);
$seconds = floor(($diff - $hours*60*60 - $minutes*60));

if($hours < 10){
$hours = "0".$hours;
}
if($minutes < 10){
$minutes = "0".$minutes;
}
if($seconds < 10){
$seconds = "0".$seconds;
}

echo "$hours:$minutes:$seconds";
?>
@else
00:00:00
@endif
</span>
</div>

<div class="col-md-9">
<button id="stop-{{$dado->$primaryKey}}"  href="/painel/assignment/show/6" class="font-40 btn btn-icon btn-round btn-success" title="Atualizar/Visualizar" onclick="stop({{$dado->$primaryKey}})" @if($dado->statusWork == 0) style="display:none" @else style="display:block" @endif >
<i class="fa fa-clock-o"></i>
</button>
</div>
</div>
</td>
<td>
<p class="list-group-item-text">
<span class="label label-{{$dado->color}}">{{$dado->status}}</span>
</p>
</td>
<td>
<p class="list-group-item-text">
<span class="label label-warning">{{date('d-m-Y H:i',strtotime($dado->created_at))}}</span>
</p>
</td>
<td>
<a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-dark" title="Atualizar/Visualizar">
<i class="far fa-edit"></i>
</a>
</td>
<td>
<form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
{!! csrf_field() !!}
</form>
<button type="button" class="btn btn-icon btn-round btn-danger" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i></button>
</td>
</tr>


<div class="modal fade" id="modalAssignment-{{$dado->id_assignment}}" tabindex="-1" role="dialog" aria-labelledby="verticalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="verticalCenterTitle">Descrição da Tarefa</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-12">
<div style="height:350px; overflow: auto;">
{!! $dado->description !!}
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@empty
<tr>
<td colspan="100">Nenhum resultado encontrado</td>
</tr>
@endforelse
</tbody>
</table>
</div> -->

<div class="row">
  @foreach($status as $s)
  <div class="col-3">
    <div class="col-12 text-center">
      <label>{{$s->name}}</label>
    </div>
    <br>
    <div class="col-12 text-class">
      <ul id="sortable_{{$s->id_assignment_status}}" class="connectedSortable">
        @forelse($data->where('id_assignment_status', $s->id_assignment_status) as $dado)
        <li class="ui-state-default" id="{{$dado->$primaryKey}}"> <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->subject}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  @endforeach
</div>

</div>
</div>
</div>
</div>


@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( "{{rtrim($class,', ')}}" ).sortable({
    connectWith: ".connectedSortable",
    start: function(e, ui) {
      var newIndex = ui.item.index();
      var oldIndex = $(this).attr('data-previndex');
      var element_id = ui.item.attr('id');
      var id_assignment_status = e.target.id.split('_')[1];
      console.log(element_id);
      console.log(id_assignment_status);
      // creates a temporary attribute on the element with the old index
      $(this).attr('data-previndex', ui.item.index());
    },
    update: function(e, ui) {
      // gets the new and old index then removes the temporary attribute
      var newIndex = ui.item.index();
      var oldIndex = $(this).attr('data-previndex');
      var element_id = ui.item.attr('id');
      // alert('id of Item moved = '+element_id+' old position = '+oldIndex+' new position = '+newIndex);
      // $(this).removeAttr('data-previndex');

      var id_assignment_status = e.target.id.split('_')[1];
      var id_assignment = element_id;
      console.log(oldIndex+" => "+ id_assignment +" => "+ id_assignment_status);
      if(oldIndex === undefined){
        $.post("/painel/assignment/change-status", {id_assignment_status: id_assignment_status, id_assignment: id_assignment}, function(data, status){

        });
      }
    }
  }).disableSelection();
} );
</script>


<script type="text/javascript"><!--


var cronometros = [];

function start(id){

  document.getElementById("stop-"+id).style.display = "block";
  document.getElementById("start-"+id).style.display = "none";
  document.getElementById("timer-"+id).style.display = "block";

  cronometros[id] = setInterval(function () {
    toSeconds(id);
  }, 1000);

  $.get("/{{$principal}}/{{$rota}}/start-service/"+id);
}

function init(id){

  document.getElementById("stop-"+id).style.display = "block";
  document.getElementById("start-"+id).style.display = "none";
  document.getElementById("timer-"+id).style.display = "block";

  cronometros[id] = setInterval(function () {
    toSeconds(id);
  }, 1000);

}

@forelse($data as $dado)
@if($dado->statusWork == 1)
init({{$dado->$primaryKey}});
@endif
@endforeach



function stop(id){
  document.getElementById("start-"+id).style.display = "block";
  document.getElementById("stop-"+id).style.display = "none";
  document.getElementById("timer-"+id).style.display = "none";
  clearInterval(cronometros[id]);

  $.get("/{{$principal}}/{{$rota}}/stop-service/"+id);
}

function toSeconds(idDiv) {
  var s = document.getElementById("count-"+idDiv).innerHTML;

  var p = s.split(':');
  sec =  parseInt(p[0], 10) * 3600 + parseInt(p[1], 10) * 60 + parseInt(p[2], 10)+1;

  var result = fill(Math.floor(sec / 3600), 2) + ':' +
  fill(Math.floor(sec / 60) % 60, 2) + ':' +
  fill(sec % 60, 2);
  document.getElementById("count-"+idDiv).innerHTML = result;
}

function fill(s, digits) {
  s = s.toString();
  while (s.length < digits) s = '0' + s;
  return s;
}

</script>




@endsection
