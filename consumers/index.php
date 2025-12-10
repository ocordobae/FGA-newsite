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

//------------------TOP SLIDER:SEASONS -------------------------------
// I know the next request will be to create a link on the picture,
// this is not a problem, you have to create a .json with all stuff inside
// using the same name as the picture and loading all info we need.
//--------------------------------------------------------------------
$top_slider_images     = '';
$top_slider_indicators = '';

//------------------------------------------------------------------
// JSON dashFGA banners in node
// force node=1 , we are on index
//------------------------------------------------------------------
$jsonprds   = $com->file_cache_contents('https://dashfga.com/prdbanner.php?node=1&lang='.$lang);
$prdbanners = json_decode($jsonprds,true); // array(...);
//------------------------------------------------------------------

//-------carrousel------------------------------------------
$carrousel_html = $com->get_carrousel($prdbanners,$vtxt);
//----------------------------------------------------------

//------------------ABOUT US SECTION ---------------------------------
// can be placed images or videos
// the orders will be defined alphabetically
// for videos, please use a file txt including the video info
//--------------------------------------------------------------------

$html_about_us_sliders = '';
$path = "../img/about_us/";
if (!is_dir($path)) {
    $html_about_us_sliders .= "<p style='color:#ff0000'> Please create the folder [$path] and add .jpg images </p>\n";
} else {
    $sliders = array();
    foreach (new DirectoryIterator($path) as $file) {
        if ($file->isDot()) continue; // no
        if ($file->isDir()) continue;
        $fname = $file->getFilename();  // 01_filename.jpg
        $ext   = strtolower(substr($fname, strrpos($fname, '.') + 1)); // jpg or txt
        if (($ext == 'jpg')||($ext=='htm')){
            $sliders[$fname] = $ext;
        }
    } // foreach
    ksort($sliders);
    $active = 'active'; // first one active
    foreach ($sliders as $fname => $ext) {
        if($ext == 'htm'){
            $video = file_get_contents($path.$fname);
            $html_about_us_sliders .= "
              <div class='carousel-item $active'>
              {$video}
              </div>";
        }
        if($ext == 'jpg'){
            $html_about_us_sliders .= "
               <div class='carousel-item $active'>
                 <img class='d-block w-100' src='{$path}{$fname}' alt='fga'>
               </div>";
        }
        $active = '';
    }
}

//------------------AGE GROUPS----------------------------------------
//
$html_ages_slider = '';
$path  = "../img/age_groups/";
$count = 0;
foreach ($ag_values as $agcode => $agval) {
    $count++;
    $html_ages_slider .= "    
    <!--========= {$count}th slide =========-->
            <div class='carousel-item' >
                <div class='row'>
                    <div class='col gp_products_item' >
                        <div class='ag_product_inner' >
                            <div class='gp_products_item_image' >
                                <a href = 'search_by_age.php?age={$agcode}' ><img src = '{$path}{$agcode}.png' alt = '{$agval}' /></a >
                            </div >
                            <div class='ag_text_item_caption text-center' >
                                <a href = 'search_by_age.php?age={$agcode}' > {$agval} </a >
                            </div >
                        </div >
                    </div >
                </div >
            </div >
    ";
}
//------------------BRAND GROUPS----------------------------------------
//
//----------------------------------------------------------------------
$html_slider_brands = '';
$count              = 1;
foreach($wbrands as $brand_key => $brandinfo){
    // i did a lot of funny things, this is one of them ..
    // susan requested to have internal key = FG for texts .. :'O
    $haha = ($brand_key=='FGA')?'FG':$brand_key;



    $html_slider_brands .= "
        <!--========= {$count}st slide =========-->
        <div class='carousel-item'>
            <div class='row'> <!-- Row -->
                <div class='col'>
                    <div class='columns_carousel_caption'>
                        <img class='iconb' src='../img/brands/icon_{$brand_key}.jpg' alt='{$brandinfo['name']}' />
                        <a href='search_by_brand.php?brand={$brand_key}'><img class='ibrand' src='../img/brands/brand_{$brand_key}.png?22' alt='{$brandinfo['name']}' /></a>
                        <div class='brand_descr'>
                            <a href='search_by_brand.php?brand={$brand_key}'>".$vtxt["brand_{$haha}_descr"]."</a>
                        </div>
                        <input class='btn btn-default btn-sm' value='".$vtxt["brand_explore_more"]."' type='button' />
                    </div>
                </div>
            </div>
        </div>
    ";
    $count++;
}

