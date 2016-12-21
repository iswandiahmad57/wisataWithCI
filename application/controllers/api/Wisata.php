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
class Wisata extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('wisata_model','wisata',TRUE);
    }

    //fungsi untuk mendapatkan seluruh wisata
    public function wisataAll_get()
    {
        $wisata=$this->wisata->get_all_wisata();
        if(!empty($wisata)){ //cek apakah terdapat record atau tidak
            $this->response($wisata, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }
    }
    public function getGambar_get()
    {
        $wisata=$this->wisata->getGambar($this->get('wisataID'));
        if(!empty($wisata)){ //cek apakah terdapat record atau tidak
            $this->response($wisata, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }
    }
    public function wilayah_get(){
        $wilayah=$this->wisata->get_wilayah();
        if(!empty($wilayah)){ //cek apakah terdapat record atau tidak
            $this->response($wilayah, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }        
    }
    //fungsi untuk mendapatkan data wisata sesuai dengan paramater
    public function wisata_get()
    {
        $param=$this->get('wisataID');
        $data=$this->wisata->get_wisata($param);

        if($data){
            $this->response(['status'=>true,'data'=>$data], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'error' => 'Tidak ada wisata'], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    //fungsi untuk menambah resource didalam tabel product

    public function validasi_post(){
        $_POST=json_decode(file_get_contents('php://input'), true);

         if($this->wisata->validasi_tambah()){
                $this->set_response(['status'=>true,'error'=>'validasi Oke'], REST_Controller::HTTP_CREATED);
  
            }else{
                // gagal memvalidasi 
                    $formError=array();
                    foreach ($this->post() as $key=>$value ) {
                        # code...
                            if($key!="file"){
                                if($key!="cover"){
                                    
                                        if($key!="coverIndex"){
                                           
                                                if($key!="imageNumber"){
                                                    
                                                 $formError[$key]=form_error($key);
                                                }
                                        }      
                                }   
                            }
                    }
                    $this->response(['status'=>FALSE,'error'=>'Validasi Failed','data'=>$formError], REST_Controller::HTTP_OK);             
            }                    
    }

    public function uploadImage_post(){//upload image untuk editing ketika menambahkan gambar
        $config['upload_path']      = 'uploads/';
        $config['allowed_types']    = 'jpg|png';
        $config['max_size']         = '5120';
        $wisataID=$this->post('wisataID');
        $extension = explode(".", $_FILES['file']['name']);

        //cek ada berapa gambar yang ada di timeline 
        $gambarGet=$this->db->where('wisataID',$wisataID)->limit(1)->order_by('wisataimageID','DESC')->get('wisataimages')->row();
        $imageNumberPost=$this->post('imageNumber')+1;
        $gambarNumber=0;
        if($gambarGet){
            $in=explode('_', $gambarGet->wisataimageName);
            $inn=explode('.',$in[1]);

            $gambarNumber=$inn[0]+$imageNumberPost;
        }else{
            $gambarNumber=$imageNumberPost;
        }
        $ext = $wisataID."_".$gambarNumber.'.'.$extension[count($extension)-1];
        $config['file_name'] =$ext;
        $this->load->library('upload', $config);
        if( $this->upload->do_upload('file') ) {

                $dataForm=array('wisataimageID'=>md5(microtime()),'wisataimageName'=>$ext,'wisataID'=>$wisataID);
                $this->wisata->insert_gambar($dataForm);
                 $this->set_response(['status'=>true,'error'=>'datas Berhasil di inputkan'], REST_Controller::HTTP_CREATED);                    
        }else{
            //gagal mengupload
                    // Set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'error' => 'Upload Failed',
                        'data'=>$this->upload->display_errors()
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
        }         
    }


    public function deleteGambar_get(){
        $param=$this->get('gambarID');

        $gambar=$this->db->where('wisataimageID',$param)->get('wisataimages')->row();

        $gambarName=$gambar->wisataimageName;
        $data=$this->wisata->delete_gambar($param);

        //hapus data dari database;
        if($data){
            unlink('uploads/'.$gambarName);
             $this->response([
                'status' => TRUE,
                'success' => 'Gambar Berhasil Di hapus'
                ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
         }else{
            $this->response([
                'status' => FALSE,
                'error' => 'Gambar Gagal Dihapus'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
         }
    }


    public function wisata_post()
    {
                //rule for uploading cover
        $config['upload_path']      = 'uploads/';
        $config['allowed_types']    = 'jpg|png';
        $config['max_size']         = '5120';
       
     
        
        $extension = explode(".", $_FILES['file']['name']);
  
        
        
        if($this->post('wisataID')==null){
            $wisataID=md5(microtime());
        }else{
            $wisataID=$this->post('wisataID');

        }
        $ext =$wisataID.'_'.$this->post('imageNumber').'.'.$extension[count($extension)-1];
        $config['file_name'] =$ext;
         $this->load->library('upload', $config);
                    $data=array();
                    foreach ($this->post() as $key=>$value ) {
                        # code...

                            if($key!="file"){
                                if($key!="cover"){
                                
                                        if($key!="coverIndex"){
                                            
                                                if($key!="imageNumber"){

                                                 $data[$key]= trim($value);
                                                }  
                                        }
                                
                                }

                                
                            }
          
                    }


        if($this->post('imageNumber')==0){
             
            if($this->wisata->validasi_tambah()){


                    $extIcon=explode('.',$this->post('icon'));
                    $extCover=explode('.', $this->post('cover'));
                    $data['wisataID']=$wisataID;
                    $data['wisataCover']=$wisataID."_".$this->post('coverIndex').'.'.$extCover[count($extension)-1];
                    // $data['wisataIcon']=$wisataID."_".$this->post('coverIndex').'.'.$extIcon[count($extension)-1];
                    
                    

                        if( $this->upload->do_upload('file') ) {
                            if($this->wisata->tambah_wisata($data)){
                                 $this->set_response(['status'=>true,'error'=>'data Berhasil di inputkan','id'=>$wisataID], REST_Controller::HTTP_CREATED);
                            }else{
                                    // Set the response and exit
                                    $this->response([
                                        'status' => FALSE,
                                        'error' => 'Input Failed',
                                        'id'=>$wisataID,
                                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
                            }
                        }else{
                            //gagal mengupload
                                    // Set the response and exit
                                    $this->response([
                                        'status' => FALSE,
                                        'error' => 'Upload Failed',
                                        'data'=>$this->upload->display_errors(),
                                        'id'=>$wisataID,
                                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
                        }

                
            }else{
                // gagal memvalidasi 
                    $formError=array();
                    foreach ($this->post() as $key=>$value ) {
                        # code...
                            if($key!="file"){
                                if($key!="cover"){
                                    
                                        if($key!="coverIndex"){
                                           
                                                if($key!="imageNumber"){
                                                    
                                                 $formError[$key]=form_error($key);
                                                }
                                            
                                           
                                        }
                                        
                                    
                                
                                }

                                
                            }
 
          
                    }
                    $this->response(['status'=>FALSE,'error'=>'Validasi Failed','data'=>$formError], REST_Controller::HTTP_BAD_REQUEST);             
            }            
        }else{
          
                    
                   // masukkan ke dalam tabel wisata image
                    $data['wisataimageID']=md5(microtime());
                    $data['wisataimageName']=$ext;
                    $data['wisataID']=$wisataID;

                    if( $this->upload->do_upload('file') ) {
                            $this->wisata->tambah_wisata_image($data);
                             $this->set_response(['status'=>true,'error'=>'datas Berhasil di inputkan','id'=>$wisataID], REST_Controller::HTTP_CREATED);                    
                    }else{
                        //gagal mengupload
                                // Set the response and exit
                                $this->response([
                                    'status' => FALSE,
                                    'error' => 'Upload Failed',
                                    'data'=>$this->upload->display_errors(),
                                    'id'=>$timelineID,
                                ],REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code 
                    }   
        }


    }

    //fungsi untuk mengupdate resource didalam tabel product
    public function wisata_put(){
        $param=$this->put('wisataID');
        $data=array();
        $i=0;
        foreach ($this->put() as $key=>$value ) {
            # code...
            if($value != null){
                $data[$key]= $value;
            }
        }

 

            if($this->wisata->update_wisata($param,$data)){
                $this->set_response(['status'=>true,'erro'=>'Data berhasil di update'], REST_Controller::HTTP_CREATED);
            }else{
                $this->response(['status' => FALSE,'error' => 'Gagal Mengupdate'], REST_Controller::HTTP_NOT_FOUND);            
            }            
 


    }

    public function wisata_delete(){
        $param=$_GET['wisataID'];
         //cek apakah product ID ada didalam database

        if($this->wisata->get_wisata($param)){

            //hapus data dari database;
            if($this->wisata->hapus_wisata($param)){
                 $this->response([
                    'status' => TRUE,
                    'success' => 'wisata Berhasil Di hapus'
                    ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
             }else{
                $this->response([
                    'status' => FALSE,
                    'error' => 'wisata Gagal Dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
             }

        }else{
                        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'error' => 'Tidak Ada wisata Di temukan'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }


    public function tiket_post(){
        $data=array();
        foreach ($this->post() as $key=>$value ) {
            # code...
                $data[$key]= trim($value); 
        }
        $data['wisatatiketID']=md5(microtime());

        $_POST=json_decode(file_get_contents('php://input'),true);
        if($this->wisata->validasi_tambah_tiket()){
            if($this->wisata->tambah_tiket($data)){
                 $this->set_response(['status'=>TRUE,'data'=>'data Berhasil di inputkan'], REST_Controller::HTTP_CREATED);
            }else{
                    // Set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'error' => 'Gagal Menginput Data',
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
            }            
        }else{
                $datas=array(
                    'wisatatiketAdultPrice'=>form_error('wisatatiketAdultPrice'),
                    'wisatatiketChildrenPrice'=>form_error('wisatatiketChildrenPrice'));
                $this->response(['status'=>FALSE,'data'=>$datas],REST_Controller::HTTP_OK); 
        }

    }
    public function tiket_get(){
        $param=$this->get('wisataID');

        $wisatatiket=$this->wisata->get_wisata_tiket($param);
        if(!empty($wisatatiket)){ //cek apakah terdapat record atau tidak
            $this->response($wisatatiket, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }
    }
    public function tiketBy_get(){
        $param=$this->get('wisatatiketID');

        $wisatatiket=$this->wisata->get_tiket_by($param);
        if(!empty($wisatatiket)){ //cek apakah terdapat record atau tidak
            $this->response($wisatatiket, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }        
    }

    public function tiket_put(){
        $param=$this->put('wisatatiketID');
        $data=array();
        $i=0;
        foreach ($this->put() as $key=>$value ) {
            # code...
            if($value != null){
                $data[$key]= $value;
            }
        }

 

            if($this->wisata->edit_tiket($param,$data)){
                $this->set_response(['status'=>true,'erro'=>'Data berhasil di update'], REST_Controller::HTTP_CREATED);
            }else{
                $this->response(['status' => FALSE,'error' => 'Gagal Mengupdate'], REST_Controller::HTTP_NOT_FOUND);            
            }   
    }

    public function tiket_delete(){
        $param=$_GET['wisatatiketID'];
         //cek apakah product ID ada didalam database

        if($this->wisata->get_tiket_by($param)){

            //hapus data dari database;
            if($this->wisata->delete_tiket($param)){
                 $this->response([
                    'status' => TRUE,
                    'success' => 'wisata Berhasil Di hapus'
                    ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
             }else{
                $this->response([
                    'status' => FALSE,
                    'error' => 'wisata Gagal Dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
             }

        }else{
                        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'error' => 'Tidak Ada wisata Di temukan'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
    }



    public function comment_get(){
        $param=null;
       if($this->get('wiasataID')){
            $param=$this->get('wisataID');
       }
        $wisataComment=$this->wisata->get_all_wisata_comment($param);
        if(!empty($wisataComment)){ //cek apakah terdapat record atau tidak
            $this->response($wisataComment, REST_Controller::HTTP_OK);
        }else{
            $this->response( REST_Controller::HTTP_NOT_FOUND);           
        }

    }



    public function comment_delete(){
        $param=$_GET['commentID'];
         //cek apakah product ID ada didalam database


            //hapus data dari database;
            if($this->wisata->delete_comment($param)){
                 $this->response([
                    'status' => TRUE,
                    'success' => 'wisata Berhasil Di hapus'
                    ], REST_Controller::HTTP_CREATED); // NO_CONTENT (204) being the HTTP response code               
             }else{
                $this->response([
                    'status' => FALSE,
                    'error' => 'wisata Gagal Dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code                
             }

        
    }

}   
