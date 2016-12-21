<?php
class Wisata_model extends CI_Model {

    //model untuk wisata
    //parameter Utama Adalah wisataID mengacu pada nama kolom di dalam db_tabel
    public $db_tabel    = 'wisata';
    public $per_halaman = 10;
    public $offset      = 0;


    function get_all_wisata(){
        
        return $this->db->get($this->db_tabel)->result();


    }
    function get_wilayah(){
        
        return $this->db->where('wilayahTipe','Provinsi')->get('wilayah')->result();


    }
    function get_wisata($wisataID){
        $a=$this->db->where('wisataID',$wisataID)->get($this->db_tabel);

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }


    }
    function getGambar($wisataID){
        return $this->db->where('wisataID',$wisataID)->get('wisataimages')->result();

    }
    function get_gambar($param){

        $a=$this->db->where('wisataID',$param)->get('wisataimages');

        if($a->num_rows()>0){
            return $a->result();
        }else{
            return false;
        }
    }

    function tambah_wisata($data=array()){
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
    function tambah_wisata_image($data=array()){
        $this->db->insert('wisataimages', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function update_wisata($wisataID,$data){
        // for ($i=0; $i < count($data) ; $i++) { 
        //     # code...
        //     $datas=array()
        // }
        $this->db->where('wisataID',$wisataID)->update($this->db_tabel,$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function hapus_wisata($wisataID){
        $this->db->where('wisataID', $wisataID)->delete($this->db_tabel);

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
                'field' => 'wisataWilayah',
                'label' => 'wilayah',
                'rules' => 'required'
            ),
            array(
                'field' => 'wisataLat',
                'label' => 'Latitude',
                'rules' => 'required'
            ),

            array(
                'field' => 'wisataLng',
                'label' => 'Longitude',
                'rules' => 'required'
            ),
            array(
                'field' => 'wisataContent',
                'label' => 'Latitude',
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

    public function validasi_tambah_tiket(){
        $form=array(
            array(
                'field' => 'wisatatiketAdultPrice',
                'label' => 'Adult Price',
                'rules' => 'required'
            ),
            array(
                'field' => 'wisatatiketChildrenPrice',
                'label' => 'Children Price',
                'rules' => 'required'
            )

        );
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
    public function delete_gambar($gambarID){
         $this->db->where('wisataimageID', $gambarID)->delete('wisataimages');

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
       
        }       
    }  
    function insert_gambar($data=array()){
        $this->db->insert('wisataimages', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function get_wisata_tiket($wisataID){
        $a=$this->db->select('*')->from('wisatatiket')
                    ->join('wisata','wisatatiket.wisataID=wisata.wisataID')
                    ->where('wisatatiket.wisataID',$wisataID)->get();

        if($a->num_rows()>0){
            return $a->result();
        }else{
            return false;
        }


    }

    function get_tiket_by($wisataTiketID){
        $a=$this->db->where('wisatatiketID',$wisataTiketID)->get('wisatatiket');

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }        
    }

    function tambah_tiket($data=array()){
         $this->db->insert('wisatatiket', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }       
    }

    function delete_tiket($wisataTiketID){
         $this->db->where('wisatatiketID',$wisataTiketID)->delete('wisatatiket');

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
       
        }               
    }

    function edit_tiket($wisataTiketID,$data){
        $this->db->where('wisatatiketID',$wisataTiketID)->update('wisatatiket',$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }


    public function get_all_wisata_comment($param){
        if($param!=null){
            $this->db->where('wisataID',$param);
        }

        return $this->db->get('wisataComment')->result();

    }
    function delete_comment($commentID){
         $this->db->where('commentID',$commentID)->delete('wisataComment');

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
       
        }               
    }


    //wisata front post
    public function get_all_wisata_front($category=null,$wilayah=null,$range=null,$start, $limit){

        $this->db->select('*,IFNULL(wt.wisataID,wisata.wisataID)AS wisataID')->from('wisata');
        // $this->db->query('LEFT JOIN (SELECT wisatatiketPrice FROM wisatatiket LIMIT 1) wt ON wisata.wisataID=wt.wisataID')
        $this->db->join('(SELECT wisatatiketPrice,wisataID FROM wisatatiket LIMIT 1) wt ','wisata.wisataID=wt.wisataID','LEFT');
        if($wilayah){
            $this->db->where_in('wisataWilayah',$wilayah);
        }
        if($category){
            $this->db->where_in('wisataCategory',$category);
        }
        if($range){
            $this->db->where_in('wt.wisatatiketPrice',$range);
        }



        $this->db->limit($limit,$start);

        return $this->db->get()->result();
    }

    public function get_wisata_front($wisataID){

        $this->db->select('*')->from('wisata');
        $this->db->join('(SELECT wt.wisatatiketPrice,wt.wisataID,wt.wisatatiketChildrenPrice FROM wisatatiket wt LIMIT 1) wt ','wisata.wisataID=wt.wisataID','LEFT');
        $a=$this->db->where('wisata.wisataID',$wisataID)->get();

        if($a->num_rows()>0){
            return $a->row();
        }else{
            return false;
        }

    }

    public function get_comment_front($wisataID){
        $this->db->where('wisataID',$wisataID);
        return $this->db->get('wisatacomment')->result();
    }
    function tambah_comment($data=array()){
         $this->db->insert('wisatacomment', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }       
    }
    function tambah_rating($data=array()){
         $this->db->insert('wisatarating', $data);

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