//------------------------CATEGORIES SLIDER ----------------------------
//
//
$count = 1;
$html_categories_slider = '';
foreach($prdtrees[$consumers_node] as $cont => $onenode){
    $act   = ($node==$onenode['node'])?'selected':'';
    $opcs  = json_decode($onenode['options'],true);
    $class = (isset($opcs['class']))?$opcs['class']:"";
    $html_categories_slider .= "
        <!--========= {$count}st slide =========-->
        <div class='carousel-item'>
            <div class='row'> <!-- Row -->
                <div class='col gp_products_item'>
                    <div class='gp_products_inner gp_cat_inner'>
                        <div class='gp_products_item_image'>
                            <a href='categoryview.php?node={$onenode['node']}'><img src='../img/categories/CAT-{$onenode['node']}.png' alt='{$onenode['value']}' /></a>
                        </div>
                        <div class='gp_products_item_caption text-center'>
                            <a href='categoryview.php?node={$onenode['node']}' style='color:#555555;'>{$onenode['value']}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
    $count++;
}
//===========================================================================================//
//===========================================================================================//
//===========================================================================================//
//===========================================================================================//
//===========================================================================================//
//===========================================================================================//
//===========================================================================================//
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>
    <style> /* tempo styles here */
    .gp_cat_inner{
        box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.5) !important;
      -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.5);
        border-radius: 15px;
      -webkit-border-radius: 15px;
        min-height: 285px;
        margin-bottom: 10px;
    }
        .gp_products_item_image{
            -webkit-border-radius: 15px 15px 0 0 !important;   /* rounded when selected */
        }

    </style>
</head>

<body>

<?php include "header.php"; ?>
<!-- ------------------------------------------------------------------ -->
<!-- TOP SLIDER : season slider --------------------------------------- -->
<!-- ------------------------------------------------------------------ -->

<div id="season_slider" class="carousel slide" data-ride="carousel">
    <?php echo $carrousel_html; ?>
    <a class="carousel-control-prev" href="#season_slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#season_slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>




<!-- colorful widebar -->
<div class="w-100" style="line-height: 1; height:5px;"><img src="../img/nav/colorfull_widebar.png" alt="" style="vertical-align: top; width: 100%;"></div>

<br>
<!-- ------------------------------------------------------------------ -->
<!-- ABOUT US --------------------------------------------------------- -->
<!-- ------------------------------------------------------------------ -->
<div class="container-fluid d-block w-100" style="background-image: url('../img/nav/about_us_video_background.png'); background-repeat: no-repeat;">
    <div class="row">
        <div class="col-md-8">

            <!-- slider about us ------- -->
            <div id="about_us_carousel" class="carousel slide" data-ride="carousel" style="width:90%; margin:50px 10px 10px 10px;">
                <div class="carousel-inner">
                    <?php echo $html_about_us_sliders; ?>
                </div>
                <a class="carousel-control-prev" href="#about_us_carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#about_us_carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- end slider about us --- -->


        </div>
        <div class="col-md-4">
            <div class='text-center w-100'><img src="../img/fga_logo.png" style="width: 12vw; " alt="" /> </div>
            <div class="text-center" style="padding: 10px; margin: 20px auto; width:85%; box-shadow: 10px 10px navy; background:#FFFFFF;"><h3><?php echo $vtxt['talk_about_us_title'] ?></h3>
                <p class="text-left"><?php echo $vtxt['talk_about_us_text'] ?></p>
                <br> <!-- a href='#' class="btn-sm btn-danger float-md-right" ><?php echo $vtxt['talk_about_us_button'] ?></a --> <br><br>
            </div>
        </div>
    </div>

</div>

<br>

