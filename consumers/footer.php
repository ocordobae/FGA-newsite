<?php
global $allprds;
global $wbrands;
global $com;
global $vtxt;
//--------------------------------------------------
$html_footer_brands = " <ul class='footer_menu'> \n";
foreach ($wbrands as $brandcode => $brandinfo){
    $html_footer_brands .= "<li><a href=\"search_by_brand.php?brand={$brandcode}\">{$brandinfo['name']}</a></li>\n";
}
$html_footer_brands .= "</ul>\n";


/**
 * @param $allprds
 * @param $random_keys
 * @param $images
 * @return string
 */
function quick_products($allprds,$random_keys,$images){
    $html = '';
    foreach($random_keys as $i=>$pid){
        $element = $allprds[$pid];
        $html .= " <div class='grid-item'><a href='productview.php?pro_id={$pid}'><img src='".$images[$pid]['url']."' alt='' title='".urldecode($element['name'])."'></a></div> \n";
    }
    return $html;
}
// replace  old $vtxt['footer_new_releases_prds']
function coming_soon(){
    global $com,$allprds;
    $jsonprds = $com->file_cache_contents('https://dashfga.com/prdinnode.php?node=348');
    $prdinode = json_decode($jsonprds,true); // array(34,456,767,78);
    foreach ($prdinode as $pid){
        $element = $allprds[$pid];
        $html .= "<a style='color:#FFFFFF;' href='productview.php?pro_id={$pid}'>".$element['name']."</a><br>\n";
    }
    return $html;
}


?>
<!-- Footer logo need this br's -->
<br>
<br>
<br>
<br>
<br>
<div class="container-fluid d-block w-100 footer-info" style="background-image: url('../img/nav/footer_background.png'); background-repeat: no-repeat; ">
    <div class="row text-center" style="margin-bottom:100px;">
        <img src="../img/fga_logo_footer.png" alt="Family Games America" style="margin:-80px auto; width:22vh; height: 18vh;"/>
    </div>
    <div class="row" style="padding-bottom: 30px;">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
            <B> <?php echo $vtxt['footer_quick_links'] ?></B>
            <hr style="background-color:#FFFFFF">
            <ul class="footer_menu">
                <li><a href="../consumers/index.php"><?php echo $vtxt['footer_home'] ?></a></li>
                <li><a href="../consumers/index.php#ages_slider"><?php echo $vtxt['footer_age'] ?></a></li>
                <li><a href="../consumers/index.php#category_slider"><?php echo $vtxt['footer_cat'] ?></a></li>
                <li><a href="#"><?php echo $vtxt['footer_new_releases'] ?></a></li>
                <li><a href="../consumers/index.php#brand_slider"><?php echo $vtxt['footer_brands'] ?></a></li>
                <li><a href="#"><?php echo $vtxt['footer_about_us'] ?></a></li>
                <li><a href="#"><?php echo $vtxt['footer_contact_us'] ?></a></li>
            </ul>
            <b><?php echo $vtxt['footer_brands'] ?></b>
            <hr style="background-color:#FFFFFF">
            <?php echo $html_footer_brands; ?>

        </div>
        <div class="col-md-3">
            <b><?php echo $vtxt['footer_quick_prds'] ?></b>
            <hr style="background-color:#FF0000">
            <div class="grid-container" >
                <?php
                $random_keys = rand_prods(12); // get 12 random products, change each hour
                $jsonimg     = $com->file_cache_contents('https://dashfga.com/prdimg.php?key=j75&pid='.implode('|',array_values($random_keys)),3600); // refresh each hour
                $rndimgs     = json_decode($jsonimg,true);
                echo quick_products($allprds,$random_keys,$rndimgs);
                ?>
            </div>
        </div>

        <div class="col-md-3">
            <b><?php echo $vtxt['footer_b2b_title'] ?></b>
            <hr style="background-color:#FF0000">
            <p class="footer_p">
                <?php echo $vtxt['footer_b2b_descr'] ?>
            </p>
            <br>
            <b><?php echo $vtxt['footer_new_releases_title'] ?></b>
            <hr style="background-color:#FF0000">
            <div style="width: 100%; height:220px; overflow-y: auto; overflow-x: hidden; font-size: 90%;">
                <?php echo coming_soon(); ?>
            </div>
        </div>

        <div class="col-md-2">
            <b><?php echo $vtxt['footer_contact_info_title'] ?></b>
            <hr style="background-color:#FF0000">
            <p class="footer_p">
                <?php echo $vtxt['footer_contact_info_descr'] ?>
            </p>
            <br>
            <b><?php // echo $vtxt['footer_subscribe_newsletter']?></b>
            <br>
            <!-- small><a href="#">here</a></small -->
        </div>
        <div class="col-md-1">
        </div>
    </div>
</div>
<!-- colorful YELLOW ENDBAR -->
<div class="w-100 text-center" style="line-height: 1; font-size: 80%; height:40px; background: url('../img/nav/bottom.png'); background-repeat: repeat-x; padding-top:15px;"> ALL RIGHT RESERVED &middot; FAMILY GAMES AMERICA FGA INC&reg; &middot; 1987 - 2022 </div>

<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>

<!-- header / footer scripts -->
<script type="text/javascript">

    $(document).ready(function () {
        /*
        // show menu automatically on mouse over the text
        $('.navbar-light .dmenu').hover(function () {
            $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
        }, function () {
            $(this).find('.sm-menu').first().stop(true, true).slideUp(105)
        });

         */
    });

    $(document).ready(function() {
        $(".megamenu").on("click", function(e) {
            e.stopPropagation();
        });
    });

</script>