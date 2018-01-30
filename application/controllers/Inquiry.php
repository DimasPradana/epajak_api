<?php
	require(APPPATH.'libraries/REST_Controller.php');
    defined('BASEPATH') OR exit('No direct script access allowed'); 

	class inquiry extends REST_Controller {
		
		function __construct($config ='rest')
		{
			// parent::__construct($config);
			parent::__construct();
		}

		function index_get()
		{
			//  //respond with information about skp
			///////////////////////
			 $NOP = $this->get('NOP');
			 if ($NOP == '')
			 {
			     $inquiry = $this->db->get('inquiry')->result();
                 $this->response($inquiry, 200);
			 } else
			 {
               if($this->db->where('NOP',$NOP))
               {
                 $query = $this->db->get('inquiry');
                 // $inquiry = $query->result();
                foreach ($query->result_array() as $inquiry)
                {
                  $NOP = $inquiry['NOP'];
                  $Nama = $inquiry['Nama'];
                  $Alamat = $inquiry['Alamat'];
                  $Masa = $inquiry['Masa'];
                  $Tahun = $inquiry['Tahun'];
                  $NoSK = $inquiry['NoSK'];
                  $JatuhTempo = $inquiry['JatuhTempo'];
                  $TanggalSekarang = $inquiry['TanggalSekarang'];
                  $Selisih = $inquiry['Selisih'];
                  $KodeRekening = $inquiry['KodeRekening'];
                  $Pokok = $inquiry['Pokok'];
                  $Denda = $inquiry['Denda'];
                  $Total = $inquiry['Total'];
                  $Lunas = $inquiry['Lunas'];
                  $Aktif = $inquiry['Aktif'];
                  $dataDouble = $inquiry['dataDouble'];
                  $hasil = array("NOP" => $NOP, "Nama" => $Nama, "Alamat" => $Alamat, "Masa" => $Masa,
                  "Tahun" => $Tahun, "NoSK" => $NoSK, "JatuhTempo" => $JatuhTempo, "TanggalSekarang" => $TanggalSekarang,
                  "Selisih" => $Selisih, "KodeRekening" => $KodeRekening, "Pokok" => $Pokok, "Denda" => $Denda,
                  "Total" => $Total, "Lunas" => $Lunas, "Aktif" => $Aktif, "dataDouble" => $dataDouble);
                  $Kode00 = array("IsError" => "False", "ResponseCode" => "00", "ErrorDesc" => "Sukses");
                  $Kode10 = array("IsError" => "True", "ResponseCode" => "10", "ErrorDesc" => "Data tagihan tidak ditemukan");
                  $Kode13 = array("IsError" => "True", "ResponseCode" => "13", "ErrorDesc" => "Data tagihan telah lunas");
                  $Kode14 = array("IsError" => "True", "ResponseCode" => "14", "ErrorDesc" => "Jumlah tagihan yang dibayarkan tidak sesuai");
                  $Kode34 = array("IsError" => "True", "ResponseCode" => "34", "ErrorDesc" => "Data reversal tidak ditemukan");
                  $Kode36 = array("IsError" => "True", "ResponseCode" => "36", "ErrorDesc" => "Data reversal telah dibatalkan");
                  $Kode99 = array("IsError" => "True", "ResponseCode" => "99", "ErrorDesc" => "System Error");
                }
                $data = array("Data" => $hasil, "Status" => $Kode00);
                header('Content-type: application/json');
                echo json_encode($data);
                 // $this->response($inquiry);
			 }
			//////////////////////////////
          }
        }

		function index_post()
		{
			// create a new user and respond with a status / errors
			$data = array('returned: '.$this->post('id'));
			$this->response($data);
		}

		// function index_put()
		// {
            // //update an existing skp and respond with a status / errors
			// $nomor_skprd = $this->put('nomor_skprd');
			// $data = array(
                                        // 'nomor_skprd' => $this->put('nomor_skprd'),
                                        // 'tanggal_terbit' => $this->put('tangal_terbit'),
                                        // 'bulan' => $this->put('bulan'),
                                        // 'tahun' => $this->put('tahun'),
                                        // 'nomor_sptpd' => $this->put('nomor_sptpd'),
                                        // 'nomor_sptpd_lama' => $this->put('nomor_sptpd_lama'),
                                        // 'verifikasi' => $this->put('verifikasi'),
                                        // 'aktif' => $this->put('aktif'),
										// 'lunas' => $this->put('lunas=1'),
                                        // 'dataentri' => $this->put('dataentri'),
                                        // 'tanggalentri' => $this->put('tanggalentri'),
                                        // 'verifikator' => $this->put('verifikator'),
                                        // 'tanggalverifikasi' => $this->put('tanggalverifikasi'),
                                        // 'nobayar' => $this->put('nobayar'),
                                        // 'nobayarlama' => $this->put('nobayarlama'),
                                        // 'tglbayar' => $this->put('tglbayar'),
                                        // 'penyetor' => $this->put('penyetor'),
                                        // 'denda' => $this->put('denda'),
                                        // 'masa1' => $this->put('masa1'),
                                        // 'masa2' => $this->put('masa2'),
                                        // 'keterangan' => $this->put('keterangan')
										// );
			// $this->db->where('nomor_skprd', $nomor_skprd);
			// $update = $this->db->update('skp',$data);
			// if ($update)
			// {
				// $this->response($data,200);
			// } else
			// {
				// $this->response(array('status' => 'fail',502));
			// }
		// }

		function index_patch()
		{
			// update an existing skp and respond with a status / errors
			$nomor_skprd = $this->patch('nomor_skprd');
			$data = array(
                        'nomor_skprd' => $this->patch('nomor_skprd'),
                        // 'tanggal_terbit' => $this->patch('tangal_terbit'),
                        // 'bulan' => $this->patch('bulan'),
                        // 'tahun' => $this->patch('tahun'),
                        // 'nomor_sptpd' => $this->patch('nomor_sptpd'),
                        // 'nomor_sptpd_lama' => $this->patch('nomor_sptpd_lama'),
                        // 'verifikasi' => $this->patch('verifikasi'),
                        // 'aktif' => $this->patch('aktif'),
                        'lunas' => $this->patch('lunas'),
                        // 'dataentri' => $this->patch('dataentri'),
                        // 'tanggalentri' => $this->patch('tanggalentri'),
                        // 'verifikator' => $this->patch('verifikator'),
                        // 'tanggalverifikasi' => $this->patch('tanggalverifikasi'),
                        'nobayar' => $this->patch('nobayar'),
                        // 'nobayarlama' => $this->patch('nobayarlama'),
                        'tglbayar' => $this->patch('tglbayar'),
                        'penyetor' => $this->patch('penyetor'),
                        'denda' => $this->patch('denda')
                        // 'masa1' => $this->patch('masa1'),
                        // 'masa2' => $this->patch('masa2'),
                        // 'keterangan' => $this->patch('keterangan')
                        );
			$this->db->where('nomor_skprd', $nomor_skprd);
			$update = $this->db->update('skp',$data);
			if ($update)
			{
				$this->response($data,200);
			} else
			{
				$this->response(array('status' => 'fail',204));
			}
		}

		function index_delete()
		{
			// delete a skp and respond with status / errors
			$data = array('returned: '.$this->delete('id'));
			$this->response($data);
		}
	}
?>
