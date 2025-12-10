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
$pidsel = (isset($_GET['pidsel'])?$_GET['pidsel']:''); // from the selection list
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Family Games America</title>
    <?php include "html_header.php"; ?>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


    <style> /* tempo styles here */
        #map {
            height: 35vw;
            margin-left:4vw;
            margin-right:4vw;
        }

    </style>
</head>

<?php
$page_html = '';

$prdinfo = array();
$prdimg  = "&nbsp;";

if(intval($pidsel)>0){
    //------------------------------------------------------------------
    $jsonprd = $com->file_cache_contents('https://dashfga.com/prdinfo.php?pid=' . $pidsel . '&lang=' . $lang);
    $prdinfo = json_decode($jsonprd, true);
    $prdimg  = (!empty($prdinfo['url']))?"<a href='productview.php?pro_id={$pidsel}'><img src='".$prdinfo['url']."' alt='".$prdinfo['url']."' style='position: absolute; bottom:10px;'  width='100%' /></a>":"&nbsp;";
}

if($pro_id<=0){
    global $allprds;
    $page_html = "
<br><br>
<div class=''>

    <div class='container'>
      <div class='row'>
      
        <div class='col-1'>
          {$prdimg}
        </div>
              
        <div class='col-5'>
          <div class='form-group'>
          <label for='pidsel' class='text-muted'>&nbsp;{$vtxt['store_locator_select_prd']}</label>
          <select class='selectpicker' data-width='100%' data-live-search='true' data-style='btn-info'  name='item'  id='pidsel' onchange='update_pidsel()'>
            <option value=''>..</option>\n";
    foreach($allprds as $pid=>$oneprd){
        $sel = ($pidsel==$pid)?'selected=1':'';
        if(intval($oneprd['type']) == 4 ) continue; // remove set-up products
        $page_html .="<option value='$pid' $sel>{$oneprd['name']}</option>\n ";
    }
    $page_html .= " </select>
          </div><!-- form-group -->
        </div>
        
        <div class='col-3'>
           <div class='form-group'>
             <label for='country' class='text-muted'>&nbsp; {$vtxt['store_locator_country']}</label>
             <select class='selectpicker' data-width='100%' data-live-search='true' data-style='btn-info'  name='item'  id='country' onchange='update_country()'>
                 <option value=''>..</option>
                 <option value='US' >United States</option>
                 <option value='CA' >Canada</option>
             </select>
           </div>
        </div>
        
        <div class='col-3'>
           <div class='form-group'>
             <label for='state' class='text-muted'>&nbsp;  {$vtxt['store_locator_stprov']}</label>
             <select class='selectpicker' data-width='100%' data-live-search='true' data-style='btn-info'  name='item'  id='state' onchange='update_pidsel()'>
                    <option value=''>..</option>
                    <option value='AK'>Alaska</option>
                    <option value='AL'>Alabama</option>
                    <option value='AR'>Arkansas</option>
                    <option value='AZ'>Arizona</option>
                    <option value='CA'>California</option>
                    <option value='CO'>Colorado</option>
                    <option value='CT'>Connecticut</option>
                    <option value='DC'>Washington DC</option>
                    <option value='DE'>Delaware</option>
                    <option value='FL'>Florida</option>
                    <option value='GA'>Georgia</option>
                    <option value='HI'>Hawaii</option>
                    <option value='IA'>Iowa</option>
                    <option value='ID'>Idaho</option>
                    <option value='IL'>Illinois</option>
                    <option value='IN'>Indiana</option>
                    <option value='KS'>Kansas</option>
                    <option value='KY'>Kentucky</option>
                    <option value='LA'>Louisiana</option>
                    <option value='MA'>Massachusetts</option>
                    <option value='MD'>Maryland</option>
                    <option value='ME'>Maine</option>
                    <option value='MI'>Michigan</option>
                    <option value='MN'>Minnesota</option>
                    <option value='MO'>Missouri</option>
                    <option value='MS'>Mississippi</option>
                    <option value='MT'>Montana</option>
                    <option value='NC'>North Carolina</option>
                    <option value='ND'>North Dakota</option>
                    <option value='NE'>Nebraska</option>
                    <option value='NH'>New Hampshire</option>
                    <option value='NJ'>New Jersey</option>
                    <option value='NM'>New Mexico</option>
                    <option value='NV'>Nevada</option>
                    <option value='NY'>New York</option>
                    <option value='OH'>Ohio</option>
                    <option value='OK'>Oklahoma</option>
                    <option value='OR'>Oregon</option>
                    <option value='PA'>Pennsylvania</option>
                    <option value='PR'>Puerto Rico</option>
                    <option value='RI'>Rhode Island</option>
                    <option value='SC'>South Carolina</option>
                    <option value='SD'>South Dakota</option>
                    <option value='TN'>Tennessee</option>
                    <option value='TX'>Texas</option>
                    <option value='UT'>Utah</option>
                    <option value='VA'>Virginia</option>
                    <option value='VI'>Virgin Islands</option>
                    <option value='VT'>Vermont</option>
                    <option value='WA'>Washington</option>
                    <option value='WI'>Wisconsin</option>
                    <option value='WV'>West Virginia</option>
                    <option value='WY'>Wyoming</option>
                    <option value='AB'>Alberta</option>
                    <option value='BC'>British Columbia</option>
                    <option value='MB'>Manitoba</option>
                    <option value='NB'>New Brunswick</option>
                    <option value='NL'>Newfoundland and Labrador</option>
                    <option value='NS'>Nova Scotia</option>
                    <option value='NT'>Northwest Territories</option>
                    <option value='NU'>Nunavut</option>
                    <option value='ON'>Ontario</option>
                    <option value='PE'>Prince Edward Island</option>
                    <option value='QC'>Quebec</option>
                    <option value='SK'>Saskatchewan</option>
                    <option value='YT'>Yukon</option>
             </select>
           </div>
        </div>
        
      </div><!-- row -->
    </div> <!-- container -->
 </div> <!-- border gap container --> \n";

}
?>

