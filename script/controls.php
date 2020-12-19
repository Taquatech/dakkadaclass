<?php

function Button($Title="",$Action="",$style="",$icon="mbri-right"){
    return '<button class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" onclick="'.$Action.'" style="'.$style.'"><span>'.$Title.'</span><i class="'.$icon.'"></i></button>';
}

function TextBox($Title="",$attr="",$icon="mbri-right"){
    return '<div class="nuco-tb fadeInUp animate-delay-2 animate-fill-both" '.$attr.'><i class="'.$icon.'"></i><input id="" placeholder="'.$Title.'" /></div>';
}
function Password($Title="",$attr="",$icon="mbri-right"){
    return '<div class="nuco-tb fadeInUp animate-delay-2 animate-fill-both" '.$attr.'><i class="'.$icon.'"></i><input id="" placeholder="'.$Title.'" type="password" /></div>';
}


function LinkButton($Title="",$Action="",$style="",$icon="mbri-right"){
    return '<a class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" target="_blank" href="'.$Action.'" style="'.$style.'"><span>'.$Title.'</span><i class="'.$icon.'"></i></a>';
}

function Title($Title="", $delay="animate-delay-1-5"){
    return '<div class="main-text w3-xlarge fadeInUp '.$delay.' animate-fill-both">'.$Title.'</div>';
}

function Video($Video){
   return '<video controls class="fadeInUp animate-delay-1-5 animate-fill-both">
   <source src="video/'.$Video.'" type="video/mp4">
       Your device does not support this video
</video>';
}

function Centered(){
    return '<div class="centralized">';
}
function _Centered(){
    return '</div>';
}

function Grid1($size = "m6"){
    return '<div class="w3-row-padding"><div class="w3-col '.$size.' ">';
}
function _Grid1(){
    return '</div>';
}
function Grid2($size = "m6"){
    return '<div class="w3-col '.$size.' ">';
}
function _Grid2(){
    return '</div></div>';
}

function Text($Title="", $delay="animate-delay-1-5"){
    return '<div class="main-text w3-large fadeInUp '.$delay.' animate-fill-both">'.$Title.'</div>';
}

function Radio($Title="",$Name="",$Checked="",$Action="",$style=""){
 return '<div class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" onclick="'.$Action.'" style="'.$style.'">
 <input type="radio" class="nuco-radio-input" name="'.$Name.'" '.$Checked.' /> 
 <div class="radio-circle"><div class="radio-circle-inner fadeIn animated"></div></div><span>'.$Title.'</span></div>';
}


?>