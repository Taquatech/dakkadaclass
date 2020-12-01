<?php
error_reporting(1);
$docroot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
$curfile = str_replace(array($docroot,basename(__FILE__)),"",str_replace('\\','/',__FILE__)) ;
$loadbase = basename($_SERVER['SCRIPT_FILENAME']);
$loadfile = str_replace(array($docroot,$loadbase),"",$_SERVER['SCRIPT_FILENAME']);
//form arrays
$curfilearr = explode("/",$curfile);
$loadfilearr = explode("/",$loadfile);
//remove the scriptname

$curfilearrrst = $curfilearr;
for($s=0;$s<count($curfilearrrst);$s++){
    if(trim($curfilearr[$s]) == trim($loadfilearr[$s])){
        unset($curfilearr[$s]);
        unset($loadfilearr[$s]);
    }
}

/* $curfile = implode("/",$curfilearr);
$loadfile = implode("/",$loadfilearr);
//$curfilearrtemp = $curfilearr;
echo $curfile." : ".$loadfile."<br />"; */
$bakstr = "";
if(count($loadfilearr) > 0){
   foreach($loadfilearr as $indlfile){
       if(trim($indlfile) != ""){
        $bakstr .= "../"; 
        array_unshift($curfilearr,"..");
       }
   }
    
}
$rootfromaim = "";
if(!isset($_REQUEST['aim-root'])){
    //accessing root from aim dir
    /* $rootarr = $loadfilearr;
     $g = count($loadfilearr)-1;
     $aimrootarr = $curfilearr;
     $rstarr = [];
     for($aimrt = count($aimrootarr) - 1; $aimrt >= 0; $aimrt--){
         $fld = $aimrootarr[$aimrt];
         if($fld != ".."){
            array_push($rstarr,"..");
         }else{
            array_push($rstarr,$rootarr[$g]);
            $g--;
         }
     }
     $rootfromaim = implode("/",$rstarr)."/"; */
     $rootfromaim = "./"; //from the current loading page directory (usually - index.php)
}else{
    $rootfromaim = $_REQUEST['aim-root'];
}

$AimDirl = trim(implode("/",$curfilearr));
//echo json_encode(pathinfo($_SERVER['SCRIPT_FILENAME']))."<br />".json_encode(pathinfo(__FILE__));


//$defaultpassw = "new@user";
 //AIM Server
$AimDir = !isset($AimDir)?$AimDirl:$AimDir; //if not set (meaning aim.php is not included from another file - aim is access directly from it folder - usually from ajax (aim.js))
$AimDir = trim($AimDir) == ""?"./":$AimDir."/";
//echo $AimDir . "</br>";
//echo $rootfromaim;
//echo $rootfromaim;
//exit;
 //String manipulation functions - extracted from TaquaLB phplb.php
 class StrFunctions{
	//form a javascript code
public static function Script($JavascriptCode){
$scripthead = "<script type=\"text/javascript\">";
$scriptClose = "</script>";
echo $scripthead . $JavascriptCode . $scriptClose;	
}

public function GenerateString($minlen,$maxlen,$charset = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','!','@','#','$','%','&','*','(',')','-','_','=','+','[','{',']','}','\\','|',';',':',"'",'"','<',',','>',".","?","/",' ',"^",'`')){
	//$rand = mt_rand()
	$ac = "";
	$s=1;
	$chars = mt_rand($minlen,$maxlen);
	while($s <= $chars){
	  $rand = mt_rand(0,82);
	  $ac .= $charset[$rand];
	   $s++;	
	}
	return $ac;
}
 function _($txt){$decr="";if(trim($txt) != ""){$brd = explode("~",$txt);if(count($brd) == 3){$pos = $brd[1];$enc = $brd[2];$posvals = explode(" ",$pos);for($f=0;$f<count($posvals);$f++){$curpos = (int)$posvals[$f];$char = substr($enc,$curpos,1);$decr .= $char;	}}}return $decr;}
function _d($txt){
	//return "aaa";
	$posstr = "";
	$encr = "";
	if(trim($txt) != ""){
		$totchar = strlen($txt);
		$pick = true;
		for($d=0;$d<$totchar;$d++){
			//if($pick){
				$txtpic = substr($txt,$d,1);
				//$txtpic = strlen($txtpic) == 1?$txtpic."`":$txtpic;
				//$txtpic = substr($txtpic,1,1).substr($txtpic,0,1);
				$GC = $this->GenerateString(300,500);
				$GCLen = strlen($encr)+strlen($GC);
				$encr .= $GC.$txtpic;
				$posstr .= $GCLen." ";
				
				
				//$pick = false;
			//}else{
				//$pick = true;
			//}
		}
		$posstr = trim($posstr);
		$encr = $this -> GenerateString(300,500)."~".$posstr."~".$encr;
		
		return $encr;
		}
}
function __($txt){ //encrypt
	return $this -> _d($txt);
  do{
    $encr = $this -> _d($txt);
	$dencr = $this -> _($encr) ;
  }while($dencr != $txt);
	
	return $encr;
}

//function to convert url string to array
public static function DataArray($str,$elemstr = "&",$keyItem = "=",$multiSep = ""){
	$str = trim($str);
	$rst = array();
	if($str != ""){
		$strarr = explode($elemstr,$str);
		for($a=0; $a<count($strarr) ; $a++){
			$strv = $strarr[$a];
			$stratrvallarr = explode($keyItem,$strv);
			if(count($stratrvallarr) == 2){
				$aval = urldecode($stratrvallarr[1]);
				if(trim($multiSep) != ""){
					//split keys
					$multikeys = explode($multiSep,$stratrvallarr[0]);
					if(count($multikeys) > 1){ //if  multi dimentional
                       //form the code
					   $cd = "\$rst[";
					   foreach($multikeys as $indkeys){
						   $cd .="'".$indkeys."'][";
					   }
					   $cd = rtrim($cd,"[");
					   $cd = $cd."='';\$rstpos=&".$cd.";";
					   eval($cd);
                       $rstpos = $aval;
					}else{
						$rst[trim($stratrvallarr[0])] = urldecode($stratrvallarr[1]);
					}
				}else{
					$rst[trim($stratrvallarr[0])] = urldecode($stratrvallarr[1]);
				}
				
				
			}elseif(count($stratrvallarr) == 1){
				$rst[] = urldecode($stratrvallarr[0]);
			}
			
		}
		
	}
	return $rst;
	
}

//function to convert array to url string
public static function DataString($arr,$safe=true,$recursiveKey=""){
	$str = "";
	$recursiveKey = trim($recursiveKey) != ""?$recursiveKey."_":"";
	if(is_array($arr)){
	  foreach($arr as $key => $val){
		  $key = $recursiveKey.$key; //form the new key in case of multdimentional array
		  if(is_array($val)){ //multi dimentional arrau
			   $str .= self::DataString($val,$safe,$key) ."&";
		  }else{
			if($safe){
			$str .= $key."=".rawurlencode($val)."&";
			}else{
				$str .= $key."=".$val."&";  
			}
		  }
	  }
	}
	return rtrim($str,"&");
}

//function to check if array is associate
//check associate array
public function Is_ASSOC($arr){
    return array_keys($arr) !== range(0, count($arr) - 1);
}

public function IsAssoc($arr){
    return $this->Is_ASSOC($arr);
}

//function to redirect to another page
public function Redirect($locationPath){
    header("Location: " . $locationPath);
	exit;	
 }
	
}

//Main AIM Class
class AIM extends StrFunctions{
//GLOBALS
/************************** */
//Structure Markup
public static $HtmlStruc = <<<mainhtml
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <title>Welcome</title>
    {{aim-html-requires}}
    <style>
     {{aim-body-style}}
    </style>
</head>
<body {{aim-body-attribute}}>
<div id="aim-general-loading" style="display:none">
    <div class="aim-general-loading-item" style="display:none">
    <div class="aim-general-loading-content"> </div> <a href="javascript:void(0)" class="aim-general-loading-close" style="">&times;</a></div>
</div>
    <div id="aim-body">
      {{aim-html-body}}
    </div>
   
</body>
</html>
mainhtml;


//PrintPDF Markup
public static $PrintPDFHTML = <<<printhtml
<!-- AIM PrintPDF -->
<div class="w3-container w3-text-red aim-printer-text-color" id="aim-printpdf" style="padding:0px;height:100%">
    <!-- Small Sidebar -->
    <div id="aim-printpdf-small-menu" class="w3-hide-large w3-card-4 w3-round w3-opacity w3-hover-opacity-off w3-animate-left" style="width:200px;position:absolute;z-index:2;margin-top:30px;margin-left:10px">
           <div class="w3-red aim-printer-bg-color w3-text-white w3-round" style="padding:15px" id="aim-printpdf-header">
               <!-- Close Button -->
               <div class="w3-left">
                   <button class="w3-btn w3-circle w3-border w3-text-red aim-printer-text-color  w3-hover-white w3-hover-opacity w3-white  w3-ripple aim-printer-close" style="padding:3px; width:40px;height:40px" title="Close"><i class="fa fas fa-times"></i></button>
               </div>
               <!-- Show Main Sidebar Button -->
               <div class="w3-right w3-margin-right">
                   <button id="aim-printpdf-show-sidebar" class="w3-btn w3-circle w3-border w3-text-black  w3-hover-white w3-hover-opacity w3-white  w3-ripple" style="padding:3px; width:40px;height:40px" title="Settings"><i class="fa fas fa-cogs"></i></button>
               </div>
               <!-- Download Button -->
               <div class="w3-right w3-margin-right">
                   <button class="w3-btn w3-circle w3-border w3-text-black  w3-hover-white w3-hover-opacity w3-white aim-printer-download-btn w3-ripple" style="padding:3px; width:40px;height:40px" title="Download"><i class="fa fas fa-download"></i></button>
               </div>
               <div style="clear:both"></div>
               </div>
    </div>
    <!-- Small Sidebar End-->

    <!-- Main Sidebar -->
    <div id="aim-printpdf-sidebar" class="w3-sidebar w3-card-4 w3-text-red aim-printer-text-color w3-colapse w3-hide-medium w3-hide-small" style="width:300px;height:calc(100% - 20px)">

       <!-- Main Sidebar Header-->
           <div class="w3-red aim-printer-bg-color w3-margin-bottom w3-card" style="padding:15px" id="aim-printpdf-header">
               <!-- Show Small Sidebar Button -->
               <div class="w3-left w3-margin-right">
                   <button id="aim-printpdf-show-small-menu" class="w3-btn w3-circle w3-border w3-text-black  w3-hover-white w3-hover-opacity w3-white  w3-ripple w3-hide-large" style="padding:3px; width:40px;height:40px" title="Minimize"><i class="fa fas fa-chevron-left"></i></button>
               </div>
               <!-- Close Button -->
               <div class="w3-left">
                   <button class="w3-btn w3-circle w3-border w3-text-red aim-printer-text-color  w3-hover-white w3-hover-opacity w3-white  w3-ripple aim-printer-close" style="padding:3px; width:40px;height:40px" title="Close"><i class="fa fas fa-times"></i></button>
               </div>
               <!-- Download Button -->
               <div class="w3-left w3-margin-left">
                   <button class="w3-btn w3-circle w3-border w3-text-black  w3-hover-white w3-hover-opacity w3-white aim-printer-download-btn w3-ripple" style="padding:3px; width:40px;height:40px" title="Download" ><i class="fa fas fa-download"></i></button>
               </div>

               <!-- PrintPDF Logo -->
               <div class="w3-right w3-xlarge" title="Aim PrintPDF"><i class="fa fas fa-print"></i> <span class="w3-large">PDF</span></div>
               <div style="clear:both"></div>
           </div>
       <!-- Main Sidebar Header End-->
       
       <!-- Paper and Font Size Setting Section-->
       <div class="w3-padding">
           <!-- Paper Setting-->
           <!-- Label -->
           <div class="w3-large w3-padding"><i class="fa fas fa-file-alt w3-text-red aim-printer-text-color"></i> Paper</div>

           <div class="w3-row w3-card" style="padding-left:0px;height:40px">
               <!-- Paper Type Dropdown -->
               <div class="w3-col s6 style="padding-left:0px"  title="Select Paper Type">
                   <select id="aim-printpdf-papertype" class="w3-select w3-border-none " style="font-weight:bold;height:40px">
                       {{PaperType}}
                   </select>
               </div>

               
               <div class="w3-col s6" style="padding:0px">
               
               <!-- Papersize Button (Portrait) -->
                   <button id="aim-printpdf-portrait" class="w3-red aim-printer-bg-color w3-left" style="padding:0px;width:50%;height:40px;margin:0px;border:0px" title="Paper Orientation - Portrait"><i class="fa fas fa-file-alt"></i></button>

                   <!-- Papersize Button (Landscape) -->
                   <button id="aim-printpdf-landscape" class="w3-red aim-printer-bg-color w3-left w3-opacity w3-card-4 w3-hover-greyscale" style="padding:0px;width:50%;height:40px;margin:0px;border:0px" title="Paper Orientation - Landscape"><i class="fa fas fa-file-alt" style="transform:rotate(-90deg)"></i></button>
               </div>
               
               <!--<div class="w3-quarter">
                   
               </div>-->
           </div>

           <!-- Font Size Setting -->
           <!-- Label and Font Size Indicator -->
           <div class="w3-large w3-margin-top w3-padding"><i class="fa fas fa-text-width w3-text-red aim-printer-text-color"></i> Font Size (<strong class="w3-text-red aim-printer-text-color" id="aim-printpdf-fontsize">10</strong>)</div>

           <div class="" style="padding-left:0px">
                 <!-- Font Size Slider -->
                   <div style="width: 230px; margin:auto; position:relative; height:30px;padding-top:10px" title="Drag to Set Font Size">
                       <!-- Inner Bar -->
                       <div style="width:100%; height:10px;" class="w3-red aim-printer-bg-color w3-round w3-opacity-max w3-card"></div>
                       <!-- Slider Button-->
                       <button id="aim-printpdf-fontslider" class="w3-button w3-circle w3-red aim-printer-bg-color w3-card w3-text-white w3-hover-red w3-hover-border-red" style="width:20px;height:20px;position:absolute;padding:2px;top:5px;"></button>
                   </div>
               
               <div style="clear:both"></div>
           </div>
       </div>
       <!-- Paper and Font Size Setting Section End-->

       <hr style="margin:10px 0px">

       <!-- Margin Settings Section -->
       <div class="w3-padding">
       <div class="w3-large w3-padding"><i class="fa fas fa-outdent w3-text-red aim-printer-text-color"></i> Margin</div>
       <div class=" w3-display-container" id="aim-printpdf-margin-box" style="height:250px;width:250px">
           <!-- Top Margin -->
         <div class="w3-display-topmiddle w3-center" style="width: 40px; height:40px;"><strong class="w3-text-red aim-printer-text-color" id="aim-printpdf-marginvalue-top">4</strong></div>
          <!-- Top Margin Line -->
          <hr id="aim-printpdf-marginline-top" style="border-style:dashed !important; position:absolute;top:30px;cursor:ns-resize;width:100%; height:4px; margin:0px" class="w3-border-red w3-border-none w3-hover-border-grey" title="Drag to Set Margin Top" />
         
