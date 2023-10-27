@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Blocos Automáticos </h4>
          <p>Dominio: <strong><a href="https://{{$domain['name']}}/" style="color:#136e38">{{$domain['name']}}</a></strong></p>
         
        </div>
      </div>
        <div class="card-body">
        
        <p>Para exibir os blocos automáticos em seu site, copie e cole o script abaixo na seção `body` de seu site.<br />[Se o seu site utiliza o WordPress, você pode instalar o plugin "<a href="https://wordpress.org/plugins/insert-headers-and-footers/" target="_blank">Insert Headers and Footer</a>" e inserir em "Script's in Body"].<br />
        Não esqueça de adicionar o ads.txt na pasta principal de seu site. </p>
        <br />
        <div class="row">
          <div class="col-md-6">        
            <p>Sem cache (*porem mais lento).</p>
            <textarea  rows="1"  class="form-control" readonly><script src="https://<?php echo $_SERVER['SERVER_NAME'] ?>/scripts/domain_{{$domain['id_domain']}}.js"></script></textarea><br />
          </div>
          
        
        
        <table id="table" class="table mb-0">
            <thead class="thead-light">
              <tr   class="text-center">

                <th scope="col" width="300">Formato</th>
                <th scope="col">Nome</th>
                <th scope="col" width="85">Status</th>
                

              </tr>
            </thead>
                <?php foreach($blocos as $bloco){ ?>
                <tr>
                    <td><img src="{{$bloco['img']}}"></td>
                    <td style="text-align:center"><?php echo $bloco['name'] ?></td>
                    <td style="text-align:center"><div class="form-group">
                    <!-- <label for="inputEmail4">Status</label> -->
                    <div class="checkbox checbox-switch switch-success" style="text-align:left">
                      <label>
                        <input type="hidden" name="{{$bloco['field']}}" value="0" />
                        <input type="checkbox" class="checkok" data-domain_id="{{$domain['id_domain']}}" data-id="{{$bloco['field']}}"  name="{{$bloco['field']}}" value="1" <?php if($bloco['status'] == 1){ echo 'checked'; } ?>/>
                        <span></span>
                      </label>
                    </div>
                  </div></td>
                </tr>
                <?php } ?>

            <tbody>
            </tbody>
        </table>

        
        
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('scripts')
  <script>
  $('.js-basic-multiple').select2();

  $(".checkok").change(function(e){
    
        $valor  = $(this).prop('checked')
        $id     = $(this).attr('data-id');
        $domain_id     = $(this).attr('data-domain_id');
        
        
           
            $.ajax({
                type: "POST",   
                url: "/painel/domain/blocos-fixos/"+$domain_id ,
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_domain':$domain_id,
                    'type': $id
                },
                success: function (response) {
                    console.debug(response);
                    $.ajax({
                        type: "GET",   
                        url: "/painel/domain/generate-block-fixed/"+$domain_id ,
                        success: function (response) {
                            console.debug(response);
                        }
                    });
                }
            });

            

        
    
  })

  </script>
  @endsection
