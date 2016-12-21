<?php
class Api_model extends CI_Model {

    //model untuk api
    //parameter Utama Adalah apiID mengacu pada nama kolom di dalam db_tabel
    //carikan rekomendasi yang sesuai dengan parameter datestart,datefinish , wilayah , language
    public function randomGuides($orderID){
        $orders=$this->db->select('*')
                 ->from('orders o')
                 ->join('orderdetail od','o.orderID=od.orderID')
                 ->join('wisata w','od.wisataID=w.wisataID')
                 ->join('wilayah wl','w.wilayahID=wl.wilayahID')
                 ->where('orderID',$orderID)->get()->row();
        $customers=$this->db->select('*')
                 ->from('customers')
                 ->where('customerID',$orders->customerID)->get()->row();
                 $gender=($orders->orderGender=="R")?array("L","P"):array($orders->orderGender);
                 $languageID=array($orders->languageID,$customers->languageID);

        $query="SELECT o.guideID  FROM orders o where o.orderDateStart BETWEEN '".$orders->orderDateStart ."' AND '". $orders->orderDateFinish ."' AND o.orderDateFinish BETWEEN '".$orders->orderDateStart ."' AND '". $orders->orderDateFinish ."'  AND o.orderStatus IN ('Paid','OnService') " ;
        $guideNotReady=array();

        foreach ($this->db->query($query)->result() as $row) {
            # code...
            $guideNotReady[]=$row->guideID;
        }
        // var_dump($guideNotReady);

        
         $a=$this->db->select('g.guideID,g.gcmID,g.guideCode,g.guideName,g.guidePhoto,(SELECT COUNT(*) from orderbid where guideID=g.guideID and statusGet="Yes")AS choose, (SELECT COUNT(*) from orderbid where guideID=g.guideID and statusBid="Accept")AS accept,(SELECT COUNT(*) from orderbid where guideID=g.guideID and statusBid="Decline")AS decline , IF((gl.guidelanguageRating = NULL OR gl.guidelanguageRating = ""),CONCAT(0),gl.guidelanguageRating) AS guidelanguageRating ,IFNULL((SELECT (SUM(guideratingValue)/COUNT(*)) FROM guiderating WHERE guideID = g.guideID),0) AS rattingVal')
                ->from('guides g')
                ->join('guidelanguage gl','g.guideID = gl.guideID')

                ->where_in('guideGender',$gender)
                ->where_not_in('gl.guideID',$guideNotReady)
                ->where('g.wilayahID',$orders->wilayahID)
                ->where_in('gl.languageID', $languageID);

        return $this->db->get()->result();
        // echo $this->db->last_query();

    }
    public function getLanguageAll(){
        return $this->db->select('languageName, languageCode , languageID')->get('languages')->result();
    }
    // Customer Section
    public function getCustomer($customerID){
        return $this->db->select('customers.customerID , customers.customerCode , customers.customerName, customers.customerEmail , customers.customerPhone , customers.customerPhoto , customers.username , customers.password , languages.languageID, languages.languageCode , languages.languageName')
            ->from('customers')
            ->join('languages','customers.languageID = languages.languageID')
            ->where('customers.customerID',$customerID)
            ->order_by('customerID','ASC')
            ->get()
            ->result();
    }

