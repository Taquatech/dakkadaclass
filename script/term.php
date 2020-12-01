<?php
require_once "../../Aim/aim.php";
include "controls.php";
//get the studies
$studies = $_->Query("SELECT * FROM semester_tb WHERE Enable = 1");
//get the study details
$studdet = $_->SelectFirstRow("study_tb","","ID=".$_POST['Key1']);
$lvl = $_->SelectFirstRow("schoollevel_tb","","ID=".$_POST['Key']);
$headtitle = is_array($studdet)?$studdet['Name'] .'-'. $lvl['Descr']:'E-learning';
if(is_array($studies)){
  //fech all value
  $mk = Title("Select a Term");
 
  while($v = $studies[0]->fetch_assoc()){
     $mk .= Button($v['Descr'],"Elearn.SubjectFrom('TermPage',".$v['Num'].")") ;
  }
}else{
    $mk = '#No Term Found';
}

echo json_encode([$headtitle,$mk]);

?>