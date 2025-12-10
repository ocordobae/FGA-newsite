<?php
################################################################################
# CONSUMERS CONFIGURATION
# last Update: 19 Nov 2007
#
if (!defined('FGAsite')) exit; // security key

define('CHARSET', 'UTF-8');
define('CONTYPE', "<meta http-equiv='Content-Type' content='text/html; charset=".CHARSET."'>\n");
if (!defined('NO_CHARSET_ON_HEADER')) header('Content-type: text/html; charset='.CHARSET);

/* ----------------------------- LANGUAGE ------------------------------------------ */
$_LGarray = array("EN","FR","ES"); // languages availables
$_SESSION['lang'] = 'EN'; // (3)
if ((isset($_COOKIE['FGAlang']))&&($_COOKIE['FGAlang']!='')){ $_SESSION['lang']= $_COOKIE['FGAlang']; } // (2)
if ((isset($_GET['lang']))&&(in_array(strtoupper($_GET['lang']),$_LGarray))){
    $_SESSION['lang'] = strtoupper($_GET['lang']); //(1)
    setcookie('FGAlang','',time() - 3600,'/',$_SERVER['HTTP_HOST']); // delete
    setcookie('FGAlang',strtoupper($_GET['lang']),60 * 60 * 24 * 60 + time(),'/',$_SERVER['HTTP_HOST']); // create a new one
}
if(!defined("LANG_EN")){define ("LANG_EN"      , "config.php?lang=EN");}
if(!defined("LANG_FR")){define ("LANG_FR"      , "config.php?lang=FR"); }
if(!defined("LANG_ES")){define ("LANG_ES"      , "config.php?lang=ES");}
if(!defined("LANG_DE")){define ("LANG_DE"      , "#");}
/* ---------------------------------------------------------------------------------- */

define('SINGLE'    ,0);
define('DISPLAY'   ,1);
define('BABY'      ,2);
define('ASSORTMENT',3);
define('SETUP'     ,4);

/* ---------------------------------------------------------------------------*/
$url = "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
define('URL_BASE',substr($url,0,strrpos($url,'/')+1));
define('URL_ROOT',substr($url,0,strrpos(URL_BASE,'/',-2)+1));
/* ---------------------------------------------------------------------------*/
$locale = array(  // locale language
    'EN'=>'en_US',
    'FR'=>'fr_FR',
    'ES'=>'es_ES',
    'DE'=>'de_DE');
$_USERTYPES = array(
    '1' => 'Consumers'    ,
    '2' => 'Retailers'    ,
    '3' => 'Distributors' ,
    '4' => 'Sales Reps'   ,
    '5' => 'Toys International',
    '31'=> 'Internal'     ,
    '10'=> 'Consumers2013');
/* use the DB data on departments */
$_DEPTS = array(
    '0'=>'no box',
    '1'=>'it-web graphics',
    '2'=>'manufacture',
    '3'=>'marketing - sales',
    '4'=>'inventory',
    '5'=>'customers related');