          <!-- Left Margin -->
         <div class="w3-display-left  w3-center" style="width: 40px; height:40px;"><strong style="position:absolute" class="w3-display-left w3-text-red aim-printer-text-color" id="aim-printpdf-marginvalue-left">4</strong></div>
         <!-- Left Margin Line -->
         <hr id="aim-printpdf-marginline-left" style="border-left-style:dashed !important; position:absolute;left:30px;cursor:ew-resize;height:100%; width:4px; margin:0px; border:1px" class="w3-border-red w3-hover-border-grey" title="Drag to Set Margin Left" />

         <!-- Right Margin -->
         <div class="w3-display-right w3-center" style="width: 40px; height:40px;"><strong style="position:absolute" class="w3-display-right w3-text-red aim-printer-text-color" id="aim-printpdf-marginvalue-right">4</strong></div>
         <!-- Right Margin Line -->
         <hr id="aim-printpdf-marginline-right"  style="border-left-style:dashed !important; position:absolute;left:220px;cursor:ew-resize;height:100%; width:4px; margin:0px; border:1px" class="w3-border-red w3-hover-border-grey" title="Drag to Set Margin Right" />

         <!-- Bottom Margin -->
         <div class="w3-display-bottommiddle w3-center" style="width: 40px; height:40px;"><strong class="w3-text-red aim-printer-text-color w3-display-bottommiddle" style="position:absolute;" id="aim-printpdf-marginvalue-bottom">4</strong></div>
         <!-- Bottom Margin Line -->
         <hr id="aim-printpdf-marginline-bottom" style="border-style:dashed !important; position:absolute;top:220px;cursor:ns-resize;width:100%; height:4px; margin:0px" class="w3-border-red w3-border-none w3-hover-border-grey" title="Drag to Set Margin Bottom" />

        </div>
       </div>
       <!-- Margin Settings Section End -->
    </div>
    <!-- Main Sidebar End -->

    <!-- Main Printer Container -->
    <div class="w3-main w3-light-grey" style="margin-left:300px;height:calc(100% - 20px)">
        <div class="w3-display-container" id="aim-printpdf-container" style="height:100%" >
        <div class="w3-display-middle" id="aim-printpdf-loading" style="width:50px;height:50px;opacity:0" >
          <div class="w3-display-container" style="width:100%;height:100%" >
            <div id="aim-printpdf-loading1" class="w3-circle w3-red aim-printer-bg-color w3-display-topleft" style="width:10px;height:10px;position:absolute;"> </div>
            <div id="aim-printpdf-loading2" class="w3-circle w3-red aim-printer-bg-color w3-display-topmiddle" style="width:10px;height:10px;position:absolute;"> </div>
            <div id="aim-printpdf-loading3" class="w3-circle w3-red aim-printer-bg-color w3-display-topright" style="width:10px;height:10px;position:absolute;"> </div>
          </div>
        </div>
        <iframe id="aim-printpdf-iframe" src="" style="width:100%;height:100%;border:0px"  ></iframe>
        
        </div>
        <div style="clear:both"></div>
        <iframe id="aim-printpdf-iframedl" style="display:none" src="" ></iframe>
    </div>
    <!-- Main Printer Container Ends-->

    <!-- Footer-->
    <div class="w3-red aim-printer-bg-color w3-small" id="aim-printpdf-footer" style="position:absolute;bottom:0px;height:20px;z-index:3;width:100%">
    <div class="w3-left w3-margin-left w3-hide-small w3-hide-medium"> <span><i class="fa fas fa-file-pdf-o"></i></span><span id="aim-footer-papertype">A4</span><span id="aim-footer-orientation">Portrait</span><span>Font: <span id="aim-footer-fontsize">10</span>pt</span> <span>Margin: T <span id="aim-footer-margintop">4</span>pt, R <span id="aim-footer-marginright">4</span>pt, B <span id="aim-footer-marginbottom">4</span>pt, L <span id="aim-footer-marginleft">4</span>pt</span> </div>
       <div class="w3-right w3-margin-right w3-rigth-align">  <span id="aim-printpdf-footer-status">Course Registration Form</span><span id="aim-printer-version">Aim PrintPDF V2</span> <span><i class="fa fas fa-print"></i></span> </div>
    </div>
</div>
<!-- AIM PrintPDF End-->
printhtml;
//PrintPDF Markup ENDS

//The AIM #Config objects (#Main Array)
//Aim #groupname
private static $ConfigGroup = ["aim-connection", "aim-alias", "aim-printer","aim-directory","aim-mailer"];
//Internal Aim #config data (#aim.conf)
private static $Config = [] ;
//Aim #reference to #root #dir
public static $RootRef = "../";
//Startup page #reference to #root #dir from index page (will be use to replace the protocol (root://) in any markup to be displayed in the index page)
private static $StartRootRef = "";
//#Database #connection #Object
public $Connection = NULL;
//#Log
public $Log = array();
//#Aliases #lookup array
private static $Alias = [];
//#Aliases #fallback array
private static $UseAlias = []; //hold used aliases, incase the alias is needed back, NB: [realdata => Alias,...], i.e alias can be derived back using the realdata as key.
//Hold the #database
private static $UseDatabase = "aim_db";
//Hold the #connection #type (#auto | #manual)
private static $ConnectionType = "manual";
//Hold the #Widget Markups
private static $Widgets = "";
//Hold the #UI Data
private static $UIData = [];

//GLOBALS #End
//************************************* */

//AIM #Errors #logs
//************************************** */
private $Errors = array(
  "CF01"=>"AIM Config File Not Found",
  "CN01"=>"AIM Database connection failed",
  "CN02"=>"AIM Database creation failed",
  "DF01"=>"AIM Database Table auto-creation failed",
  "DF02"=>"Invalid Dataset",
  "DF03"=>"Empty Record Set",
  "DF04"=>"AIM found an Invalid Datafield(Placeholder)",
  "DF05"=>"AIM Column creation failed",
  "DF06"=>"AIM Data fetching faild",
  "CB01"=>"Invalid AIM Page filename",
  "CB02"=>"AIM Page Not Found",
  "UD01"=>"UI Data not found",
  "AA01"=>"Unknown Error"
);
##Errors
//************************************** */
//AIM #Errors #logs #End


//AIM #CONSTRUCTOR
/********************************* */
function __construct(){
    global $AimDir;
    global $rootfromaim;
    $rootfromaim = !isset($rootfromaim) || $rootfromaim == ""?"./":$rootfromaim;
    //seach for the aim.config in root folder
    $configs = $this->DirectorySearch('/aim\.conf$/',$rootfromaim);
    
    $configurl = $AimDir.'aim.conf';
    //$configurl = "ggg";
        foreach($configs as $configurls){
            $configurl = $configurls->getPathname();
           //$cseen = true;
            break;
        }
        //$this->Error(["Code"=>"CF01","Line"=>__LINE__,"Message"=>$configurl]); 
    //#load the #aim.conf file
    $confstr = file_get_contents($configurl);
    //$AimDir = "";
   //exit(htmlentities($confstr));
    if(trim($confstr) == "")$this->Error(["Code"=>"CF01","Line"=>__LINE__,"Message"=>$configurl]);
    //get individual #config file
    foreach(self::$ConfigGroup as $GrpName){
        $userSet = $this->ConfigLookup($GrpName,$confstr);
        if($userSet !== false){
          self::$Config[$GrpName] = $userSet;
        }
    }
    //determine the aim #reference to aim #ref #root (#protocol)
    if(trim($rootfromaim) != "")self::$RootRef = $rootfromaim;
    
    if(isset(self::$Config["aim-directory"]) && isset(self::$Config["aim-directory"]["aim-root-dir"])){
         $aimDir = trim(strtolower(self::$Config["aim-directory"]["aim-root-dir"]));
         $startDir = trim(strtolower(self::$Config["aim-directory"]["aim-startup-dir"]));
         $portocol = isset(self::$Config["aim-directory"]["aim-protocol"])?trim(strtolower(self::$Config["aim-directory"]["aim-protocol"])):"root://";
        /*  $aimDir = ltrim($aimDir,$portocol);
         $startDir = ltrim($startDir,$portocol);
         //from the reference based on the aim ref root (protocol), if not loading from index page
         if($portocol == "root://"){
            
            $rootref = "";$rootrefStart = "";
            //exit($aimDir);
            //form aim directory path
            foreach(explode($aimDir,"/") as $indDir){
                if(trim($indDir) != "")$rootref .= "../Breilla/";
            }
            //form startup directory path
            foreach(explode($startDir,"/") as $indSDir){
                if(trim($indSDir) != "")$rootrefStart .= "";
            }
            if(trim($rootref) != "")self::$RootRef = $AimDir.$rootref;
           //self::$RootRef = $startDir;

            if(trim($rootrefStart) != "")self::$StartRootRef = $rootrefStart;
         } */
         //self::$RootRef = $rootfromaim;
         //exit(self::$RootRef);
         
    }
    //exit(self::$RootRef);
    //#connect to #database
    //check if database connection settings exist
    if(isset(self::$Config["aim-connection"]) && isset(self::$Config["aim-connection"]['host']) && isset(self::$Config["aim-connection"]['user'])){
        extract(self::$Config["aim-connection"]);
        self::$UseDatabase = isset($database) && trim($database) != ""?$database:self::$UseDatabase;
        
        self::$ConnectionType = $type;
        if(trim($type) == "auto"){//if #auto #database #type is set
            $con = new mysqli($host, $user, $password);
            if($con->connect_errno > 0){
                $this->Error(["Code"=>"CN01","Line"=>__LINE__,"Message"=>$con->connect_error]);
            }else{
                $this->Connection = $con;
                //check if #database #exist and #create it
                $dbcreate = $this->Query("CREATE DATABASE IF NOT EXISTS ".self::$UseDatabase.";");
                if(!is_array($dbcreate)){
                    $this->Error(["Code"=>"CN02","Line"=>__LINE__]);
                }else{
                    //#select the #database
                    $con->select_db(self::$UseDatabase);
                }
            }
        }else{//if #manaul #database #type set
            $con = new mysqli($host, $user, $password,self::$UseDatabase);
            if($con->connect_errno > 0){
                $this->Error(["Code"=>"CN01","Line"=>__LINE__]);
            }else{
                $this->Connection = $con;
            }
        }
        
        
    }

    //form the #aliases #lookup #AliasTranspose
    $this->AliasTranspose();
   
    //get the user set widgets
    $this->Widget();
    //get all user data
    $this->UIData(self::$Config["aim-directory"]["aim-ui-data"]);
    //$this->Error(["Code"=>"CN01","Line"=>__LINE__,"Message"=>self::$Widgets]);
}
//AIM CONSTRUCTOR #ENDS
/****************************** */

//#INTERNAL METHODS
/*********************************** */
//#ConfigLookup
//get a group setting from aim #config string
//returns the object (containing the user sttings)
private function ConfigLookup($groupName,$confStr){
 if(!isset($groupName) || trim($groupName) == "" || !isset($confStr) || trim($confStr) == "")return false;
  //look for the #groupname
  $pos = strpos($confStr,"<".$groupName);
  if($pos < 0)return false;
  
  //get the ending tag
  $lpos = strpos($confStr,"/>",$pos);

  //get the internal set data
  $startpos = $pos + strlen("<".$groupName) + 1;
  $datalen = $lpos < 0?false:$lpos - $startpos;
  $internalData = trim($datalen === false?substr($confStr,$startpos): substr($confStr,$startpos,$datalen ));
  if($internalData == "")return false;

  //convert to object and return it
  return json_decode("{".$internalData."}",true);
}

//Function to #clean #url from aim (#protocol)
private function UrlPrep($url){
    $portocol = isset(self::$Config["aim-directory"]["aim-protocol"])?trim(strtolower(self::$Config["aim-directory"]["aim-protocol"])):"root://";
    //$this->Error(["Code"=>"CF01","Line"=>__LINE__,"Message"=>str_replace($portocol,self::$RootRef,$url)]);
   // return self::$RootRef.ltrim(strtolower(trim($url)),$portocol);
   return str_replace($portocol,self::$RootRef,$url);
}

//Function to #clean #url in markup to be loaded in the index page (#protocol)
// Not use for now because it will also change aim object url
private function UrlPrepStart($url){
    $portocol = isset(self::$Config["aim-directory"]["aim-protocol"])?trim(strtolower(self::$Config["aim-directory"]["aim-protocol"])):"root://";
   // return self::$RootRef.ltrim(strtolower(trim($url)),$portocol);
   return str_replace($portocol,self::$RootRef,$url);
}

//#AliasTranspose
//function to #transpose the #aliases and form alias #lookup array
private function AliasTranspose(){
    //aim-alias
    if(isset(self::$Config["aim-alias"]) && count(self::$Config["aim-alias"]) > 0){
        //loop through all user specified aliases
        foreach(self::$Config["aim-alias"] as $item => $alias){
            if(is_array($alias)){ //if item has multiple aliases
               //loop throgh item aliases and register it in AliasLookup array
               foreach($alias as $al){
                   self::$Alias[$al] = $item;
               }
            }else{
                self::$Alias[$alias] = $item;
            }
        }
    }
}

//#Widgets
//function to #Load all widget
private function Widget(){
     //get the user defined widgets
     $widgets = $this->DirectorySearch('/\.aiw$/',self::$RootRef);
     foreach($widgets as $widget){
        if(!file_exists($widget)){
            $this->Error(["Code"=>"CB02","Line"=>__LINE__,"Message"=>$param['Src'],"Abort"=>false]);
        }
      
        
        //Get the file Content
        $filcont = file_get_contents($widget);
        
        
       
        if($filcont){ //if file exist
            self::$Widgets .= $filcont;
        }
      //read the markup (proccess Code behind if set)
          //$rtn = $this->ReadFile(json_encode(array("Src"=>trim($widget))));
          //self::$Widgets .= trim($rtn["Markup"]);
        // $markup .= $rtn["Markup"];
     }
}

//#Data (Json)
//function to #ui data (json)
private function UIData($uidataname = ["main.json","theme.json"]){
    $uidataname = (is_string($uidataname) && trim($uidataname) == "") || (is_array($uidataname) && count($uidataname) == 0)?["main.json","theme.json"]:$uidataname;
    $uidataname = is_string($uidataname)?[$uidataname]:$uidataname;
    //get the user defined widgets
    $jsons = $this->DirectorySearch('/\.json$/',self::$RootRef);
    foreach($jsons as $json){
        
//break filename down
$drd = pathinfo($json);
$bn = strtolower($drd['basename']);
//$this->Error(["Code"=>"UD01","Line"=>__LINE__,"Message"=>$uidataname,"Abort"=>false]);
if(!in_array($bn,$uidataname,false))continue;
       if(!file_exists($json)){
           $this->Error(["Code"=>"UD01","Line"=>__LINE__,"Message"=>$param['Src'],"Abort"=>false]);
       }
     
       
       //Get the file Content
       $jsobcont = file_get_contents($json);
       
       
      
       if($jsobcont){ //if file exist
          //decode the json
          $jdecode = json_decode($jsobcont,true);
          if(!is_null($jdecode)){
            
          }
           self::$UIData = array_merge(self::$UIData,$jdecode);
       }
     //read the markup (proccess Code behind if set)
         //$rtn = $this->ReadFile(json_encode(array("Src"=>trim($widget))));
         //self::$Widgets .= trim($rtn["Markup"]);
       // $markup .= $rtn["Markup"];
    }
}

//#RealData
//function to check for and get real item incase alias is used
private function RealData($alias){
    return isset(self::$Alias[$alias])?self::$Alias[$alias]:$alias;
}

//#Prepare
//function to convert parameter sent (datastring, json string, object ) to array
 //resolve param send to all EduportaEngine Methods
 private function Prepare($param = array()){
    //check if array type sent
    if(is_array($param)){
        return $param;
    }else if(is_string($param) && strlen(trim($param)) > 0){ //if string
      $fchar = substr(trim($param),0,1);
      $lchar = substr(trim($param),strlen(trim($param)) - 1,1);
      if(($fchar == "{" && $lchar == "}") || ($fchar == "[" && $lchar == "]")){ //possibly a json string
         $jsonarr = json_decode(trim($param),true);
         return $jsonarr?$jsonarr:$this->DataArray($param);
      }else{
          return $this->DataArray($param);
      }
    }else if(is_object($param)){
        //convert to array
        return json_decode(json_encode($param),true);
    }else{
        return array();
    }
   //return is_array($param)?$param:$this->DataArray($param);
}

//#Error
//Retuen an error back to js call
//public function Error($ErrorCode, $line = __LINE__, $usertxt = "",$abort=true){
public function Error($ErrorParam){
    $ErrorParam['Code'] = !isset($ErrorParam['Code']) ||  trim($ErrorParam['Code']) == ""?"AA01":$ErrorParam['Code'];
    $msg = isset($this->Errors[$ErrorParam['Code']])?$this->Errors[$ErrorParam['Code']]:"";
    $ErrorParam['Message'] = !isset($ErrorParam['Message']) ||  trim($ErrorParam['Message']) == ""?$msg:$msg."[".$ErrorParam['Message']."]";
    $ErrorParam['Line'] = !isset($ErrorParam['Line'])?__LINE__:$ErrorParam['Line'];
    $ErrorParam['Abort'] = !isset($ErrorParam['Abort'])?true:$ErrorParam['Abort'];
    $err = array("Error"=>$ErrorParam);
   exit(json_encode($err));
}

//Return result back to js call
public function Push($Result){
   exit(json_encode($Result));
}

//INTERNAL METHODS ENDS
/*********************************** */

//DATABASE METHODS
//*************************************** */
   //function to escape string for database #sqlsafe
  public function SqlSafe($str){
    if(!is_null($this->Connection)){
     $str = mysqli_real_escape_string($this->Connection,$str);
    }else{
     $str = addslashes($str);
    }
    return $str;
   }
   public function Safe($str){
       return $this->SqlSafe($str);
   }

