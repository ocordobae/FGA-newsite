<?php

    $iphone  = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
    $android = strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS');
    $berry   = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry');
    $ipod    = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod');
    define('MOBILE',($iphone || $android || $palmpre || $ipod || $berry == true));

    //--------- remove the "Page Has Expired" Warnings--------
    Header("Cache-Control: max-age=3000, must-revalidate");
    //--------------------------------------------------------
    session_start();  ## load basic parameter, session and ###
    define('FGAsite', true); ##             access control ###
    //include_once('../admin/conf.php'); ##    global config ###
    include_once('conf.php');###             folder config ###
    //--------------------------------------------------------
    global $_PATHINFO, $_OTROS; // load the sys values ------
    //-------------------------------------------------------
    $lang     = (isset($_SESSION['lang']))?$_SESSION['lang']:'EN';
    //if(empty(trim($lang))) { echo "Lang require to continue !"; exit; }
    //--------------------------------------------------------
    require_once("../lib/common.php");
    //-------------------------------------------------------
    $search  = (isset($_REQUEST['search']))?$_REQUEST['search']:'';
    $node    = (empty($_GET['node'  ]))?0:intval($_GET['node']);
    $node    = intval($node); // node=0 => root
    $consumers_node = 1;
    $rept    = 1; // 1 for consumers, 2 for reps and retailers
    $com     =  common::getInstance();


    /*
    754 => 'categories',
    525 => 'products',
    148 => 'rules_icon',
    826 => 'store_locator',
    900 => 'web_home',
    901 => 'web_product',
    902 => 'web_categories',
    903 => 'web_head_foot',
    160 => 'head_foot',
    161 => 'node_descr',
    162 => 'safety_wrn',
    170 => 'javascript',
    171 => 'error_code',
    172 => 'contact_txt',
    173 => 'tool_of_tt',
    287 => 'web_external_urls',
     */
    //-------------------------------------------------------
    //  head_foot
    //  txtcatinfo
    //  node_descr
    //  rules_icon
    //  store_locator
    //  products
    //  safety_wrn
    //  javascript  170
    //  error_code  171
    //  contact_txt 172

    $vtxt    = array();

    $jsontxt = $com->file_cache_contents('https://dashfga.com/prdtext.php?mods=160|141|161|148|826|525|162|170|171|172|287|900&prds=&lang='.$lang.'&scrt=74');
    $vtxt    = array_merge($vtxt,json_decode($jsontxt,true));


    //------------------------------------------------------

    $jsonall = $com->file_cache_contents('https://dashfga.com/prdall.php?node=1&lang='.$lang);
    $allprds = json_decode($jsonall,true);
/*
[2684] => Array(
    [product_id] => 2684
    [doc_images] => [{"file":164760356916,"desc":"Packaging%20and%20Product","stat":"1"},{"file":164760356965,"desc":"Packaging%20front","stat":"1"},{"file":164760356836,"desc":"Product","stat":"1"}]
    [prd_line]   => RUSTIK
    [age]        => 6+
    [players]    => 2
    [web_brand]  => RUSTIK -- can be more than one | | |
    [folder]     => BOJEUX
    [SKU]        => BJR000124
    [fga_vendor] => BJR000124
    [name]       => rustik classic french checkers 4-in-1 game
    [REF]        => BJR000124
    )
[2558] => Array(
    [product_id] => 2558
         :            :
*/
    //------------------------------------------------------------------
    // JSON dashFGA return list of subcategories on current node sort by 'sort'
    // array(
    //   1 => array('node'=>6 , 'cat_ref'=>43, 'options'=>'sds dss' parent=1),
    //   2 => array('node'=>7 , 'cat_ref'=>52, 'options'=>'sadd ss' parent=1),
    //   3 => array('node'=>8 , 'cat_ref'=>32, 'options'=>'sadd ss' parent=1),
    //   :     :
    // ------continue with 2nd level
    //  11 => array('node'=>65, 'cat_ref'=>30, 'options'=>'sadd ss' parent=6),
    //  12 => array('node'=>66, 'cat_ref'=>45, 'options'=>'sadd ss' parent=6),
    //   :     :
    //  18 => array('node'=>68 , 'cat_ref'=>32, 'options'=>'sadd ss' parent=7),
    // ----------ends 2nd level go 3rd level ( if any)
    //
    //  )

    //------------------------------------------------------------------
    $jsonnode = $com->file_cache_contents('https://dashfga.com/prdtree.php?lang='.$lang);
    $prdtrees = json_decode($jsonnode,true);
    //-------------------------------------------------------
    $search = (isset($_GET['search'])?trim(stripslashes($_GET['search'])):'');
    $from_p = ($_GET['from_post']!='')?true:false;  // otherwise will get a loop
    //-------------------------------------------------------
    // search
    //-------------------------------------------------------
    if (($search!='')&&($from_p)){
        // extract vendor from search -if any-
        $vendor='';
        if (strpos($search,"\t")>0){
          list($vendor,$search) = explode("\t",$search);
        }
        $search = urlencode($search);
        //------------------------------------------------------
        // call direct for search no web_cache please!
        // dashfga.com/prdsearch.php?tx=sdfrr&sku=EN&node=1&lang=EN&sku=LM3456
        $jsonsrch = file_get_contents('https://dashfga.com/prdsearch.php?tx='.$search.'&node=1&sku='.$vendor.'&lang='.$lang);
        $sreturns = json_decode($jsonsrch,true); // array of prd_ids
        //------------------------------------------------------
        if(count($sreturns) <1  ){ header("Location:index.php?search=".$search); exit; }
        if(count($sreturns) ==1 ){
          reset($sreturns);
          $val = key($sreturns);
          header("Location:productview.php?pro_id=".$val."&search=".$search); exit;
        }
        if(count($sreturns) >1  ){ header("Location:listview.php?prd_list=".implode("|",array_keys($sreturns))."&search=".$search); exit;}
    }

	/* ======================================================================== */
    $lang = strtolower($_SESSION['lang']);
    $login = false;

