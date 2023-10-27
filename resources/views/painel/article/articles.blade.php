@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Artigo</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Assunto</th>
                <th scope="col">Visualizar</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  {{$dado->subject}}
                </td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/eye/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-dark" title="Atualizar/Visualizar">
                    <i class="fa fa-eye"></i>
                  </a>
                </td>
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
        {!! $data->render() !!}
      </div>
    </div>
  </div>
</div>
</div>



@endsection