 //#Insert into database
  public function Insert($tb,$fields){
    if(is_null($this->Connection)) return false;
    $sql = "INSERT INTO ". $tb ." SET ";
    foreach($fields as $key => $val){
        if(is_string($val) || empty($val)){
            $val = "'" . $this->SqlSafe($val) . "'";
        }else if(is_null($val)){

            $val =  'NULL' ; 
        }else if(!is_numeric($val)){
           $val = "'" . $this->SqlSafe($val) . "'"; 
        }
            $sql .= "`".$key."`" . "=" . $val . ", ";
    }
    $sql = trim($sql,', ');
   
    //echo $sql; 
      /* "JokeText='$joketext', " .
       "JokeDate=CURDATE()";*/
    if ($this->Connection->query($sql)) {
    return true;
    } else {
    return $this->Connection->error." : ".$sql; 
    }
  }

  //#InsertID - #Insert into database and return the auto increment (generated) number #ID
  public function InsertID($tb,$fieldVal){
	$rst = $this->Insert($tb,$fieldVal);
	if($rst === true){
		return $this->Connection->insert_id;
	}else{
		return false;
	}
  }

  public function InsertID2($tb,$fieldVal){
	$rst = $this->Insert($tb,$fieldVal);
	if($rst === true){
		return $this->Connection->insert_id;
	}else{
		return $rst;
	}
  }

  //Run #Query
  public function Query($query){
    if(is_null($this->Connection)) return false;
    $type = "";
    $rst = $this->Connection->query($query);
    $query = trim($query);
    $comd = substr($query,0,6);
    if(strtolower($comd) != "select"){
        $type == "dd";
    }
    if($rst){
        if($type == ""){
           return array($rst,$rst->num_rows);  
        }else{
           return array($rst,$this->Connection->affected_rows);
            //return array($rst, $query);
        }
      
    }else{
       return $this->Connection->error; 
    }
  }

  //#Select from #Database
 public function Select($tbs,$fields="",$cond=""){
    if(is_null($this->Connection)) return false;
    if(isset($tbs)){
        $query = "SELECT ";
        //process fileds
        $filds = "";
        if(is_array($fields)){// fileds are morthen 1
            foreach($fields as $f){
               $filds .= $f . ", "; 
            }
            $filds = trim($filds, ", ");
        }elseif(is_string($fields) && $fields != ""){
            $filds = $fields;
        }else{
            $filds = "*";
        }
        $query .= $filds . " FROM ";
        
        
        //process tables
        $tbstr = "";
        if(is_array($tbs)){// fileds are morthen 1
            foreach($tbs as $t){
               $tbstr .= $t . ", "; 
            }
            $tbstr = trim($tbstr, ", ");
        }else{
            $tbstr = $tbs;
        }
        
        $query .= $tbstr;
        
        //process conditions
        if($cond != ""){
          $query .= " WHERE " . $cond;  
        }
       return $this -> Query($query);
    }
 }

 //#SelectFirstRow
 //#Select only #first #row from #database
 //NB:limit to one in condition will optimize operation
 public function SelectFirstRow($tbs,$fields = "",$cond = "",$type=MYSQLI_BOTH){
     $queryRst = $this->Select($tbs,$fields,$cond);
     //if query successful
     if(is_array($queryRst)){
        if($queryRst[1] > 0){
          return $queryRst[0]->fetch_array($type);  
        }else{
          return NULL;  
        }
    }else{
        return $queryRst;
    }
 }

 //#SelectRows
 //#Select all rows and return array
 public function SelectRows($tbs,$fields = "",$cond = "",$sqltype = MYSQLI_ASSOC){
    $queryRst = $this->Select($tbs,$fields,$cond);
   //if query successful
   if(is_array($queryRst)){
    if($queryRst[1] > 0){
      return $queryRst[0]->fetch_all($sqltype);  
    }else{
      return [];  
    }
}else{
    return $queryRst;
}

 }

 //#Update in #database
 public function Update($tb,$fieldsValeus,$cond=""){
    if(isset($tb) && isset($fieldsValeus)){
        $qy = "UPDATE {$tb} SET ";
        if(is_array($fieldsValeus)){
            foreach($fieldsValeus as $field => $value){
                $sep = (is_string($value)  || (empty($value) && !is_null($value)) )?"'":"";
                $value = is_null($value)?'NULL':$this->SqlSafe($value) ;
               $qy .= $field ." = ". $sep . $value . $sep . ", "; 
            }
            $qy = trim($qy,", ");
            if($cond != ""){
               $qy .= " WHERE ". $cond ; 
            }
            //echo $qy;
            return $rst = $this -> Query($qy);
        }
        
        
    }
 }

 //#Delete from #database
 public function Delete($tb,$cond){
    return $this->Query("DELETE FROM $tb WHERE $cond");
 }

