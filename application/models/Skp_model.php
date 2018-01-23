<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Skp_model extends CI_Model
    {
        function __construct()
        {
           parent::__construct();
        }  

        public function read()
        {
           $query = $this->db->query("select * from `skp`");
           return $query->result_array();
        }

        public function insert($data)
        {

           $this->nomor_skprd = $data['nomor_skprd']; // please read the below note
           $this->tanggal_terbit  = $data['tanggal_terbit'];
           $this->bulan = $data['bulan'];
           $this->tahun = $data['tahun'];
           $this->nomor_sptpd = $data['nomor_sptpd'];
           $this->nomor_sptpd_lama = $data['nomor_sptpd_lama'];
           $this->verifikasi = $data['verifikasi'];
           $this->aktif = $data['aktif'];
           $this->lunas = $data['lunas'];
           $this->dataentri = $data['dataentri'];
           $this->tanggalentri = $data['tanggalentri'];
           $this->verifikator = $data['verifikator'];
           $this->tanggalverifikasi = $data['tanggalverifikasi'];
           $this->nobayar = $data['nobayar'];
           $this->nobayarlama = $data['nobayarlama'];
           $this->tglbayar = $data['tglbayar'];
           $this->penyetor = $data['penyetor'];
           $this->denda = $data['denda'];
           $this->masa1 = $data['masa1'];
           $this->masa2 = $data['masa2'];
           $this->keterangan = $data['keterangan'];

           if($this->db->insert('skp',$this))
           {    
               return 'Data is inserted successfully';
           }
             else
           {
               return "Error has occured";
           }
       }

       public function update($nomor_skprd,$data)
       {

          $this->lunas = $data['lunas']; // please read the below note
          $result = $this->db->update('skp',$this,array('nomor_skprd' => $nomor_skprd));

          if($result)
          {
               return "Data is updated successfully";
          }
          else
          {
               return "Error has occurred";

          }
       }

       public function delete($nomor_skprd)
       {

          $result = $this->db->query("delete from `skp` where user_id = $nomor_skprd");

          if($result)
          {
               return "Data is deleted successfully";
          }
          else
          {
               return "Error has occurred";
          }
       }
    }
?>
