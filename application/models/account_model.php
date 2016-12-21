<?php
class Account_model extends CI_Model {

    //model untuk account
    //parameter Utama Adalah accountID mengacu pada nama kolom di dalam db_tabel
    public $db_tabel    = 'advertisers';
    public $per_halaman = 10;
    public $offset      = 0;


    function get_all_account(){
        
        return $this->db->get($this->db_tabel)->result();


    }

    function get_account($accountID){
        $a=$this->db->where('advertiserID',$accountID)->get($this->db_tabel);

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }


    }

    function tambah_account($data=array()){
        $this->db->insert($this->db_tabel, $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function update_account($accountID,$data){
        // for ($i=0; $i < count($data) ; $i++) { 
        //     # code...
        //     $datas=array()
        // }
        $this->db->where('advertiserID',$accountID)->update($this->db_tabel,$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function hapus_account($accountID){
        $this->db->where('advertiserID', $accountID)->delete($this->db_tabel);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }   


}