 //#TableExist
 //#Check if a #table #exist
 private function TableExist($tbname){
    $rst = $this->Query("SELECT * 
    FROM information_schema.tables
    WHERE table_schema = '".self::$UseDatabase."' 
        AND table_name = '$tbname'
    LIMIT 1;");
    return is_array($rst) && $rst[1] > 0?true:false;
 }

 //#ColumnExist
 //#Check if a #column #exist in a table
 private function ColumnExist($columnName,$tbname){
    $rst = $this->Query("SELECT * 
FROM information_schema.COLUMNS 
WHERE 
    TABLE_SCHEMA = '".self::$UseDatabase."' 
AND TABLE_NAME = '$tbname' 
AND COLUMN_NAME = '$columnName'");
    return is_array($rst) && $rst[1] > 0?true:false;
 }



//DATABASE METHODS #ENDS
//*************************************** */

//#MAIN #METHODS
//************************************** */
//aim mailer 
public function Mail($param){
    if(isset(self::$Config['aim-mailer']) && isset(self::$Config['aim-mailer']['aim-mailer-engine'])){
        $engineurl = $this->UrlPrep(self::$Config['aim-mailer']['aim-mailer-engine']);
       
        try {
            require $engineurl;
           // date_default_timezone_set('Etc/UTC');
//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

if((!isset($param['Username']) && !isset(self::$Config['aim-mailer']['aim-mailer-username'])) || (!isset($param['Password']) && !isset(self::$Config['aim-mailer']['aim-mailer-password']))){
    return "Aim Mailer SMTP authentication credentials(username and password) not set";
}
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = !isset($param['Username'])?self::$Config['aim-mailer']['aim-mailer-username']:$param['Username'];

//Password to use for SMTP authentication
$mail->Password = !isset($param['Password'])?self::$Config['aim-mailer']['aim-mailer-password']:$param['Password'];

$from = isset($param['From'])?$param['From']:$mail->Username;
$defaultfromname = "";
if(isset(self::$Config['aim-mailer']['aim-mailer-sender']))$defaultfromname = self::$Config['aim-mailer']['aim-mailer-sender'];
$fromn = isset($param['FromName'])?$param['FromName']:$defaultfromname;
//Set who the message is to be sent from
$mail->setFrom($from, $fromn);
//Set an alternative reply-to address
//$mail->addReplyTo('taquatech@gmail.com', 'First Last');

$to = isset($param['To'])?$param['To']:'';
$ton = isset($param['ToName'])?$param['ToName']:"";
//Set who the message is to be sent to
$mail->addAddress($to, $ton);

$subj = isset($param['Subject'])?$param['Subject']:'Message';
//Set the subject line
$mail->Subject = $subj;

$msg = isset($param['Message'])?$param['Message']:'Message from Aim';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($msg);

//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    return "Mailer Error: " . $mail->ErrorInfo;
} else {
    return true;
}

        } catch (Exception $e) {
            return 'Caught exception: '.  $e->getMessage(). "\n";
        }
    }else{
        return 'Mailer engine not set';
    }
}
   
  //send the #PrintPDF #Markup to client
  public function PrintPDF(){
    $printerColor = 'red';
      if(isset(self::$Config['aim-printer']) && self::$Config['aim-printer']['aim-printer-color']){
      $printerColor =  self::$Config['aim-printer']['aim-printer-color'];
      }
      //get all setup paper types
      $printerPaperType =  self::$Config['aim-printer']['aim-printer-paper-size'];
      $options = "";
      foreach($printerPaperType as $key => $val){
       $options .= '<option value="'.$key.'">'.$key.'</option>';
      }

     // echo self::$Config['aim-printer']['aim-printer-paper-size'];
      
      //$rtn = array("Markup"=>str_replace("-red","-".$printerColor,str_replace("{{PaperType}}",$options,self::$PrintPDFHTML)));
      //echo "hshdh}";
     // echo json_encode($rtn);
     return str_replace("-red","-".$printerColor,str_replace("{{PaperType}}",$options,self::$PrintPDFHTML));
     //self::$PrintPDFHTML;
  }

  //send the #Alert #Markup to client during startup
  public function Alert(){
    //if(isset(self::$Config['aim-default']) && self::$Config['aim-default']['aim-alert']){
       // $root = "";
        //form the array param that ReadFile recieves
      // $param = array("Src"=>self::$Config['aim-default']['aim-alert']);
      $rtn = null;
      $markup = "";
      //return self::$RootRef;
       //get the user defined alerts
       $useralerts = $this->DirectorySearch('/\.aia$/',self::$RootRef);
       //return json_encode($useralerts);
       foreach($useralerts as $ualert){
        //$markup  .=  $ualert . " : ";continue;
        //read the markup (proccess Code behind if set)
            $rtn = $this->ReadFile(json_encode(array("Src"=>trim($ualert))));
            $pathi = pathinfo($ualert);$fn=explode(".",$pathi['basename']);
            $pageName = trim($rtn['PageName']) != ""?$rtn['PageName']:$fn[0];
            $markup .= trim($rtn["Markup"]) != ""?'<input type="hidden" id="aim-alert-ind-'.$pageName.'" class="aim-alert-ind" />'.str_replace(array("{{aim-alert-title}}","{{aim-alert-body}}"),array('<input type="hidden" class="aim-alert-title" />','<input type="hidden" class="aim-alert-body" />'),$rtn["Markup"]):"";
          // $markup .= $rtn["Markup"];
       }
       //read the markup (proccess Code behind if set)
      // $rtn = $this->ReadFile(json_encode($param));
      // return self::$Config['aim-default']['aim-popup'];
       //Set the indicator element
       //$rtn["Markup"] = trim($rtn["Markup"]) != ""?'<input type="hidden" id="aim-alert-ind" />'.str_replace(array("{{aim-alert-title}}","{{aim-alert-body}}"),array('<input type="hidden" id="aim-alert-title" />','<input type="hidden" id="aim-alert-body" />'),$rtn["Markup"]):"";
       //return the markup
       return $markup;
    //}
  }

  //#InitMarkup
  //get all markup
  public function InitMarkup($root = ""){
      //load user set widgets
     
      $ppdf = $this->PrintPDF();
      $popu = $this->Alert();
   
      $arr = array("Markup"=>$popu.$ppdf);
      echo json_encode($arr);
  }

  //#Start Aim
  public function Start($homeurl = ""){
      global $AimDir;
     if(trim($homeurl) == ""){ //if no home url set
        $homese = $this->DirectorySearch('/home\.aim$|index\.aim$/',self::$RootRef);
        foreach($homese as $homeurls){
            $homeurl = $homeurls->getPathname();
            break;
        }
        /*if(isset(self::$Config['aim-default']) && self::$Config['aim-default']['aim-home']){
           $homeurl = self::$Config['aim-default']['aim-home'];
        }*/
     }

     //get the html struc
     $htmlst = self::$HtmlStruc;
     //if requires is loaded
     $manualre = '';
     //if(isset(self::$Config['aim-default']['aim-requires'])){
         $compress = isset(self::$Config['aim-directory']['aim-compress'])?self::$Config['aim-directory']['aim-compress']:false;
         $ignore = isset(self::$Config['aim-directory']['aim-ignore'])?self::$Config['aim-directory']['aim-ignore']:[];
         $ignore = is_array($ignore)?$ignore:[$ignore];
         $ignore[] = "root://Aim/";
         //$requ = self::$Config['aim-default']['aim-requires'];
         //Get all user defined css and javascript (in the root directory, including the aim dir if seen)
         //************************************************************************************ */
         $requ = $this->DirectorySearch('/\.css$|\.js$/',self::$RootRef);
         
             $aimseen = false;
             $aimjs = [];
             // sort them by name
         uasort($requ, create_function('$a,$b', 'return strnatcasecmp($a->getPathname(), $b->getPathname());'));
            // sort($requ);
             foreach($requ as $req){
               $reqformat = str_replace('\\','/',trim($this->UrlPrep($req->getPathname())));
               $toignore = false;
               if(count($ignore) > 0){
                   foreach($ignore as $urlignore){
                      $urlignore = str_replace('\\','/',trim($this->UrlPrep($urlignore)));
                      if(strtolower(substr($reqformat,0,strlen($urlignore))) == strtolower($urlignore)){
                          $toignore = true;
                          break;
                      }
                   }
                  
               }
               if($toignore){
                   continue;
               }
               
                
               //$requhtml .= '<meta name="keyword" content="'.$ignore.'">';
               $pinf = pathinfo($reqformat);
               if($pinf['extension'] == "css"){
                   //read the css and insert it internal
                   $cssfile = $this->ReadFile(array("Src"=>$reqformat));
                   //$encoded = base64_encode($cssfile['Markup']);
                   $requhtml .= '<style>'.$cssfile['Markup'].'</style>';
               // $requhtml .= '<link rel="stylesheet" href="data:text/css;base64,'.$encoded.'">';
               }else{
                   $patharr = pathinfo($reqformat);
                   $bname = $patharr['basename'];
                   $aimjs[$bname] = $reqformat;
                   if(($bname == "aim.min.js"  && $compress) || ($bname == "aim.js" && !$compress) || ($bname != "aim.min.js" && $bname != "aim.js")){
                    if($bname =="aim.min.js" || $bname == "aim.js"){
                        $manualre = ' aim-require="manual"';
                        $aimseen = true;
                        }else{
                          $manualre =  '';
                        }
                      $requhtml .= '<script src="'.$reqformat.'" '.$manualre.'></script>';
                   }
                  
               }
             }
              //************************************************************************************ */
             if(!$aimseen){ //if no aim js set
                //check if exist in the supplied aim directory
                //Get aim.js javascript (in the Aim directory)
         //************************************************************************************ */
         $requ = $this->DirectorySearch('/aim\.js$|aim\.min\.js$/',$AimDir);
         uasort($requ, create_function('$a,$b', 'return strnatcasecmp($a->getPathname(), $b->getPathname());'));
            // sort($requ);
             foreach($requ as $req){
               $reqformat = str_replace('\\','/',trim($this->UrlPrep($req->getPathname())));
               $patharr = pathinfo($reqformat);
                   $bname = $patharr['basename'];
                   $aimjs[$bname] = $reqformat;
                   if(($bname == "aim.min.js"  && $compress) || ($bname == "aim.js" && !$compress)){
                    //if($bname =="aim.min.js" || $bname == "aim.js"){
                        $manualre = ' aim-require="manual"';
                        $aimseen = true;
                        /* }else{
                          $manualre =  '';
                        } */
                      $requhtml .= '<script src="'.$reqformat.'" '.$manualre.'></script>';
                      break;
                   }

             }

         /************************************************************************* */

         if(!$aimseen){
              //check if exist in base array
              foreach(['aim.min.js','aim.js'] as $aimjsf){
                  if(isset($aimjs[$aimjsf])){
                    $requhtml .= '<script src="'.$aimjs[$aimjsf].'" aim-require="manual"></script>';
                    break;   
                  }
              }
            }
             }
        // }
         
    // }
     //load the requires
     //$aimdir = (isset(self::$Config['aim-directory']) && isset(self::$Config['aim-directory']['aim-root-dir']) && trim(self::$Config['aim-directory']['aim-root-dir']) != "")?self::$Config['aim-directory']['aim-root-dir']:"root://Aim/";
     //$requhtml = '<script src="'.$this->UrlPrep($aimdir).'aim.min.js" '.$manualre.'></script>'.$requhtml;
    //echo self::$RootRef;
     $htmlst = str_replace("{{aim-html-requires}}",$requhtml,$htmlst);
     //get the main page
     $homemarkup = "";
     if(trim($homeurl) == ""){
      $homemarkup = "<h1>Aim cannot locate the  Home file </h1>".self::$RootRef;
     }else{
        //read the file
        $rfile = $this->ReadFile(array("Src"=>$homeurl));
        $homemarkup = $rfile["Markup"];
        $winClass = $rfile["WindowClass"];
        $winStyle = $rfile["WindowStyle"];
        $htmlst = str_replace(array("{{aim-body-attribute}}","{{aim-body-style}}"),array($winClass,$winStyle),$htmlst);
     }
     $htmlst = str_replace("{{aim-html-body}}",$homemarkup,$htmlst);
     //print_r($rfile);
     //exit();
     exit($htmlst);
  }

  //#GeneratePDF
  //#process and #generate the #PDF printout of the html page
 public function GeneratePDF(){
  //$Param - JSON String of parameters from aim.js
  //decode to an object
  if(isset($_GET['aim-printer-settings']) && trim($_GET['aim-printer-settings']) != ""){
      
      //echo $_GET['aim-printer-settings'];
      $paramobj = json_decode($_GET['aim-printer-settings'],true);
      if(isset(self::$Config['aim-printer']) && isset(self::$Config['aim-printer']['aim-printer-pdf-engine'])){
      $aimpdfengine = $this->UrlPrep(self::$Config['aim-printer']['aim-printer-pdf-engine']);
      $psize = self::$Config['aim-printer']['aim-printer-paper-size'][$paramobj['PaperType']];
      //exit($aimpdfengine);
      //$paramobj['Data']['Root'] = $_GET['aim-root'];
      //check if the aim printer pdf engine exist aim-printer-pdf-engine
      if(file_exists($aimpdfengine)){
          //include the mpdf7 autoload.php
          require_once $aimpdfengine;
          $mpdf = new \Mpdf\Mpdf(["format"=>$psize,"orientation"=>$paramobj['Orientation'],"default_font_size"=>$paramobj['FontSize'],"margin_left"=>$paramobj['MarginLeft'],"margin_right"=>$paramobj['MarginRight'],"margin_top"=>$paramobj['MarginTop'],"margin_bottom"=>$paramobj['MarginBottom']]);

          $txt = $paramobj['WaterMark'];
          if(isset($txt) && $txt != ""){
              $txtrs = $this->UrlPrep($txt);
              if(file_exists($txtrs)){
                $mpdf->SetWatermarkImage($txtrs,0.1,50,"F");
                $mpdf->showWatermarkImage = true;
              }else{
                $mpdf->SetWatermarkText($txt,0.1);
                $mpdf->showWatermarkText = true;  
              }
            
           // $this->mpdf->SetWatermarkText()
           /* $this->mpdf->SetWatermarkImage($src,$op,$size,$pos);
    $this->mpdf->showWatermarkImage = true; */
            }

          if(trim($paramobj['Src']) != ""){
              //get the protocol incase set for the first only (for multiple page)
            //check if from root - root://
            $fromroot = false;
            if(strtolower(substr(trim($paramobj['Src']),0,7)) == "root://")$fromroot = true;
            $multisrc = explode(";",$paramobj['Src']);
            
            $rptmarkup = "";
            $cnt = 0;
            $totalpage = count($multisrc);
            
           // exit($paramobj['Src']);
            foreach($multisrc as $src){
                if(trim($src) == "")continue;
                //check if aim file
                $srcarr = explode(".",$src);
                if(count($srcarr) < 2){
                    $rptmarkup .= "INVALID FILE ($src)";
                    continue;
                }
                if(strtolower(substr(trim($src),0,7)) != "root://" && $fromroot == true)$src = "root://".$src; 
$nopdf = false;
  if(strtolower($srcarr[count($srcarr) - 1]) == "aim"){
//page-break-after: always
            $markup = $this->ReadFile(array("Src"=>$src,"Data"=>$paramobj['Data']));
  }else{
    $src = $this->UrlPrep($src);
      //redirect to the file to allow browser to handle the display
      if($totalpage == 1){
        $this->Redirect($src); 
      }
     
      if(strtolower($srcarr[count($srcarr) - 1]) == "jpg" || strtolower($srcarr[count($srcarr) - 1]) == "jpeg" || strtolower($srcarr[count($srcarr) - 1]) == "png" || strtolower($srcarr[count($srcarr) - 1]) == "gif"){ //if image file
        $markup['Markup'] = '<img src="'.$src.'" style="max-width:100%;height:auto;border:none"/>';
      }else{
          
          $markup['Markup'] = '<iframe src="'.$src.'" style="width:100%;height:100vh;border:none;"></iframe>';
          $nopdf = true;
      }
      
      //$this->Redirect($this->UrlPrep($src));
  }

                
                
                if($cnt == 0){
                    $rptmarkup .= $markup['Markup'];
                    
                }else{
                    $rptmarkup .= '<div style="page-break-after: always"></div>'.$markup['Markup'];
                }
                $cnt++;
            }
            
            $html = "";
            if($rptmarkup != ""){
             $html = '<html><head><title>'.$paramobj['Title'].'</title></head><body>'.$rptmarkup.'</body><html>';
               
            }else{
                $html = json_encode($markup);
                
            }
          //$mpdf->WriteHTML($html); 
          }else{
              $oridis = $paramobj->Orientation == "P"?"Portrait":"Landscape (".$paramobj['Orientation'].')';
              $printerPaperType =  self::$Config['aim-printer']['aim-printer-paper-size'];
              $options = "<ul>";
              foreach($printerPaperType as $key => $val){
                
               $options .= '<li>'.$key.' ('.implode("mm x ",$val).'mm)</li>';
              }
              $options .= "</ul>";
              $html = '<html><head><title>AIM PDF PRINTER</title></head><body><h1>AIM V'.$_GET['aim-version'].' PDF Printer</h1>
              <h2>Settings</h2>
              <table border="1" style="border-colapse:colapse">
                <tbody>
                <tr><th colspan="2">Print Settings</th></tr>
                  <tr><td>Paper Fomat</td><td>'.$paramobj['PaperType'].' ('.implode("mm x ",$psize).'mm)</td></tr>
                  <tr><td>Orientation</td><td>'.$oridis.'</td></tr>
                  <tr><td>Font Size</td><td>'.$paramobj['FontSize'].'pt</td></tr>
                  <tr><td>Margin Top</td><td>'.$paramobj['MarginTop'].'mm</td></tr>
                  <tr><td>Margin Right</td><td>'.$paramobj['MarginRight'].'mm</td></tr>
                  <tr><td>Margin Bottom</td><td>'.$paramobj['MarginBottom'].'mm</td></tr>
                  <tr><td>Margin Left</td><td>'.$paramobj['MarginLeft'].'mm</td></tr>
                  <tr><th colspan="2">Config Settings</th></tr>
                  <tr><td>Mpdf</td><td>'.self::$Config['aim-printer']['aim-printer-pdf-engine'].'</td></tr>
                  <tr><td>Color Scheme</td><td>'.self::$Config['aim-printer']['aim-printer-color'].'</td></tr>
                  <tr><td>Paper Formats</td><td>'.$options.'</td></tr>
                </tbody>
              </table></body></html>';
              //<tr><td></td><td></td></tr>
              
          }
         // exit($html);
          if($nopdf == true){
              echo $html;
          }else{
             $mpdf->WriteHTML($html);
          //return $html;
          if(isset($_GET['aim-printer-download']) && (int)$_GET['aim-printer-download'] == 1){
            $mpdf->Output(str_replace(" ","_",$paramobj->Title).".pdf",\Mpdf\Output\Destination::DOWNLOAD);
          }else{
              //exit($html);
            $mpdf->Output(); 
          } 
          }
          
          
          /*require_once ;
          $mpdf=new mPDF('c'); 
          
          $mpdf->WriteHTML(file_get_contents($this->UrlPrep($paramobj->Src)));
         // $mpdf->WriteHTML($request);
          $mpdf->Output();*/
          //echo file_get_contents(str_replace("Aim/","",$paramobj->Src));
      }else{ //if mpdf file not exixt
        //Load HTML (redirect to the src)
      }
    }else{ //if no printer setting
        //Load HTML (redirect to the src)
    }
      
  }
 }


//#Fill
//Method to proccess #aim-datafill object server operation (#select from #database and return data as required)
 public function Fill(){
   $param = $_POST['aim-param'];
   if(trim($param) != ""){
       $paramobj = json_decode($param,true);
      //$paramobj = $param;
       $KnwnField = array_unique($paramobj['DataName']);
       if($paramobj['Src'] != ""){ //Src for Aim CBS
        
        $rst = $this->ReadFile($param);
        //$rst = $this->ReadFile(json_encode($param));
       // $this->Return(array("Markup"=>$rst["Markup"],"Popup"=>$rst[1],"PopupTitle"=>$rst[2],"PageTitle"=>$rst[3]));
       $this->Push($rst);
       }

       

      // if(count($KnwnField) == 0)$KnwnField[] = "ID"
       if($paramobj['DataSet'] != ""){
          $tb = $this->RealData($paramobj['DataSet']);//table name
        $cond = trim($this->RealData($paramobj['DataCond']));
          //check existence of the tablename
          if(!$this->TableExist($tb)){
              if(self::$ConnectionType == "manual")$this->Error(["Code"=>"DF02"]);
              //create the table
              $sql = "CREATE TABLE $tb (";
              $seenID = false; //indicate if user set a field named ID
              $seenautoIn = "";
              //form filed name arrays
              $fieldDef = "";
              if(count($KnwnField) > 0){
                  $insertval = []; //hold array of intial insertvalue
                 //form the field declearations
                 foreach($KnwnField as $kfield){
                     $kfieldarr = explode("|",$kfield);
                     //fildname
                     $fieldName = trim($this->RealData($kfieldarr[0]));
                     //default value
                     $default = isset($kfieldarr[1])?$kfieldarr[1]:"";
                     //get the user set constraint
                     $Constriant = isset($kfieldarr[2])?$this->RealData($kfieldarr[2]):"LONGTEXT";
                     //check if user already name a field id
                     if(strtolower($fieldName) == "id")$seenID = true;
                    //check if user set any auto-increament filed
                    if(strpos(strtolower($Constriant),"auto_increment") !== false)$seenautoIn = $fieldName;
                     $fieldDef .= ",".$fieldName." ".$Constriant;
                     $insertval[$fieldName] = $default; //add initial value
                     
                 }
                 
              }

              //form the entire query
              if($seenautoIn == ""){
                  $seenautoIn = (!$seenID)?"ID":"AIM_ID";
                  $fieldDef = $seenautoIn." INT NOT NULL AUTO_INCREMENT".$fieldDef;
              }
              $sql .= ltrim($fieldDef,",").",PRIMARY KEY ( $seenautoIn ));";
              //run the query
              $createtb = $this->Query($sql);
              if(!is_array($createtb)){ //if not created successfully
                echo $createtb;
                 $this->Error(["Code"=>"DF01","Line"=>__LINE__]); //cannot create table error
              }

              //add initail value
              $inst = $this->Insert($tb,$insertval);
              if($inst !== true){
                $this->Error(["Code"=>"DF03","Line"=>__LINE__]); //return empty set error
              }
             //  //return empty record set error (i.e the table is empty)
            }
  
            //Table already exist
            //Try get data from the table
            //form the query fields
            $qfields = "*";
            //the fieldname only
            $fieldNameArr = [];
            if(count($KnwnField) > 0){
                $qfields = "";
                //form the field declearations
                foreach($KnwnField as $kfield){
                    $kfieldarr = explode("|",$kfield);
                    $assumeAlias = $kfieldarr[0];
                    //fildname
                    $fieldName = trim($this->RealData($kfieldarr[0]));
                    //default value
                    $default = isset($kfieldarr[1])?$kfieldarr[1]:"";
                    //get the user set constraint
                    $Constriant = isset($kfieldarr[2])?$this->RealData($kfieldarr[2]):"LONGTEXT";
                    //check if field/column not exist, add it to table
                   if(!$this->ColumnExist($fieldName,$tb)){
                     //add column to table if aim connection type is auto
                     if(self::$ConnectionType == "manual")$this->Error(["Code"=>"DF04"]);//if manual return error (invalid column found)
                     $alterq = "ALTER TABLE `$tb` ADD `$fieldName` $Constriant";
                      //run the query
                      $qrst = $this->Query($alterq);
                      if(!is_array($qrst))$this->Error(["Code"=>"DF05","Line"=>__LINE__]); //if column adding faild return error Aim column creation failed

                   }
                   $asalias = trim($assumeAlias) != trim($fieldName)?" as $assumeAlias":"";
                   $qfields .=$fieldName.$asalias.", ";
                   array_push($fieldNameArr,$assumeAlias);
                }
                $qfields = rtrim($qfields,", ");
            }
            //form query
            //process condition string
            if($cond != ""){ //if condition sent
                 $ncond = $cond;
                 /*$fpos = -1;
                 $lpos = 0;
                 while($fpos !== false){
                     $fpos = strpos($cond,"`",$lpos);
                     if($fpos !== false){ //if opening found
                        //get closing position
                        $lpos = strpos($cond,"`",$fpos+1);
                        //if close found, get the enclosed string
                        if($lpos !== false){
                            $str = substr($cond,$fpos+1,$lpos-$fpos-1);
                            $strReal = $this->RealData($str);
                            if($strReal != $str){
                                $ncond = str_replace($str,$strReal,$ncond);
                            }
                            $lpos++;
                        }else{
                            $fpos = false; 
                        }
                     }
                 }*/
                 //makesure the condition has a last space character which will serve as the last terminator character
                 $cond = $cond . " ";
                 $condlen = strlen($cond);
                 $nncond = "";
                 $lchar = "";$char="";$quotecnt =0;$fieldstart = -1;$token="";
                 $quotseen=false;$tokentype = "";//""=>fieldname, $=>limit
                 $limitstr = "";$orderstr = "";
                 for($s=0;$s<$condlen;$s++){
                     $lchar = $char;
                    $char = substr($cond, $s, 1 );
                    //$nncond .= $char;
                    //continue;
                    //if a single quoat or double quote found and not escaped;
                    if(($char == "'" || $char == '"') && $lchar != "\\"){
                        $quotecnt++;
                        $quotseen = true;
                    }else{
                        $quotseen = false;
                    }
                    //if odd number (meaning quote opened - inside a string)
                    
                    if($quotecnt % 2 > 0){
                        $nncond .= $char;
                        //do notting 
                    }else{ //not inside a string
                        if($quotseen){ //closing qouate
                            $nncond .= $char;
                            continue;
                        }
                        if($fieldstart > -1){ //if opening of fieldname already found
                           //check if  reach closing
                           if($char == "`"){ //field indicator closing found
                            //get the fieldname
                            $fieldnm = substr($cond,$fieldstart+1,$s-$fieldstart-1);
                            $nncond .= "`".$this->RealData($fieldnm)."`";
                            $fieldstart = -1;
                           }
                        }else{ //if opening indicator not found yet
                            if($char == "`"){ //field indicator opening found
                                $fieldstart = $s; //keep the opening pos
                            }else{ //if not an indicator
                                //check if it is a terminator
                                if(strpos("!%^&*()-+=[]{}|/:; <>",$char) !== false){
                                    if(trim($token) != ""){ //if token already formed
                                        //check type of token
                                         if($tokentype == "$"){//limit token
                                            //check if range limit
                                            $tokinarr = explode(",",$token);
                                            
                                            $numtokin = (int)$tokinarr[0];
                                            //if a valid limit number found
                                            if($numtokin > 0){
                                                $limitstr = " LIMIT ".$numtokin; if(isset($tokinarr[1])){
                                                    $rnge = (int)$tokinarr[1];
                                                    if($rnge > 0){
                                                        $limitstr .= ",".$rnge;
                                                    }
                                                }
                                            }
                                            $tokentype = "";
                                        }elseif($tokentype == "?"){//order by token
                                                $orderstr = " ORDER BY ".$this->RealData($token)." ASC";
                                            
                                         }else{
                                            //include it in formated condition
                                          $nncond .= $this->RealData($token).$char; 
                                         }
                                        
                                        $token = ""; //reset the token
                                    }else{ //if no token exist
                                        
                                        $nncond .= $char; 
                                    }
                                }else{//if not a terminator character
                                    //checck if it is a limit character ($)
                                    //and not currently forming token
                                    if($char == "$" && $token == ""){
                                      //set the limit indicator
                                      $tokentype = "$";
                                    }elseif($char == "?"){//if order by character
                                        if(trim($token) != ""){
                                            $orderstr = " ORDER BY ".$this->RealData($token)." DESC";
                                            $token = $tokentype = "";
                                        }else{
                                        $tokentype = "?";
                                        }
                                    }else{
                                       $token .= $char; 
                                         
                                    }
                                    
                                }
                                
                            }
                        }
                        
                    }
                 }
                 $cond = "WHERE ".$nncond.$orderstr.$limitstr;
            }
            //get fieldnames

           // $cond = trim($cond) != ""?"WHERE ".$cond:"";
            $sq = "SELECT $qfields FROM $tb $cond";
            //run the select query
            $rq = $this->Query($sq);
            
            if(is_array($rq)){
                
               if($rq[1] == 0)$this->Error(["Code"=>"DF03","Line"=>__LINE__]);
               $filltemplate = [];
                
               //loop thru each row to fill templates
               while($rw = $rq[0]->fetch_array(MYSQLI_ASSOC)){
                
                  //loop through each template and fill data
                 foreach($paramobj['Template'] as $tempobj){
                    $tempMarkup = $tempobj['Open'].$tempobj['Body'].$tempobj['Close'];
                   foreach($fieldNameArr as $fieldn){
                       
                    $tempMarkup = str_replace('{{'.$fieldn.'}}',$rw[$fieldn],$tempMarkup);
                   }
                   
                   //check if ID already exist
                   $filltemplate[$tempobj["ID"]] .= $tempMarkup;
                 }
                
               }
                //$this->Error("DF06",__LINE__,json_encode($filltemplate)); 
               //$dt = $rq[0]->fetch_all(MYSQLI_ASSOC); //get all rows
               $this->Push($filltemplate); //return back to ajax
            }else{
                $this->Error(["Code"=>"DF06","Line"=>__LINE__]); 
            }
           // echo $sq;
       }else{
        $this->Error(["Code"=>"DF02","Line"=>__LINE__]);
       }
     
   }
 }


  //#Uploader - upload file send via aim Ajax Post
  public function Uploader($path = "../aim-files/",$sfile="",$filename = ""){
    $rptfailed = $rptsuccess = [];$single=false;
   // $rptfailed[$key] = "aaa";
   foreach($_FILES as $key=>$file){
    $filename = trim($filename) == ""?$key:$filename;
       if(trim($sfile) != ""){
           if(trim($key) != trim($sfile))continue;
           $single = true;
       }
       
   //if($_FILES[$nme]){ //get passport
      $fileTmpLoc = $file["tmp_name"];
      //check if multiple file sent 
      if(is_array($fileTmpLoc)){
          foreach($fileTmpLoc as $ind=>$val){
            $file_name = $file["name"][$ind];
            $file_temp = $val;$file_dest = rtrim($path,"/\\")."/";$file_fname = $filename."_".$ind;
            $rnamarr = explode(".",$file_name);
            $file_ext = $rnamarr[count($rnamarr) - 1];
            $performu = $this->PerformUpload($file_name,$file_temp,$file_dest,$file_fname,$file_ext);
            if($performu !== true){
                $rptfailed[$key] .= $performu . ";";
            }else{
                $rptsuccess[$key] .= $file_dest . $file_fname.".".$file_ext.";";
            }
          }
          if(isset($rptfailed[$key]))rtrim($rptfailed[$key],";");
          if(isset($rptsuccess[$key]))rtrim($rptsuccess[$key],";");
      }else{
        $rnamarr = explode(".",$file["name"]);
        $file_ext = $rnamarr[count($rnamarr) - 1];
        $performu = $this->PerformUpload($file["name"],$fileTmpLoc,rtrim($path,"/\\")."/",$filename,$file_ext);
        if($performu !== true){
            $rptfailed[$key] .= $performu;
        }else{
            $rptsuccess[$key] .= rtrim($path,"/\\")."/" . $filename.".".$file_ext;
        }
      }
      
      if($single)break;
   //}
  }
  return array("Failed"=>$rptfailed,"Success"=>$rptsuccess);
}

private function PerformUpload($file_name,$file_temp,$file_dest,$file_fname,$file_ext){
    $rnam = $file_name;
      
     //return "yommy";
      if($file_temp){
          if(!file_exists($file_dest)){
              
              $mkd = mkdir($file_dest,0777,true);
              if(!$mkd){
                return "Cannot create distination Directory";
              }
          }
          //../asset/customer/passport/6411311.jpg
          if(!move_uploaded_file($file_temp, $file_dest."$file_fname.$file_ext")){ //upload file
             // exit("#Operation Aborted: Passport Upload Failed");
             return "Moving file to destination failed";
          }else{
           return true;
          }
      }
      return "Invalid File";
}
//MAIN METHODS ENDS
/**************************************** */

//UTILITY METHODS
/**************************************** */

//Function to include external php script
/* public function Include($src = ""){
if(trim($src) == "")return;
$rsrc = $this->UrlPrep($src);
include $rsrc;
} */

/* public function Require($src = ""){
    if(trim($src) == "")return;
    $rsrc = $this->UrlPrep($src);
    require $rsrc;
    }

    public function RequireOnce($src = ""){
        if(trim($src) == "")return;
        $rsrc = $this->UrlPrep($src);
        require_once $rsrc;
        }
 */
//call a script using curl
public function CallScript($url,$fields = []){
   

$fields_string = "";
if(is_array($fields)){
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
$fields_string=rtrim($fields_string, '&');
}

//return json_encode($fields);
//open connection
$ch = curl_init();
//echo $ch;
//print_r($ch);
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1));

//execute post
$rst = curl_exec($ch);
$rst = rtrim($rst,"</html>");
$rst = trim($rst);
curl_close($ch);
$etr = urldecode($rst);
//$data = UrlToArray($etr); //$etr = implode("~",$data);
//$data['BANK'] = 1;
return $etr;
}


