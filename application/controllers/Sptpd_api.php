<?php
	require(APPPATH.'libraries/REST_Controller.php');
    defined('BASEPATH') OR exit('No direct script access allowed'); 

	class sptpd_api extends REST_Controller {
		
		function __construct($config ='rest')
		{
			parent::__construct($config);
		}

		function index_get()
		{
			// respond with information about sptpd
			$NoID = $this->get('noid');
			if ($NoID == '')
			{
				$sptpd = $this->db->get('sptpd')->result();
			} else
			{
				$this->db->where('NoID',$NoID);
				$sptpd = $this->db->get('sptpd')->result();
			}
			$this->response($sptpd, 200);
		}

		function index_post()
		{
			// create a new user and respond with a status / errors
			$data = array('returned: '.$this->post('id'));
			$this->response($data);
		}

		// function index_put()
		// {
            // //update an existing sptpd and respond with a status / errors
			// $NoID = $this->put('NoID');
			// $data = array(
                                        // 'NoID' => $this->put('NoID'),
                                        // 'JenisPajak' => $this->put('JenisPajak'),
                                        // 'NamaPajak' => $this->put('NamaPajak'),
                                        // 'TanggalTerbit' => $this->put('TanggalTerbit'),
                                        // 'Bulan' => $this->put('Bulan'),
                                        // 'Tahun' => $this->put('Tahun'),
                                        // 'NPWPD' => $this->put('NPWPD'),
                                        // 'NamaWP' => $this->put('NamaWP'),
										// 'DataEntri' => $this->put('DataEntri'),
                                        // 'TanggalEntri' => $this->put('TanggalEntri'),
                                        // 'Verifikasi' => $this->put('Verifikasi'),
                                        // 'Aktif' => $this->put('Aktif'),
                                        // 'Lunas' => $this->put('Lunas'),
                                        // 'KeteranganPajak' => $this->put('KeteranganPajak'),
                                        // 'RuasJalan' => $this->put('RuasJalan'),
                                        // 'ObyekPajak' => $this->put('ObyekPajak'),
                                        // 'Luas' => $this->put('Luas'),
                                        // 'Lebar' => $this->put('Lebar'),
                                        // 'Lama' => $this->put('Lama'),
                                        // 'Jumlah' => $this->put('Jumlah'),
                                        // 'BatasWaktu' => $this->put('BatasWaktu'),
										// 'Sisi' => $this->put('Sisi'),
                                        // 'TotalNilai_SebelumPajak' => $this->put('TotalNilai_SebelumPajak'),
                                        // 'JumlahPajak' => $this->put('JumlahPajak'),
                                        // 'Verifikator' => $this->put('Verifikator'),
                                        // 'TanggalVerifikasi' => $this->put('TanggalVerifikasi'),
                                        // 'NoSPTLama' => $this->put('NoSPTLama')
                                        // );
			// $this->db->where('NoID', $NoID);
			// $update = $this->db->update('sptpd',$data);
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
			// update an existing sptpd and respond with a status / errors
			$NoID = $this->patch('NoID');
			$data = array(
                        'NoID' => $this->patch('NoID'),
                        // 'JenisPajak' => $this->patch('JenisPajak'),
                        // 'NamaPajak' => $this->patch('NamaPajak'),
                        // 'TanggalTerbit' => $this->patch('TanggalTerbit'),
                        // 'Bulan' => $this->patch('Bulan'),
                        // 'Tahun' => $this->patch('Tahun'),
                        // 'NPWPD' => $this->patch('NPWPD'),
                        // 'NamaWP' => $this->patch('NamaWP'),
						// 'DataEntri' => $this->patch('DataEntri'),
                        // 'TanggalEntri' => $this->patch('TanggalEntri'),
                        // 'Verifikasi' => $this->patch('Verifikasi'),
                        // 'Aktif' => $this->patch('Aktif'),
                         'Lunas' => $this->patch('Lunas')
                        // 'KeteranganPajak' => $this->patch('KeteranganPajak'),
                        // 'RuasJalan' => $this->patch('RuasJalan'),
                        // 'ObyekPajak' => $this->patch('ObyekPajak'),
                        // 'Luas' => $this->patch('Luas'),
                        // 'Lebar' => $this->patch('Lebar'),
                        // 'Lama' => $this->patch('Lama'),
                        // 'Jumlah' => $this->patch('Jumlah'),
                        // 'BatasWaktu' => $this->patch('BatasWaktu'),
						// 'Sisi' => $this->patch('Sisi'),
                        // 'TotalNilai_SebelumPajak' => $this->patch('TotalNilai_SebelumPajak'),
                        // 'JumlahPajak' => $this->patch('JumlahPajak'),
                        // 'Verifikator' => $this->patch('Verifikator'),
                        // 'TanggalVerifikasi' => $this->patch('TanggalVerifikasi'),
                        // 'NoSPTLama' => $this->patch('NoSPTLama')
                        );
			$this->db->where('NoID', $NoID);
			$update = $this->db->update('sptpd',$data);
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
			// delete a sptpd and respond with status / errors
			$data = array('returned: '.$this->delete('id'));
			$this->response($data);
		}
	}
?>
