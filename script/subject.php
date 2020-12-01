<?php
require_once "../../Aim/aim.php";
include "controls.php";
//get the studies
$studies = $_->Query("SELECT * FROM course_tb c, programme_tb p, dept_tb d, fac_tb f, study_tb s WHERE c.DeptID = p.ProgID AND p.DeptID = d.DeptID AND d.FacID = f.FacID AND f.StudyID = s.ID AND s.ID = {$_POST['StudyID']} AND c.Lvl = {$_POST['LevelID']} AND c.Sem = {$_POST['SemID']}");
//get the study details
$studdet = $_->SelectFirstRow("study_tb","","ID=".$_POST['StudyID']);
$lvl = $_->SelectFirstRow("schoollevel_tb","","ID=".$_POST['LevelID']);
$sem = $_->SelectFirstRow("semester_tb","","Num=".$_POST['SemID']);
$headtitle = is_array($studdet)?$studdet['Name'] .'-'. $lvl['Descr'] ."-".$sem['Descr']:'E-learning';
if(is_array($studies)){
  //fech all value
  $mk = Title("Select a Subject");
 
  while($v = $studies[0]->fetch_assoc()){
     $mk .= Button(ucfirst($v['Title']),"Elearn.LearnFrom('SubjectPage',".$v['CourseID'].")") ;
  }
}else{
    $mk = '#No Subject Found - '.$studies;
}

echo json_encode([$headtitle,$mk]);

?>