//------------------------------------------------------------------
$ag_values = array(
    "01Y"=>"1+","02Y"=>"2+","03Y"=>"3+","04Y"=>"4+","05Y"=>"5+","06Y"=>"6+","08Y"=>"8+","09Y"=>"9+","10Y"=>"10+","14Y"=>"14+","21Y"=>"21+"
);

$wbrands = array(
    "FGA"    => array('name'   =>"Family Games",   'color'=>"#FFD700"), //  > <style> x{ color:#FFD700}
    "LM"     => array('name'   =>"Little Moppet",  'color'=>"#32CD32"), //  > <style> x{ color:#32CD32}
    "MATCH"  => array('name'   =>"Matchitecture",  'color'=>"#F0E68C"), //  > <style> x{ color:#F0E68C}
    "MATH"   => array('name'   =>"Mathable",       'color'=>"#262626"), //  > <style> x{ color:#262626}
    "RJ"     => array('name'   =>"Reeves & Jones", 'color'=>"#4169E1"), //  > <style> x{ color:#4169E1}
    "ROP"    => array('name'   =>"Roll-o-Puzzle",  'color'=>"#2E8B57"), //  > <style> x{ color:#2E8B57}
    "RUSTIK" => array('name'   =>"Rustik",         'color'=>"#8B4513"), //  > <style> x{ color:#8B4513}
    "TANTRIX"=> array('name'   =>"Tantrix",        'color'=>"#FF8C00"), //  > <style> x{ color:#FF8C00}
    "TF"     => array('name'   =>"Tutti Frutti",   'color'=>"#AB0000"), //  > <style> x{ color:#AB0000}
    "TOTTV"  => array('name'   =>"Turn Off the TV",'color'=>"#800080"), //  > <style> x{ color:#800080}
);

/* ******************************************************************************************* */
/* ******************************************************************************************* */
/* ******************************************************************************************* */

/** *******************************************************************************************
 *
 * @param $txt
 * @return string
 */
function canonical_format_name($txt){
    $txt = strip_tags($txt);
    $find = array("&#8482;",   "(TM)","<br>","\n","&ndash;","&nbsp;","  ");
    $repl = array(     "™",      "™",   '' , '' ,'-'      ,     " "," " );
    return addslashes(str_replace($find,$repl,$txt));
}


/** *******************************************************************************************
 *
 *
 * @param $breadc array
 * @return string
 */
function get_breadcrum($breadc){
    $breadcrum_html = "";
    list($file,$path) = explode("/",strrev($_SERVER['HTTP_REFERER']),2);
    $path = strrev($path)."/categoryview.php?node=";

    foreach($breadc as $cat => $name){
        if ($cat=='1') $link = "index.php";
        else           $link = $path.$cat;
        $breadcrum_html = " <li><a href='$link'>$name</a> <span class='divider'>/</span></li>\n ".$breadcrum_html;
    }

    $breadcrum_html = "<ul class='breadcrumb'> $breadcrum_html \n</ul>\n";
   return $breadcrum_html;
}

