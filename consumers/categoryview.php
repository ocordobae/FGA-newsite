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


//------------------------------------------------------------------
// JSON dashFGA breadcrumb in node
//
//------------------------------------------------------------------
$jsonbc = $com->file_cache_contents('https://dashfga.com/prdbreadcrumb.php?node='.$node."&lang=".$lang);
$breadc = json_decode($jsonbc,true);
//------------------------------------------------------------------
$breadcrum_html = get_breadcrum($breadc);


//===========================================================================================//
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>
    <style>
        a.catdef { color:#555555; display:inline-block; font-size: small;}
        a.catsel { border-bottom: solid 2px #FF0000; font-weight:600;}
        a.subcatsel { font-weight:bold; color:red;}
        .redline{width: 5vw; height:3px; background: red; margin-bottom: 10px;}
        .titleop{letter-spacing: 2.5px; font-weight: 800; font-size: 1.5vw; color:#444444; }
    </style>
</head>

<body>

<?php include "header.php"; ?>

<?php
/** using images for each category
    $header_cat ='';
        $file = "../img/categories/node_{$node}_".$lang.".jpg";
        $md5  = filemtime($file);
    $header_cat = "<div style=\"width:100%; height:12vw; background-image: url('{$file}?{$md5}'); background-size: 100% 100%; \"></div>";
*/

$header_cat ='';
$file = "../img/nav/catalog.jpg";
$md5  = filemtime($file);
$header_cat =
 " <div style=\"width:100%; height:10vw; background-image: url('{$file}?{$md5}'); background-size: 100% 100%; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 3vw;letter-spacing: 3px;padding-top:1.5vw; \">
     <!-- OUR CATALOG --> 
     <div style='font-size: 0.9vw;'> <!-- ALL PRODUCTS --> </div>
   </div>";


    echo $header_cat;
?>

<br>

<div class="mx-5">
    <!--
    <h2 class="titleop">
    <?php echo $vtxt['our_products_2lines']; ?>
    </h2>
    <div class="redline"></div>
    -->
<br>
    <?php

    $prdinode = array();

    // recover the parent node of current selected node
    // 1st level : parent = $consumer_node =1
    // 2st level : parent = node of 1st level
    $parent_sel = $node;
    foreach ($prdtrees as $one_arr){
        foreach($one_arr as $itr2 => $one_xnode) {
            if ($one_xnode['node'] == $node) {  // when parent is the same as current parent
                $parent_sel = $one_xnode['parent'];
            }
        }
    }
    // echo "node=[$node] parent sel =[$parent_sel]<br>";
    // $consumers_node = 1  = root

    if(($parent_sel == $node)||($parent_sel=='-1')){ // invalid node or root node
        // maybe a message like : please select a category to see products
    }else{ // 2nd level node
        $html_text_subcategories ="<div class='w-100'>\n    "; // leave spaces
        $usenode = ($parent_sel==$consumers_node)?$node:$parent_sel;
        foreach($prdtrees[$usenode] as $itr =>$one_subnode) {
            $act ='';
            if ($node==$one_subnode['node']) {$act = 'subcatsel';}
            $html_text_subcategories .=" <a href='categoryview.php?node={$one_subnode['node']}' class='{$act} catdef'>{$one_subnode['value']}</a> |\n";
        }
        $html_text_subcategories = substr($html_text_subcategories,0,-3);
        $html_text_subcategories .="</div> \n";
        //------------------------------------------------------------------
        $html_box_subcategories ="<div class='btn-group text-sm-center' role='group' aria-label='subcat levels'>\n    "; // leave spaces
        $usenode = ($parent_sel==$consumers_node)?$node:$parent_sel;
        foreach($prdtrees[$usenode] as $itr =>$one_subnode) {
            $act ='btn-light';$col='#555555;';
            if ($node==$one_subnode['node']) {$act = 'btn-info'; $col='#FAFAFA;';}
            $html_box_subcategories .="<a type='button' class='btn {$act}' style='text-transform: none;  color:{$col}' href='categoryview.php?node={$one_subnode['node']}'>{$one_subnode['value']}</a>\n";
        }
        $html_box_subcategories .="</div> \n";
        //------------------------------------------------------------------
        // JSON dashFGA products in node
        // note : when you are in a main node, it return empty, because we dont have product and nodes mixed.
        //------------------------------------------------------------------
        $jsonprds = $com->file_cache_contents('https://dashfga.com/prdinnode.php?node='.$node);
        $prdinode = json_decode($jsonprds,true); // array(34,456,767,78); because 1 single node
        //------------------------------------------------------------------
    }
    // print subcategories ( if cat selected) bold on selected

        // print all main categories, bold on the category selected
        $html_text_categories ="<div class='w-100'>\n    "; // leave spaces
        foreach($prdtrees[$consumers_node] as $cont => $onenode){
            // it will be red if you are in category or in a child
            $act= '';
            if(($onenode['node']==$node)||($onenode['node']==$parent_sel)){ $act = 'catsel'; }// parent node selected
            // if parent
            $html_text_categories .=" <a href='categoryview.php?node={$onenode['node']}' class='{$act} catdef' >{$onenode['value']}</a> |\n";
        }
        $html_text_categories = substr($html_text_categories,0,-3);
        $html_text_categories .="</div> \n";
        echo $html_text_categories;

        echo "<br>\n";


        //echo $html_text_subcategories;
        echo $html_box_subcategories;
        ?>


</div>


<br>
<br>
<div class="w-100 grid px-5">
<?php
    //------------------------------------------------------------------
    // JSON dashFGA images recover
    // echo 'https://dashfga.com/prdimg.php?pid='.implode('|',$prdinode).'&key=icon';
    // NO CACHE this is random access , no option to save locally.
    //------------------------------------------------------------------
    $jsonimg = file_get_contents('https://dashfga.com/prdimg.php?key=j300&pid='.implode('|',$prdinode));
    $rndimgs = json_decode($jsonimg,true);

    //------------------------------------------------------------------
    // JSON dashFGA text recover, 36 = from products table  TEXT for prds current node and all subnodes
    // echo 'https://dashfga.com/prdtext.php?mods=305|341&prds=269|637|640&lang=EN&scrt=36';
    //    341 => 'txtproinfo',   // nkey_nnnn product name
    //    429 => 'txtprozdesc',  // short description
    //    141 => 'txtcatinfo',
    //    699 => 'txtproincl',   // product includes
    //    824 => 'txtqplaydesc', // quick play descr
    //    555 => 'txtprosell',   // selling points
    //    305 => 'txtprodesc',   // dkey_nnnn product description
    //    306 => 'txtotherdesc', // other description
    //    307 => 'txtpromdesc',  // awards
    //    747 => 'txtbludesc',   //
    //------------------------------------------------------------------
    $jsontxt = file_get_contents('https://dashfga.com/prdtext.php?mods=305&prds='.implode('|',$prdinode).'&lang='.$lang.'&scrt=36');
    $vtxt    = array_merge($vtxt,json_decode($jsontxt,true));
    //------------------------------------------------------------------
    echo random_products($allprds,$prdinode,$rndimgs,$vtxt);

?>
</div>




<br><br><br>

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
<!-- Your custom scripts (optional) -->
<script type="text/javascript">
    // Javascript
</script>


</body>
</html>
