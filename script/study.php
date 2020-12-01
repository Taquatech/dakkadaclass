<?php
require_once "../../Aim/aim.php";
include "controls.php";
//get the studies
$studies = $_->Query("SELECT * FROM study_tb WHERE SchoolType = (SELECT Type FROM school_tb Limit 1)");
$headtitle = 'E-learning';
if(is_array($studies)){
  //fech all value
  $mk = Title("Select a School");
 
  while($v = $studies[0]->fetch_assoc()){
     $mk .= Button($v['Name'],"Elearn.ClassFrom('SchoolPage',".$v['ID'].")") ;
  }
}else{
    $mk = '#No School Found - '.$studies;
}

echo json_encode([$headtitle,$mk]);

?>