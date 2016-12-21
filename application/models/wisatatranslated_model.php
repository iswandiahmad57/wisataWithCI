<?php
class wisatatranslated_model extends CI_Model {

    //model untuk wisatatranslated
    //parameter Utama Adalah wisatatranslatedID mengacu pada nama kolom di dalam db_tabel
    public $db_tabel    = 'wisatatranslated';
    public $per_halaman = 10;
    public $offset      = 0;


    function get_all_wisatatranslated($param){
        return $this->db->select(' wt.wisataName, wt.wisataContent, l.languageName,wt.wisatatranslatedID')
            ->from('wisatatranslated wt')
            ->join('localizations lz','wt.localizationID= lz.localizationID')
            ->join('languages l','lz.languageID = l.languageID')
            ->where('wt.wisataID',$param)
             ->get()
            ->result();



    }

    function get_wisatatranslated($wisatatranslatedID){
        $a=$this->db->where('wisatatranslatedID',$wisatatranslatedID)->get($this->db_tabel);

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }


    }

    function tambah_wisatatranslated($data=array()){
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

    function update_wisatatranslated($wisatatranslatedID,$data){
        // for ($i=0; $i < count($data) ; $i++) { 
        //     # code...
        //     $datas=array()
        // }
        $this->db->where('wisatatranslatedID',$wisatatranslatedID)->update($this->db_tabel,$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function hapus_wisatatranslated($wisatatranslatedID){
        $this->db->where('wisatatranslatedID', $wisatatranslatedID)->delete($this->db_tabel);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }   
    public function load_form_rules_tambah(){
        $form = array(
            array(
                'field' => 'wisataName',
                'label' => 'name',
                'rules' => 'required'
            ),
            array(
                'field' => 'localizationID',
                'label' => 'Bahasa',
                'rules' => 'required'
            ),
            array(
                'field' => 'wisataContent',
                'label' => 'Content',
                'rules' => 'required'
            )
        );
        return $form;
    }

    public function validasi_tambah()
    {
        $form = $this->load_form_rules_tambah();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}
