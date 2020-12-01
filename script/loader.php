<?php
require_once "../../Aim/aim.php";
include "controls.php";
include "lesson.php";
function SchoolPage(){
  global $schools;
//get the studies
/* Should Normaly Select From Database*/
//nuco temp
$headtitle = 'Akwa Ibom State';
$mk = Title("Select your School");
foreach($schools as $key=>$det){
  if(is_string($det))$det = ["Title"=>$det];
  if(isset($det["Link"]) && trim($det["Link"]) != ""){
    $mk .= LinkButton($det["Title"],$det["Link"]) ;
  }else{
    $mk .= Button($det["Title"],"Elearn.Load('ClassPage',".$key.")") ;
  }
}
/* foreach([1=>"Nursery","Primary"] as $key=>$sch){
  $mk .= Button($sch,"Elearn.Load('ClassPage',".$key.")") ;
}
$mk .= LinkButton("Senior Secondary School","http://www.mobileclassroom.com.ng/") ; */
exit(json_encode([$headtitle,$mk]));
}

function ClassPage($SchID=0){
  global $clases;
  $datas = $clases;
  /* Should Normaly Get Level From Database*/
  /* $datas = [
    1=>["Title"=>"Nursery","Class"=>["1_2"=>"Nursery 2"]],
    2=>["Title"=>"Primary","Class"=>["2_1"=>"Primary 1","2_2"=>"Primary 2","2_3"=>"Primary 3","2_4"=>"Primary 4","2_5"=>"Primary 5 (CBT)"]]
  ]; */
  //get the studies
  /* Should Normaly Select From Database*/
  //nuco temp
  //get the class details
  $classDet = $datas[$SchID];
  $headtitle = $classDet['Title'];
  $mk = Title("Select your Faculty");
  foreach($classDet['Class'] as $key=>$sch){
    if(is_string($sch))$sch = ["Title"=>$sch];
    if(isset($sch["Link"]) && trim($sch["Link"]) != ""){
      $mk .= LinkButton($sch["Title"],$sch["Link"]) ;
    }else{
      $mk .= Button($sch['Title'],"Elearn.Load('SubjectPage','".$key."')") ;
    }
    
  }
  exit(json_encode([$headtitle,$mk]));
  }

  function SubjectPage($Data){
    global $subjects;
    $datas = $subjects;
    if(isset($datas[$Data])){
$classDet = $datas[$Data];
    $headtitle = $classDet['Title'];
    $mk = Title("Select your Department");
    foreach($classDet['Subject'] as $key=>$sch){
      if(is_string($sch))$sch = ["Title"=>$sch];
      if(isset($sch["Link"]) && trim($sch["Link"]) != ""){
        $mk .= LinkButton($sch['Title'],$sch['Link']) ;
      }else{
        $mk .= Button($sch['Title'],"Elearn.Load('LevelPage','".$key."')") ;
        //this should be used for lesson page (display the first lesson)
        // $mk .= Button($sch['Title'],"Elearn.Load('LevelPage','".$key."_1')") ;
      }
      /* if($key == "2_5_1"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/00252") ;
      }else if($key == "2_5_2"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/75089") ;
      }else{
        $mk .= Button($sch,"Elearn.Load('LessonPage','".$key."_1')") ;
      } */
      
    }
    }else{
      $headtitle = "E-Learning";
      $mk = Title("Hoops!!!, E-learning Server not Available at the moment.<br/>Try Again Later");
    }
    
    exit(json_encode([$headtitle,$mk]));
    //$mk .= Button($sch,"Elearn.Load('LessonPage',[".$key.",1])") ;
  }

  function LevelPage($Data){
    global $level;
    $datas = $level;
    if(isset($datas[$Data])){
$classDet = $datas[$Data];
    $headtitle = $classDet['Title'];
    $mk = Title("Select your Level");
    foreach($classDet['Level'] as $key=>$sch){
      if(is_string($sch))$sch = ["Title"=>$sch];
      if(isset($sch["Link"]) && trim($sch["Link"]) != ""){
        $mk .= LinkButton($sch['Title'],$sch['Link']) ;
      }else{
        $mk .= Button($sch['Title'],"Elearn.Load('WeekPage','".$key."')") ;
      }
      /* if($key == "2_5_1"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/00252") ;
      }else if($key == "2_5_2"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/75089") ;
      }else{
        $mk .= Button($sch,"Elearn.Load('LessonPage','".$key."_1')") ;
      } */
      
    }
    }else{
      $headtitle = "E-Learning";
      $mk = Title("Hoops!!!, E-learning Server not Available at the moment.<br/>Try Again Later");
    }
    
    exit(json_encode([$headtitle,$mk]));
    //$mk .= Button($sch,"Elearn.Load('LessonPage',[".$key.",1])") ;
  }

  function WeekPage($Data){
    global $week;
    $datas = $week;
    if(isset($datas[$Data])){
$classDet = $datas[$Data];
    $headtitle = $classDet['Title'];
    $mk = Title("");
    foreach($classDet['Weeks'] as $key=>$sch){
      if(is_string($sch))$sch = ["Title"=>$sch];
      if(isset($sch["Link"]) && trim($sch["Link"]) != ""){
        $mk .= LinkButton($sch['Title'],$sch['Link']) ;
      }else{
        //$mk .= Button($sch['Title'],"Elearn.Load('LevelPage','".$key."')") ;
        $mk .= Button($sch['Title'],"Elearn.Load('CoursePage','".$key."')") ;
      }
      /* if($key == "2_5_1"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/00252") ;
      }else if($key == "2_5_2"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/75089") ;
      }else{
        $mk .= Button($sch,"Elearn.Load('LessonPage','".$key."_1')") ;
      } */
      
    }
    }else{
      $headtitle = "E-Learning";
      $mk = Title("Hoops!!!, E-learning Server not Available at the moment.<br/>Try Again Later");
    }
    
    exit(json_encode([$headtitle,$mk]));
    //$mk .= Button($sch,"Elearn.Load('LessonPage',[".$key.",1])") ;
  }


  function CoursePage($Data){
    global $course;
    $datas = $course;
    if(isset($datas[$Data])){
$classDet = $datas[$Data];
    $headtitle = $classDet['Title'];
    $mk = Title("Select Course to Start");
    foreach($classDet['Courses'] as $key=>$sch){
      if(is_string($sch))$sch = ["Title"=>$sch];
      if(isset($sch["Link"]) && trim($sch["Link"]) != ""){
        $mk .= LinkButton($sch['Title'],$sch['Link'],"width:50%;float:left") ;
      }else{
        //$mk .= Button($sch['Title'],"Elearn.Load('LevelPage','".$key."')") ;
        $mk .= Button($sch['Title'],"Elearn.Load('LessonPage','".$key."_1')","width:50%;float:left") ;
      }
      /* if($key == "2_5_1"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/00252") ;
      }else if($key == "2_5_2"){
        $mk .= LinkButton($sch,"https://schoolgate.ng/index.php/courses/view/75089") ;
      }else{
        $mk .= Button($sch,"Elearn.Load('LessonPage','".$key."_1')") ;
      } */
      
    }
    $mk .= '<div style="clear:both"></div>';
    }else{
      $headtitle = "E-Learning";
      $mk = Title("Hoops!!!, E-learning Server not Available at the moment.<br/>Try Again Later");
    }
    
    exit(json_encode([$headtitle,$mk]));
    //$mk .= Button($sch,"Elearn.Load('LessonPage',[".$key.",1])") ;
  }



  function LessonPage($Data){
    global $lessons;
    $datas = $lessons;
    $dd = explode("_",$Data);
    $lesson = array_pop($dd);
    $Data = implode("_",$dd);
    if(isset($datas[$Data]) && isset($datas[$Data][$lesson])){
      $classDet = $datas[$Data][$lesson];
    $nlesson = (int)$lesson + 1;
    $headtitle = $classDet["Title"]."/".count($datas[$Data]);
    $mk = Title($classDet['Details']);
    if(isset($classDet["Video"]) && trim($classDet["Video"]) != ""){
      $mk .= Video($classDet["Video"]);
    }

    if(isset($classDet["Link"]) && trim($classDet["Link"]) != ""){
      $mk .= LinkButton('Play Now',$classDet['Link']) ;
    }

    $mk .= Title("Available Downloads","animate-delay-2");
    $mk .= Button("PDF","","width:50%;float:left","mbri-file") ;
    $mk .= Button("AUDIO","","width:50%;float:left","mbri-music") ;
    $mk .= '<div style="clear:both"></div>';
    $mk .= Title("Assignment","animate-delay-2");
    $mk .= Button("Download","","width:50%;float:left","mbri-down") ;
    $mk .= Button("Upload","","width:50%;float:left","mbri-up") ;
    $mk .= '<div style="clear:both"></div>';
    $mk .= LinkButton("References","https://www.aksu.edu.ng");
    if(isset($datas[$Data][$nlesson])){
      //$mk .= Button("Next Lesson","Elearn.Load('LessonPage','".$Data."_".$nlesson."')") ;
    }else{
      $mk .= Button("Back to Home","var aa= _('HomePage');aa.parentElement.insertBefore(aa, aa.parentElement.childNodes[0])") ;
    }
    }else{
      $headtitle = "E-Learning";
      $mk = Title("Hoops!!!, E-learning Server not Available at the moment.<br/>Try Again Later");
    }
    
    
    /* foreach($classDet['Subject'] as $key=>$sch){
      $mk .= Button($sch,"Elearn.Load('LessonPage',['".$key."',1])") ;
    } */
    exit(json_encode([$headtitle,$mk]));
  }



  extract($_POST);
 // exit(json_encode($_POST));
if(isset($PageID)){
  $ids = explode("_",$PageID);
  $PageID = count($ids) > 1?$ids[0]:$PageID;
  $Data = !isset($Data)?"":$Data;
  call_user_func($PageID,$Data);
}




?>