//Function to convert mysql date time to specified format
public function DateFormat($date="",$format="d, M Y"){
   $date = trim($date) == ""?date("Y-m-d"):$date;
   $dtobj = new DateTime($date);
   return $dtobj->format($format);
}

//Function to get file names of file in a directory
public function DirectorySearch($parttern,$dir = "",$reculsive = true){
    if(!isset($parttern) || trim($parttern) == "" || $parttern == null)return [];
    $files = [];
    if($reculsive){//'/\.aim$/''\.'.$parttern.'$' 
        $all_files  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));    
    }else{
        //will return the file names only cos it is searcing nside one directory only
        $all_files  = new IteratorIterator(new DirectoryIterator($dir));
    }
    $files = new RegexIterator($all_files,$parttern); 
    return iterator_to_array($files);
}
//UTILITY METHODS END
/*************************************** */

//CDS - CODE BEHIND SYSTEM INTERNAL OPERATION METHODS
//*************************************** */

//ReadFileInsertValue
//Method to insert value in place holder
private function ReadFileInsertValue($Markup ="",$placehoder="",$value=""){
    // $Markup;
   if(trim($placehoder) == ""){
       return $Markup;
   }
   //if $value is url, resolve the protocol
  // $value = $this->UrlPrep($value);
   return str_replace('{{'.$placehoder.'}}',$value,$Markup);
}

//#ReadFileIterateRegion
//Method to get iterating region
private function ReadFileIterateRegion($Markup="",$placehoder=""){
    //get the looping string (Iterating Region)
                     $Fpos = strpos($Markup,'{{'.$placehoder.'}}');//get first ocurence
                     
                     if($Fpos !== FALSE){
                                              
                       $StartPos = $Fpos + strlen('{{'.$placehoder.'}}'); //get the loopstring startpos
                       //get the last ocurence
                       $Lpos = strpos($Markup,'{{'.$placehoder.'}}',$StartPos);
                       if($Fpos != $Lpos){ //if the ending label found
                         
                         $loopstrlen = $Lpos - $StartPos; //get the lenght of the loopstr
                        // echo $loopstrlen;
                          return substr($Markup,$StartPos,$loopstrlen); 
                          //get the loopstring
                         // echo $loopstr;
                       }else{
                           //if ending label not found take the rest string
                           return substr($Markup,$StartPos);
                       }
                     }else{
                         return NULL; //no loop region found
                     }
 }

 //#ReadFileIterateRegionName
//Method to get iterating region and the region name
private function ReadFileIterateRegionName($Markup="",$placehoder=""){
    //get the looping string (Iterating Region)
                     $Fpos = strpos($Markup,'{{'.$placehoder." ");//get first ocurence
                        $Fpos = $Fpos === false?strpos($Markup,'{{'.$placehoder."}}"):$Fpos;
                        $name = "";
                     if($Fpos !== FALSE){
                         $SeenLen = strlen('{{'.$placehoder);
                        //try to get the closing brackets
                        $FposEnd =  strpos($Markup,'}}',$Fpos + $SeenLen - 1);//get closing
                        if($FposEnd !== false){
                            //get the name
                            $nameLen = $FposEnd - ($Fpos + $SeenLen);
                            if($nameLen > 0){
                                $name = substr($Markup,$Fpos + $SeenLen,$nameLen);
                            }
                            

                           //get the last ocurence
                            $Lpos = strpos($Markup,'{{'.$placehoder.'}}',$FposEnd);
                            
                            $StartPos = $FposEnd + 2; //get the loopstring startpos
                            
                            if($Lpos !== false && $StartPos < $Lpos){ //if the ending label found
                                
                                $loopstrlen = $Lpos - $StartPos; //get the lenght of the loopstr
                                // echo $loopstrlen;
                                return array("Body"=>substr($Markup,$StartPos,$loopstrlen),"Name"=>$name); 
                                //get the loopstring
                                // echo $loopstr;
                            }else{
                                //if ending label not  found take the rest string
                                return array("Body"=>substr($Markup,$StartPos),"Name"=>$name);
                            }
                        }else{
                            return array("Body"=>"","Name"=>""); //no loop region found  
                        }
                      
                     }else{
                         return array("Body"=>"","Name"=>""); //no loop region found
                     }
 }

 

 //#ProccessDirectAddressing
 private function InsertDirectAddress($ValueArr=array(),$Markup="",$placehoder=""){
     if(is_array($ValueArr)){
        foreach($ValueArr as $Key => $Val){
                if(is_string($Val) || is_numeric($Val)){ //if replacable
                    if($placehoder != ""){
                        $Markup = str_replace('{{'.$placehoder.'->'.$Key.'}}',$Val,$Markup);
                    }
                }else if(is_array($Val)){
                    $nplacehoder = $placehoder == ""?$Key:$placehoder.'->'.$Key;
                    $Markup = $this->InsertDirectAddress($Val,$Markup,$nplacehoder);
                }
            }
     }
     
     return $Markup;
 }

 //#ReadFileProccessArrayValue
 //Method to Handle array values
 private function ReadFileProccessArrayValue($ValueArr=array(),$Markup="",$placehoder="",$ParentPlaceholder=""){//str_replace('{{'.$placehoder.'}}','',$Markup);
 if(trim($Markup) == "") return "";

if(trim($placehoder) == ""){
     //if place holder is numeric or not set
//echo $placehoder;
if(trim($ParentPlaceholder) == "" || is_numeric($ParentPlaceholder))return $Markup; //if the parent placeholder is also not set, meaning nothing to replace return back the markup
//use the parent placeholder
$placehoder = $ParentPlaceholder;
}


//process all direct addressing values
$Markup = $this->InsertDirectAddress($ValueArr,$Markup,$placehoder);

$filcont = $Markup;
//get the IterateRegion
//$IterateRegion = $this->ReadFileIterateRegion($Markup,$placehoder);
$IterateRegion = $this->ReadFileIterateRegion($filcont,$placehoder);
//echo $IterateRegion;

//if(trim($IterateRegion) == "")return str_replace('{{'.$placehoder.'}}','',$Markup); //if no iteration region
while(!is_null($IterateRegion)){
$FormedMarkup = ""; //reset the formed markup for the new place holder seen
//if no data sent for the iteration region
if((is_array($ValueArr) && count($ValueArr) < 1) || (is_object($ValueArr) && isset($ValueArr->num_row) && $ValueArr->num_row < 1) || trim($IterateRegion) == "") {
    //return str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}','',$Markup); //if no array item found clear the placeholder and the IterationRegion
    $filcont = str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}','',$filcont); //if no array item found clear the placeholder and the IterationRegion
    $IterateRegion = $this->ReadFileIterateRegion($filcont,$placehoder);
    continue;
}

//Check for Option 1
//Numeric iteration
if(is_array($ValueArr) && count($ValueArr) == 1){
if(!$this->Is_ASSOC($ValueArr) && is_numeric($ValueArr[0])){ //if no key set and the value is numeric
   for($s=1;$s<=$ValueArr[0];$s++){ //concatinate the IterateRegion in $ValueArr[0] times and also display the increament if the increament placeholder is set
      $FormedMarkup .= str_replace(array('{{$}}','{{$'.$placehoder.'}}'),$s,$IterateRegion);
   }
  // $filcont = str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}',$FormedMarkup,$Markup);
   $filcont = str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}',$FormedMarkup,$filcont);
 //return $filcont;
 $IterateRegion = $this->ReadFileIterateRegion($filcont,$placehoder);
 continue;
}

}

