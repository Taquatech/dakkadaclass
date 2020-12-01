<?php
require_once "../../Aim/aim.php";
include "controls.php";
//get the studies
$studies = $_->Query("SELECT * FROM schoollevel_tb WHERE StudyID = ".$_POST['Key']);
//get the study details
$studdet = $_->SelectFirstRow("study_tb","","ID=".$_POST['Key']);
$headtitle = is_array($studdet)?$studdet['Name']:'E-learning';
if(is_array($studies)){
  //fech all value
  $mk = Title("Select a Class");
 
  while($v = $studies[0]->fetch_assoc()){
     $mk .= Button($v['Descr'],"Elearn.TermFrom('ClassPage',".$v['Level'].")") ;
  }
}else{
    $mk = '#No Class Found';
}

echo json_encode([$headtitle,$mk]);

?>