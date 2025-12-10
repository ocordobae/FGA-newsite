<?php
include_once('init_.php');
global $com;       // object common tools
global $node;      // current root node
global $prdtrees;  // full structure and categories / subcategories
global $lang;      // current language
global $vtxt;      // text value for head and foot
global $allprds;   // required for search
global $ag_values; // age group range values
global $wbrands;   // web brands info, and sort names for images
global $consumers_node; // its one!
$pro_id = (isset($_GET['pro_id'])?$_GET['pro_id']:'0');
$pro_id = intval($pro_id);
if($pro_id<=0){  header("Location: ../consumers/index.php"); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>
    <style> /* tempo styles here */
    .thumbnail_image_carousel_wrapper{
        background: none !important;
        border:solid 1px #AAAAAA;
    }
    .thumbnail_image_carousel_caption{
        background: rgba(100, 100, 100, 0.8);
        top:78%;
    }

    .thumbnail_image_carousel_caption p{
        text-align: center !important;
    }
    .thumbnail_image_carousel_indicators{
        background: none !important;
        border-top:1px solid #888888 !important;
    }

    .carousel-indicators li{
        width: 5rem !important;
        height: auto !important;
    }

.carousel-caption{
    bottom:0;
    padding:0;
}
h1{
    color:#555555;
    text-transform: uppercase;
    font-size: 2.4vw;
    font-weight: 500;
}
.prdintable td,.prdintable th{
    padding:0 !important;
    line-height: normal !important;
}

.nav-link{
    font-weight: 400 !important;
    color:#444444;
}

.nav-link.active{
    color:orange !important;
}
.noborder{
    border: 0px !important;
    box-shadow: 0px 0px 0px #fff !important;
}
.thumbnails li{
    list-style-type: none;
    display: inline-block;
    text-align: center;
    margin-right: 15px;
    margin-bottom: 15px;
    width: 100px;
    vertical-align: top;
}

.ext_content{
    width: 100%;
    height: 100%;
    border:0;
}

table.wtb{
 width: 90%;
margin: 0 auto;
}

table.wtb th{
    text-align: center;
}
table.wtb td{
    text-align: center;
}
table.wtb img{
    width:10vw;
}

.tab-pane{
    height: 220px;
    overflow-y: auto;
}
.gp_products_item_image{
 -webkit-border-radius: 200px !important;   /* rounded when selected */
}
.gp_products_inner{
    -webkit-box-shadow: none !important;  /* remove shadow*/
}
.tab_item{  font-family: Oswald, sans-serif; }
    </style>
</head>

<?php
// ----------- breadcrum ----------------------------------------------------
// need to run before the call to product info
//
$bc = array();
$breadc = "";
foreach($prdtrees[$consumers_node] as $cont => $onenode){
    $level_1_node  = intval($onenode['node']);
    $bc[] =  $onenode['node'];
    $breadc .= " <a href='categoryview.php?node={$onenode['node']}'>[".$level_1_node."=".$onenode['value']."]</a>";
}
?>

<?php
$tw = '<svg id="tw_icon" data-name="tw_icon" width="28" height="27" viewBox="0 0 28 27" xmlns="http://www.w3.org/2000/svg"> <rect id="Rectangle_94" data-name="Rectangle 94" width="28" height="27" rx="6" fill="#b3b3b3"/> <path id="Icon_awesome-twitter" data-name="Icon awesome-twitter" d="M14.361,6.591c.01.141.01.282.01.423a9.225,9.225,0,0,1-9.334,9.249A9.332,9.332,0,0,1,0,14.8a6.848,6.848,0,0,0,.792.04,6.608,6.608,0,0,0,4.073-1.389A3.283,3.283,0,0,1,1.8,11.2a4.174,4.174,0,0,0,.62.05,3.5,3.5,0,0,0,.863-.111A3.259,3.259,0,0,1,.65,7.95V7.91a3.327,3.327,0,0,0,1.483.413A3.241,3.241,0,0,1,.67,5.615a3.2,3.2,0,0,1,.447-1.64,9.353,9.353,0,0,0,6.764,3.4A3.638,3.638,0,0,1,7.8,6.631a3.29,3.29,0,0,1,5.677-2.224,6.5,6.5,0,0,0,2.082-.785,3.247,3.247,0,0,1-1.442,1.791,6.624,6.624,0,0,0,1.889-.5,7.017,7.017,0,0,1-1.645,1.681Z" transform="translate(6.031 4.021)" fill="#fff"/></svg>';
$fb = '<svg id="fb_icon" data-name="fb_icon" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg"> <g id="Group_616" data-name="Group 616" transform="translate(-1453 -639)"> <rect id="Rectangle_93" data-name="Rectangle 93" width="27" height="27" rx="6" transform="translate(1453 639)" fill="#b3b3b3"/> <path id="Icon_awesome-facebook-f" data-name="Icon awesome-facebook-f" d="M9.3,8.566,9.728,5.81H7.059V4.022A1.384,1.384,0,0,1,8.627,2.533H9.84V.186A14.926,14.926,0,0,0,7.687,0,3.38,3.38,0,0,0,4.052,3.71v2.1H1.609V8.566H4.052v6.662H7.059V8.566Z" transform="translate(1460.451 645.229)" fill="#fff"/> </g></svg>';
$ig = '<svg id="ig_icon" data-name="ig_icon" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg"> <g id="Group_615" data-name="Group 615" transform="translate(-1417 -639)"> <rect id="Rectangle_92" data-name="Rectangle 92" width="27" height="27" rx="6" transform="translate(1417 639)" fill="#b3b3b3"/> <path id="Icon_simple-instagram" data-name="Icon simple-instagram" d="M11.927,0C8.686,0,8.282.015,7.01.072a8.794,8.794,0,0,0-2.9.555A5.84,5.84,0,0,0,2,2,5.819,5.819,0,0,0,.626,4.115a8.769,8.769,0,0,0-.555,2.9C.012,8.282,0,8.686,0,11.927s.015,3.645.072,4.917a8.8,8.8,0,0,0,.555,2.9A5.849,5.849,0,0,0,2,21.851a5.832,5.832,0,0,0,2.113,1.376,8.805,8.805,0,0,0,2.9.555c1.272.06,1.677.072,4.917.072s3.645-.015,4.917-.072a8.826,8.826,0,0,0,2.9-.555,6.1,6.1,0,0,0,3.489-3.489,8.8,8.8,0,0,0,.555-2.9c.06-1.272.072-1.677.072-4.917s-.015-3.645-.072-4.917a8.82,8.82,0,0,0-.555-2.9A5.854,5.854,0,0,0,21.851,2,5.811,5.811,0,0,0,19.738.626a8.774,8.774,0,0,0-2.9-.555C15.571.012,15.167,0,11.927,0Zm0,2.147c3.183,0,3.563.016,4.82.071a6.571,6.571,0,0,1,2.213.412,3.925,3.925,0,0,1,2.264,2.263,6.585,6.585,0,0,1,.41,2.213c.057,1.258.07,1.636.07,4.82s-.015,3.563-.074,4.82a6.712,6.712,0,0,1-.418,2.213,3.787,3.787,0,0,1-.893,1.374,3.721,3.721,0,0,1-1.372.891,6.633,6.633,0,0,1-2.221.41c-1.266.057-1.639.07-4.829.07s-3.564-.015-4.829-.074a6.763,6.763,0,0,1-2.222-.418,3.693,3.693,0,0,1-1.371-.893,3.621,3.621,0,0,1-.894-1.372,6.768,6.768,0,0,1-.417-2.221c-.045-1.252-.061-1.639-.061-4.814s.016-3.564.061-4.831A6.761,6.761,0,0,1,2.58,4.86a3.535,3.535,0,0,1,.894-1.373A3.528,3.528,0,0,1,4.845,2.6a6.6,6.6,0,0,1,2.207-.418c1.267-.045,1.64-.06,4.829-.06l.045.03Zm0,3.655a6.124,6.124,0,1,0,6.124,6.124A6.124,6.124,0,0,0,11.927,5.8Zm0,10.1A3.976,3.976,0,1,1,15.9,11.927,3.974,3.974,0,0,1,11.927,15.9Zm7.8-10.341a1.431,1.431,0,1,1-1.431-1.43A1.432,1.432,0,0,1,19.724,5.561Z" transform="translate(1418.574 640.574)" fill="#fff"/> </g> </svg>';

//------------------------------------------------------------------
// JSON dashFGA product info recover
// echo 'dashfga.com/prdinfo.php?pid=56&lang=EN;
// Array(
//    [id] => 338
//    [status] => 5
//    [product_type] => 0
//    [SKU] => BJTT14825
//    [UPC] => 061404148255
//    [age] => 3+
//    [players] => 1+
//    [difficulty] => N/A
//    [material] => dough, plastic
//    [box_size_cm] => 19 x 23 x 19
//    [box_weight_kg] => 1.03
//    [itemsbydplay] =>
//    [CPS_size_cm] => 39.5 x 25 x 39.5
//    [CPS_weight_kg] => 4.578
//    [CPS_quantity] => 4
//    [MPS_size_cm] => na x na x na
//    [MPS_weight_kg] => NA
//    [MPS_quantity] => NA
//    [name] => party bucket
//)
//------------------------------------------------------------------
$jsonprd = $com->file_cache_contents('https://dashfga.com/prdinfo.php?pid='.$pro_id.'&lang='.$lang.'&bc='.implode(',',$bc));
$prdinfo = json_decode($jsonprd,true);
//------------------------------------------------------------------
$jsonimg = $com->file_cache_contents('https://dashfga.com/prdimg.php?key=main&pid='.$pro_id);
$images  = json_decode($jsonimg,true);
// -----------------------------------------------------------------
$jsondoc = $com->file_cache_contents('https://dashfga.com/prddoc.php?pid='.$pro_id.'&key=consumerPDF&lang='.$lang);
$docs    = json_decode($jsondoc,true);
// -----------------------------------------------------------------
$img_prd = $images[$pro_id];

$name = str_replace(array("'","\n"),array("`",""),$prdinfo['name']);
$name = strip_tags($name);

$ptype    = intval($prdinfo['product_type']);

// brands -------------------------------------------------------------------------
$brands    = empty($prdinfo['web_brand'])?array():explode("|",$prdinfo['web_brand']);
// header brand related to product
$header_brand = '';
if(!empty($brands)){
    $file = "../img/brands/banners/".$brands[0]."_".$lang.".png";
    $md5  = filemtime($file);
    $header_brand = "<img src='{$file}?{$md5}' style='width:100%;' alt='' />";
}

// quick play ---------------------------------------------------------------------
$quick_play = '';
if(!empty($prdinfo['qplay'])){
    $quick_play = "<h5>".$vtxt['quickp']."</h5>\n".$com->html_convert($prdinfo['qplay']);
}
// safety warnings ----------------------------------------------------------------
$safety_w = '<br>';
if(!empty($prdinfo['safety_w'])){
    $warns = explode('|',$prdinfo['safety_w']);
    foreach($warns as $onew){
        $safety_w .= "<img src='../img/safety_warnings/{$onew}_{$lang}.jpg' alt='{$onew}' style='height: 10vw;' > &nbsp; ";
    }
}

// where to buy -------------------------------------------------------------------
$tgphandle = (empty($prdinfo['tgpHandle']))?'#':$prdinfo['tgpHandle'];

$where_to_buy = '';
$where_to_buy = "<br> 
 <!-- <h5>".$vtxt['pro_where_to_buy']."</h5> -->
<table class='wtb' >
<tr>
<th>Canada</th>
<th>United States</th>
<th>International</th>
<th>Store Locator</th>
</tr>
<tr>
    <td><a href='https://toysgamespuzzles.ca/collections/all/products/{$tgphandle}' target='TGPca'><img src='../img/tgp_logo.png' alt='tgp' /></a></td>
    <td><a href='https://toysgamespuzzles.com/collections/all/products/{$tgphandle}' target='TGPus'><img src='../img/tgp_logo.png' alt='tgp' /></a></td>
    <td><a href='#'><i class='far fa-envelope fa-4x'></i></a></td>
    <td><a href='store_locator.php?pidsel={$pro_id}'><i class='fas fa-map-marked-alt fa-4x'></i></a></td>
</tr>
</table>
";



$img_thumb = "";
$img_slide = "";
$cont      = 0;
$active    = 'active';
foreach($img_prd['images'] as $cont => $oneimg) {
    $descr = str_replace('%20',' ',$oneimg['desc']);
    $img_slide .= "<!--  Slide {$cont} ----------- --> 
                            <div class='carousel-item {$active}' style='height: 520px;'>
                            <img src='{$oneimg['url']}' alt='{$descr}' />
                                <div class='carousel-caption thumbnail_image_carousel_caption'>
                                    <p>{$descr}</p>
                                </div>
                            </div>
                            \n";
    $img_thumb .= "<li data-target='#thumbnail_image_carousel' data-slide-to='{$cont}' class='{$active}'>
                              <img src='{$oneimg['thumb']}' alt='{$descr}' />
                           </li>\n";
    $cont++;
    if($active!='') $active='';
}


//--------------------Rules---------------------------------------
$rules = "<br><ul class='thumbnails fixthumbleft' data-lang='EN'>\n";
if (isset($docs[$prdinfo['id']]['documents'])){
    foreach($docs[$prdinfo['id']]['documents'] as $onedoc){
        $filename = $name."_-_".$onedoc['desc']."-".str_replace(array("|","\""),array("-","`"),$onedoc['lang']).".pdf";
        $rules .=  "
                                <li class='span3'> 
                                    <div class='thumbnail noborder text-center'>              
                                        <a href='".$onedoc['url']."' target='PDF' download='$filename' ><img src='../img/nav/icon_pdf.png' alt='' /></a>
                                        <p style='font-size:75%'>".$onedoc['desc']."-".str_replace("|","-",$onedoc['lang'])."</p>
                                    </div> 
                                </li> \n";
    }
    // includes  external link ( if any )
    if(!empty($vtxt[$prdinfo['SKU'].'_EXT_URL'])) {
        $ext_url_descr = (isset($vtxt[$prdinfo['SKU'].'_EXT_URL_DESC']))?$vtxt[$prdinfo['SKU'].'_EXT_URL_DESC']:"LINK";
        $rules .= "
                                <li class='span3'> 
                                    <div class='thumbnail noborder text-center'>              
                                        <a href='#' data-toggle='modal' data-target='#external_url'><img src='../img/nav/icon_html.png' alt='' /></a>
                                        <p style='font-size:75%'>$ext_url_descr</p>
                                    </div> 
                                </li> 
                                <div class='modal fade external_url' id='external_url' tabindex='-1' role='dialog' style='z-index:100001' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog modal-xl h-100'>
                                    <div class='modal-content h-75'>
                                       <iframe class='ext_content'></iframe>
                                    </div>
                                  </div>
                                </div>
                                ";
    }

}
$rules .= "</ul>\n";
//------------------------------------------- END RULES-----------

?>

<body>

<?php include "header.php"; ?>

<?php echo $header_brand; ?>

<?php
// ------------  BREADCRUM FOR EACH LOCATEIO WHERE THE PRODUCT WAS FOUND ------------
$max_ele   = count($prdinfo['breadcrum']);
$plusieurs = ($max_ele > 1);
$first_ele = true;
$count_ele = 1;
foreach($prdinfo['breadcrum'] as $one_location){
    $toggler = '';
    if($plusieurs){$toggler= "<a href='#' onclick='toggler(this)'><i class='fas fa-retweet'></i></a>";}
    if($first_ele){
        echo "<div id='bc{$count_ele}' style='width:100%; background: #EAEAEA; text-align:center; font-size: x-small;padding:5px;border-bottom: solid 1px #FFF;box-shadow: 0 0 15px 0 rgba(0,0,0,0.3);' data-pos='{$count_ele}' data-max='{$max_ele}'> {$one_location}  &nbsp; &nbsp;  {$toggler} </div>";
        $first_ele = false;
    }else{
        echo "<div id='bc{$count_ele}' style='display:none; width:100%; background: #EAEAEA; text-align:center; font-size: x-small;padding:5px;border-bottom: solid 1px #FFF;box-shadow: 0 0 15px 0 rgba(0,0,0,0.3);' data-pos='{$count_ele}' data-max='{$max_ele}'> {$one_location}  &nbsp; &nbsp;   {$toggler} </div>";
    }
$count_ele++;
}
?>

<br>
<br>



<!-- ########################   P.R.O.D.U.C.T.S    S.E.T.U.P  ################################# -->
<?php if($ptype == SETUP) { ?>
    <br>
    <div>
        <div class="w-100 mb-0 text-center carousel_header"><?php echo $name; ?></div>
        <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $prdinfo['descr']; ?></div>
        <hr class="carousel_header_hr" >
    </div>
    <br>
    <br>
<div class="" style="margin-left:3vw;margin-right:3vw;">
    <div class="w-100 grid">
        <?php
        $items = array_keys($prdinfo['singles']);
        //------------------------------------------------------------------
        // JSON dashFGA images recover
        // echo 'https://dashfga.com/prdimg.php?pid='.implode('|',$prdinode).'&key=icon';
        // NO CACHE this is random access , no option to save locally.
        //------------------------------------------------------------------
        $jsonimg = file_get_contents('https://dashfga.com/prdimg.php?key=j300&pid='.implode('|',$items));
        $rndimgs = json_decode($jsonimg,true);
        //------------------------------------------------------------------
        // JSON dashFGA text recover, 36 = from products table  TEXT for prds current node and all subnodes
        // echo 'https://dashfga.com/prdtext.php?mods=305|341&prds=269|637|640&lang=EN&scrt=36';
        //------------------------------------------------------------------
        $jsontxt = file_get_contents('https://dashfga.com/prdtext.php?mods=305&prds='.implode('|',$items).'&lang='.$lang.'&scrt=36');
        $vtxt    = array_merge($vtxt,json_decode($jsontxt,true));
        //------------------------------------------------------------------
        echo random_products($prdinfo['singles'],$items,$rndimgs,$vtxt);
        ?>
    </div>
</div>
<?php } ?>
<!-- ########################################################################################## -->




<!-- ########################   P.R.O.D.U.C.T      D.E.T.A.I.L.S  ############################# -->
<?php if($ptype != SETUP) { ?>
<div class="" style="margin-left:3vw;margin-right:3vw;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

                <!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->

                <div id="thumbnail_image_carousel" class="carousel slide carousel-fade thumbnail_image_carousel_fade thumbnail_image_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="60000" data-pause="hover" style="max-height: 1000px;">

                    <!-- Indicators -->
                    <ol class="carousel-indicators thumbnail_image_carousel_indicators" style="height: 90px;">
                        <?php echo $img_thumb; ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php echo $img_slide; ?>
                    </div>

                    <!--======= Navigation Buttons =========-->

                    <!--======= Left Button =========-->
                    <a class="carousel-control-prev thumbnail_image_carousel_control_left" href="#thumbnail_image_carousel" data-slide="prev">
                        <span class="fas fa-chevron-circle-left thumbnail_image_carousel_control_icons" aria-hidden="true"></span>

                    </a>

                    <!--======= Right Button =========-->
                    <a class="carousel-control-next thumbnail_image_carousel_control_right" href="#thumbnail_image_carousel" data-slide="next">
                        <span class="fas fa-chevron-circle-right thumbnail_image_carousel_control_icons" aria-hidden="true"></span>

                    </a>

                </div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->

            </div>
            <div class="col-md-8">
                <h1><?php echo $name; ?></h1>
                <table class="table-sm w-100 text-sm-center prdintable">
                    <tr>
                        <th>SKU #</th>
                        <th>AGE</th>
                        <th><?php echo strtoupper($vtxt['pro_players']) ?></th>
                        <th rowspan="2"><!-- button type="button" class="btn" style="background:darkorange; color:white;"><?php echo $vtxt['pro_inquiries'] ?></button --></th>
                        <th rowspan="2"><?php echo $fb.' '.$ig.' '.$tw; ?></th>
                    </tr>
                    <tr>
                        <td><?php echo $prdinfo['SKU'     ]; ?></td>
                        <td><?php echo $prdinfo['age'     ]; ?></td>
                        <td><?php echo $prdinfo['players' ]; ?></td>
                    </tr>
                </table>
                <br>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item tab_item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-descr" role="tab" aria-controls="nav-descr" aria-selected="true"><?php echo strtoupper($vtxt['pro_desc']) ?></a>
                        <a class="nav-item tab_item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-rules" role="tab" aria-controls="nav-rules" aria-selected="false"><?php echo strtoupper($vtxt['pro_rules']) ?></a>
                        <a class="nav-item tab_item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-safety" role="tab" aria-controls="nav-safety" aria-selected="false"><?php echo strtoupper($vtxt['pro_safety']) ?></a>
                        <a class="nav-item tab_item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-buy" role="tab" aria-controls="nav-buy" aria-selected="false"><?php echo strtoupper($vtxt['buy_now']) ?></a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-descr" role="tabpanel" aria-labelledby="nav-descr-tab"><br><?php echo $prdinfo['descr']; ?></div>
                    <div class="tab-pane fade" id="nav-rules"  role="tabpanel" aria-labelledby="nav-rules-tab"><?php echo $rules.$quick_play; ?></div>
                    <div class="tab-pane fade" id="nav-safety" role="tabpanel" aria-labelledby="nav-safety-tab"><?php echo $safety_w; ?></div>
                    <div class="tab-pane fade" id="nav-buy"    role="tabpanel" aria-labelledby="nav-buy-tab"><?php echo $where_to_buy; ?></div>
                </div>

                <?php if(!empty($prdinfo['singles'])) { ?>
                <br>
                <h6 class="text-warning" style="font-weight: bold;">SINGLE ITEMS</h6>
                <?php
                    foreach($prdinfo['singles'] as $pid => $oneprd){
                        echo "<div class='text-center' style='width:170px; padding:10px; margin-right: 20px; border-radius: 20px; background:#EFEFEF;  margin-bottom: 20px; display:inline-block; vertical-align:top;'><a href='productview.php?pro_id={$pid}'><img src='{$oneprd['url']}' alt='{$oneprd['alt']}' style='width:100%'><br>{$oneprd['name']}</a></div>";
                    }
                ?>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->
<!-- ########################   R.E.L.A.T.E.D    P.R.O.D.U.C.T    ############################# -->
<?php if(!empty($prdinfo['related'])) {
    $dc1200 = count($prdinfo['related']);// starts 0
    if ($dc1200 > 6) $dc1200 = 6;
    $dc992  = abs(($dc1200+1)/2);  // about the half of the 1200 when you have only few elements.
    ?>
    <br>
    <br>
    <div style="background:#FFFFFF;" id="adv_gp_products_6_columns_carousel" class="carousel slide gp_products_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="50000" data-pause="hover" data-column="<?php echo $dc1200; ?>" data-m576="1" data-m768="1" data-m992="<?php echo $dc992; ?>" data-m1200="<?php echo $dc1200; ?>">

        <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['related_products'] ?></div>
        <!--========= Wrapper for slides =========-->
        <div class="carousel-inner" role="listbox">
            <?php
            $count = 1;
            $html_related_prds = '';
            foreach($prdinfo['related'] as $pid => $oneprd) {
                $html_related_prds .= "
        <!--========= {$count}st slide =========-->
        <div class='carousel-item'>
            <div class='row'> <!-- Row -->
                <div class='col gp_products_item'>
                    <div class='gp_products_inner gp_cat_inner'>
                        <div class='gp_products_item_image'>
                            <a href='productview.php?pro_id={$pid}'><img src='{$oneprd['url']}' alt='{$oneprd['alt']}' /></a>
                        </div>
                        <div class='gp_products_item_caption text-center'>
                            <a href='productview.php?pro_id={$pid}' style='color:#555555;'>{$oneprd['name']}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
                $count++;
            }
            echo $html_related_prds;
            ?>
        </div>
        <!--======= Navigation Buttons =========-->

        <!--======= Left Button =========-->
        <a class="carousel-control-prev gp_products_carousel_control_left" href="#adv_gp_products_6_columns_carousel" data-slide="prev">
            <span class="fas fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>
        </a>

        <!--======= Right Button =========-->
        <a class="carousel-control-next gp_products_carousel_control_right" href="#adv_gp_products_6_columns_carousel" data-slide="next">
            <span class="fas fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>
        </a>

    </div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->
<?php } ?>
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->
<!-- ########################################################################################## -->

<?php include "footer.php"; ?>

<!-- End your project here yeee -->

<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="../js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../js/mdb.min.js"></script>
<!--======= Touch Swipe =========-->
<script src="../js/touchSwipe.js"></script>
<!--======= Customize =========-->
<script src="../js/responsive_bootstrap_carousel.js"></script>
<!--======= Select Picker ==========-- -->
<script src="../js/bootstrap-select.min.js"></script>

<!-- Your custom scripts (optional) -->
<script type="text/javascript">
    // Javascript
    $(document).ready(function(){
        $('#external_url').on('show.bs.modal', function (e) {
            $('.ext_content').attr('src','<?php echo (isset($vtxt[$prdinfo['SKU'].'_EXT_URL'])?$vtxt[$prdinfo['SKU'].'_EXT_URL']:""); ?>');
        })
    });
    
   // toggler for the breadcrum when more than one option is printed
   function toggler(obj){
       let div  = $(obj).parent();
       let max  = div.attr('data-max');
       let cur  = div.attr('data-pos');
       let next = parseInt(cur)+1;
       if(next >= max) next = 1;
                 div.css('display','none');
       $('#bc'+next).css('display','block');
   }

</script>


</body>
</html>
