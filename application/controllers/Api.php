<?php
require(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed'); 

date_default_timezone_set('Asia/Jakarta');

class api extends REST_Controller {

  function __construct($config ='rest')
  {
    // parent::__construct($config);
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
          // $Kode00 = array("IsError" => "False", "ResponseCode" => "00", "ErrorDesc" => "Sukses");
          // $Kode10 = array("IsError" => "True", "ResponseCode" => "10", "ErrorDesc" => "Data tagihan tidak ditemukan");
          // $Kode13 = array("IsError" => "True", "ResponseCode" => "13", "ErrorDesc" => "Data tagihan telah lunas");
          // $Kode14 = array("IsError" => "True", "ResponseCode" => "14", "ErrorDesc" => "Jumlah tagihan yang dibayarkan tidak sesuai");
          // $Kode34 = array("IsError" => "True", "ResponseCode" => "34", "ErrorDesc" => "Data reversal tidak ditemukan");
          // $Kode36 = array("IsError" => "True", "ResponseCode" => "36", "ErrorDesc" => "Data reversal telah dibatalkan");
          // $Kode99 = array("IsError" => "True", "ResponseCode" => "99", "ErrorDesc" => "System Error");
        }
          if (!isset($Hasil))
          {
            $Kode10 = array("IsError" => "True", "ResponseCode" => "10", "ErrorDesc" => "Data tagihan tidak ditemukan");
            $Data = array("Data" => "Kosong", "Status" => $Kode10);
          } elseif($Lunas == 1)
          {
            $Kode13 = array("IsError" => "True", "ResponseCode" => "13", "ErrorDesc" => "Data tagihan telah lunas");
            $Data = array("Data" => $Hasil, "Status" => $Kode13);
          } else
          {
            $Kode00 = array("IsError" => "False", "ResponseCode" => "00", "ErrorDesc" => "Sukses");
            $Data = array("Data" => $Hasil, "Status" => $Kode00);
          }
          header('Content-type: application/json');
          // echo "<pre>";
          // die(print_r($Data,FALSE));
          echo json_encode($Data);
    }
  }
  function payment_post()
  {
    $NOP = $this->get('NOP');
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
    $hasilPayment = array(
        'NOP' => $this->post('NOP'),
        'Masa' => $this->post('Masa'),
        'Tahun' => $this->post('Tahun'),
        // 'JatuhTempo' => $this->post('JatuhTempo'),
        // 'KodeRek' => $this->post('KodeRek'),
        'Pokok' => $this->post('Pokok'),
        'Denda' => $this->post('Denda'),
        'Total' => $this->post('Total')
        // 'Pengesahan' => $this->post('Pengesahan')
    );
    
    $queryPayment = $this->db->insert('payment',$hasilPayment);
    header('Content-type: application/json');
    // echo "<pre>";
    // print_r ($hasilPayment);
    echo json_encode($queryPayment);
  }
  function reversal_patch()
  {
    $NOP = $this->patch('NOP');
    $hasilReversal = array(
        'NOP' => $this->patch('NOP'),
        'Masa' => $this->patch('Masa'),
        'Tahun' => $this->patch('Tahun'),
        // 'JatuhTempo' => $this->post('JatuhTempo'),
        // 'KodeRek' => $this->post('KodeRek'),
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