<body>

<?php include "header.php"; ?>

<?php print $page_html; ?>

<div id="map"></div>

<div  class='' style='margin-left:3vw;margin-right:3vw;'>
    <div id="relatives"></div>
    <table class="table" id='locs'>
        <thead>
        <tr>
            <th> #</th>
            <th><?php echo $vtxt['store_locator_store']; ?></th>
            <th><?php echo $vtxt['store_locator_addr']; ?></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!--
 The `defer` attribute causes the callback to execute after the full HTML
 document has been parsed. For non-blocking uses, avoiding race conditions,
 and consistent behavior across browsers, consider loading using Promises
 with https://www.npmjs.com/package/@googlemaps/js-api-loader.
-->
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnDx-VpRl8Ab-BByCk69UNoKKssBSu7o4&callback=initMap&v=weekly"
        defer
></script>


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
    var getpidsel  = '<?php echo (isset($_GET['pidsel'])?$_GET['pidsel']:''); ?>';
    var getcountry = '<?php echo (isset($_GET['co'])?$_GET['co']:''); ?>';
    var getstate   = '<?php echo (isset($_GET['st'])?$_GET['st']:''); ?>';
    var getrelated = '<?php echo trim($prdinfo['related_prds'],', '); ?>';
    var inilat = 37.090240;
    var inilon = -95.712891;
    var inzoom = 12;
    const pin_red    = "https://www.familygamesamerica.com/newsite/img/pin-red.png";
    const pin_orange = "https://www.familygamesamerica.com/newsite/img/pin-orange.png";

    // Javascript
    $(document).ready(function(){
        // update selected options

        let can_arr      = 'AB BC MB NB NL NS NT NU ON PE QC SK YT';
        let is_can_prov  = (can_arr.indexOf(getstate)>0);


        $('#country').val(getcountry);
        // you have a canadian prov
        if((is_can_prov)&&(getstate!=='')){
            $('#country').val('CA');
        }else if (getstate!==''){ // you hae us state
            $('#country').val('US');
        }

        $('#state').val(getstate);
        $('.selectpicker').selectpicker('refresh');
        // update store locator map using the info received.

        $.getJSON('https://dashfga.com/prdstore.php?pid=' + getpidsel + '&st=' + getstate + '&co=' + getcountry + '&lang=EN&callback=?', function (data) {
            let lnkrel = false;
            if (typeof data.sites !== 'undefined'){
                if (data.sites.length < 10 ) lnkrel = true;
            }else{
                lnkrel = true;
            }
            if(lnkrel){
                //alert('rel='+getrelated);
                $('#relatives').html("<small><a href='#' onclick=\"store_relatives('"+getrelated+"','"+getstate+"','"+getcountry+"')\"><?php echo $vtxt['store_locator_more_results'];?></a></small>");
            }

            window.initMap = initMap(data);
            // too few answers, please show related products as well
        });



    });

    // if user change the country, set state as empty
    function update_country(){
        $('#state').val('');
        $('.selectpicker').selectpicker('refresh');
        update_pidsel();
    }