/* ---------------------------------------------------------------------------*/
################################################################################
# MAIN # MAIN # MAIN # MAIN # MAIN # MAIN # MAIN # MAIN # MAIN # MAIN ##########
################################################################################
if (("65.61.44.146"              ==$_SERVER['HTTP_HOST'])||
    ("65.61.40.8"              ==$_SERVER['HTTP_HOST'])||
    ("www.familygamesamerica.com"==$_SERVER['HTTP_HOST'])||
    ("familygamesamerica.com"    ==$_SERVER['HTTP_HOST'])){
    $flag            = true;
    $_DBINFO['user'] = 'eljefe';
    $_DBINFO['pswd'] = 'rS,Mx;k[~8v;r_';
    $_DBINFO['host'] = 'localhost:3306'; // old= localhost
    $_DBINFO['dbnm'] = 'familyga_mesamis';
    //$_DBINFO['serv'] = 'javascript:alert(\"no DB assigned, call Oliver C.! \")';
    //-------------------------------------
    $_OTROS['lightver']= '1'; // enable light version of site
    $_OTROS['wide']    = '1'; // enable wide screen
    $_OTROS['sitemap'] = '0'; // enable the sitemap
    $_OTROS['stats']   = '0'; // enable the statistics
    $_OTROS['sts_name']= '1'; // enable a code to update name of products and categories in "purchase" page
    $_OTROS['ltxt']  = "";
    $_OTROS['targ_db'] = 'MDBA';
    $_OTROS['targ_tx'] = 'MTXT';
    $_OTROS['targ_hm'] = 'MSITE';
    $_OTROS['reqmail'] = 'web@familygamesamerica.com'; // retail request mail receiver
    $_OTROS['frmmail'] = 'web@familygamesamerica.com';  // contact form, email client from
    $_OTROS['ctcmail'] = array( // contact form, departments mails
        'web@familygamesamerica.com',
        'web@familygamesamerica.com',
        'web@familygamesamerica.com',
        'web@familygamesamerica.com');
    $_OTROS['noindex'] = '';
    //----[PDF formats]---------------
    // use -> to diference between titleand desc
    $_OTROS['form_PDF'] = array(
        1 =>'BASIC-> name - descr - incl - awards - img',
        2 =>'FULL -> name - descr - measurements - weights',
        5 =>'##local--*FULL -> name - descr - measurements - weights SPEC SHEET',
        6 =>'AWARDS -> Name- desc - awards, award images',
    );
    $_OTROS['pdf_cat_list'] = array(
        1 =>'BASIC consumers (but no display no gigamic)',
        2 =>'BASIC retailers (display but no gigamic)',
        5 =>'WAREHOUSE (displays, POP and cotsco)',
        6 =>'FULL  retailers (no cotsco)',
        7 =>'GERMAN 2009 retailers, displays and POP ',
    );
    $root = (defined('ROOT'))?ROOT:""; // allow programs in root using mainsite libraries
    //-[resources]--------------------------------
    $_PATHINFO['style' ]   = "<link rel='stylesheet' type='text/css' href='css/style.css'>";
    $_PATHINFO['jquery']   = "<script type='text/javascript' src='script/jquery-2.0.3.min.js'></script>";
    $_PATHINFO['jqueryui'] = "<script type='text/javascript' src='script/jquery-ui-1.8.5.custom.min.js'></script>";
    $_PATHINFO['script']   = "<script type='text/javascript' src='script/script.js'></script>";
    $_PATHINFO['FGdata']   = "/FGdata/"; // where all data is saved
    $_PATHINFO['url_base']  = "https://".$_SERVER['HTTP_HOST'];
    $_PATHINFO['site']      = "../$root";
    $_PATHINFO['resources'] = $_PATHINFO['site'     ]."resources/";
    $_PATHINFO['theme_dir'] = $_PATHINFO['resources']."theme_2013/";
    //-[img_path]---------------------------------
    $_PATHINFO['flags']     = $_PATHINFO['resources']."images/flags/";
    $_PATHINFO["cat_banner"]= $_PATHINFO['resources']."categories/banner/";
    $_PATHINFO["cat_backgd"]= $_PATHINFO['resources']."categories/background/";
    $_PATHINFO["img_cat"]   = $_PATHINFO['resources']."categories/";
    $_PATHINFO["img_pro"]   = $_PATHINFO['resources']."products/";
    $_PATHINFO['css']       = $_PATHINFO['theme_dir']."css/";
    $_PATHINFO['includes']  = $_PATHINFO['theme_dir']."includes/";
    $_PATHINFO['img']       = $_PATHINFO['theme_dir']."img/";
    $_PATHINFO['img_icon']  = $_PATHINFO['theme_dir'].$_SESSION['lang']."/icons/";
    $_PATHINFO['img_btn']   = $_PATHINFO['theme_dir'].$_SESSION['lang']."/buttons/";
    $_PATHINFO['img_bttot'] = $_PATHINFO['theme_dir'].$_SESSION['lang']."/tott_buttons/";
    $_PATHINFO['banners']   = $_PATHINFO['theme_dir'].$_SESSION['lang']."/banners/";
    $_PATHINFO['pretty']    = $_PATHINFO['theme_dir'].$_SESSION['lang']."/pretty/";
    //-[adm]---------------------------------
    $_PATHINFO['admcss']  = "css/";
    $_PATHINFO['admhdr']  = "includes/header.php";
    $_PATHINFO['salrhdr'] = "includes/header_salesrep.php";
    $_PATHINFO['retshdr'] = "includes/header_retailers.php";
    $_PATHINFO['emptyhd'] = "includes/header_empty.php";
    $_PATHINFO['admfoot'] = "includes/footer.php";
    $_PATHINFO['pr_path'] = "https://".$_SERVER['HTTP_HOST']."/mainsite/resources/";
    $_PATHINFO['basepath'] = "mainsite/";
    $_PATHINFO['img_tif'] = "images/tiff/";
    $_PATHINFO['img_jpg'] = "images/jpeg/";
    $_PATHINFO['img_png'] = "images/png/";

    //####################################################################PATHFILES
    //-------------------------------------------
    define ("ROOT_PATH","https://".$_SERVER['HTTP_HOST']."/mainsite/");
    define ("RINDEX_SUBMIT","../retailers/index.php");
    define ("SINDEX_SUBMIT","../sales/index.php");
    define ("OUTPUT_FILE"  ,"../tmp/fgalog.log");  // output file log
    define ("FAVICON"      , '<link rel="shortcut icon" href="../favicon.ico">');
    define ("CONSUMERS"    , 1);
    define ("RETAILERS"    , 2);
    define ("DISTRIBUTORS" , 3);
    define ("SALESAGENTS"  , 4);
    define ("ADMIN"        , 7);
}else{
    print "<p style='font:10px Verdana'>FGA:host mismatch, check configuration file for this site. {$_SERVER['HTTP_HOST']} </p> "; exit;
}


