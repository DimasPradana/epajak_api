<?php
require(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed'); 

header('Content-type: application/json');
date_default_timezone_set('Asia/Jakarta');

class api extends REST_Controller {


  function __construct($config ='rest')
  {
    parent::__construct();
  }


  //inquiry
  function inquiry_get()
  {
    $Nop = $this->get('Nop');
    if ($Nop == '')
    {
      $Inquiry = $this->db->get('inquiry')->result();
      $this->response($Inquiry, 200);
    } else
    {
      $query = $this->db->get_where('inquiry', array('Nop' => $Nop));
      foreach ($query->result_array() as $Inquiry)
      {
        $Nop             = $Inquiry['Nop'];
        $Nama            = $Inquiry['Nama'];
        $Alamat          = $Inquiry['Alamat'];
        $Masa            = $Inquiry['Masa'];
        $Tahun           = $Inquiry['Tahun'];
        $NoSK            = $Inquiry['NoSK'];
        $JatuhTempo      = $Inquiry['JatuhTempo'];
        $KodeRekening    = str_replace(".","",$Inquiry['KodeRekening']);
        $Pokok           = $Inquiry['Pokok'];
        $Denda           = $Inquiry['Denda'];
        $Total           = $Inquiry['Total'];
        $Hasil = array(
            "Nop"             => $Nop,
            "Nama"            => $Nama,
            "Alamat"          => $Alamat,
            "Masa"            => $Masa,
            "Tahun"           => $Tahun,
            "NoSK"            => $NoSK,
            "JatuhTempo"      => $JatuhTempo,
            "KodeRekening"    => $KodeRekening,
            "Pokok"           => $Pokok,
            "Denda"           => $Denda,
            "Total"           => $Total,
        );
      }
      if (!isset($Hasil))
      {
        $Data = array(
            "Status"           => array(
                "IsError"      => "True",
                "ResponseCode" => "10",
                "ErrorDesc"    => "Data tagihan tidak ditemukan"
            )
        );
      } else
      {
        $Data = array(
            "Nop"              => $Nop,
            "Nama"             => $Nama,
            "Alamat"           => $Alamat,
            "Masa"             => $Masa,
            "Tahun"            => $Tahun,
            "NoSK"             => $NoSK,
            "JatuhTempo"       => $JatuhTempo,
            "KodeRekening"     => $KodeRekening,
            "Pokok"            => $Pokok,
            "Denda"            => $Denda,
            "Total"            => $Total,
            "Status"           => array(
                "IsError"      => "False",
                "ResponseCode" => "00",
                "ErrorDesc"    => "Sukses"
            )
        );
      }
      echo json_encode($Data);
    }
  }


  //payment
  function payment_post()
  {
    $HasilPayment = array(
                            'Nop'   => $this->post('Nop'),
                            'Masa'  => $this->post('Masa'),
                            'Tahun' => $this->post('Tahun'),
                            'Pokok' => $this->post('Pokok'),
                            'Denda' => $this->post('Denda'),
                            'Total' => $this->post('Total')
    );

    $query = $this->db->get_where('inquiry', array('Nop' => $HasilPayment['Nop']));
    foreach ($query->result_array() as $Inquiry)
    {
      $Nop             = $Inquiry['Nop'];
      $Nama            = $Inquiry['Nama'];
      $Alamat          = $Inquiry['Alamat'];
      $Masa            = $Inquiry['Masa'];
      $Tahun           = $Inquiry['Tahun'];
      $NoSK            = $Inquiry['NoSK'];
      $JatuhTempo      = $Inquiry['JatuhTempo'];
      $KodeRekening    = str_replace(".","",$Inquiry['KodeRekening']);
      $Pokok           = $Inquiry['Pokok'];
      $Denda           = $Inquiry['Denda'];
      $Total           = $Inquiry['Total'];
      $Lunas           = $Inquiry['Lunas'];
      $Hasil = array(
          "Nop"             => $Nop,
          "Nama"            => $Nama,
          "Alamat"          => $Alamat,
          "Masa"            => $Masa,
          "Tahun"           => $Tahun,
          "NoSK"            => $NoSK,
          "JatuhTempo"      => $JatuhTempo,
          "KodeRekening"    => $KodeRekening,
          "Pokok"           => $Pokok,
          "Denda"           => $Denda,
          "Total"           => $Total,
      );
    }

    $HasilJoin = array(
        "Nop"          => $HasilPayment['Nop'],
        "Masa"         => $HasilPayment['Masa'],
        "Tahun"        => $HasilPayment['Tahun'],
        "JatuhTempo"   => $JatuhTempo,
        "KodeRekening" => $KodeRekening,
        "Pokok"        => $HasilPayment['Pokok'],
        "Denda"        => $HasilPayment['Denda'],
        "Total"        => $HasilPayment['Total']
    );

    if (!isset($Hasil))
    {
      $DataPayment = array( 
                            "Status" => array(
                                                "IsError"      => "True",
                                                "ResponseCode" => "10",
                                                "ErrorDesc"    => "Data tagihan tidak ditemukan"
          )
      );
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['Nop']) == isset($Inquiry['Nop']) && $Lunas == 1)
    {
      $DataPayment = array(  
                            "Status" => array(  
                                                "IsError"         => "True",
                                                "ResponseCode"    => "13",
                                                "ErrorDesc"       => "Data tagihan telah lunas",
                                              ));
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['Nop']) == isset($Inquiry['Nop']) && $Lunas == '0' && $HasilPayment['Pokok'] != $Pokok || $HasilPayment['Denda'] != $Denda || $HasilPayment['Total'] != $Total)
    {
      $DataPayment = array(  
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "14",
                                                "ErrorDesc"         => "Jumlah tagihan yang dibayarkan tidak sesuai",
                                              ));
      echo json_encode($DataPayment);  
    } elseif (isset($HasilPayment['Nop']) == isset($Inquiry['Nop']) && $Lunas == 0 && isset($HasilPayment['Total']) == $Total && isset($HasilPayment['Total']) == $Total)
    {
      $nomor_skprd = substr($Nop, 13,5);
      $pengesahan = $nomor_skprd.str_replace("/", "", date("H/i/d/m/y/D"));
      $DataPayment = array( 
                            "Nop"          => $HasilPayment['Nop'],
                            "Masa"         => $HasilPayment['Masa'],
                            "Tahun"        => $HasilPayment['Tahun'],
                            "JatuhTempo"   => $JatuhTempo,
                            "KodeRekening" => $KodeRekening,
                            "Pokok"        => $HasilPayment['Pokok'],
                            "Denda"        => $HasilPayment['Denda'],
                            "Total"        => $HasilPayment['Total'],
                            "Pengesahan"   => $pengesahan,
                            "Status"       => array(
                                                "IsError"           => "False",
                                                "ResponseCode"      => "00",
                                                "ErrorDesc"         => "Sukses"
                                              ));
      $DataInsert = array(
                            "Nop"        => $HasilPayment['Nop'],
                            "Masa"       => $HasilPayment['Masa'],
                            "Tahun"      => $HasilPayment['Tahun'],
                            "Pokok"      => $HasilPayment['Pokok'],
                            "Denda"      => $HasilPayment['Denda'],
                            "Total"      => $HasilPayment['Total'],
                            "Pengesahan" => $pengesahan
                          );
      $DataUpdate = array(
                            "Nomor_SKPRD" => $nomor_skprd,
                            "Lunas"       => "1",
                            "Pengesahan"  => $pengesahan
                          );
      //insert data di table payment
      $this->db->insert('payment', $DataInsert);
      
      //update lunas & kodepengesahan di table skp
      $this->db->update('skp', $DataUpdate, "Nomor_SKPRD = ".$nomor_skprd);
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['Nop']) != isset($Inquiry['Nop']))
    {
      $DataPayment = array(  
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "10",
                                                "ErrorDesc"         => "Data tagihan tidak ditemukan"
                                              ));
      echo json_encode($DataPayment);
    } else 
    {
      $DataPayment = array(  
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "99",
                                                "ErrorDesc"         => "System Failure"
                                              ));
      echo json_encode($DataPayment);
    }
  }


  //reversal
  function reversal_post()
    {
      $HasilReversal = array(
                            'Nop'   => $this->post('Nop'),
                            'Masa'  => $this->post('Masa'),
                            'Tahun' => $this->post('Tahun'),
                            'Pokok' => $this->post('Pokok'),
                            'Denda' => $this->post('Denda'),
                            'Total' => $this->post('Total')
                          );

      $query = $this->db->get_where('payment', array('Nop' => $HasilReversal['Nop']));
      foreach ($query->result_array() as $reversal)
      {
        $Nop   = $reversal['Nop'];
        $Masa  = $reversal['Masa'];
        $Tahun = $reversal['Tahun'];
        $Pokok = $reversal['Pokok'];
        $Denda = $reversal['Denda'];
        $Total = $reversal['Total'];
        $Hasil = array(
              "Nop"   => $Nop,
              "Masa"  => $Masa,
              "Tahun" => $Tahun,
              "Pokok" => $Pokok,
              "Denda" => $Denda,
              "Total" => $Total
        );
      }

      $nomor_skprd = substr($HasilReversal['Nop'], 13,5);
      $Data = array(
                  "Pengesahan" => "",
                  "Lunas"      => "0"
      );

      if (isset($HasilReversal['Nop']) == isset($reversal['Nop']))
      {
          //update
          $this->db->update('skp', $Data,'Nomor_SKPRD = '.$nomor_skprd);
          //delete
          $this->db->delete('payment', 'Nop ='.$HasilReversal['Nop']);

          $DataReversal = array( //"Data" => $HasilReversal['Nop'], 
                              "Status" => array(  
                                                  "IsError"           => "False",
                                                  "ResponseCode"      => "00",
                                                  "ErrorDesc"         => "Sukses"
                                                  ));
        echo json_encode($DataReversal);
      } elseif (isset($HasilReversal['Nop']) != isset($hasil['Nop'])) 
      {
          $DataReversal = array(  
                              "Status" => array(  
                                                  "IsError"           => "True",
                                                  "ResponseCode"      => "10",
                                                  "ErrorDesc"         => "Data tagihan tidak ditemukan" 
                                                  ));
          
          echo json_encode($DataReversal);
      } else 
      {	
          $DataReversal = array(  
                              "Status" => array(  
                                                  "IsError"           => "True",
                                                  "ResponseCode"      => "99",
                                                  "ErrorDesc"         => "System Failure" 
                                                  ));
          echo json_encode($DataReversal);	
      }
  }
}
?>