function update_pidsel(){
    let pidsel  = $('#pidsel' );
    let country = $('#country');
    let state   = $('#state'  );
    let loc     = window.location;
    window.location = loc.protocol + '//' + loc.host + loc.pathname +"?pidsel="+pidsel.val()+'&co='+country.val()+'&st='+state.val();
}


/* GOOGLE MAPS */
    let map;

    function initMap(data) {
        inia = data.stprov.lat;
        inib = data.stprov.lon;
        iniz = data.stprov.zoom;

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: iniz,
            center: new google.maps.LatLng(inia,inib),
            mapTypeId: "terrain",
        });

        let address = "";
        let store   = "";
        let contador= 1;
        for(let i=0;i<data.sites.length; i++){
            address = data.sites[i].address.trim() + ", "+data.sites[i].city.trim()+", "+data.sites[i].state.trim();
            address = address.replace(/ /g,"+");
            store   = data.sites[i].store;
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyDnDx-VpRl8Ab-BByCk69UNoKKssBSu7o4', function (gdata) {
                if(gdata.status==="OK"){
                    let lat = gdata.results[0].geometry.location.lat;
                    let lon = gdata.results[0].geometry.location.lng;
                    let sto = data.sites[i].store;
                    let adr = gdata.results[0].formatted_address;

                    const latLng = new google.maps.LatLng(lat, lon);
                    new google.maps.Marker({
                        position: latLng,
                        title:sto,
                        label:""+contador,
                        map: map,
                        icon:pin_red
                    });
                    $('#locs tbody').append("<tr><td> "+contador+"</td><td>"+sto+"</td><td>"+adr+"</td></tr>");
                    contador++;
                }
            });

        }
        //add places on map




    }


function store_relatives(pidlist,state,country){

 $.getJSON('https://dashfga.com/prdstore.php?pid=' + pidlist + '&st=' + state + '&co=' + country + '&lang=EN&callback=?', function (data) {
     contador = 1;
     addrlist = [];
     // count current values
     $('#locs tbody').find('tr').each(function(){
         addrlist.push($(this).find('td:eq(2)').html());
         contador++;
     });
     // alert(JSON.stringify(addrlist));

     for(let i=0;i<data.sites.length; i++){
         address = data.sites[i].address.trim() + ", "+data.sites[i].city.trim()+", "+data.sites[i].state.trim();
         address = address.replace(/ /g,"+");
         store   = data.sites[i].store;

         $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyDnDx-VpRl8Ab-BByCk69UNoKKssBSu7o4', function (gdata) {
             if(gdata.status==="OK"){
                 let lat = gdata.results[0].geometry.location.lat;
                 let lon = gdata.results[0].geometry.location.lng;
                 let sto = data.sites[i].store;
                 let adr = gdata.results[0].formatted_address;

                 if (addrlist.includes(adr)) {
                     // already on system
                 }else {
                     const latLng = new google.maps.LatLng(lat, lon);
                     new google.maps.Marker({
                         position: latLng,
                         title: sto,
                         label: "" + contador,
                         map: map,
                         icon: pin_orange
                     });
                     $('#locs tbody').append("<tr><td class='text-warning'> " + contador + "</td><td>" + sto + "</td><td>" + adr + "</td></tr>");
                     contador++;
                 }
             }
         });

     }
 });

}

</script>


</body>
</html>
