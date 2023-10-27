<?php
namespace App\Helpers;

class Helper
{
    public static function shout(string $string)
    {
        $encoding = 'UTF-8';
        if(isset($string)){
            return mb_convert_case($string, MB_CASE_UPPER, $encoding);
        }
        
        // return strtoupper($string);
    }

    public static function soNumero($str) {
        $saida = preg_replace("/[^0-9]/", "", $str);
        $saida = str_replace(" ","",$saida);
        return $saida;
      }
      public static function removeZero($str) {
        return str_replace("0", "", $str);
      }

    public static function removalHttp($str){
        $str = str_replace('http://','',$str);
        $str = str_replace('https://','',$str);
        return 'https://'.$str;
    }

    public static function formatDateTime($data){
        $old_date_timestamp = strtotime($data);
        $new_date = date('d/m/Y - H:i:s', $old_date_timestamp);
        return $new_date;
    }

    public static function formatDate($data){
        $old_date_timestamp = strtotime($data);
        $new_date = date('d/m/Y', $old_date_timestamp);
        return $new_date;
    }

    public static function formatData($data,$type){
        if($data != null){
            switch($type){
                case 1;
                    $date = explode('/',$data);
                    $newdate = $date[2].'-'.$date[1].'-'.$date[0];
                break;
                case 2;
                    $date = explode('-',$data);
                    $newdate = $date[2].'/'.$date[1].'/'.$date[0];
                break;
                case 3;
                    $date = explode('-',$data);
                    $newdate = $date[2].'-'.$date[1].'-'.$date[0];
                break;
            }
            return $newdate;
        }
    }

    public static function moedaSys($data){
        if($data != null){
            $date = str_replace('.','',$data);
            $newdate = str_replace(',','.',$date);
            return $newdate;
        }
    }

    public static function moedaView($data){
        if($data != null){
            if($data == 0){
                return '0,00';
            } else {
                $newdate = number_format($data, 2, ',', '.');
                return $newdate;
            }
        } else {
            return '0,00';
        }
    }

    public static function type($data){
        if($data != null){
            switch($data){
                case 1;
                    $newdate = 'Despesas';
                break;
                case 2;
                    $newdate = 'Receitas';
                break;
                case 3;
                    $newdate = 'Pró-labore';
                break;
                case 4;
                    $newdate = 'Publisher';
                break;
            }
            return $newdate;
        }
    }

    public static function status($type){
        if($type==1){
            return 'Ativo';
        } elseif($type==2){
            return 'Inativo';
        }
    }

    public static function statusType($data,$type){
        if($data != null){

            if($type == 1){
                $status  = array(1=>'Em Aberto',2=>'Paga');
                return $status[$data];
            }
            if($type == 2){
                $status  = array(1=>'Em Aberto',2=>'Recebida');
                return $status[$data];
            }
            if($type == 3){
                $status       = array(1=>'Em Aberto',2=>'Pago');
                return $status[$data];
            }
            if($type == 4){
                $status       = array(1=>'Em Aberto',2=>'Pago');
                return $status[$data];
            }


        }
    }

    public static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
        if($mask[$i] == '#')
        {
        if(isset($val[$k]))
        $maskared .= $val[$k++];
        }
        else
        {
        if(isset($mask[$i]))
        $maskared .= $mask[$i];
        }
        }
        return $maskared;
    }

    public static function cpfcnpj($cpfoucnpj){
        //Caso seja CNPJ
        if(strlen($cpfoucnpj) == 14) {
            return Helper::mask($cpfoucnpj,'##.###.###/####-##');
        }
    
        //Caso seja CPF
        if(strlen($cpfoucnpj) == 11) {
            return Helper::mask($cpfoucnpj,'###.###.###-##');
        }
    }

    public static function mes($mes){
        $meses = array(
            1=>'Janeiro',
            2=>'Fevereiro',
            3=>'Março',
            4=>'Abril',
            5=>'Maio',
            6=>'Junho',
            7=>'Julho',
            8=>'Agosto',
            9=>'Setembro',
            10=>'Outubro',
            11=>'Novembro',
            12=>'Dezembro'
        );
        return $meses[$mes];
  
    }

}
