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
class Front extends REST_Controller {

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
    public function wisatafront_post()
    {

        $category=$this->post('paramCategory')?$this->post('paramCategory'):null;
        $wilayah=$this->post('paramWilayah')?$this->post('paramWilayah'):null;
        $price=$this->post('price')?$this->post('price'):null;
        $start=$this->post('start');
        $limit=$this->post('limit');
        $wisata=$this->wisata->get_all_wisata_front($category,$wilayah,$price,$start,$limit);

 
        $total=count($this->db->get('wisata')->result());
        // echo $this->db->last_query();
        if(!empty($wisata)){ //cek apakah terdapat record atau tidak
            $this->response(['status'=>'success','start'=>$start,'total'=>$total,'data'=>$wisata], REST_Controller::HTTP_OK);
        }else{
            $this->response( ['status'=>'empty'],REST_Controller::HTTP_NOT_FOUND);           
        }
    }
    // public function getGambar_get()
    // {
    //     $wisata=$this->wisata->getGambar($this->get('wisataID'));
    //     if(!empty($wisata)){ //cek apakah terdapat record atau tidak
    //         $this->response($wisata, REST_Controller::HTTP_OK);
    //     }else{
    //         $this->response( REST_Controller::HTTP_NOT_FOUND);           
    //     }
    // }

    //fungsi untuk mendapatkan data wisata sesuai dengan paramater
    public function wisata_get()
    {
        $param=$this->get('wisataID');
        $data=$this->wisata->get_wisata_front($param);

        if($data){
            $this->response(['status'=>true,'data'=>$data], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'error' => 'Tidak ada wisata'], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function comment_post(){
        $data=array();
        foreach ($this->post() as $key=>$value ) {
            # code...
                $data[$key]= trim($value); 
        }
        $data['commentID']=md5(microtime());
        $data['commentDate']=date("Y-m-d");


            if($this->wisata->tambah_comment($data)){
                 $this->set_response(['status'=>TRUE,'data'=>'data Berhasil di inputkan'], REST_Controller::HTTP_CREATED);
            }else{
                    // Set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'error' => 'Gagal Menginput Data',
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
            }            


    }
    public function rating_post(){
        $data=array();
        foreach ($this->post() as $key=>$value ) {
            # code...
                $data[$key]= trim($value); 
        }
        $data['ratingID']=md5(microtime());
    


            if($this->wisata->tambah_rating($data)){
                 $this->set_response(['status'=>TRUE,'data'=>'data Berhasil di inputkan'], REST_Controller::HTTP_CREATED);
            }else{
                    // Set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'error' => 'Gagal Menginput Data',
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code            
            }            


    }


    public function comment_get(){
        $param=$this->get('wisataID');
        $data=$this->wisata->get_comment_front($param);

        if($data){
            $this->response(['status'=>true,'data'=>$data], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'error' => 'Tidak ada wisata'], REST_Controller::HTTP_NOT_FOUND);
        }
    }





    public function pesawat_get()
    {
        // Users from a data store e.g. database
        $tanggal=$this->get('data');

        $this->load->helper('url');
        $param=$this->get('search');
        $postFields="offset=0&limit=20&p=1";
         $curl = curl_init("https://www.tiket2.com/search/".$param);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields); 
        curl_setopt($curl, CURLOPT_VERBOSE, TRUE);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_exec($curl);
        $page = curl_exec($curl);
        if(curl_errno($curl)) // check for execution errors
        {
            echo 'Scraper error: ' . curl_error($curl);
            exit;
        }
        curl_close($curl);


        $html = new Simple_html_dom();
        $html->load($page);
        $a=$html->find('.search-flight-row');

        echo $a[0];
        
        $discountPrice=new Simple_html_dom();
        $discountPrice->load($page);
        $price=$discountPrice->find('.search-flight-discount-price');

        // // echo count($a[0]->children(2)->children(0)->children(0)->children(0)->children);

        $data[]=array();
        $i=0;
        
        for($as=0; $as< count($a); $as++){
            $time[]=array();
            $bs=0;
            for ($b=0; $b <count($a[0]->children(2)->children(0)->children(0)->children(0)->children) ; $b++) { 
                # code...
                $time[$bs++]=array('waktu' =>count($a[0]->children(2)->children(0)->children(0)->children(0)->children($b)));
            }
            $data[$i++]=array('pesawat'=> trim($a[$as]->children(1)->plaintext),
                                'harga'=>trim(str_replace('Rp', '', $price[0]->plaintext)),
                                'waktu'=>$time);
            # code...
        }
        
        $this->response($data, REST_Controller::HTTP_OK);
  
        // foreach ($html->find('select') as $element) {
        //     echo $element . '<br>';
        // }
    
        
    }

    public function airport_get(){
        $curl = curl_init();
        // get airport from around the world
            $url='https://airport.api.aero/airport?user_key=ac27764e9403c5556dbca7ad778ec0f8';
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/json';
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Codular Sample cURL Request'
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            // Close request to clear up some resources
            $a=json_decode($resp);


            $airport[]=array();
            $i=0;
            foreach ($a->airports as $key) {
                # code...
                $bandara=$key->country.' '.$key->name.'('.$key->code.')';

                $airport[$i++]=array('bandara'=>$bandara);
            }

            return $airport;
    }

}   
