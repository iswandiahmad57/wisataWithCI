<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * http://example.com/index.php/welcome
     *    - or -
     * http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    // function __construct(){
    //     parent::__construct();

    //     if(!$this->session->userdata('userID')){
    //         redirect(base_url().'manager');
    //     }

    //     $this->load->model('backend_login', 'login', TRUE);
    // }
    // public function index()
    // {
  
    //     $type=$this->session->userdata('type');
    //     $data['menu']=$this->login->get_menu($type);
    //     $this->load->view('coba',$data);
    
    // }
    public function index()
    {
  
        if(!$this->session->userdata('userID')){
            redirect(base_url().'manager');
        }
        $this->load->view('coba');
    
    }
}