//Option 2 and 3
//Stop here, trying to code, if the current array is associate, loop through the values to set the replacement if value is string else resend into array proccessor, using the associate key as place holder and curent iterate region as markup.

//else if current array is not associate, loop trough each value, and set 
if((is_array($ValueArr) && !$this->Is_ASSOC($ValueArr)) || (is_object($ValueArr) && isset($ValueArr->num_rows))){ //if not associate array
//echo $placehoder. " not associate <br>";
$cnter = 1; //for increament display
if(is_array($ValueArr)){ //if an array
    foreach($ValueArr as $rval){
    if(!is_array($rval)){ //if current value is not an array replace placeholder in the iteration region markup
        $FormedMarkup .= $this->ReadFileInsertValue(str_replace(array('{{$}}','{{$'.$placehoder.'}}'),$cnter,$IterateRegion),"?",$rval);
        
    }else{
        //loop through each item and replace then in iterationRegion, before concatinating the resultant IterationRegion to FormedMarkup
        //$ValueArr=array(),$Markup="",$placehoder="",$ParentPlaceholder=""
        
        $FormedMarkup .= $this->ReadFileProccessArrayValue($rval,"{{".$placehoder."}}".str_replace(array('{{$}}','{{$'.$placehoder.'}}'),$cnter,$IterateRegion)."{{".$placehoder."}}",$placehoder);
    }
    $cnter++;
    }
}else{ //if database object
  while($rval = $ValueArr->fetch_assoc()){
    $FormedMarkup .= $this->ReadFileProccessArrayValue($rval,"{{".$placehoder."}}".str_replace(array('{{$}}','{{$'.$placehoder.'}}'),$cnter,$IterateRegion)."{{".$placehoder."}}",$placehoder);
    $cnter++;
  }
}

}else{ //if an associate array

$internalIterationRegion = $IterateRegion;
//check if the $ValueArr is array

   foreach($ValueArr as $rkey => $rval){
 
 if(is_array($rval) || is_object($rval)){//if valu not array
 //if($placehoder=="Colored"){
    // echo "$rkey=>$rval <br/>";
 //}
 
 $internalIterationRegion =   $this->ReadFileProccessArrayValue($rval,$internalIterationRegion,$rkey,$placehoder);
 }else{
   $internalIterationRegion = $this->ReadFileInsertValue($internalIterationRegion,$rkey,$rval);
 }
}


$FormedMarkup = $internalIterationRegion;
}
 
//$filcont = str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}',$FormedMarkup,$Markup);
$filcont = str_replace('{{'.$placehoder.'}}'.$IterateRegion.'{{'.$placehoder.'}}',$FormedMarkup,$filcont);
//return $filcont;
$IterateRegion = $this->ReadFileIterateRegion($filcont,$placehoder);
 continue;
}
return $filcont;
}

//************************************************

//Get the Alert Region
private function AlertRegion(&$filcont){
              //get the IterateRegion
//$popupRegionarr = $this->ReadFileIterateRegionName($filcont,"aim-alert");
$aalerttags = $this->GetGroupByName($filcont,"aim-alert",false);
if(count($aalerttags) > 0){
    //foreach($aalerttags as $alertName => $component){
        //get the last alert
        $component = end($aalerttags);
        $alertName = $component['Name'];
        $popupName = is_numeric($alertName)?"":trim($alertName);
        $popupRegion = $component['Markup'];
        //$popupName = trim($popupRegionarr['Name']);
        //$popupRegion = $this->ReadFileIterateRegion($filcont,"aim-alert");
        //$popupName = "MainAlert";
        //echo $IterateRegion;
        $poputitle = "Message";
        if(trim($popupRegion) != ""){
            $filcont  = str_replace($popupRegion,'',$filcont); //remove the alert region from the maim markup
            //get the popup title
            $alertTitlearr = $this->GetGroupByName($popupRegion,"aim-alert-title",false);
            if(count($alertTitlearr) > 0){
                $alertTitleelem = end($alertTitlearr);
                $poputitle = $alertTitleelem['Markup'];
            }
           // $poputitle = $this->ReadFileIterateRegion($popupRegion,"aim-alert-title");
            
            $popupRegion = str_replace(array($alertTitleelem['OpenTag'].$alertTitleelem['RawMarkup'].$alertTitleelem['CloseTag'],'<aim-alert-title>','</aim-alert-title>'),'',$popupRegion); //remove the title tag from the popup region
            $poputitle = trim($poputitle) == ""?"Message":$poputitle;
            //get the popup body
            $alertBody = $this->GetGroupByName($popupRegion,"aim-alert-body",false);
            if(count($alertBody) > 0){
                $alertBodyelem = end($alertBody);
                $popubody = $alertBodyelem['Markup'];
            }
            //$popubody = $this->ReadFileIterateRegion($popupRegion,"aim-alert-body");
            //set the allert body as the popupregion to return back
            $popupRegion = trim($popubody) == ""?str_replace(array('<aim-alert-body>','</aim-alert-body>'),'',$popupRegion):$popubody;
        }
        //clear any traces of the alert tags in the main markup
       // $filcont = str_replace(array('{{aim-alert'.$popupRegionarr['Name'].'}}','{{aim-alert}}'),'',$filcont); //if no iteration region
       $filcont = str_replace(array($component['OpenTag'],$component['RawMarkup'],$component['CloseTag'],'<aim-alert>','</aim-alert>'),'',$filcont);
        //it will return only one alert seen (cos it is assumed that two allert will not be needed per page return display)
        return array("Title"=>$poputitle,"Body"=>$popupRegion,"Name"=>$popupName);
    //}
}
return array("Title"=>"","Body"=>"","Name"=>"");
}

//get inner content
/*private function TagContent(&$markup,$placeholder){
    
   $contents = array();
   $startInd = 0;
   $end = false;
   $internalMarkup = "";
  while($end == false){
       //get the openeing
       $openIndex = strpos($markup,'{{'.$placeholder.'}}',$startInd);
      
       if($openIndex !== false){
           $nextind = $openIndex+ strlen($placeholder) + 4;
         $mainclose = strpos($markup,'{{'.$placeholder.'}}',$nextind);
         if($mainclose !== false){
            $internalMarkup = substr($markup,$nextind,$mainclose - $nextind);

            $startInd = $mainclose +strlen($placeholder)+4; //where to start the next search from
         }else{
            $internalMarkup = substr($markup,$nextind); //take the rest 
            $end = true;
         }
         
         $contents[] = $internalMarkup;
         
         //clear it from the markup
         $markup = str_replace('{{'.$placeholder.'}}'.$internalMarkup.'{{'.$placeholder.'}}','',$markup);
       }else{
           $end = true;
       }
   }
   return $contents;
}*/

private function TagContent(&$markup,$placeholder,$count = -1){
    $contents = array();
    //get the tag markup or content
    $rtnmks = $this->GetGroupByName($markup,$placeholder,false);
    if(count($rtnmks) >0){
        $cnt = 0;
        foreach($rtnmks as $mkdet){
            if($count > -1 && $cnt >= $count){
                break;
            }
            $cnt++;
            $contents[]  = $mkdet['Markup'];
            //remove from markup
            $markup = str_replace($mkdet['OpenTag'].$mkdet['RawMarkup'].$mkdet['CloseTag'],'',$markup);
        }
    }
return $contents;
}

//function to get the number of open tag seen withen a string
private function GetCloseTag($markup,$startpos = 0,$tagname = "aim-widget"){
    $openseen = 1; //the open tag seen is one at default, one is seen (the main open tag which the close tag is to be gotten)
    $closeseen = 0;$entagpos;$mainclose = 0;
  do{
    $entagpos = strpos($markup,'</'.$tagname.'>',$startpos);
    if($entagpos === false)break; //if no close tag found get out of the loop
    $mainclose = $entagpos; //update the close tag pos
    $closeseen++; //increament the total close seen
    //get the open tags between the last open tag and current close tag
    $alltag  = substr_count($markup,"<".$tagname,$startpos+1,$entagpos - $startpos);
    $openseen += $alltag; //add tags seen to total open tag seen
    $startpos = $entagpos + 2 + strlen($tagname); //locate and reset where the next close tag search will start from
  }while($openseen != $closeseen);

    
    /*while($openseen != $closeseen){ //while the open tag clossing not seen
       // $closeseen =  $closeseen == 0?1: $closeseen;
       // $openseen = $openseen==0?1:$openseen; //set the first open tagseen
       $closeseen++; //increament close seen, cause for every loop entarnce one close has been seen
        //get all open tag between
        $alltag  = substr_count($markup,"<".$tagname,$tagsStartPos+1,$entagpos - $tagsStartPos);
        $openseen += $alltag; //add to total open tag seen
       
        //return array($alltag,1,$mainclose);
        //set new positions
        $tagsStartPos = $entagpos;
        $entagpos = strpos($markup,'</'.$tagname.'>',$entagpos+1); //get the next close tag (incose the real closing tag is not gotten)
        if($entagpos !== false){
            $mainclose = $entagpos;
        }else{
            break;
        }
    }*/

    return $mainclose;
}

//process all widget set in the supplied markup
private function GetGroupByName($markup,$objname = "aim-widget",$closebyName = false){
    $widgetseen = array();
   $startIndex = 0;
   $end = false;
   
  while($end == false){
   //get and add section
   $openIndex = strpos($markup,"<".$objname,$startIndex);
   if($openIndex !== false){
       //get the open tag close chars
       $openCloseIndex = strpos($markup,">",$openIndex+1+strlen($objname));
       if($openCloseIndex !== false){ //if valid
              //get the section name
              $namelen = $openCloseIndex-($openIndex + (1+strlen($objname)));
              //if($namelen > 0){
                  $WidgetName = trim(substr($markup,$openIndex+1+strlen($objname),$namelen));
              //}else{
              //  $WidgetName = ""; 
             // }
              
              //get the entire opening string
              $WidgetOpening = substr($markup,$openIndex,($openCloseIndex + 1) - $openIndex);
              //look for the main closing tag
             // $closetag = $closebyName && $WidgetName != ""?'</'.$WidgetName.'>':'</'.$objname.'>';
              
              //Handle nexted tags (identify the closing tag even if same tag is nexted in it)
              if(!($closebyName && $WidgetName != "")){ //if the tag closing is the tag itself
                $closetag = '</'.$objname.'>';
               // GetCloseTag($markup,$startpos = 0,$tagname = "aim-widget")
                $mainclose = $this->GetCloseTag($markup,$openCloseIndex+1,$objname);
                //$mainclose = strpos($markup,$closetag,$openCloseIndex+1);
              }else{
                  $closetag = '</'.$WidgetName.'>';
                $mainclose = strpos($markup,$closetag,$openCloseIndex+1);
              }
              
              $internalMarkup = "";
              if($mainclose !== false){//if the main closing found
                $internalMarkup = substr($markup,$openCloseIndex+1,$mainclose - ($openCloseIndex+1));
                $startIndex = $mainclose + strlen($closetag); //where to start the next search from
              }else{
                $closetag = "";
               $internalMarkup = substr($markup,$openCloseIndex+1); //take the rest 
               $end = true;
              }
              $rtninternalMarkup = $internalMarkup;
              //check if internalMarkup is url
              $tartchar = substr(trim($internalMarkup),0,1);
              //check if start with @ symbol
              if($tartchar == "@"){
                 //get the remaining part
                 $urlstr = substr(trim($internalMarkup),1);
                 //resolve the url
                 $urlstr = $this->UrlPrep($urlstr);
                 //try to get the file
                 $filecont = file_get_contents($urlstr);
                 if($filecont){
                    $internalMarkup =  $filecont ;
                 }
              }

              $rsta = array("Name"=>$WidgetName,"Markup"=>$internalMarkup,"OpenTag"=>$WidgetOpening,"CloseTag"=>$closetag,"RawMarkup"=>$rtninternalMarkup);
              //if($WidgetName == ""){
                $widgetseen[] = $rsta;
             // }else{
               // $widgetseen[$WidgetName] = $rsta;
              //}
       }else{
           $end = true;
       }
   }else{ //if no section in markup
       $end = true;
   }
}
return $widgetseen;
}

//function to get attr/value pair in a string
private function GetAttributeValue($str){
    $attrval = array();
    $tokenkey = "";
    $tokenval = "";
    $procspecialchar = true;
    $strvalind = 'key';
    if(trim($str) == "")return [];
    //loop through all character of the string
    $strlen = strlen( $str );
    for( $i = 0; $i <= $strlen; $i++ ) {
        $char = substr( $str, $i, 1 );
        if($char == "=" && $procspecialchar){ //if equal found and special character are allowed to proccing
            $strvalind = 'value'; //set current token reading to value
        }else if($char == '"' && $procspecialchar && $strvalind == 'value'){ //if token reading is value and value open quote found and symbol processing is allowed
            $procspecialchar = false; //disable symbol processing
        }else if($char == '"' && $procspecialchar == false && $strvalind == 'value'){  //if closing value qoute, indicate value reading end
            $procspecialchar = true; //disable symbol processing
            $strvalind = 'key'; //set token reading back to key
            //set the array
            $attrval[trim($tokenkey)] = $tokenval;
            //clear all tokens
            $tokenkey = "";
            $tokenval = "";
        }else{
            
                if($char == " " && $procspecialchar)continue;
                //if forming key
                if($strvalind == 'key'){
                    $tokenkey .= $char;
                }else{
                    $tokenval .= $char;
                }
            
            
        }
        
    }
    return $attrval;
}

