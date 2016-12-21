<?php
class wisatarange_model extends CI_Model {

    //model untuk wisatarange
    //parameter Utama Adalah wisatatimerangeID mengacu pada nama kolom di dalam db_tabel
    public $db_tabel    = 'wisatatimerange';
    public $per_halaman = 10;
    public $offset      = 0;


    function get_all_wisatarange($param){
        
        return $this->db->select('wisatatimerange.wisatatimerangeID,wisatatimerange.duration,wisatatimerange.destinationID,wisata.wisataName')
                ->join('wisata','wisatatimerange.destinationID = wisata.wisataID')->
            where('originalID',$param)->order_by('wisatatimerangeID','ASC')->get($this->db_tabel)->result();


    }

    function get_wisatarange($wisatatimerangeID){
        $a=$this->db->where('wisatatimerangeID',$wisatatimerangeID)->get($this->db_tabel);

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }


    }

    function tambah_wisatarange($data=array()){
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

    function update_wisatarange($wisatatimerangeID,$data=array()){
        $this->db->where('wisatatimerangeID',$wisatatimerangeID)->update($this->db_tabel,$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }

    function hapus_wisatarange($wisatatimerangeID){
        $this->db->where('wisatatimerangeID', $wisatatimerangeID)->delete($this->db_tabel);

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
                'field' => 'duration',
                'label' => 'duration',
                'rules' => 'required'
            ),
            array(
                'field' => 'destinationID',
                'label' => 'Destinasi',
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
/* End of file absen_model.php */
/* Location: ./application/models/absen_model.php */