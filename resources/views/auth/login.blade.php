@inject('Settings', 'App\Models\Painel\Settings')
@inject('DomainCategory', 'App\Models\Painel\DomainCategory')
@extends('auth.layouts.app')
@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<div class="app-auth" id="authLogin">

    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--4-col boxLoginPro">

            
            
            @include('auth.boxLogin')
            @include('auth.boxRegister')

            <div class="allright">
                <p>&copy; All Rights Reserved. MonetizerAds.</p>
            </div>

        </div>

        <div class="mdl-cell mdl-cell--8-col signUpEmpty">

            <div>
                <script>

                    $(document).ready(function(){

                        // MOBILE

                        $('#openWindowSignUp2').on('click', function(){

                        if($('#windowSignIn').hasClass('activeWindow')){

                            $('#textSignUpEmpty').html('Crie sua conta para obter acesso aos recursos da <strong>MonetizerAds</strong>');


                            $('#windowSignIn').hide().removeClass('activeWindow');

                            $('#windowSignUp').fadeIn('fast');
                            $('#windowSignUp').addClass('activeWindow');

                            $('#openWindowSignUp2').hide().removeClass('activeWindow');
                            $('#openWindowSignIn').fadeIn('fast').addClass('activeWindow');
                            
                        }

                        });


                        // login

                        $('#openWindowSignIn2').on('click', function(){

                            if($('#windowSignUp').hasClass('activeWindow')){

                                $('#textSignUpEmpty').html('Faça login com sua conta da <strong>MonetizerAds</strong>');

                                $('#windowSignUp').hide().removeClass('activeWindow');
                                
                                $('#windowSignIn').fadeIn('fast');
                                $('#windowSignIn').addClass('activeWindow');

                                $('#openWindowSignIn2').hide().removeClass('activeWindow');
                                $('#openWindowSignUp').fadeIn('fast').addClass('activeWindow');
                                
                            }

                        });

                        // DESKTOP 

                        $('#openWindowSignUp').on('click', function(){

                            if($('#windowSignIn').hasClass('activeWindow')){

                                $('#textSignUpEmpty').html('Crie sua conta para obter acesso aos recursos da <strong>MonetizerAds</strong>');


                                $('#windowSignIn').hide().removeClass('activeWindow');

                                $('#windowSignUp').fadeIn('fast');
                                $('#windowSignUp').addClass('activeWindow');

                                $('#openWindowSignUp').hide().removeClass('activeWindow');
                                $('#openWindowSignIn').fadeIn('fast').addClass('activeWindow');
                                
                            }

                        });


                        // login

                        $('#openWindowSignIn').on('click', function(){

                            
                            
                            if($('#windowSignUp').hasClass('activeWindow')){

                                $('#textSignUpEmpty').html('Faça login com sua conta da <strong>MonetizerAds</strong>');

                                $('#windowSignUp').hide().removeClass('activeWindow');
                                
                                $('#windowSignIn').fadeIn('fast');
                                $('#windowSignIn').addClass('activeWindow');

                                $('#openWindowSignIn').hide().removeClass('activeWindow');
                                $('#openWindowSignUp').fadeIn('fast').addClass('activeWindow');
                                
                            }

                        });


                        $('#logomarcax').animate({
                            marginTop: '0px',
                            opacity: 1
                        }, 500);

                        $('#textSignUpEmpty').animate({
                            opacity: 0.1
                        }, 100);

                        $('#textSignUpEmpty').animate({
                            opacity: 0.3
                        }, 200);

                        $('#textSignUpEmpty').animate({
                            opacity: 0.8
                        }, 400);

                        $('#textSignUpEmpty').animate({
                            opacity: 0.9
                        }, 500);

                    });
                </script>

                <img src="{{ asset('assets/site/brand2.png') }}" id="logomarcax">
                <h2 id="textSignUpEmpty">Crie sua conta para obter acesso aos recursos da <strong>MonetizerAds</strong></h2>

                <button id="openWindowSignUp" class="btnSignUp" style="margin-top: 20px;width: 300px;float:left;" type="button"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; CRIAR UMA CONTA</button>

                <button id="openWindowSignIn" class="btnSignUp" style="margin-top: 20px;width: 300px;float:left;" type="button"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; FAZER LOGIN</button>


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