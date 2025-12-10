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
$age   =(isset($_GET['age'])?$_GET['age']:0);

$html_ages= '';
foreach ($ag_values as $agecode=>$agetxt){
    if(trim($age,'Y')==trim($agetxt,'+')){
        $html_ages .= "<button type='button' class='btn btn-info btn-lg'>{$agetxt}</button>\n";
    }else {
        $html_ages .= "<a href='?age={$agecode}'><button type='button' class='btn btn-light btn-lg'>{$agetxt}</button></a>\n";
    }
}

//===========================================================================================//
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>
    <style> /* tempo styles here */ </style>
</head>

<body>

<?php include "header.php"; ?>

<br>
<br>
<div class="" style="margin-left:3vw;margin-right:3vw; text-align: center;">
    <?php echo $html_ages; ?>
</div>
<br>
<div>
    <div class="w-100 mb-0 text-center carousel_header"><?php echo $vtxt['search_by_age'] ?> : <?php echo $ag_values[$age]; ?> </div>
    <div class="w-100 m-0 text-center carousel_header_sub"><?php echo $vtxt['search_by_age_descr'] ?></div>
    <hr class="carousel_header_hr" >
</div>

<br>
<br>

<div class="" style="margin-left:3vw;margin-right:3vw;">
    <div class="w-100 grid">
        <?php
        //------------------------------------------------------
        // call direct for search no web_cache please!
        // dashfga.com/prdsearch_age.php?age=09Y&node=1&lang=EN
        $jsonsrch = file_get_contents('https://dashfga.com/prdsearch_age.php?age='.$age.'&node=1');
        $sreturns = json_decode($jsonsrch,true); // array of prd_ids
        //------------------------------------------------------
        $prd_sels    = array_keys($sreturns);
        //------------------------------------------------------------------
        // JSON dashFGA images recover
        // echo 'https://dashfga.com/prdimg.php?pid='.implode('|',$prdinode).'&key=icon';
        // NO CACHE this is random access , no option to save locally.
        //------------------------------------------------------------------
        $jsonimg = file_get_contents('https://dashfga.com/prdimg.php?key=j300&pid='.implode('|',$prd_sels));
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
        $jsontxt = file_get_contents('https://dashfga.com/prdtext.php?mods=305&prds='.implode('|',$prd_sels).'&lang='.$lang.'&scrt=36');
        $vtxt    = array_merge($vtxt,json_decode($jsontxt,true));
        //------------------------------------------------------------------

        echo random_products($allprds,$prd_sels,$rndimgs,$vtxt);

        ?>
    </div>
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