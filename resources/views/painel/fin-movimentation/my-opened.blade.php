@extends('painel.layouts.app')
@section('content')


<div class="row">
      <div class="col-12 col-lg-12">
        <div class="card card-statistics">
          <div class="card-header">
            <div class="card-heading">
              <h4 class="card-title">Financeiro - Em aberto</h4>
            </div>
          </div>
          <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Mês</td>
                <th scope="col">Subtotal</th>
                <th scope="col">Invalidos</th>
                <th scope="col">Valor</th>
              </tr>
            </thead>
            <tbody>
            <?php $total = 0; $subtotal = 0; $invalido = 0; ?>
              
                <?php if (is_array($adx)) { foreach($adx as $key => $d){  ?>
                <?php  if($d['month'] >= '11' and $d['year'] >= '2019'){ ?>
              <tr>
                <td>{{$key}}</td>
                <td>$ {{Helper::moedaView($d['value'])}} <?php $subtotal += $d['value']; ?></td>
                <td>$ {{Helper::moedaView($d['invalid'])}} <?php $invalido += $d['invalid']; ?></td>
                <td>$ {{Helper::moedaView(($d['value']-$d['invalid']))}} <?php $total += ($d['value']-$d['invalid']); ?></td>
              </tr>
                <?php } ?>
              
                          
                <tr>
                  <th scope="col"><strong>Total: </total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($subtotal)}}</total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($invalido)}}</total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($total)}}</total></th>
                </tr>
                <?php }} ?>
						</tbody>
					</table>
				
        </div>
      </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')

@endsection