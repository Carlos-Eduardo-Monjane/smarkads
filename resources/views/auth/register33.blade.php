@inject('Settings', 'App\Models\Painel\Settings')
@inject('DomainCategory', 'App\Models\Painel\DomainCategory')
@extends('auth.layouts.app')
@section('content')


<div class="app" style="background-color: #4a4a4a;">
  <div class="app-wrap">


    <div class="app-contant">
      <div class="bg-white">
        <div class="container-fluid p-0">
          <div class="row no-gutters" style="background-color: #fff;">
            <div class="col-sm-6 col-lg-6 col-xxl-5 align-self-center order-1 order-sm-1">
              <div class="login p-50">

                <center><img class="img-fluid" id="logomarcax" style="margin-left: -1700px !important;opacity:0.2 !important;" src="{{URL('/assets/painel/uploads/settings')}}/logoMonetizerAds.png" style="max-width: 100%;"></center>

                <script>
                    $(document).ready(function(){
                        $('#logomarcax').animate({
                            marginLeft: '0px',
                            opacity: 1
                        });
                    }, 800);
                </script>

                <h1 class="mb-2" style="color: #000;">Registrar</h1>
                <p>Bem-vindo, por favor, preencha o formulário para concluir seu cadastro.</p>
                <br>

                <form method="POST" action="{{ route('register') }}">

                  @csrf

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label" style="color: #000;">Nome*</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nome" />
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" style="color: #000;">E-mail*</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" style="color: #000;">WhatsApp*</label>
                        <input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="WhatsApp" />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" style="color: #000;">Senha*</label>
                        <input type="password" name="password" class="form-control" placeholder="Senha" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" style="color: #000;">Repetir Senha*</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repetir Senha" />
                      </div>
                    </div>
                  </div>


                  <div class="inputRows">
                    <div id="newRow-1" >
                      <div class="row" style="border-top: 1px solid #f0f0f0; margin-top: 5px;">
                        <br>
                        <div class="col-md-6" style="margin-top: 5px;">
                          <div class="form-group">
                            <label class="control-label" style="color: #000;">Domínio*</label>
                            <input type="text" class="form-control" name="domains[1][name]" required/>
                          </div>
                        </div>

                        <div class="col-md-3" style="margin-top: 5px;">
                          <div class="form-group">
                            <label class="control-label" style="color: #000;">Categoria*</label>
                            <select  class="form-control" name="domains[1][id_domain_category]">
                              @foreach($DomainCategory->get() as $Category)
                              <option value="{{$Category->id_domain_category}}"> {{$Category->name}} </option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3" style="margin-top: 5px;">
                          <div class="form-group">
                            <label class="control-label" style="color: #000;">PageViews/Mês*</label>
                            <input type="text" class="form-control" name="domains[1][page_views]" required/>
                          </div>
                        </div>

                        <div class="col-2" id="button-delete" style="margin-bottom: 3px;">

                        </div>

                      </div>
                    </div>
                    <br>
                  </div>

                  <div class="row">
                    <div class="col-sm-12" style="margin-top: 15px;">
                      <button type="button" id="addRow" class="btn btn-icon btn-round btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 mt-3">
                      <button type="submit" class="btn btn-danger text-uppercase">Registrar</button>
                    </div>

                    <div class="col-12  mt-3">
                      <p style="color: #000;">Já tem registro?<a href="/login" style="color: #000;"> Realizar login</a></p>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <div class="col-sm-6 col-xxl-7 col-lg-6 o-hidden order-2 order-sm-2" style="text-align: right; background-image: url('{{URL('/assets/painel/uploads/settings/mymonetize-e390011d10e8e930fcb98b534b263f17.jpg')}}'); background-size: cover; height: 100vh;background-position: left;">
              <div class="row align-items-center h-100">
                <div class="col-12 mx-auto">
                    &nbsp;
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')

<script type="text/javascript">

$(document).ready(function(){

    $('.inputRows').on('click', 'button' ,function(){
  $(this).parent().parent().remove();
});

$('#addRow').click(function(){
  var $newRow = $('div[id^="newRow"]:first').clone(),
  newId = Number($('div[id^="newRow"]:last').attr('id').split('-')[1]) + 1;

  $newRow.find('#button-delete').append('<button type="button" class="btn btn-icon btn-round btn-danger" style="margin-top: 5px; margin-bottom: 5px;"><i class="fa fa-trash"></i></button>');
  $newRow.find('input').val('');

  $newRow.find('input').each(function() {
    var name = this.name;
    this.name = name.replace('[1]','['+(newId)+']');
  });

  $newRow.find('select').each(function() {
    var name = this.name;
    this.name = name.replace('[1]','['+(newId)+']');
  });

  $newRow.attr('id','newRow-' + newId);
  $('.inputRows').append($newRow);
});

});

</script>


<script type="text/javascript">
$(document).ready(function(){
  var maxField = 10; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var wrapper = $('#domains'); //Input field wrapper
  var fieldHTML = '<div class="col-4"><div class="form-group"><label class="control-label">Domínio*</label><input type="email" class="form-control" name="email" placeholder="Email" /></div></div><div class="col-3"><div class="form-group"><label class="control-label">Categoria*</label><input type="text" class="form-control" name="whatsapp" placeholder="WhatsApp" /></div></div><div class="col-3"><div class="form-group"><label class="control-label">PageViews/Mês*</label><input type="text" class="form-control" name="whatsapp" placeholder="WhatsApp" /></div></div><div class="col-2"><div class="form-group"><label class="control-label">Add/Remove</label> <a href="javascript:void(0);" class="remove_button"><img src="/assets/painel/images/icon-subtract.png" width="25"></a> </div></div>'; //New input field html
  var x = 1; //Initial field counter is 1

  //Once add button is clicked
  $(addButton).click(function(){
    //Check maximum number of input fields
    if(x < maxField){
      x++; //Increment field counter
      $(wrapper).append(fieldHTML); //Add field html
    }
  });

  //Once remove button is clicked
  $(wrapper).on('click', '.remove_button', function(e){
    e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    x--; //Decrement field counter
  });
});
</script>
@endsection
