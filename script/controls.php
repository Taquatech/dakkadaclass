<?php

function Button($Title="",$Action="",$style="",$icon="mbri-right"){
    return '<button class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" onclick="'.$Action.'" style="'.$style.'"><span>'.$Title.'</span><i class="'.$icon.'"></i></button>';
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

function TextBox($Id,$Title){

}
?>