/* choose one of those from http://bootswatch.com  */
define ("HTML_CHARMAP"   , "<link href='https://fonts.googleapis.com/css?family=Titillium+Web:300,600' rel='stylesheet' type='text/css'>");
define ("BOOTSTRAP_CSS"  , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap.min.css' rel='stylesheet' media='screen'>\n");
define ("BS_COSMO_CSS"   , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap.cosmo.min.css' rel='stylesheet' media='screen'>\n");
define ("BS_SPACE_CSS"   , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap.space.min.css' rel='stylesheet' media='screen'>\n");
define ("BS_JOURNAL_CSS" , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap.journal.min.css' rel='stylesheet' media='screen'>\n");
define ("BS_CERULEAN_CSS", "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap.cerulean.min.css' rel='stylesheet' media='screen'>\n");
define ("ELASTICSL_CSS"  , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/elastislide.css' rel='stylesheet' media='screen'>\n");
/* add this one */
define ("BS_resp_CSS"    , "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/bootstrap-responsive.min.css' rel='stylesheet' media='screen'>\n");
/* add the ui interface */
define ("BOOTST_UI_CSS", "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/jquery-ui-1.9.2.custom.css' rel='stylesheet' media='screen'>\n".
	                       "<!--[if lt IE 9]>\n".
                         "<link rel='stylesheet' type='text/css' href='{$_PATHINFO['theme_dir']}bootstrap/css/jquery.ui.1.9.2.ie.css'/>\n".
                         "<![endif]-->\n");
/* add the font awesome */
define ("FONT_AWSO_CSS", "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/font-awesome.min.css' rel='stylesheet' media='screen'>\n".
	                       "<!--[if lt IE 7]>\n".
                         "<link rel='stylesheet' type='text/css' href='{$_PATHINFO['theme_dir']}bootstrap/css/font-awesome-ie7.min.css'/>\n".
                         "<![endif]-->\n");
define("FONT_AWSOME_5",  "<link  href='{$_PATHINFO['theme_dir']}bootstrap/css/all.css' rel='stylesheet' >\n");

define ("JQUERY"        , "<script src=' https://code.jquery.com/jquery.js'></script>\n");

define ("BOOTSTRAP_JS"  , "<script src='{$_PATHINFO['theme_dir']}bootstrap/js/bootstrap.min.js'></script>\n");
define ("BOOTST_UI_JS"  , "<script src='{$_PATHINFO['theme_dir']}bootstrap/js/jquery-ui-1.9.2.custom.min.js'></script>\n");
define ("ELAST_MOD_JS"  , "<script src='{$_PATHINFO['theme_dir']}bootstrap/js/modernizr.custom.17475.js'></script>\n");
define ("ELASTICSL_JS"  , "<script src='{$_PATHINFO['theme_dir']}bootstrap/js/jquery.elastislide.js'></script>\n");



define ("WAIT_INDICATOR","<div id='indicator' style='width:80;height:16;top:0;left:0;position:absolute;font:8px Verdana,Arial;'><img src='".$_PATHINFO['img']."indicator.gif' width='16' height='16'>Loading...</div>");
define ("STYLESH"," <link rel='stylesheet' type='text/css' href='{$_PATHINFO['css']}styles.css'  charset='utf-8' /> \n");
  
define ("JSCRIPT", 
"<script type='text/javascript' src='{$_PATHINFO['jquery']}'  ></script>
 <script type='text/javascript' src='../script/script.js'></script>\n");
$bgfolder = (isset($_SESSION['bg_folder']))?$_SESSION['bg_folder']:"";
define ("ONLOAD" ,
'<script type="text/javascript" charset="utf-8">
  var patharrowimg   = "'.$bgfolder.'"; // Image SlideShow
  $(document).ready(function(){
   alert("jquery ready");
  });
	</script>');

define ("WOOPRA" ," " ); /*<script type='text/javascript' src='//static.woopra.com/js/woopra.v2.js'></script> <script type='text/javascript'> woopraTracker.track();</script> */
define ("TFOOTER",$_PATHINFO['includes']."footer.php");
define ("RFRAME" ,$_PATHINFO['includes']."right_frame.php");
define ("KEYWORD","../includes/keyword_".strtolower($_SESSION['lang']).".php");
define ("WHERE2BUY_LINK","consumers/where2buy.php");

//--tree views-------------------------------
define ("NODE_ROOT"  ,"107"); // node root
define ("LTREENODE_1","619");   // puzzles
define ("LTREENODE_2","107"); // highlighs
define ("LTREENODE_3","108"); // games
define ("LTREENODE_4","112"); // puzzles
define ("LTREENODE_5","114"); // bojeux
define ("LTREENODE_6","116"); // lagoon
define ("EXTRA_JS"   ,""); //<script type='text/javascript' src='../script/snow.js'></script>
define ("TELEPHONES" ,"");
// EXTRA_JS only for consumer/index
