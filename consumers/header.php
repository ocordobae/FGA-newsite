<?php

global $ag_values;
global $wbrands;
global $prdtrees;
global $consumers_node;
global $node;      // current root node
global $vtxt;
global $search;    // search typed value
global $lang;
//-------------------------- MENU AGE GROUPS -------------------------
$html_menu_ages = "<div class='dropdown-menu sm-menu' aria-labelledby='navbar_age_Dropdown'>\n";
foreach ($ag_values as $agcode => $agval){
    $html_menu_ages .= "  <a class='dropdown-item' href='search_by_age.php?age={$agcode}'>{$agval}</a>\n";
}
$html_menu_ages .= "</div>\n";


//-------------------------- MENU BRANDS -----------------------------
$html_menu_brands = "<div class='dropdown-menu sm-menu' aria-labelledby='navbar_brand_Dropdown'>\n";
foreach ($wbrands as $brandcode => $brandinfo){
    $html_menu_brands .= "  <a class='dropdown-item' href='search_by_brand.php?brand={$brandcode}'>{$brandinfo['name']}</a>\n";
}
$html_menu_brands .= "</div>\n";




//-------------------------- MENU SEASON -----------------------------
$html_seasons_dropmenu = "<div class='dropdown-menu sm-menu' aria-labelledby='navbar_season_Dropdown'>\n";
foreach($prdtrees[62] as $cont2 => $onesubnode){
    $opts   = json_decode($onesubnode['options'],true);
    $clas2  = (isset($opts['class']))?$opts['class']:"";
    $act    = ($node==$onesubnode['node'])?"class='active'":'';
    $act2   = ($node==$onesubnode['node'])?"class='{$clas2}-bkg'":"";
    $grpi[] = $onesubnode['node'];
    $html_seasons_dropmenu .= "       <a class='dropdown-item' href=\"categoryview.php?node={$onesubnode['node']}\">".trim($onesubnode['value'])."</a>\n";
}
$html_seasons_dropmenu .= "</div>\n";


//-------------------------- MENU CATEGORIES ---------------------------
$html_menu_cats = '';
$count     = 0;
foreach($prdtrees[$consumers_node] as $cont => $onenode){
    $act   = ($node==$onenode['node'])?'selected':'';
    $opcs  = json_decode($onenode['options'],true);
    $class = (isset($opcs['class']))?$opcs['class']:"";
    if($count % 3 === 0) {
        $html_menu_cats .= "\n<div data-inf='row wrap' class='col-sm-6 col-lg-3 border-right mb-4'>\n";
    }
    $html_menu_cats .= " <!-- {$count} --><h6><a href='categoryview.php?node={$onenode['node']}' class='{$opcs['class']}'>{$onenode['value']}</a></h6><hr>\n";
    foreach($prdtrees[$onenode['node']] as $cont2 => $onesubnode){
        $opts   = json_decode($onesubnode['options'],true);
        $clas2  = (isset($opts['class']))?$opts['class']:"";
        $act    = ($node==$onesubnode['node'])?"class='active'":'';
        $act2   = ($node==$onesubnode['node'])?"class='{$clas2}-bkg'":"";
        $grpi[] = $onesubnode['node'];
        $html_menu_cats .= "          <a class='dropdown-item' href=\"categoryview.php?node={$onesubnode['node']}\"><i class='fas fa-angle-right text-black-50'></i> {$onesubnode['value']}</a>\n";
    }
    $count++;
    if($count % 3 === 0 ) {
        $html_menu_cats .= "</div><!-- row wrap --> \n";
    }

}
if($count % 3 !== 0 ) {
    $html_menu_cats .= "</div><!-- force close row wrap --> \n";
}

$html_menu_cats =  $html_menu_cats. "
                            <div class='col-sm-6 col-lg-3 mb-4'>
                                <h6 class='text-black-50'>Advertisement</h6>
                                <img src='../img/pub01.png' alt='advertisement' />
                            </div>
";


?>
<!------ Include the above in your HEAD tag ---------->