<!-- ------------------------------------------------------------------ -->
<!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL AGES *-*-*-*-*-*-*-*-*-*-*-*-->
<!-- ------------------------------------------------------------------ -->
<div style="background:#FFFFFF;" id="ages_slider" class="carousel slide gp_products_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="10000" data-pause="hover" data-column="6" data-m576="1" data-m768="1" data-m992="3" data-m1200="5">

    <div>
        <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['search_by_age'] ?></div>
        <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $vtxt['search_by_age_descr'] ?></div>
        <hr class="carousel_header_hr" >
    </div>

    <!--========= Wrapper for slides =========-->
    <div class="carousel-inner" role="listbox">

        <?php echo $html_ages_slider; ?>

    </div>
    <!--======= Navigation Buttons =========-->

    <!--======= Left Button =========-->
    <a class="carousel-control-prev gp_products_carousel_control_left" href="#ages_slider" data-slide="prev">
        <span class="fas fa-chevron-circle-left gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>

    <!--======= Right Button =========-->
    <a class="carousel-control-next gp_products_carousel_control_right" href="#ages_slider" data-slide="next">
        <span class="fas fa-chevron-circle-right gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>

</div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL AGE *-*-*-*-*-*-*-*-*-*-->



<!-- colorful widebar -->
<div class="w-100" style="line-height: 1;"><img src="../img/nav/separation_spike.png" alt="" style="vertical-align: top; width: 100%;"></div>

<!-- ------------------------------------------------------------------ -->
<!--  discover slider                                                   -->
<!-- ------------------------------------------------------------------ -->
<div id="discoverslider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#discoverslider" data-slide-to="0" class="active"></li>
        <li data-target="#discoverslider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="../img/slider-prom/MODULE-1-FGA-GLUTENFREE-V3.png" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="../img/slider-prom/MODULE-1-RUSTIK.png" alt="Second slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#discoverslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#discoverslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- colorful widebar -->
<div class="container-fluid w-100" style="line-height: 1; margin-top:-50px; position:relative; z-index:100; height:306px; background-image: url('../img/nav/social_background.png');">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4 text-center" style="margin-top: 5.5vw; width:5vw;">
            <img src="../img/nav/follow-us.png" alt="">
        </div>
        <div class="col-md-4 text-center" style="margin-top: 6vw;">
            <a href="#"><img src="../img/nav/facebook.png" style='width:5vw;' alt="facebook" /> </a>
            <a href="#"><img src="../img/nav/instagram.png" style='width:5vw;'  alt="Instagram" /></a>
            <a href="#"><img src="../img/nav/tweeter.png" style='width:5vw;' alt="Tweeter" /></a>
            <a href="#"><img src="../img/nav/linkedin.png" style='width:5vw;' alt="LinkedIn" /></a>
            <a href="#"><img src="../img/nav/youtube.png" style='width:5vw;' alt="YouTube" /></a>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>


<!-- ------------------------------------------------------------------ -->
<!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL BRANDS *-*-*-*-*-*-*-*-*-*-*-->
<!-- ------------------------------------------------------------------ -->
<div id="brand_slider" class="carousel slide brands_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="300000" data-pause="hover" data-column="4" data-m576="1" data-m768="1" data-m992="4" data-m1200="4" style="background-image: url('../img/nav/search_by_brand_background.png'); background-repeat: no-repeat;background-size: cover;">

    <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['search_by_brand'] ?></div>
    <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $vtxt['search_by_brand_descr'] ?></div>
    <hr class="carousel_header_hr" >

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php echo $html_slider_brands; ?>
    </div>

    <div class="text-center mt-5">
        <input class="btn btn-warning btn-lg" value="<?php echo $vtxt['search_by_brand_button'] ?>" type="button" />
    </div>

    <!--======= Navigation Buttons =========-->
    <!--======= Left Button =========-->
    <a class="carousel-control-prev gp_products_carousel_control_left" href="#brand_slider" data-slide="prev">
        <span class="fas fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>

    <!--======= Right Button =========-->
    <a class="carousel-control-next gp_products_carousel_control_right" href="#brand_slider" data-slide="next">
        <span class="fas fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>


</div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL BRANDS *-*-*-*-*-*-*-*-*-*-->






