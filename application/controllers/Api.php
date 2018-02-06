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
    $NOP = $this->get('NOP');
    if ($NOP == '')
    {
      $Inquiry = $this->db->get('inquiry')->result();
      $this->response($Inquiry, 200);
    } else
    {
      $query = $this->db->get_where('inquiry', array('NOP' => $NOP));
      foreach ($query->result_array() as $Inquiry)
      {
        $NOP             = $Inquiry['NOP'];
        $Nama            = $Inquiry['Nama'];
        $Alamat          = $Inquiry['Alamat'];
        $Masa            = $Inquiry['Masa'];
        $Tahun           = $Inquiry['Tahun'];
        $NoSK            = $Inquiry['NoSK'];
        $JatuhTempo      = $Inquiry['JatuhTempo'];
        $TanggalSekarang = $Inquiry['TanggalSekarang'];
        $Selisih         = $Inquiry['Selisih'];
        $KodeRekening    = $Inquiry['KodeRekening'];
        $Pokok           = $Inquiry['Pokok'];
        $Denda           = $Inquiry['Denda'];
        $Total           = $Inquiry['Total'];
        $Lunas           = $Inquiry['Lunas'];
        $Aktif           = $Inquiry['Aktif'];
        $dataDouble      = $Inquiry['dataDouble'];
        $Hasil = array(
            "NOP"             => $NOP,
            "Nama"            => $Nama,
            "Alamat"          => $Alamat,
            "Masa"            => $Masa,
            "Tahun"           => $Tahun,
            "NoSK"            => $NoSK,
            "JatuhTempo"      => $JatuhTempo,
            "TanggalSekarang" => $TanggalSekarang,
            "Selisih"         => $Selisih,
            "KodeRekening"    => $KodeRekening,
            "Pokok"           => $Pokok,
            "Denda"           => $Denda,
            "Total"           => $Total,
            "Lunas"           => $Lunas,
            "Aktif"           => $Aktif,
            "dataDouble"      => $dataDouble
        );
      }
      if (!isset($Hasil))
      {
        $Data = array(
            "Data" => "Kosong",
            "Status"           => array(
                "IsError:"     => "True",
                "ResponseCode" => "10",
                "ErrorDesc"    => "Data tagihan tidak ditemukan"
            )
        );
      } else
      {
        $Data = array(
            "Data" => $Hasil,
            "Status"           => array(
                "IsError:"     => "True",
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
                            'NOP'   => $this->post('NOP'),
                            'Masa'  => $this->post('Masa'),
                            'Tahun' => $this->post('Tahun'),
                            'Pokok' => $this->post('Pokok'),
                            'Denda' => $this->post('Denda'),
                            'Total' => $this->post('Total')
    );

    $query = $this->db->get_where('inquiry', array('NOP' => $HasilPayment['NOP']));
    foreach ($query->result_array() as $Inquiry)
    {
      $NOP             = $Inquiry['NOP'];
      $Nama            = $Inquiry['Nama'];
      $Alamat          = $Inquiry['Alamat'];
      $Masa            = $Inquiry['Masa'];
      $Tahun           = $Inquiry['Tahun'];
      $NoSK            = $Inquiry['NoSK'];
      $JatuhTempo      = $Inquiry['JatuhTempo'];
      $TanggalSekarang = $Inquiry['TanggalSekarang'];
      $Selisih         = $Inquiry['Selisih'];
      $KodeRekening    = $Inquiry['KodeRekening'];
      $Pokok           = $Inquiry['Pokok'];
      $Denda           = $Inquiry['Denda'];
      $Total           = $Inquiry['Total'];
      $Lunas           = $Inquiry['Lunas'];
      $Aktif           = $Inquiry['Aktif'];
      $dataDouble      = $Inquiry['dataDouble'];
      $Hasil = array(
          "NOP"             => $NOP,
          "Nama"            => $Nama,
          "Alamat"          => $Alamat,
          "Masa"            => $Masa,
          "Tahun"           => $Tahun,
          "NoSK"            => $NoSK,
          "JatuhTempo"      => $JatuhTempo,
          "TanggalSekarang" => $TanggalSekarang,
          "Selisih"         => $Selisih,
          "KodeRekening"    => $KodeRekening,
          "Pokok"           => $Pokok,
          "Denda"           => $Denda,
          "Total"           => $Total,
          "Lunas"           => $Lunas,
          "Aktif"           => $Aktif,
          "dataDouble"      => $dataDouble
      );
    }

    $HasilJoin = array(
        "NOP"          => $HasilPayment['NOP'],
        "Masa"         => $HasilPayment['Masa'],
        "Tahun"        => $HasilPayment['Tahun'],
        "JatuhTempo"   => $JatuhTempo,
        "KodeRekening" => $KodeRekening,
        "Pokok"        => $HasilPayment['Pokok'],
        "Denda"        => $HasilPayment['Denda'],
        "Total"        => $HasilPayment['Total']
    );

    if(isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == 1)
    {
      $DataPayment = array( "Data" => "NOP telah melunasi tagihan", 
                            "Status" => array(  
                                                "IsError"         => "True",
                                                "ResponseCode"    => "13",
                                                "ErrorDesc"       => "Data tagihan telah lunas",
                                                "Total"           => $Total,
                                                "HasilPaymentNOP" => $HasilPayment['NOP'],
                                                "InquiryNOP"      => $Inquiry['NOP'],
                                                "Lunas"           => $Lunas));
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == '0' && $HasilPayment['Pokok'] != $Pokok || $HasilPayment['Denda'] != $Denda || $HasilPayment['Total'] != $Total)
    {
      $DataPayment = array( "Data" => "Jumlah tagihan (Pokok/Denda/Total) yang diinputkan tidak sama dengan tagihan", 
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "14",
                                                "ErrorDesc"         => "Jumlah tagihan yang dibayarkan tidak sesuai",
                                                "HasilPaymentPokok" => $HasilPayment['Pokok'],
                                                "Pokok"             => $Pokok,
                                                "HasilPaymentDenda" => $HasilPayment['Denda'],
                                                "Denda"             => $Denda,
                                                "HasilPaymentTotal" => $HasilPayment['Total'],
                                                "Total"             => $Total,
                                                "HasilPaymentNOP"   => $HasilPayment['NOP'],
                                                "InquiryNOP"        => $Inquiry['NOP'],
                                                "Lunas"             => $Lunas));
      echo json_encode($DataPayment);  
    } elseif (isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == 0 && isset($HasilPayment['Total']) == $Total && isset($HasilPayment['Total']) == $Total)
    {
      $nomor_skprd = substr($NOP, 13,5);
      $pengesahan = $nomor_skprd.str_replace("/", "", date("H/i/d/m/y/D"));
      $DataPayment = array( "Data" => $HasilJoin, 
                            "Status" => array(  
                                                "IsError"           => "False",
                                                "ResponseCode"      => "00",
                                                "ErrorDesc"         => "Sukses",
                                                "Nomor_skprd"       => $nomor_skprd,
                                                "HasilPaymentPokok" => $HasilPayment['Pokok'],
                                                "Pokok"             => $Pokok,
                                                "HasilPaymentDenda" => $HasilPayment['Denda'],
                                                "Denda"             => $Denda,
                                                "HasilPaymentTotal" => $HasilPayment['Total'],
                                                "Total"             => $Total,
                                                "HasilPaymentNOP"   => $HasilPayment['NOP'],
                                                "InquiryNOP"        => $Inquiry['NOP'],
                                                "Lunas"             => $Lunas,
                                                "Pengesahan"        => $pengesahan
                                              ));
      $DataInsert = array(
                            "NOP"        => $HasilPayment['NOP'],
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
    } elseif (isset($HasilPayment['NOP']) != isset($Inquiry['NOP']))
    {
      $DataPayment = array( "Data" => "Kosong", 
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "10",
                                                "ErrorDesc"         => "Data tagihan tidak ditemukan",
                                                "HasilPaymentTotal" => $HasilPayment['Total'],
                                                "Total"             => $Total,
                                                "HasilPaymentNOP"   => $HasilPayment['NOP'],
                                                "InquiryNOP"        => $Inquiry['NOP'],
                                                "Lunas"             => $Lunas));
      echo json_encode($DataPayment);
    } else 
    {
      $DataPayment = array( "Data" => "System Failure", 
                            "Status" => array(  
                                                "IsError"           => "True",
                                                "ResponseCode"      => "99",
                                                "ErrorDesc"         => "System Failure",
                                                "HasilPaymentTotal" => $HasilPayment['Total'],
                                                "Total"             => $Total,
                                                "HasilPaymentNOP"   => $HasilPayment['NOP'],
                                                "InquiryNOP"        => $Inquiry['NOP'],
                                                "Lunas"             => $Lunas));
      echo json_encode($DataPayment);
    }
  }


  //reversal
  function reversal_post()
    {
      $HasilReversal = array(
          'NOP'   => $this->post('NOP'));

      $query = $this->db->get_where('payment', array('NOP' => $HasilReversal['NOP']));
      foreach ($query->result_array() as $reversal)
      {
        $NOP = $reversal['NOP'];
        $Hasil = array(
              "NOP" => $NOP
        );
      }

      $nomor_skprd = substr($HasilReversal['NOP'], 13,5);
      $Data = array(
                  "Pengesahan" => "",
                  "Lunas"   => "0"
      );

      if (isset($HasilReversal['NOP']) == isset($reversal['NOP']))
      {
          //update
          $this->db->update('skp', $Data,'Nomor_SKPRD = '.$nomor_skprd);
          //delete
          $this->db->delete('payment', 'NOP ='.$HasilReversal['NOP']);

          $DataReversal = array( "Data" => $HasilReversal['NOP'], 
                              "Status" => array(  
                                                  "IsError"           => "False",
                                                  "ResponseCode"      => "00",
                                                  "ErrorDesc"         => "sukses"
                                                  ));
        echo json_encode($DataReversal);
      } elseif (isset($HasilReversal['NOP']) != isset($reversal['NOP'])) 
      {
          $DataReversal = array( "Data" => "Kosong", 
                              "Status" => array(  
                                                  "IsError"           => "True",
                                                  "ResponseCode"      => "10",
                                                  "ErrorDesc"         => "Data tagihan tidak ditemukan" 
                                                  ));
          
          echo json_encode($DataReversal);
      } else 
      {	
          $DataReversal = array( "Data" => "System Failure", 
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