/** *******************************************************************************************
 *
 * @param $prdinode
 * @param $images
 * @param $vtxt
 * @return string
 */
function get_products_in_cat($prdinode,$images,$vtxt){
    $prdsincat_html = "<ul class='thumbnails fixthumbleft listview' >\n ";
    foreach($prdinode as $pid){
        $pid  = intval($pid);
        $name = str_replace(array("'","\n"),array("`",""),$vtxt['nkey_'.$pid]);
        $name = strip_tags($name);
        $split_na = str_replace(array('-'),array('<br>'),$name);
        $prdsincat_html .=
            "  <li class='span3'>
                    <div class='thumbnail'>
                        <a href='productview.php?pro_id={$pid}'><img src='".$images[$pid]['url']."' alt='' title='".urldecode($images[$pid]['alt'])."' /></a>
                        <h5><a href='productview.php?pro_id={$pid}'>{$split_na}</a></h5>
                        <p>{$vtxt['dkey_'.$pid]}</p>
                    </div>
                </li>
            ";
    }
    $prdsincat_html .= "</ul>\n";
    return $prdsincat_html;
}
/** *******************************************************************************************
 *
 * get a list of subnodes on the main node
 * @param $nodelist
 * @return string
 */
function subnodes_on_node($nodelist){
    $nolist = array();
    foreach($nodelist as $count => $nodedet){
        $nolist[]=$nodedet['node'];
    }
    return implode(',',$nolist);
}

/** *******************************************************************************************
 *
 * get all products on list of nodes
 * @param $nodes
 */
function products_on_nodes($nodes){
    $list_prds = array();
    foreach($nodes as $onenode=>$prods){
        $list_prds = array_merge($list_prds,$prods);
    }
    return implode('|',$list_prds);
}

/** *******************************************************************************************
 *  To avoid make a dashfga request on every page refresh, I have this tool that give me a random list of products
 *  to be use on the footer, the list changes every hour.
 *  this list will be common for all users and as i said before, last one hour
 *
 * @param $qty  int
 * @param $to int
 * @return array
 */
function rand_prods($qty=10,$to=3600){
    $fn       = "../web_cache/rand_prods_$qty.json";
    $uselocal = false;
    $arr_keys = array();

    // check if we have already and under the time frame
    if (file_exists($fn)) {
        $filetime = filectime($fn);
        $uselocal = ((time() - $filetime) < $to);
    }
    // all set, return the local values
    if ($uselocal) { return json_decode(file_get_contents($fn),true); }

    // need to create a new set and save
    $jsonall  = file_get_contents('https://dashfga.com/prdall.php?node=1&lang=EN');
    $allprds  = json_decode($jsonall, true);
    $arr_keys = array_rand($allprds, $qty);
    // a valid request, save locally
    if (!empty($arr_keys)) { file_put_contents($fn, json_encode($arr_keys)); }

    return $arr_keys;
}


/** **************************************************************************************
 * @param $allprds
 * @param $cont
 * @return string
 */
function random_products($allprds,$random_keys,$images,$vtxt){
    global $wbrands;
    $html = '';
    foreach($random_keys as $i=>$pid){
        $element = $allprds[$pid];
        $age = str_replace(' ','',$element['age']);
        $ply = str_replace(' ','',$element['players']);
        list($brand) = explode('|',$element['web_brand']."|");
        $brand_color = isset($wbrands[$brand])?$wbrands[$brand]['color']:'#000';
        $html .= " 
        <div class='boxcc'>
            <a href='productview.php?pro_id={$pid}'><img src='".$images[$pid]['url']."' alt='' title='".urldecode($images[$pid]['alt'])."' /></a>
            <div class='prdinfo'>
                <div class='blacktxt1'>{$vtxt['players']}</div>
                <div class='boxplayers'>{$ply}</div>
                <div class='blacktxt2'>{$vtxt['rated_age']}</div>
                <div class='boxag'>{$age}</div>
            </div>
            <H2 class='prodtitle'>{$element['name']}</H2>
            <div class='proddescr'>{$vtxt['dkey_'.$pid]}</div>
            <a href='search_by_brand.php?brand=$brand' ><div class='triangle' style='background: linear-gradient(to bottom right, #fff 0%, #fff 45%, {$brand_color} 55%, {$brand_color} 100%);'></div></a>
        </div>
";
    }
    return $html;
}