    public function updateCustomer($id,$data){
        $this->db->where('customerID',$id)->update('customers',$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function tambah_customer($data=array()){
        $this->db->insert('customers', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //end of customer Section


    //Guide Section 
    public function getGuide($id){
        return $this->db->select('guideID, guideCode, guideName, guideEmail, guidePhone, guidePhoto, username, password, wilayah.wilayahID, wilayahNama')
            ->from('guides')
            ->join('wilayah','guides.wilayahID = wilayah.wilayahID')
            ->where('guideID',$id)
            ->order_by('guideID','ASC')
            ->get()
            ->result();
    }


    public function updateGuide($id,$data){
        $this->db->where('guideID',$id)->update('guides',$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function updateGuideLanguage($id,$data){
        foreach ($data as $row) {
            # code...
            $datas['guideID']=$id;
            $datas['guidelanguageID']=md5(microtime());
            $datas['guidelanguageRating']=$row['guidelanguageRatting'];
            $datas['languageID']=$row['languageID'];
            $cekData=$this->db->where('guideID',$id)->where('languageID',$row['languageID'])->limit(1)->get('guidelanguage')->result();

            if(count($cekData)< 1){
                $this->db->insert('guidelanguage',$datas);
            }else{
                $dataEdit=array('guidelanguageRating'=>$row['guidelanguageRatting']);
                $this->db->where('guideID',$id)->where('languageID',$row['languageID'])->update('guideLanguage',$dataEdit);
            }

        }

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function languageByGuide($guideID){
        return $this->db->select('languages.languageID , guideID,  languageCode , languageName')
                    ->from('guidelanguage')
                    ->join('languages','guidelanguage.languageID = languages.languageID')
                    ->where('guideId',$guideID)
                    ->get()->result();
    }
    public function updateGuideDesc($id,$data){
        $this->db->where('guidelanguageID',$id)->update('guideDescription',$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function updateGuideRatting($id,$data){
        $this->db->where('guideID',$id)->update('guides',$data);
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function tambah_guide($data=array()){
        $this->db->insert('guides', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //End OF Guide Section


    //wilayah Section 

    public function getWilayah($parentID, $wilayahType){
        return $this->db
            ->where('parentID',$parentID)
            ->where('wilayahTipe',$wilayahType)
            ->get('wilayah')
            ->result();
    }

    //End Section OF Wilayah

    //wisata Section
    // Customer Section
    public function getWisata($id){
        return $this->db
            ->from('wisata')
            ->where('wilayahID',$id)
            ->order_by('wisataID','ASC')
            ->get()
            ->result();
    }
    //End wisata Section


    //Timeline Section 
    public function getTimeline(){
        return $this->db
            ->from('timelines')
            ->order_by('timelineDate','DESC')
            ->get()
            ->result();
    }

    public function searchTimeline($keyword){
        return $this->db->like('timelineTitle',$keyword)->get('timelines')->result();
    }


    //End Of Timeline Section

    //Orders Section

    public function saveOrder($data){
        $this->db->insert('orders', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function saverOrderDetail($idOrder,$wisata){

        $orderID=$idOrder;

        

        foreach ($wisata as $row) {
            # code...
            $data=array('orderdetailID'=>md5(microtime()),'orderID'=>$orderID);
            $data['wisataID']=$row;
            $this->db->insert('orderdetail',$data);
        }
        // for ($i=0; $i < count($wisata); $i++) { 
        //     # code...
        //     $data['wisataID']=$wisata[$i];
        //     $this->db->insert('orderdetail',$data);
        // }
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function chooseGuide($id,$guide){
        $this->db->trans_start();
        $this->db->where('orderID',$id)->update('orders',array('guideID'=>$guide,'orderStatus'=>'WaitPayment'));
        $this->db->where('orderID',$id)->where('statusBid','Accept')->update('orderbid',array('statusGet'=>'Yes'));


        if($this->db->trans_complete())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function paid($id){
        $this->db->where('orderID',$id)->update('orders',array('orderStatus'=>'WaitConfirm'));
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getGuideList($orderStatus){
        return $this->db->select('orders.guideID, guideCode, guideName , guideEmail , guidePhone , guidePhoto')
                ->from('orders')
                ->join('orderbid','orderbid.orderID = orders.orderID' , 'right')
                ->join('guides','orderbid.guideID = guides.guideID')

                ->where('orders.orderStatus',$orderStatus)
                // ->where('orderbid.statusbid =','Send Notif')
                ->order_by('orders.orderDate','DESC')
                ->get()
                ->result();
    }

    public function getDescription($guideID){
        return $this->db
                    ->from('guidelanguage')
                    
                    ->join('guidedescription','guideDescription.guidelanguageID = guideLanguage.guidelanguageID','right')
                    ->where('guidelanguage.guideID',$guideID)
                    ->get()
                    ->result();

    }

    public function bidOrder($data){

        $this->db->insert('orderbid', $data);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }      
    }

    public function bid_status($bidID,$dataUpdate){
        $this->db->where('id_bid',$bidID)->update('orderbid',array('statusBid'=>$dataUpdate));
        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }        
    }

    public function getLastOrder($orderStatus){
        return $this->db->select('orderID , orders.languageID as optionaLanguage , customers.languageID as primaryLanguage, orders.wilayahID , wilayahNama , orderDateStart, orderDateFinish , orderGender , orderCount , orderComment')
                ->from('orders')
                ->join('wilayah','orders.wilayahID = wilayah.wilayahID')
                ->join('customers','orders.customerID = customers.customerID')
                ->where('orders.orderStatus',$orderStatus)
                ->order_by('orders.orderDate','DESC')
                ->get()
                ->result();
    }
    public function getHistoryOrder($customerID,$orderStatus){
        return $this->db->select('orderID , orders.languageID as optionaLanguage , customers.languageID as primaryLanguage, orders.wilayahID , wilayahNama , orderDateStart, orderDateFinish , orderGender , orderCount , orderComment')
                ->from('orders')
                ->join('wilayah','orders.wilayahID = wilayah.wilayahID')
                ->join('customers','orders.customerID = customers.customerID')
                ->where('orders.customerID',$customerID)
                ->where_in('orders.orderStatus',$orderStatus)
                ->order_by('orders.orderDate','DESC')
                ->get()
                ->result();
    }
    public function getHistoryBid($guideID,$orderStatus){
        return $this->db->select('orders.orderID , orders.languageID as optionaLanguage , customers.languageID as primaryLanguage, orders.wilayahID , wilayahNama , orderDateStart, orderDateFinish , orderGender , orderCount , orderComment,statusBid, statusGet')
                ->from('orderbid')
                ->join('orders','orders.orderID=orderbid.orderID')
                ->join('wilayah','orders.wilayahID = wilayah.wilayahID')
                ->join('customers','orders.customerID = customers.customerID')
                ->where('orderbid.guideID',$guideID)
                ->where_in('orders.orderStatus',$orderStatus)
                ->order_by('orders.orderDate','DESC')
                ->get()
                ->result();
    }
    public function getOrderDetail($orderID){
        return $this->db->where('orderID',$orderID)->get('orderdetail')->result();
    }

    public function getOrderLanguage($languageID){
        return $this->db->select('languageID , languageCode , languageName ')->from('languages')
                    ->where('languageID',$languageID)
                    ->get()
                    ->result();

    }
}