<!-- navbar lang -->
<nav class="navbar navbar-light">
    <small class="text-black-80 w-60 " style="font-size: 70%;">
        <?php echo $vtxt['inquiries']; ?>
    </small>
    <small class="text-right w-40">
        <?php if(!isset($_GET['refresh'])) { $and = (empty($_GET))?'?':'&'; ?>
            <a href="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$and; ?>refresh" class="text-black-50 font-smaller"> <i class="fas fa-sync-alt"></i> </a> &nbsp;&nbsp;&nbsp;
        <?php   }    ?>

        <?php  if(strtolower($lang)=='en'){    ?>
            <a href="?lang=en" class="text-black-80 font-smaller disabled">English</a> &nbsp; &nbsp;
            <a href="?lang=fr" class="font-smaller">Français</a>
        <?php   }    ?>

        <?php  if(strtolower($lang)=='fr'){    ?>
            <a href="?lang=en" class="font-smaller">English</a> &nbsp; &nbsp;
            <a href="?lang=fr" class="text-black-80 font-smaller disabled">Français</a>
        <?php   }    ?>


    </small>
</nav>


<!-- navbar search -->
<nav class="navbar navbar-light bg-light justify-content-between">

    <a class="navbar-brand" href="../consumers/index.php"><img src="../img/fga_logo.png" alt='' style='position:absolute;z-index:100000;top:5px;left:4vw; width:150px;' /></a>
    <div class="col-md-2">

    </div>
    <div class="col-md-6 float-md-right">
        <form class="form-inline w-100" action="listview.php" method="post" id="srchform">
            <label class="sr-only" for="inlineFormInputGroup"><?php echo $vtxt['search'] ?></label>
            <div class="input-group my-4 w-100">
                <input type="text" class="form-control" name="search" id="search"  placeholder="<?php echo $vtxt['search'] ?>" style="z-index:100000;" value="<?php echo $search; ?>" onchange="document.getElementById('srchform').submit();">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2" style="background:#FF4500;color:#FFFFFF;"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <?php if( basename($_SERVER['SCRIPT_FILENAME']) != 'store_locator.php'){ ?>
            <a href='../consumers/store_locator.php' class="btn btn-warning btn-sm my-4" type="button"><i class="fas fa-map-marked-alt"></i> <?php echo $vtxt['store_locator'] ?></a>
            <a href='../consumers/b2b.php'><button class="btn btn-default btn-sm my-4" type="button">B2B</button></a>
        <?php } ?>
    </div>
</nav>

<!-- colorful widebar -->
<div class="w-100" style="line-height: 1; height:5px;"><img src="../img/nav/colorfull_widebar.png" alt="" style="vertical-align: top; width: 100%;"></div>

<!-- navbar megamenu -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background:url('../img/nav/header_menu_background.png');background-size:100% 100%; background-repeat: repeat-x;">
    <div class="container">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#mobile_nav" aria-controls="mobile_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mobile_nav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 float-md-right">
            </ul>
            <ul class="navbar-nav navbar-light">


                <li class="nav-item"><a class="nav-link" href="../consumers/index.php"><?php echo $vtxt['header_home'] ?> </a></li>


                <!--==== NAVBAR AGE OPTIONS ====-->
                <li class="nav-item dmenu dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar_age_Dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $vtxt['header_age'] ?>
                    </a>
                    <?php echo $html_menu_ages; ?>
                </li>


                <!--==== NAVBAR BRANDS OPTIONS ====-->
                <li class="nav-item dmenu dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar_brand_Dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $vtxt['header_brands'] ?>
                    </a>
                    <?php echo $html_menu_brands; ?>
                </li>


                <!--=== NAVBAR CATEGORIES =====-->
                <li class="nav-item dropdown megamenu-li dmenu">
                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $vtxt['header_category'] ?>
                    </a>
                    <div class="dropdown-menu megamenu sm-menu border-top" aria-labelledby="dropdown01">
                        <div class="row">
                            <?php echo $html_menu_cats; ?>
                        </div>
                    </div>
                </li>


                <!--=========-->
                <li class="nav-item"><a class="nav-link" href="../consumers/categoryview.php?node=348"><?php echo $vtxt['header_coming_soon'] ?></a></li>


                <!--==== NAVBAR SEASON OPTIONS ====-->
                <li class="nav-item dmenu dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar_season_Dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $vtxt['header_season'] ?>
                    </a>
                    <?php echo $html_seasons_dropmenu; ?>
                </li>

                <li class="nav-item"><a class="nav-link" href="about_us.php"><?php echo $vtxt['header_about'] ?></a></li>

                <!--========-->
                <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact Us</a></li>

            </ul>
        </div>
    </div>
</nav>