//function to process widget in the supplied markup
private function ProccessWidget(&$markup){
    //continue to process aim-widget in markup, until non exist
    while(strpos($markup,'<aim-widget ') !== false){
        //1. get the aim-widgets set in markup
        $Gwidgets = $this->GetGroupByName($markup,"aim-widget");
        
        foreach($Gwidgets as  $WidgetDet){
            $WidgetName = trim($WidgetDet['Name']);
            if($WidgetName == "")continue;
            //Process the name to get the atrribute value part
            $wnamePart = explode(" ",$WidgetName);
            $attrpart = [];
            if(count($wnamePart) > 1){
               $WidgetName  = array_shift($wnamePart); 
              // $attrpart = implode(" ",$wnamePart);
            }
            //populaye or user set attribut and value
            $wnamePart = implode(" ",$wnamePart);
            $attrpart = $this->GetAttributeValue($wnamePart);
            /*foreach($wnamePart as $indstr){
                if(trim($indstr) == "")continue;
                //get the key and value
                $keyval = explode("=",$indstr);
                if(count($keyval) > 1){
                    $attrpart[trim($keyval[0])] = trim($keyval[1],'"\'');
                }
            }*/

            //2. Use the name to get the widget markup in the global widget markup and 
            //2.1 Get the opning tag
            $openT = strpos(self::$Widgets,'<'.$WidgetName.'>');
            /*$dd = substr(self::$Widgets,0,6);
            if($openT === false){
              $rst['Markup'] = self::$Widgets.$rst['Markup'];
            }else{
              $rst['Markup'] = $openT.$rst['Markup'];
            }
            
              return $rst;*/
            if($openT !== false){//if exist
             //2.2 Get the clossing
             $markupstart = $openT+3+strlen($WidgetName);
              $closeT = strpos(self::$Widgets,'</'.$WidgetName.'>',$markupstart);
              //2.4 Get the set markup of the widget
              $setwidgetMarkup = "";
              if($closeT != false){ //if closing found
                  $setwidgetMarkup = substr(self::$Widgets,$markupstart,$closeT - $markupstart);
              }else{//if closing not found just take the rest
                  $setwidgetMarkup = substr(self::$Widgets,$markupstart);
              }
             
              if(trim($setwidgetMarkup) == "")continue;
              //Get the placeholders
              //3. Get the placeholder that exist in the widget markup
              $widgetPlaceholders = array();
              $end = false;$startInd = 0;
              while($end == false){
               //3.1 Get the placeholder open tag
               $popenTag = strpos($setwidgetMarkup,"{{",$startInd);
              //3.2 check if placeholder exist
              if($popenTag === false){
                  $end = true;
              }else{
              //3.3 check if escaped
               if($popenTag > 0 && substr($setwidgetMarkup,$popenTag - 1,1) == "\\"){
                  $startInd = $popenTag + 2;
                 continue;
               } 
               //3.4 Get the close tag
               $pcloseTag = strpos($setwidgetMarkup,"}}",$popenTag+2);
               //3.5 check if close tag does not exist
               if($pcloseTag === false){
                   $end = true;
               }else{
                   //3.6 check if close tag is escaped
                   while(substr($setwidgetMarkup,$pcloseTag - 1,1) == "\\"){
                      $pcloseTag = strpos($setwidgetMarkup,"}}",$pcloseTag + 2); 
                  }
                  //3.7 get the placeholder
                  $placho = substr($setwidgetMarkup,$popenTag+2,$pcloseTag - ($popenTag+2));
                  if($placho !== ""){
                      //check for default value
                      $plachoarr = explode("||",$placho);
                      if(trim($plachoarr[0]) == "?"){ //if not inner markup placeholder
                         $widgetPlaceholders["aim-inner-placeholder"] = isset($plachoarr[1])?$plachoarr[1]:NULL;
                      }else if(trim($plachoarr[0]) == "??"){ //if other attribute place holder
                        $widgetPlaceholders["aim-attr-placeholder"] = isset($plachoarr[1])?$plachoarr[1]:NULL;
                      }else{
                        $widgetPlaceholders[$plachoarr[0]] = isset($plachoarr[1])?$plachoarr[1]:NULL;  
                      }
                      
                  }
                  $startInd = $pcloseTag + 2;
               }
              

              }
               
              }//while loop to get individual placeholders
              //4. Loop through all place holder, get the value from group widget markup, form new markup by replacing the placeholder in the global widget markup
              //4.1 loop through all placeholders
               //4.2 get its value in the current widget group
               $groupWidgetMarkup = $WidgetDet['Markup'];
              $otherattr = '';
              if(count($widgetPlaceholders) > 0){
                 foreach($widgetPlaceholders as $indplaceholder=>$defaultval){
                    if($indplaceholder == "aim-inner-placeholder" || $indplaceholder == "aim-attr-placeholder")continue;
                     //4.2.1 check if exist in attrval
                     if(isset($attrpart[$indplaceholder])){
                        $plachValue = $attrpart[$indplaceholder];
                        //unset the attrpart seen
                        unset($attrpart[$indplaceholder]);
                     }else{
                     //4.3 get the current placeholder value
                     //$plachValue = $this->ReadFileIterateRegion($groupWidgetMarkup,trim($indplaceholder));
                     $plachValuearr = $this->GetGroupByName($groupWidgetMarkup,$indplaceholder,false);
                     if(count($plachValuearr) > 0){
                         foreach($plachValuearr as $plachValueInd){
                            $plachValue = $plachValueInd['Markup'];
                            //remove seen tag from the $groupWidgetMarkup
                            $groupWidgetMarkup = str_replace($plachValueInd['OpenTag'].$plachValueInd['RawMarkup'].$plachValueInd['CloseTag'],'',$groupWidgetMarkup);
                         }
                       
                     }else{
                        $plachValue = ""; 
                     }
                     
                     }
                     
                     $plachValue = trim($plachValue) == ""?is_null($defaultval)?"":$defaultval:$plachValue;
                     $pltag = is_null($defaultval)?'{{'.$indplaceholder.'}}':'{{'.$indplaceholder.'||'.$defaultval.'}}';
                     //set the widget markup value from the global widget
                     $setwidgetMarkup = str_replace($pltag,$plachValue,$setwidgetMarkup);
                     
                 }
                 
              }
               //4.12 Set the innermarkup if exist and placeholder set
              if(isset($widgetPlaceholders['aim-inner-placeholder']) || is_null($widgetPlaceholders['aim-inner-placeholder'])){
                $plachValue = trim($groupWidgetMarkup) == ""?is_null($widgetPlaceholders['aim-inner-placeholder'])?"":$widgetPlaceholders['aim-inner-placeholder']:$groupWidgetMarkup;
                 $rtag = is_null($widgetPlaceholders['aim-inner-placeholder'])?"{{?}}":"{{?||".$widgetPlaceholders['aim-inner-placeholder']."}}";
                $setwidgetMarkup = str_replace($rtag,$plachValue,$setwidgetMarkup);
               }

               //4.13 Set the remaining attribute.
               if(isset($widgetPlaceholders['aim-attr-placeholder']) || is_null($widgetPlaceholders['aim-attr-placeholder'])){
                 //loop through the remaining attribute value and form the attrvalue string
                 $remattrvalstr = '';
                    foreach($attrpart as $attr=>$attval){
                        $remattrvalstr .= $attr . '="'.$attval.'" ';
                    }
                    $plachValue = trim($remattrvalstr) == ""?is_null($widgetPlaceholders['aim-attr-placeholder'])?"":$widgetPlaceholders['aim-attr-placeholder']:$remattrvalstr;
                    $rtag = is_null($widgetPlaceholders['aim-attr-placeholder'])?"{{??}}":"{{??||".$widgetPlaceholders['aim-attr-placeholder']."}}";
                    $setwidgetMarkup = str_replace($rtag,$plachValue,$setwidgetMarkup);
               }
                 //4.2 Remove escape characters
                 $setwidgetMarkup = str_replace(array('\\{{','\\}}'),array('{{','}}'),$setwidgetMarkup);
               //5 Set the new formed markup in the group widget markup
               $markup = str_replace($WidgetDet['OpenTag'].$WidgetDet['RawMarkup'].$WidgetDet['CloseTag'],$setwidgetMarkup,$markup);

            }//if statement to check if the current widget(name) exist in global widget markup
        }//foreach loop of individual widget that exist in the markup
      }//main loop that makes sure all the widget that exist in markup are all proccessed
}

//Get all section in the script
/*private function ReadSection($markup){
   $sections = array();
   $startIndex = 0;
   $end = false;
   
  while($end == false){
   //get and add section
   $openIndex = strpos($markup,"{{aim-section",$startIndex);
   if($openIndex !== false){
       //get the open tag close chars
       $openCloseIndex = strpos($markup,"}}",$openIndex+13);
       if($openCloseIndex !== false){ //if valid
              //get the section name
              $SectionName = trim(substr($markup,$openIndex+13,$openCloseIndex-($openIndex + 13)));
              //get the entire opening string
              $SectionOpening = substr($markup,$openIndex,($openCloseIndex + 2) - $openIndex);
              //look for the main closing tag
              $mainclose = strpos($markup,"{{aim-section}}",$openCloseIndex+2);
              $internalMarkup = "";
              if($mainclose !== false){//if the main closing found
                $internalMarkup = substr($markup,$openCloseIndex+2,$mainclose - ($openCloseIndex+2));
                $startIndex = $mainclose + 15; //where to start the next search from
              }else{
                
               $internalMarkup = substr($markup,$openCloseIndex+2); //take the rest 
               $end = true;
              }
              $section[$SectionName] = array("Markup"=>$internalMarkup,"OpenTag"=>$SectionOpening);
       }else{
           $end = true;
       }
   }else{ //if no section in markup
       $end = true;
   }
}
return $section;
}*/

