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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>

    <style> /* tempo styles here */
/* -------------------------------------------------------------------- */
    #about_video_box{
        height:500px;
        background-image: url("../img/about_us_page/banner-header-background-contact.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        z-index: 1;
        padding: 0;
    }
    #about_cream{
        z-index: 10;
        position: absolute;
        bottom:-10px;
    }
    #about_cream img{
        width: 100%;
    }
    #about_video{
        width:50%;
        height:400px;
        background-color: black;
        z-index: 5;
        position: absolute;
        top:20px;
        right: 20px;
    }
    #about_txt1{ /* distributing*/
        position: absolute;
        top:50px;
        left:30px;
        font-size: 70px;
        font-weight: bold;
        /* font-family: Verdana,Arial; */
        color: #CCCCCC;
        opacity: 0.5;
    }
        #about_txt2{ /* happiness */
            position: absolute;
            top:100px;
            left:70px;
            font-weight: bold;
            font-size: 90px;
            /* font-family: Verdana,Arial; */
            color: #CCCCCC;
            opacity: 0.5;
        }

        #about_txt3{ /* since */
            position: absolute;
            top:190px;
            left:70px;
            font-size: 50px;
            font-family: Verdana,Arial;
            color: #CCCCCC;
            opacity: 0.5;
        }

        #about_txt4{ /* 1987*/
            position: absolute;
            top:161px;
            left:196px;
            font-size: 140px;
            /* font-family: Verdana,Arial; */
            color: #CCCCCC;
            opacity: 0.5;
            font-weight: bold;
        }
/* -------------------------------------------------------------------- */
        #about_global_box{
            position: relative;
            z-index: 1;
        }
        #about_global_head{
            text-align: center;
            color:#BB0B0B;
        }
        #about_global_title{
            text-align: center;
            font-size: 50px;
            font-weight: bold;
        }
        #about_global_image{
            width: 30%;
            position: absolute;
            top:10px;
            right:50px;
            z-index: 5;
            text-align: right;
        }
        #button_cata{
            background-color: #BB0B0B;
            border-radius: 25px;
            padding:.5rem 0.65rem;
            text-transform: none;
            font-size: 90%;
        }
        #blabla1{
            color:#BB0B0B;
            font-size: 80%;
            text-transform: uppercase;
        }
        #blabla2{
            font-size: 30px;
            font-weight: bold;
        }
        #blabla3{
            font-size: 120%;
            color: #666;
        }
/* -------------------------------------------------------------------- */
        #wwyou_box{
            background-color:#2C4263;
            color:#FFFFFF;
            position:relative;
        }
        #wwyou_proud{
            font-size: 70%;
            color:#CCCCCC;
        }

    </style>
</head>


<body>

<?php include "header.php"; ?>

<!-- ------------------------------------------------------------------ -->
<!-- ABOUT US VIDEITO ------------------------------------------------- -->
<!-- ------------------------------------------------------------------ -->
<div id="about_video_box" class="container-fluid d-block w-100">
    <div id="about_video">video here</div>
    <div id="about_txt1">Distributing</div>
    <div id="about_txt2">Happiness</div>
    <div id="about_txt3">Since</div>
    <div id="about_txt4">1987</div>
    <div id="about_cream" class="w100">
       <img src="../img/about_us_page/banner-header-background-contact-over-separation.png" alt=""/>
    </div>
</div>

<!-- ------------------------------------------------------------------ -->
<!-- ABOUT US global image -------------------------------------------- -->
<!-- ------------------------------------------------------------------ -->
<div id="about_global_box" class="container-fluid d-block w-100">
    <div id="about_global_head" class="w-100">Happiness again</div>
    <div id="about_global_title" class="w-100">About Us</div>
    <div id="about_global_image"><img src="../img/about_us_page/group_461.png" alt=""  style="width: 200px;"></div>
    <table class="w-100" style="position: relative; z-index: 10;">
        <tr>
            <td style="width: 10%">&nbsp;</td>
            <td style="width: 40%"><img src="../img/about_us_page/contact-vector.jpg" alt=""></td>
            <td style="width: 40%; vertical-align: text-top;">
                <div id="blabla1">JUST A CONSULTANCY</div>
                <div id="blabla2">WE ARE WORKING AROUND THE CLOCK BLA BLA BLAL Y MAS BLA BLA BLA BLA PUFF TOY INDUSTRY</div>
                <div id="blabla3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                <a href='#'><button class="btn btn-danger" type="button" id="button_cata"><small>Check our catalog</small> &nbsp; <i style="color:#DB1E1E" class="fas fa-circle"></i></button></a>
            </td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
    </table>
</div>

<!-- ------------------------------------------------------------------ -->
<!-- WE WANT YOU !         -------------------------------------------- -->
<!-- ------------------------------------------------------------------ -->
<div id="wwyou_box" class="container-fluid d-block w-100 text-center">
    <br>
    <br>
    <br>
    <small>Ready to Start with Us?</small>
    <h4>We want to wrok with yuyu </h4>
    <br>
    <p id="wwyou_proud">
    were really product bla bla bla bla bla bla blalb alb and bla bla lbla
    </p>
</div>


<!-- ########################################################################################## -->
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


    });


</script>


</body>
</html>
