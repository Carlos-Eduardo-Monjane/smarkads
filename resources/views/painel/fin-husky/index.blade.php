@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h3 class="card-title" style="float:left"><?php echo $title ?></h3>
          <div style="float:right;">
          <h5 style="float:left;margin-right:10px;margin-top:10px;">Envio de Pagamentos</h5>

            @if($mp)
              <a href="#" data-id="{{$mp->id_fin_mass_payment}}" data-husky="{{$mp->id_husky}}" class="btn btn-success closeMP">Fechar</a>
            @else
              <a href="#" class="btn btn-danger abrirMP">Abrir</a>
            @endif
            
          
          </div>
          
          <br>

          
         
				
        
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Dolar</th>
                <th scope="col">Real</th>
                <th scope="col">Transações</th>
                <th scope="col">Processamento</th>
                <th scope="col">Visualizar</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado['id']}}</td>
                <td>{{$dado['formatted_total_value']}}</td>
                <td>{{$dado['formatted_total_final_value']}}</td>
                <td>{{$dado['number_of_transaction']}}</td>
                <td>{{round($dado['processed'],2)}}%</td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/view/{{$dado['id']}}" class="btn btn-icon btn-round btn-info" title="Atualizar/Visualizar">
                    <i class="fa fa-eye"></i>
                  </a></td>
              </tr>
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@section('scripts')
<script>
    $('.abrirMP').click(function(e){
			e.preventDefault();
			$.ajax({
				type: "GET",
				url: "/{{$principal}}/{{$rota}}/create_mp/",
				success: function (response) {
					console.debug(JSON.parse(response));
					location.reload();					
				}
			});
		})

		$('.closeMP').click(function(e){
			e.preventDefault();
			var $id = $(this).attr('data-id');
			var $husky_id = $(this).attr('data-husky');
			$.ajax({
				type: "GET",
				url: "/{{$principal}}/{{$rota}}/close_mp/"+$id+'/'+$husky_id,
				success: function (response) {
					console.debug(JSON.parse(response));
					location.reload();				
				}
			});
		})
</script>
@endsection