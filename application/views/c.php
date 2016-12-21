<?php

$index=0;
$indexNews=0;
$indexAdvertising=0;
$lengthAdvertising=count($queryAdvertising)-1;
 foreach($general as $row){
 		if($row->timelineType=="News"){
 			$indexNews++;
 		}

 		if($indexNews==5){

 		}
 }