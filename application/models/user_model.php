                            <?php class User_model extends CI_Model {

        public $db_tabel    = "users";
        public $per_halaman = 10;
        public $offset      = 0;


        function get_all_user(){
                    return $this->db->select("*")->from("users")
                    ->get()->result();
        }

        //get with DT
        function get_all_userDt($start,$limit,$searchValue=null){
            $this->db->select("*")->from("users us");

            if(!empty($searchValue)){$this->db->like("userID",$searchValue);
                $this->db->like("userCode",$searchValue);
                $this->db->like("userNickname",$searchValue);
                $this->db->like("userPhoto",$searchValue);
                $this->db->like("userType",$searchValue);
                $this->db->like("username",$searchValue);
                $this->db->like("password",$searchValue);}

            $userType=array();
            if($this->session->userdata('type')=="Super"){
                $userType=array('Super', 'Administrator');
            }else{
                $userType=array('Publication','Cashier');
            }
            $this->db->where_in('userType',$userType);
            $this->db->limit($limit,$start);

            return $this->db->get()->result();


        }
        function get_user($userID){
            $a=$this->db->where("userID",$userID)->get($this->db_tabel);

            if($a->num_rows()>0){
                return $a->row();
            }else{
                return false;
            }


        }

        function tambah_user($data=array()){
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

        function update_user($userID,$data){
            // for ($i=0; $i < count($data) ; $i++) { 
            //     # code...
            //     $datas=array()
            // }
            $this->db->where("userID",$userID)->update($this->db_tabel,$data);
            if($this->db->affected_rows() > 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        function hapus_user($userID){
            $this->db->where("userID", $userID)->delete($this->db_tabel);

            if($this->db->affected_rows() > 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
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
        public function load_form_rules_tambah(){
            $form = array(array(
                            'field'=>'userNickname',
                            'label'=>'userNickname',
                            'rules'=>'required'
                        ),array(
                            'field'=>'userType',
                            'label'=>'userType',
                            'rules'=>'required'
                        ),array(
                            'field'=>'username',
                            'label'=>'username',
                            'rules'=>'required'
                        ),array(
                            'field'=>'password',
                            'label'=>'password',
                            'rules'=>'required'
                        ),);
            return $form;
        }
    }                        