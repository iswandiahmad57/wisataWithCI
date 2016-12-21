<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_login extends CI_Model {

    public $db_tabel = 'user';

    public function load_form_rules()
    {
        $form_rules = array(
                            array(
                                'field' => 'username',
                                'label' => 'Username',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'password',
                                'label' => 'Password',
                                'rules' => 'required'
                            ),
        );
        return $form_rules;
    }

    public function validasi()
    {
        $form = $this->load_form_rules();
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

    // cek status user, login atau tidak?
    public function cek_user()
    {
        $username = $this->input->post('username');
        $password = $this->gumcrypt->gumencrypt($this->input->post('password'));

        $query = $this->db->where('username', $username)
                          ->where('password', $password)
                          ->limit(1)
                          ->get('users');
       

        if ($query->num_rows() == 1)
        {
             $user=$query->row();
            $data = array('login'=>true,'type'=>$user->userType,'userID'=>$user->userID);
            // buat data session jika login benar
            $this->session->set_userdata($data);
            return TRUE;


        }
        else
        {
            return FALSE;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE));
        $this->session->sess_destroy();
    }
    public function logout_special(){
         $this->session->sess_destroy();
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE));
        
    }

    public function get_menu($type){
        return $this->db->select('*')
                ->from('menus')
                ->join('menulist','menus.menulistID=menulist.listID')
                ->where('menus.menuType',$type)
                ->get()
                ->result();
    }
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */