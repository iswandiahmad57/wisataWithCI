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
class Wisatarange extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('wisatarange_model','wisatarange',TRUE);
    }

    //fungsi untuk mendapatkan seluruh wisatarange
    public function wisataranges_get()
    {
        $param=$this->get('wisataID');
        $wisatarange=$this->wisatarange->get_all_wisatarange($param);
        if(!empty($wisatarange)){ //cek apakah terdapat record atau tidak
            $this->response($wisatarange, REST_Controller::HTTP_OK);
        }else{
            $this->response(REST_Controller::HTTP_NOT_FOUND);           
        }
    }

    //fungsi untuk mendapatkan data wisatarange sesuai dengan paramater
    public function wisatarange_get()
    {
        $param=$this->get('wisatatimerangeID');
        $data=$this->wisatarange->get_wisatarange($param);

        if($data){
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'error' => 'Tidak ada wisatarange'], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    //fungsi untuk menambah resource didalam tabel product
    public function wisatarange_post()
    {
        $id=md5(microtime());
        // $_POST=json_decode(file_get_contents('php://input'), true);

        foreach ($this->post() as $key=>$value ) {
            # code...
           
                $data[$key]= $value;
            
        }
        $data['wisatatimerangeID']=$id;
        $_POST=json_decode(file_get_contents('php://input'),true);
           
        
        if($this->wisatarange->validasi_tambah()){
            if($this->wisatarange->tambah_wisatarange($data)){
                 $this->set_response(['status'=>TRUE,'data'=>'data Berhasil di inputkan'], REST_Controller::HTTP_CREATED);
            }
            // }else{
            //         // Set the response and exit
            //         $this->response([
            //             'status' => FALSE,
            //             'data' => 'Gagal Menginput Data',
            //         ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
            // }
        }else{
            //fetch $_POST
                $formerror['destinationID']=form_error('destinationID');
                $formerror['duration']=form_error('duration');
                $this->response(['status'=>FALSE,'data'=>$formerror],REST_Controller::HTTP_OK);         
        }
    }

    //fungsi untuk mengupdate resource didalam tabel product
    public function wisatarange_put(){
        $param=$_GET['wisatatimerangeID'];
        $data=array();
        $i=0;
        foreach ($this->put() as $key=>$value ) {
            # code...
            if($value != null){
                $data[$key]= $value;
            }
        }

        $_PUT=json_decode(file_get_contents('php://input'), true);

    
            if($this->wisatarange->update_wisatarange($param,$data)){
                
                $this->set_response(['status'=>true,'error'=>'Data berhasil di update'], REST_Controller::HTTP_CREATED);
            }
            else{

                $this->response(['status' => FALSE,'error' => 'Gagal Mengupdate'], REST_Controller::HTTP_NOT_FOUND);            
            }
                  
        // }else{
        //         $datas=array(
        //             'productCode'=>form_error('productCode'),
        //             'productName'=>form_error('productName'),
        //             'productDescription'=>form_error('productDescription'),
        //             'productTermOfServices'=>form_error('productTermOfServices'),
        //             'productPrivacyPolicy'=>form_error('productPrivacyPolicy'),
        //             'productRating'=>form_error('productRating'));
        //         $this->response(['status'=>FALSE,'data'=>$datas],REST_Controller::HTTP_OK);             
        // }
        
    }

    public function wisatarange_delete(){
        $param=$_GET['wisatatimerangeID'];  


         //cek apakah product ID ada didalam database

        if($this->wisatarange->get_wisatarange($param)){

            //hapus data dari database;
            if($this->wisatarange->hapus_wisatarange($param)){
                 $this->response([
                    'status' => TRUE,
                    'success' => 'wisatarange Berhasil Di hapus'
                    ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
             }else{
                $this->response([
                    'status' => FALSE,
                    'error' => 'wisatarange Gagal Dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
             }

        }else{
                        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'error' => $param
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }

    


}
