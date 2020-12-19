<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKRP</title>
    <script src="Aim/aim.js" aim-jsonly="true"></script>
    <link rel="stylesheet" href="../LIB/W3CSS4/w3.css">
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../LIB/FA5/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="../LIB/mobiriseicons/24 px/mobirise/style.css" rel="stylesheet" />
    <link href="../LIB/Animate/animate.css" rel="stylesheet" />
    
    <script src="js/main.js"></script>
    
    
</head>
<body>
    <?php
  //function Page($PageID,$Back){
      echo '<div id="nuco-page-template" style="display:none"><div class="school  w3-center nuco-page" id="{{PageID}}">
      <!-- Header -->
      <div class="main-head">
          <button  id="{{BackID}}" class="icon-back fadeInDown w3-padding" onclick="Elearn.Back(this)"><i class="mbri-left w3-xlarge animate-slow animate-fill-back"></i></button>
          <div class="icon-bx fadeInDown"><i class="mbri-image-slider w3-xxxlarge animate-slow animate-fill-back"></i><!--<img class="mbri-image-slider w3-xxxlarge animate-slow animate-fill-back" src="images/logo.png" alt="AKS Logo" style="width:50px">--></div>
          <div class="cont-bx">
              <div class=" smallLineHeight w3-xlarge animate-fill-back animate-delay-0-5 fadeInUp"><img class="mbri-image-slider w3-xxxlarge animate-slow animate-fill-back" src="images/logo2.png" alt="AKS Logo" style="width:50px"></div>
              <div class="fadeInUp animate-fill-back animate-delay-1 nuco-title"><div class="loading fadeInUp animate-slow animate-delay-1 animate-fill-both"><i class="mbri-setting3 fa fa-spin"></i></div></div>
          </div>
          <div class="clear"></div>
      </div>
      <!-- Body -->
    <div class="nuco-body  w3-padding-large">
    <div class="loading fadeInUp animate-slow animate-delay-1 animate-fill-both"><i class="mbri-setting3 fa fa-spin"></i></div>
      
    </div>
     
  </div></div>';
  //}

?>
    <div class="w3-display-container nuco-container" id="nuco-main-cont">
      <div class="home w3-display-middle w3-center nuco-page" id="HomePage">
        <div class="w3-jumbo fadeInDown animate-slow animate-fill-back smallLineHeight"><!-- <i class="mbri-image-slider"></i> -->
        <img src="images/logo.png" alt="AKS Logo" style="width:180px"> <br/>
        <img src="images/logo2.png" alt="AKRP" style="width:180px">
        </div>
        <!-- <div class="w3-xlarge w3-opacity fadeInDown animate-slow animate-fill-back">Welcome</div> -->
        <div class="w3-xxlarge nuco-name animate-fill-both fadeInDown animate-slow animate-delay-0-5">Computer Based Testing</div>
        <div class="w3-large nuco-elearn w3-opacity-min fadeInUp animate-delay-1-5 animate-fill-back">&nbsp;</div>
        <button class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" onclick="Elearn.Load('SchoolPage')"><span>Start Now</span><i class="mbri-right"></i></button>
    </div> 
    
   

    

    

    <!-- Video Page -->
    <!-- <div class="school  w3-center w3-hide" id="LearnPage">
       
        <div class="main-head">
            <button class="icon-back fadeInDown w3-padding" onclick="Elearn.SubjectFrom('LearnPage')"><i class="mbri-left w3-xlarge animate-slow animate-fill-back"></i></button>
            <div class="icon-bx fadeInDown"><i class="mbri-image-slider w3-xxxlarge animate-slow animate-fill-back"></i></div>
            <div class="cont-bx">
                <div class=" smallLineHeight w3-xlarge animate-fill-back animate-delay-0-5 fadeInUp">NUCO SCHOOLS</div>
                <div class="fadeInUp animate-fill-back animate-delay-1">Primary 1  - Mathematics</div>
            </div>
            <div class="clear"></div>
        </div>

       
      <div class="  w3-padding-large">
        
        <div class="main-text w3-xlarge fadeInUp animate-delay-1-5 animate-fill-both">Play Video to Start Learning</div>
        <video controls class="fadeInUp animate-delay-1-5 animate-fill-both">
            <source src="video/1.mp4" type="video/mp4">
                Your device does not support this video
        </video>
        <button class="nuco-btn fadeInUp animate-delay-2 animate-fill-both" onclick="Elearn.HomeFrom('LearnPage')"><span>Back to Home</span><i class="mbri-home"></i></button>
        
        </div>
    </div> -->




    </div>
    
</body>
</html>