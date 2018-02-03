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
        $NOP = $Inquiry['NOP'];
        $Nama = $Inquiry['Nama'];
        $Alamat = $Inquiry['Alamat'];
        $Masa = $Inquiry['Masa'];
        $Tahun = $Inquiry['Tahun'];
        $NoSK = $Inquiry['NoSK'];
        $JatuhTempo = $Inquiry['JatuhTempo'];
        $TanggalSekarang = $Inquiry['TanggalSekarang'];
        $Selisih = $Inquiry['Selisih'];
        $KodeRekening = $Inquiry['KodeRekening'];
        $Pokok = $Inquiry['Pokok'];
        $Denda = $Inquiry['Denda'];
        $Total = $Inquiry['Total'];
        $Lunas = $Inquiry['Lunas'];
        $Aktif = $Inquiry['Aktif'];
        $dataDouble = $Inquiry['dataDouble'];
        $Hasil = array("NOP" => $NOP, "Nama" => $Nama, "Alamat" => $Alamat, "Masa" => $Masa,
          "Tahun" => $Tahun, "NoSK" => $NoSK, "JatuhTempo" => $JatuhTempo, "TanggalSekarang" => $TanggalSekarang,
          "Selisih" => $Selisih, "KodeRekening" => $KodeRekening, "Pokok" => $Pokok, "Denda" => $Denda,
          "Total" => $Total, "Lunas" => $Lunas, "Aktif" => $Aktif, "dataDouble" => $dataDouble);
      }
      if (!isset($Hasil))
      {
        $Data = array("Data" => "Kosong", "Status" => array("IsError:" => "True", 
          "ResponseCode" => "10", "ErrorDesc" => "Data tagihan tidak ditemukan"));
      } else
      {
        $Data = array("Data" => $Hasil, "Status" => array("IsError:" => "True", 
          "ResponseCode" => "00", "ErrorDesc" => "Sukses"));
      }
      echo json_encode($Data);
    }
  }


  function payment_post()
  {
    $HasilPayment = array(
      'NOP' => $this->post('NOP'),
      'Masa' => $this->post('Masa'),
      'Tahun' => $this->post('Tahun'),
      'Pokok' => $this->post('Pokok'),
      'Denda' => $this->post('Denda'),
      'Total' => $this->post('Total')
    );

    $query = $this->db->get_where('inquiry', array('NOP' => $HasilPayment['NOP']));
    foreach ($query->result_array() as $Inquiry)
    {
      $NOP = $Inquiry['NOP'];
      $Nama = $Inquiry['Nama'];
      $Alamat = $Inquiry['Alamat'];
      $Masa = $Inquiry['Masa'];
      $Tahun = $Inquiry['Tahun'];
      $NoSK = $Inquiry['NoSK'];
      $JatuhTempo = $Inquiry['JatuhTempo'];
      $TanggalSekarang = $Inquiry['TanggalSekarang'];
      $Selisih = $Inquiry['Selisih'];
      $KodeRekening = $Inquiry['KodeRekening'];
      $Pokok = $Inquiry['Pokok'];
      $Denda = $Inquiry['Denda'];
      $Total = $Inquiry['Total'];
      $Lunas = $Inquiry['Lunas'];
      $Aktif = $Inquiry['Aktif'];
      $dataDouble = $Inquiry['dataDouble'];
      $Hasil = array("NOP" => $NOP, "Nama" => $Nama, "Alamat" => $Alamat, "Masa" => $Masa,
        "Tahun" => $Tahun, "NoSK" => $NoSK, "JatuhTempo" => $JatuhTempo, "TanggalSekarang" => $TanggalSekarang,
        "Selisih" => $Selisih, "KodeRekening" => $KodeRekening, "Pokok" => $Pokok, "Denda" => $Denda,
        "Total" => $Total, "Lunas" => $Lunas, "Aktif" => $Aktif, "dataDouble" => $dataDouble);
    }

    $HasilJoin = array("NOP" => $HasilPayment['NOP'], "Masa" => $HasilPayment['Masa'], "Tahun" => $HasilPayment['Tahun'],
      "JatuhTempo" => $JatuhTempo, "KodeRekening" => $KodeRekening, "Pokok" => $HasilPayment['Pokok'], "Denda" => $HasilPayment['Denda'],
      "Total" => $HasilPayment['Total']);

    if(isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == 1)
    {
      $DataPayment = array( "Data" => "NOP telah melunasi tagihan", 
        "Status" => array(  "IsError" => "True", 
        "ResponseCode" => "13", 
        "ErrorDesc" => "Data tagihan telah lunas", 
        "Total" => $Total, 
        "HasilPaymentNOP" => $HasilPayment['NOP'], 
        "InquiryNOP" => $Inquiry['NOP'], 
        "Lunas" => $Lunas));
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == '0' && $HasilPayment['Pokok'] != $Pokok || $HasilPayment['Denda'] != $Denda || $HasilPayment['Total'] != $Total)
    {
      $DataPayment = array( "Data" => "Jumlah tagihan (Pokok/Denda/Total) yang diinputkan tidak sama dengan tagihan", 
        "Status" => array(  "IsError" => "True", 
        "ResponseCode" => "14", 
        "ErrorDesc" => "Jumlah tagihan yang dibayarkan tidak sesuai", 
        "HasilPaymentPokok" => $HasilPayment['Pokok'],
        "Pokok" => $Pokok,
        "HasilPaymentDenda" => $HasilPayment['Denda'],
        "Denda" => $Denda,
        "HasilPaymentTotal" => $HasilPayment['Total'],
        "Total" => $Total, 
        "HasilPaymentNOP" => $HasilPayment['NOP'], 
        "InquiryNOP" => $Inquiry['NOP'], 
        "Lunas" => $Lunas));
      echo json_encode($DataPayment);  
    } elseif (isset($HasilPayment['NOP']) == isset($Inquiry['NOP']) && $Lunas == 0 && isset($HasilPayment['Total']) == $Total && isset($HasilPayment['Total']) == $Total)
    {
      $DataPayment = array( "Data" => $HasilJoin, 
        "Status" => array(  "IsError" => "False", 
        "ResponseCode" => "00", 
        "ErrorDesc" => "Sukses", 
        "HasilPaymentPokok" => $HasilPayment['Pokok'],
        "Pokok" => $Pokok,
        "HasilPaymentDenda" => $HasilPayment['Denda'],
        "Denda" => $Denda,
        "HasilPaymentTotal" => $HasilPayment['Total'],
        "Total" => $Total, 
        "HasilPaymentNOP" => $HasilPayment['NOP'], 
        "InquiryNOP" => $Inquiry['NOP'], 
        "Lunas" => $Lunas));
      echo json_encode($DataPayment);
    } elseif (isset($HasilPayment['NOP']) != isset($Inquiry['NOP']))
    {
      $DataPayment = array( "Data" => "Kosong", 
        "Status" => array( "IsError" => "True", 
        "ResponseCode" => "10", 
        "ErrorDesc" => "Data tagihan tidak ditemukan", 
        "HasilPaymentTotal" => $HasilPayment['Total'],
        "Total" => $Total, 
        "HasilPaymentNOP" => $HasilPayment['NOP'], 
        "InquiryNOP" => $Inquiry['NOP'], 
        "Lunas" => $Lunas));
      echo json_encode($DataPayment);
    } else 
    {
      $DataPayment = array( "Data" => "System Failure", 
        "Status" => array( "IsError" => "True", 
        "ResponseCode" => "99", 
        "ErrorDesc" => "System Failure", 
        "HasilPaymentTotal" => $HasilPayment['Total'],
        "Total" => $Total, 
        "HasilPaymentNOP" => $HasilPayment['NOP'], 
        "InquiryNOP" => $Inquiry['NOP'], 
        "Lunas" => $Lunas));
      echo json_encode($DataPayment);
    }
  }


  function reversal_patch()
  {
    $NOP = $this->patch('NOP');
    $hasilReversal = array(
      'NOP' => $this->patch('NOP'),
      'Masa' => $this->patch('Masa'),
      'Tahun' => $this->patch('Tahun'),
      'Pokok' => $this->patch('Pokok'),
      'Denda' => $this->patch('Denda'),
      'Total' => $this->patch('Total')
    );
    $this->db->where('NOP',$NOP);
    $update = $this->db->update('payment',$hasilReversal);
    if ($update)
    {
      $this->response($data,200);
    } else
    {
      $this->response(array('status' => 'fail',204));
    }
  }

}
?>