//insert data in markup
public function DumpData($dataarr,$filcont,$aimwinClass,$pageTitle = "",$aimstyle=""){
    arsort($dataarr); //sort data in decending order so that array value are handled first
    //Get Alert Display Region
    $popupdet = $this->AlertRegion($filcont);

    //get the tab button html if exist
    //$tabBtnHtml = $this->ReadFileIterateRegion($filcont,"aim-tab-button");
    $tabBtnHtml = "";
    $tabBtnHtmlarr = $this->GetGroupByName($filcont,"aim-tab-button");
    if(count($tabBtnHtmlarr) > 0){
        foreach($tabBtnHtmlarr as $tabBtnHtmlarrind){
        $tabBtnHtml = $tabBtnHtmlarrind['Markup'];
                $filcont = str_replace($tabBtnHtmlarrind['OpenTag'].$tabBtnHtmlarrind['RawMarkup'].$tabBtnHtmlarrind['CloseTag'],'',$filcont);
                $tabBtnHtml = '<input type="hidden" class="aim-tab-button-ind" value="tab-btn" />'.$tabBtnHtml;       
        }
        
    }
   
        
                
                if(count($dataarr) > 0){ //if dynamic content is sent
                foreach($dataarr as $key=>$val){ //loop through all the Dynamic Content and insert accordinly
                    //if($key != "Src" && $key != "DataSet"){
                        if(is_array($val) || is_object($val)){
                        //proccess the array
                        //$ValueArr=array(),$Markup="",$placehoder="",$ParentPlaceholder=""
                       
                        $filcont = $this->ReadFileProccessArrayValue($val,$filcont,$key);
                        //process the alert body content 
                        if(trim($popupdet['Body']) != ""){
                            $popupdet['Body'] = $this->ReadFileProccessArrayValue($val,$popupdet['Body'],$key);
                        }
                        //process the alert title content 
                        if(trim($popupdet['Title']) != ""){
                            $popupdet['Title'] = $this->ReadFileProccessArrayValue($val,$popupdet['Title'],$key);
                        }
                        //tab button
                        if(trim($tabBtnHtml) != ""){
                            $tabBtnHtml = $this->ReadFileProccessArrayValue($val,$tabBtnHtml,$key);
                        }

                        if(trim($aimstyle) != ""){
                            $aimstyle = $this->ReadFileProccessArrayValue($val,$aimstyle,$key);
                        }

                        
                        }else{ //if value is not an array
                            
                            $filcont = $this->ReadFileInsertValue($filcont,$key,$val);
                            if(trim($popupdet['Body']) != ""){
                                $popupdet['Body'] = $this->ReadFileInsertValue($popupdet['Body'],$key,$val);
                            }
                            if(trim($popupdet['Title']) != ""){
                                $popupdet['Title'] = $this->ReadFileInsertValue($popupdet['Title'],$key,$val);
                            }
                            //tab button
                        if(trim($tabBtnHtml) != ""){
                            $tabBtnHtml = $this->ReadFileInsertValue($tabBtnHtml,$key,$val);
                          }
                          if(trim($aimwinClass) != ""){
                            $aimwinClass = $this->ReadFileInsertValue($aimwinClass,$key,$val);
                        }

                        if(trim($aimstyle) != ""){
                            $aimstyle = $this->ReadFileInsertValue($aimstyle,$key,$val);
                        }

                        if(trim($pageTitle) != ""){
                            $pageTitle = $this->ReadFileInsertValue($pageTitle,$key,$val);
                        }
                       // $filcont = str_replace('{{'.$key.'}}',$val,$filcont);
                        }
                   // }
                }
                }
                $filcont = trim($tabBtnHtml) != ""?'<input type="hidden" class="aim-tab-content-ind" value="tab-content" />'.$filcont:$filcont;
                return array("Markup"=>$filcont,"Alert"=>$popupdet['Body'],"AlertTitle"=>$popupdet['Title'],"TabButton"=>$tabBtnHtml,"AlertName"=>$popupdet['Name'],"WindowClass"=>$aimwinClass,"PageTitle"=>$pageTitle,"WindowStyle"=>$aimstyle); //return the resultant read file
}


    //ReadFile
    //*****************************************************
    public function ReadFile($params = ""){
        global $rootfromaim;
        $param = $this->Prepare($params); //prepare arguments
        $param['Data'] = isset($param['Data'])?$param['Data']:[];
        $LocalData = self::$UIData;
        //return $param;
        
        //exit($param['Src']);
        if(!isset($param['Src'])){
            $this->Error(["Code"=>"CB01","Line"=>__LINE__]);
        }
        $directCB = false;
        //check if direct Code Behind call
        if(substr(trim($param['Src']),0,1) == "@"){
            $filcont = "<%".$param['Src']."%>";
            $directCB = true;
        }else{ 
        $param['Src'] = $this->UrlPrep($param['Src']);
       // $this->Error(["Code"=>"CF01","Line"=>__LINE__,"Message"=>self::$RootRef.$param['Src']]);
        //echo $param['Src'];
        if(!file_exists($param['Src'])){
            $this->Error(["Code"=>"CB02","Line"=>__LINE__,"Message"=>$param['Src'],"Abort"=>false]);
        }
      
        
        //Get the file Content
        $filcont = file_get_contents($param['Src']);
    }
        
       
        if($filcont){ //if file exist

            //get the file extension
            //if($directCB)
            $pathinfo = ($directCB)?["extension"=>"aim"]:pathinfo($param['Src']);
            //if an aim file
        if($pathinfo['extension'] == "aim" || $pathinfo['extension'] == "aia" || $pathinfo['extension'] == "aiw" || $pathinfo['extension'] == "css"){
            //get local data and set it
            $aaa = "";
            $aimlocaldata = $this->TagContent($filcont,"aim-local-data");
            if(count($aimlocaldata) > 0){
                foreach($aimlocaldata as $ldata){
                    $ldata = trim($ldata);
                    if($ldata != ""){
                        //check file path is specified
                        $fchar = substr($ldata,0,1);
                        if($fchar == "@"){ //if path specified
                            $ldata = substr($ldata,1);
                            $ldatafuncarr = explode(" ",$ldata);
                            $ldata = array_shift($ldatafuncarr);
                            //$ldata = $ldatafuncarr[0];
                            $funcs = "";
                            if(count($ldatafuncarr) > 0){
                                $funcs = implode(" ",$ldatafuncarr);
                            }
                            $ldata = $this->UrlPrep($ldata);
                            if(file_exists($ldata)){
                                $pinfo = pathinfo($ldata);
                                
                                if($pinfo['extension'] == 'php'){ //if file in localdata is to aim file
                                    $ldataarr = $this->ReadFile(['Src'=>'@'.$ldata. " ". $funcs]);   
                                   $ldata = $ldataarr['Data'];
                                   //$ldata = '{"txt":"'.'@'.$ldata. ' '. $funcs.'"}';
                                }else{
                                   // $ldata = '{"txt":"'.$ldata.' Get Content"}';
                                  $ldata = file_get_contents($ldata);
                                }
                                
                            }else{
                                //$ldata = '{"txt":"'.'@'.$ldata. ' '. $func.'"}';
                                continue;
                            }
                            
                        }
                        $ldobj = json_decode($ldata,true);
                        
                        if(is_array($ldobj)){
                            
                            $LocalData = array_merge($LocalData,$ldobj);
                            
                        }
                    }
                }
            }
         
            //get the cookie file (aim-localstore)
        if(isset($_COOKIE['aim-local-data']) && trim($_COOKIE['aim-local-data']) != ""){
            $localdata = json_decode($_COOKIE['aim-local-data'],true);
            //merge with data
            $LocalData = array_merge($LocalData,$localdata);
        }
        $LocalData['/'] = $rootfromaim;
        $param['Data'] = array_merge($param['Data'],$LocalData);
        $paramdupl = $param;
            $pageName = "";
            $pageTitle = "";
    $aimwinClass = "";
    //get the aim window class
    $aimwinClassarr = $this->TagContent($filcont,"aim-body-attribute");
    $aimwinStylearr = $this->TagContent($filcont,"aim-body-style");
    if(count($aimwinClassarr) > 0)$aimwinClass=$aimwinClassarr[count($aimwinClassarr) - 1]; //use the last one if multiple set
    $aimstyle = "";
    if(count($aimwinStylearr) > 0){
      foreach($aimwinStylearr as $aimstyles){
        $aimstyle .= $aimstyles;
      }
    }elseif(count($aimwinStylearr) == 1){
        $aimstyle = $aimwinStylearr[0];
    }
            
            //get the code behind for the page
            $filcont = trim($filcont);
            $funcs = array();
           
            if(substr($filcont,0,2) == "<%"){ //if code behind parameter set. 
                //NB code behind placeholder must be the first to set on every page
               $clpos = strpos($filcont,"%>",2); //check the clossing tag
               if($clpos !== false){ //if closing found
                 $cbdata = substr($filcont,2,$clpos - 2);
                
                 //get the individual codebehind properties
                 $inddata = explode(" ",trim($cbdata));
                 
                 if(count($inddata) > 0){ //if properties found
                    
                     foreach($inddata as $dt){ //loop through all properties
                         $dt = trim($dt);
                         $err = "";
                         if($dt != ""){ //if not an empty string (i.e a valid code behind header property)
                             if(substr($dt,0,1) == "@"){//if the property is the path to user engine (property that start with @)
                                // echo $this->UrlPrep(substr($dt,1));
                                //include it to the page (UrlPrep handles the aim protocol addressing)
                                //if file exixt include it
                                $scri = $this->UrlPrep(substr($dt,1));
                                if(file_exists($scri)){
                                    require_once($scri);  
                                }
                                  
                                  //require_once("engine/main.php");  
                                 
                                  
                             }elseif(substr($dt,0,1) == "#"){ //#page name
                                 $pageName = substr($dt,1);
                                 //check if dynamic code behind set
                                 //dynamic code behind is set to page name in data/localdata
                                 if(isset($param['Data'][$pageName]) && trim($param['Data'][$pageName]) != ""){
                                    $pagedet = $param['Data'][$pageName];
                                    //breakdown in to individual conponenets
                                    $pagedetarr = explode(" ",$pagedet);
                                    $codebehindseen = false;$indfuncarr = [];
                                    foreach($pagedetarr as $pageinfo){
                                        if(trim($pageinfo) == "")continue;
                                        if(substr($pageinfo,0,1) == "@"){ //if codebehind seen
                                            //if file exixt include it
                                            $scri = $this->UrlPrep(substr($pageinfo,1));
                                            if(file_exists($scri)){
                                                require_once($scri);
                                                $codebehindseen = true;  
                                            }
                                        }else{
                                            $indfuncarr[] = $pageinfo;
                                        }
                                    }
                                    if($codebehindseen){
                                        $funcs = array_merge($funcs,$indfuncarr);
                                    }
                                }
                                    
                                 
                             }else{ //others are function names
                                $funcs[] = $dt; //add the function name to function list array
                             }
                         }
                     }
                 }
                 //clear the Code Behind header details
                 $filcont = substr($filcont,$clpos+2);
               }
            }
            
           //get the sections of the markup if  exist
           $section = $this->GetGroupByName($filcont,"aim-section",false);
            
            //Run all set function, and accumulate return values in the main data array ($param['Data'])
            if(count($funcs) > 0){ //if function(s) set
              foreach($funcs as $func){//loop through all the functions in the function list
                //run the function and send user post data to it
                
                  $funcData = call_user_func($func,$paramdupl['Data']);
                  
                  if(is_array($funcData)){ //if function return data
                    //Merge return data to user send data
                      foreach($funcData as $dkey => $dval){//loop throug data from Code Behind
                        if(count($section) > 0){ //if section exist
                        //if new(dbval) is an array, merge new with sent data in other to make it avialable in a section
                       // $dval = is_array($dval)?array_merge($paramdupl['Data'],$dval):$dval;
                        }
                        
                          //check if key already exist
                          if(isset($param['Data'][$dkey])){
                              //keep the old data value 
                              $oval = $param['Data'][$dkey];
                              if(is_array($oval) && is_array($dval)){ //if existing is array and new is array, merge
                                $param['Data'][$dkey] = array_merge($oval,$dval); 
                              }elseif(is_array($oval) && !is_array($dval)){ //if existing is array and new is not array, push
                                 array_push($param['Data'][$dkey],$dval);
                              }elseif(!is_array($oval) && is_array($dval)){ //if existing is not array and new is array, push in new
                                array_push($dval,$oval);
                                $param['Data'][$dkey] = $dval;
                              }else{//if existing is not array and new is not array, use new
                                $param['Data'][$dkey] =  $dval; 
                              }
                          }else{
                            
                              //if if key not exixt, just marge to the Data array
                              //array_push()
                            //$param['Data'] = array_merge($param['Data'],array($dkey => $dval)) ;
                            $param['Data'][$dkey] = $dval;
                            //$aaa .= json_encode($param['Data']);
                          }
                      }
                      
                     // $fdata = json_encode($param['Data']);
                  }
                //$param['Data'] =  array_merge($param['Data'],call_user_func($func,$paramdupl['Data']));
                
              }
            }
            
            //Array to hold the aim use data (which will be make available in aim client(js))
             $UseData = [];
            

            //Get the sections
           // $section = $this->ReadSection($filcont);
            
            $sectionFound = false; //indicator for section data sent
            if(count($section) > 0){ //if section found
                $rfilcont = ""; //hold the resultant sections markup
                $rpopupdetBody = ""; //hold the resultant popup marup
                $rpopupdetTitle = "";//the last popup title
                $tabbtn = "";//the tab button. takes the last one in multiple section **
                $aimclass = "";$pageTi = "";
                //form the sections markups furnished with data (if data is avalable) else remove the entire section
                foreach($section as $sectionMarkup){
                    $sectionName = $sectionMarkup['Name'];
                   // print_r($param['Data']);
                    if(isset($param['Data'][$sectionName]) && is_array($param['Data'][$sectionName])){
                        
                        //if user send data to section and the data is an array (meaning contains data to fill the section)
                        //make sent data available in section (merge with section data)
                        $param['Data'][$sectionName] = array_merge($paramdupl['Data'],$param['Data'][$sectionName]);

                        $UseData = array_merge($UseData,$param['Data'][$sectionName]);
                        $sectionFound = true;
                        //check if page title exist withen section markup
                        //get page title
                        $titles = $this->TagContent($sectionMarkup['Markup'],"aim-page-title");
                        if(count($titles) > 0)$pageTitle=$titles[count($titles) - 1]; //use the last one to overide the global place holder
                        $datadumprst = $this->DumpData($param['Data'][$sectionName],$sectionMarkup['Markup'],$aimwinClass,$pageTitle,$aimstyle);
                        $rfilcont .= $datadumprst["Markup"];
                        $rpopupdetBody .= $datadumprst["Alert"];
                        $rpopupdetTitle = $datadumprst["AlertTitle"]; //the last title should be used if multiple popup title set
                        $rpopupdetName = $datadumprst["AlertName"];
                       // if($aimclass == ""){
                        $aimwinClass = $datadumprst["WindowClass"];
                        $aimwinStyle = $datadumprst["WindowStyle"];
                       // }
                        //if($pageTi == ""){
                            $pageTitle = $datadumprst["PageTitle"];
                        //}
                        if(trim($datadumprst["TabButton"]) != "")$tabbtn = $datadumprst["TabButton"];
                        /*return array("Markup"=>$sectionName,"Alert"=>$rpopupdetBody,"AlertTitle"=>$rpopupdetTitle,"PageTitle"=>$pageTitle,"TabButton"=>$tabbtn,"WindowClass"=>$aimwinClass,"PageName"=>$pageName,"AlertName"=>$rpopupdetName);*/
                    }else{ //if no data sent for the section
                        //remove the section markup from the main markup, in case section markups are not to be used
                        $filcont = str_replace($sectionMarkup['OpenTag'].$sectionMarkup['RawMarkup'].$sectionMarkup['CloseTag'],"",$filcont);
                    }
                }
            }

            /**/
           
           
            //check if secton exist
            if($sectionFound){
                //"Markup"=>$rst[0],"Popup"=>$rst[1],"PopupTitle"=>$rst[2],"PageTitle"=>$rst[3])
               $rst = array("Markup"=>$aaa.$rfilcont,"Alert"=>$rpopupdetBody,"AlertTitle"=>$rpopupdetTitle,"PageTitle"=>$pageTitle,"TabButton"=>$tabbtn,"WindowClass"=>$aimwinClass,"PageName"=>$pageTitle,"AlertName"=>$rpopupdetName,"WindowStyle"=>$aimwinStyle);
            }else{
                $UseData = $param['Data'];
                //get page title
                $titles = $this->TagContent($filcont,"aim-page-title");
                if(count($titles) > 0)$pageTitle=$titles[count($titles) - 1];
                $rst = $this->DumpData($param['Data'],$filcont,$aimwinClass,$pageTitle,$aimstyle);
               // $rst["PageTitle"]=$pageTitle;
               // $rst['WindowClass']=$aimwinClass;
                $rst['PageName']=$pageName;
                //return $rst;
            }

            //if no page title gotten check if set globally for section based markup
           /* if(trim($rst['PageTitle']) == ""){
                //get page title
            $titles = $this->TagContent($filcont,"aim-page-title");
            if(count($titles) > 0)$rst['PageTitle']=$titles[count($titles) - 1]; //use the last one if multiple set
            }*/
            
            //Process widgets in markups
            $this->ProccessWidget($rst['Markup']);
            $this->ProccessWidget($rst['Alert']);
            $this->ProccessWidget($rst['AlertTitle']);
            $this->ProccessWidget($rst['TabButton']);
            $rst['Data'] = json_encode($UseData);
            $rst['Markup']=$aaa.$rst['Markup'];

            
           return $rst;
        }else{//not aim file no processing
            return array("Markup"=>$filcont,"Alert"=>"","AlertTitle"=>"","PageTitle"=>"","TabButton"=>"","WindowClass"=>"","PageName"=>"","AlertName"=>"","UseData"=>"","WindowStyle"=>"");
        }
           
            // WriteExecutables($filcont);
           // return array($filcont,$popupdet['Body'],$popupdet['Title']); //return the resultant read file
        }
        $this->Error(["Code"=>"CB02","Line"=>__LINE__,"Message"=>$param['Filename']]);
        
    }
    //**************************************************** */


//CDS - CODE BEHIND SYSTEM INTERNAL OPERATION METHODS ENDS
//*************************************** */

public function dd(){
    return "Abayo";
}


}
//Main AIM Class Ends

 
//Start AIM Engine Class
$_ = new AIM();

if(isset($_REQUEST['aim-root']) && trim($_REQUEST['aim-root']) != ""){
    AIM::$RootRef = $_REQUEST['aim-root'];
}

//Initial Markup  loading
if(isset($_POST['aim-markup'])){
    
    //1. Printer Markup, 2.Alert Markup
    $_->InitMarkup();
    $_->Connection->close();
    exit();
}


//Generate Print Preview
if(isset($_GET['aim-printer-generate'])){
    $_->GeneratePDF();
    $_->Connection->close();
    exit();
}

//aim-datafill operations
if(isset($_POST['aim-datafill']) && (int)$_POST['aim-datafill'] == 1){
    $_->Fill();
    $_->Connection->close();
    exit();
}

function genPHPMEmail($mailto="",$from_name="NASA",$subject="Mail",$msg=""){
    if(trim($mailto) == "")return "No Destination Mail Address Supplied";
    $mailto = $mailto;
    $from_name = $from_name;
    $from_mail = "taquatech@gmail.com";
    $subject = $subject;
    $message = $msg;
    $boundary = "XYZ-" . date('dmYis') . "-ZYX";
    $header = "--$boundary\r\n";
    $header .= "Content-Transfer-Encoding: 8bits\r\n";
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n";
    $header .= "$message\r\n";
    $header .= "--$boundary\r\n";

    $header2 = "MIME-Version: 1.0\r\n";
    $header2 .= "From: ".$from_name." \r\n";
    $header2 .= "Return-Path: ".$from_mail." \r\n";
   // $header2 .= 'Cc: ubonge80@gmail.com' . "\r\n";
    $header2 .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $header2 .= "$boundary\r\n";
    $getRespons = mail($mailto,$subject,$header,$header2,"-r".$from_mail);
    if($getRespons){
        return true;
    }else{
        return "Not Sent";
    }

    

}

function SendMail($from,$to,$subject,$body){
    include('Mail.php'); // includes the PEAR Mail class, already on your server.

$username = 'admin@nasanigeria.org.ng'; // your email address
$password = 'nasanigeria@mail'; // your email address password

/* $from = "admin@nasanigeria.org.ng";
$to = "ab_keje@yahoo.com";
$subject = "Testing Mail";
$body= "Testing Mail from nasanigeria"; */

$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject,'MIME-Version' => 1,'Content-type' => 'text/html;charset=iso-8859-1'); // the email headers
$smtp = Mail::factory('smtp', array ('host' =>'localhost', 'auth' => true, 'username' => $username, 'password' => $password, 'port' => '25')); // SMTP protocol with the username and password of an existing email account in your hosting account
$mail = $smtp->send($to, $headers, $body); // sending the email

if (PEAR::isError($mail)){
return "<p>" . $mail->getMessage() . "</p>";
}
else {
return true;
// header("Location: http://www.example.com/"); // you can redirect page on successful submission.
}
}






//print_r(Uploader());


?>