<!-- ------------------------------------------------------------------------------ -->
<!--*-*-*-*-*-*-*-*-*-*- BOOTSTRAP CAROUSEL - SEARCH BY CATEGORY *-*-*-*-*-*-*-*-*-*-->
<!-- ------------------------------------------------------------------------------ -->
<div style="background:#FFFFFF;" id="category_slider" class="carousel slide gp_products_carousel_wrapper swipe_x ps_easeOutCirc" data-ride="carousel" data-duration="2000" data-interval="50000" data-pause="hover" data-column="6" data-m576="1" data-m768="1" data-m992="3" data-m1200="5">


    <div>
        <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['search_by_cat'] ?></div>
        <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $vtxt['search_by_cat_descr'] ?></div>
        <hr class="carousel_header_hr" >
    </div>


    <!--========= Wrapper for slides =========-->
    <div class="carousel-inner" role="listbox">

        <?php echo $html_categories_slider; ?>

    </div>
    <!--======= Navigation Buttons =========-->

    <!--======= Left Button =========-->
    <a class="carousel-control-prev gp_products_carousel_control_left" href="#category_slider" data-slide="prev">
        <span class="fas fa-angle-left gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>

    <!--======= Right Button =========-->
    <a class="carousel-control-next gp_products_carousel_control_right" href="#category_slider" data-slide="next">
        <span class="fas fa-angle-right gp_products_carousel_control_icons" aria-hidden="true"></span>
    </a>

</div> <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->


<!-- ------------------------------------------------------------------------------ -->
<br>
<img src="../img/pub/DISCOVER-MODULE.png" style = "width:100%" alt="pub fga" />
<br>


<!-- ------------------------------------------------------------------------------ -->
<!-- Our Products ----------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------ -->
<div>
    <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['our_products_title'] ?></div>
    <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $vtxt['our_products_descr'] ?></div>
    <hr class="carousel_header_hr" >
</div>
<br>
<br>
<br>
<br>
<div class="" style="margin-left:3vw;margin-right:3vw;">
    <div class="w-100 grid">
        <?php
        // build random list of products
        // 1. get 20 random values from the full list of products
        // 2. get images from this 20 products
        // 3. get texts from the 20 products
        // 4. build the html code
        $random_keys = array_rand($allprds, 20);
        //------------------------------------------------------------------
        // JSON dashFGA images recover
        // echo 'https://dashfga.com/prdimg.php?pid='.implode('|',$prdinode).'&key=icon';
        // NO CACHE this is random access , no option to save locally.
        //------------------------------------------------------------------
        $jsonimg = file_get_contents('https://dashfga.com/prdimg.php?key=j300&pid='.implode('|',array_values($random_keys)));
        $rndimgs = json_decode($jsonimg,true);

        //------------------------------------------------------------------
        // JSON dashFGA text recover, 36 = from products table  TEXT for prds current node and all subnodes
        // echo 'https://dashfga.com/prdtext.php?mods=305|341&prds=269|637|640&lang=EN&scrt=36';
        //    341 => 'txtproinfo',   // nkey_nnnn product name
        //    429 => 'txtprozdesc',  // short description
        //    141 => 'txtcatinfo',   // categories for products
        //    699 => 'txtproincl',   // product includes _ikey
        //    824 => 'txtqplaydesc', // quick play descr
        //    555 => 'txtprosell',   // selling points
        //    305 => 'txtprodesc',   // dkey_nnnn product description
        //    306 => 'txtotherdesc', // other description
        //    307 => 'txtpromdesc',  // awards
        //    747 => 'txtbludesc',   // 50 words blurb  _okey
        //------------------------------------------------------------------
        $jsontxt = file_get_contents('https://dashfga.com/prdtext.php?mods=305&prds='.implode('|',array_values($random_keys)).'&lang='.$lang.'&scrt=36');
        $vtxt    = array_merge($vtxt,json_decode($jsontxt,true));
        //------------------------------------------------------------------


        echo random_products($allprds,$random_keys,$rndimgs,$vtxt);

        ?>
    </div>
</div>

<?php include "footer.php"; ?>
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
<!-- Your custom scripts (optional) -->
<script type="text/javascript">
// Javascript
</script>




</body>
</html>


