<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Wisatatranslated extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('wisatatranslated_model','wisatatranslated',TRUE);
    }

    //fungsi untuk mendapatkan seluruh wisatatranslated
    public function wisatatranslatedAll_get()
    {
        $wisata=$this->wisatatranslated->get_all_wisatatranslated($this->get('wisataID'));
        if(!empty($wisata)){ //cek apakah terdapat record atau tidak
            $this->response($wisata, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }
    }

    //fungsi untuk mendapatkan data wisatatranslated sesuai dengan paramater
    public function wisatatranslated_get()
    {
        $param=$this->get('wisatatranslatedID');
        $data=$this->wisatatranslated->get_wisatatranslated($param);

        if($data){
            $this->response(['status'=>true,'data'=>$data], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'error' => 'Tidak ada wisatatranslated'], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    //fungsi untuk menambah resource didalam tabel product
    public function wisatatranslated_post()
    {


        $data=array();
        foreach ($this->post() as $key=>$value ) {
            # code...
           
                $data[$key]=trim($value);
            
        }
        $data['wisatatranslatedID']=md5(microtime());
        $_POST=json_decode(file_get_contents('php://input'), true);
        // $data=array('languageID'=>$this->input->post('languageID'),
        //             'languageCode'=>$this->put('languageCode'),
        //             'languageName'=>$this->put('languageName'),
        //             'languageAvalible'=>$this->put('languageAvalible'));
        if($this->wisatatranslated->validasi_tambah()){
            if($this->wisatatranslated->tambah_wisatatranslated($data)){
                 $this->set_response(['status'=>true,'error'=>'data Berhasil di inputkan'], REST_Controller::HTTP_CREATED);
            }else{
                    // Set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'error' => 'Gagal Menginput Data',
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
            }            
        }else{
                    $error['wisataName']=form_error('wisataName');
                    $error['wisataContent']=form_error('wisataContent');
                    $error['localizationID']=form_error('localizationID');
                    $this->response(['status'=>FALSE,'error'=>'Validasi Failed','data'=>$error], REST_Controller::HTTP_OK);              
        }
        
    }

    //fungsi untuk mengupdate resource didalam tabel product
    public function wisatatranslated_put(){
        $param=$this->put('wisatatranslatedID');
        $data=array();
        $i=0;
        foreach ($this->put() as $key=>$value ) {
            # code...
            if($value != null){
                if($key != 'wisatatranslatedID'){
                    $data[$key]= $value;
                }
                
            }
        }
        
        if($this->wisatatranslated->update_wisatatranslated($param,$data)){
            $this->set_response(['status'=>true ,'error'=>'Data berhasil di update'], REST_Controller::HTTP_CREATED);
        }else{
            $this->response(['status' => FALSE,'error' => 'Gagal Mengupdate'], REST_Controller::HTTP_NOT_FOUND);            
        }
    }

    public function wisatatranslated_delete(){
        $param=$_GET['wisatatranslateID'];
         //cek apakah product ID ada didalam database

        if($this->wisatatranslated->get_wisatatranslated($param)){

            //hapus data dari database;
            if($this->wisatatranslated->hapus_wisatatranslated($param)){
                 $this->response([
                    'status' => TRUE,
                    'success' => 'wisatatranslated Berhasil Di hapus'
                    ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
             }else{
                $this->response([
                    'status' => FALSE,
                    'error' => 'wisatatranslated Gagal Dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
             }

        }else{
                        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'error' => 'Tidak Ada wisatatranslated Di temukan'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }


}
