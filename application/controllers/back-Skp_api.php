<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 

	require(APPPATH.'libraries/REST_Controller.php');
	class skp_api extends REST_Controller {
		
		function __construct()
		{
			parent::__construct();
            $this->load->model('skp_model');
		}

		function index_get()
		{
            $r = $this->skp_model->read();
            $this->response($r);
		}

		function index_post()
		{
            $data =array('nomor_skprd' => $this->input->post('nomor_skprd'),
                          'tanggal_terbit' => $this->input->post('tanggal_terbit'),
                          'bulan' => $this->input->post('bulan'),
                          'tahun' => $this->input->post('tahun'),
                          'nomor_sptpd' => $this->input->post('nomor_sptpd'),
                          'nomor_sptpd_lama' => $this->input->post('nomor_sptpd_lama'),
                          'verifikasi' => $this->input->post('verifikasi'),
                          'aktif' => $this->input->post('aktif'),
                          'lunas' => $this->input->post('lunas'),
                          'dataentri' => $this->input->post('dataentri'),
                          'tanggalentri' => $this->input->post('tanggalentri'),
                          'verifikator' => $this->input->post('verifikator'),
                          'tanggalverifikasi' => $this->input->post('tanggalverifikasi'),
                          'nobayar' => $this->input->post('nobayar'),
                          'nobayarlama' => $this->input->post('nobayarlama'),
                          'tglbayar' => $this->input->post('tglbayar'),
                          'penyetor' => $this->input->post('penyetor'),
                          'denda' => $this->input->post('denda'),
                          'masa1' => $this->input->post('masa1'),
                          'masa2' => $this->input->post('masa2'),
                          'keterangan' => $this->input->post('keterangan')
            );
            $r = $this->skp_model->insert($data);
            $this->response($r);
		}

		function index_put()
		{
            $nomor_skprd = $this->uri->segment(3);

            $data =  array('lunas' => $this->input->get('lunas'));

            $r = $this->skp_model->update($nomor_skprd,$data);
            $this->response($r);
		}

		function index_delete()
		{
            $nomor_skprd = $this->uri->segment(3);
            $r = $this->skp_model->delete($nomor);
            $this->response($r);
		}
	}
?>
