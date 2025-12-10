<?php

class common{
    private static $instance;
    public $timeout = 2592000;  // (60 * 60 * 24 * 30) secs = 1 month
    function __construct() { }

    ## Singleton Method #################################
    public static function getInstance(){
        if (!isset(self::$instance)) {
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }



    /**
     *  read request and return locally if the date still valid or if the request to server is not reach
     * url = https://dashfga.com/APIcall.php?param1=aaa&param2=bbb&etc
     *
     * @param $url
     * @return string;
     */
    function file_cache_contents($url){
        $url = strtolower($url);
        list($the_url, $params) = explode('?', $url);
        $md = md5($params);
        $file = substr($the_url, strrpos($the_url, '/') + 1);
        $dir = substr($file, 0, strpos($file, '.'));

        $use_local = false;

        // file cache will be saved on
        //  ../web_cache/dir/md5file
        //----------------------------

        $local_filepath = "../web_cache/$dir/$md";

        // this will delete on folder files older than timeout
        // $this->delete_old_files($dir);
        // ---------------------------------------------------


        if (!file_exists("../web_cache/$dir")) {
            mkdir("../web_cache/$dir/", 0775, true);
        }

        if (file_exists($local_filepath)) {
            $use_local = true;
        }

        // force refresh : includes "?refresh" on url
        //                 and the call is made at the office
        //
        // only available if you are at office
        // -----------------------------------------------------
        $valid_urls = array(
            '142.116.32.60',   // westmount
            '199.168.221.243', // anjou
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $valid_urls)) {
            if (isset($_GET['refresh']) or isset($_GET['r'])) {
                $use_local = false;
                unset($_GET['refresh']);
            }
        }

        // do a request, all depends of the data we have locally
        if ($use_local) {
            $ret = file_get_contents($local_filepath);
        } else {
            $ret = file_get_contents($url);
            // a valid request, save locally
            if (!empty($ret)) {
                // recover images and save locally
                if (strpos($ret, 'https:\/\/dashfga.com\/PRDINFO') !== false) {
                    $ret = $this->cache_images($ret);
                }
                // file saved locally has reference to locally images ( and documents )
                file_put_contents($local_filepath, $ret);
                // include a log to see the relation of the codes with the urls
                $this->add_to_log($dir, $md, $url);
            }
        }
        return $ret;
    }


    /**
     * this log save all relation between the requested file and the url related
     * this is intended to see if we have fake calls or where the list grow so much
     * @param $dir
     * @param $md
     * @param $url
     * @return void
     */
    function add_to_log($dir, $md, $url)
    {
        $logfile = "../web_cache/$dir/log.txt";
        $json = array();
        if (file_exists($logfile)) {
            $json = json_decode(file_get_contents("../web_cache/$dir/log.txt"), true);
        }
        if (!isset($doc[$md])) {
            $json[$md] = $url;
            file_put_contents($logfile, json_encode($json));
        }
    }

    /**
     * read string, extract images and replace links
     *
     * @param $ret
     * @return mixed
     */
    function cache_images($ret)
    {
        $json = json_decode($ret, true);
        $sval = 'https://dashfga.com/PRDINFO';
        $ret = $this->array_recursive_search_key_map($sval, $json);
        return json_encode($ret);
    }

    /**
     * recursive search images, place locally and replace links
     * @param $needle
     * @param $haystack
     * @return mixed|void
     */
    function array_recursive_search_key_map($needle, $haystack)
    {
        foreach ($haystack as $first_level_key => $value) {
            if (is_array($value)) {
                $haystack[$first_level_key] = $this->array_recursive_search_key_map($needle, $value);
            } else { // no array , then string
                if (strpos($value, $needle) !== false) { // we catch one

                    // 1/3 get full url
                    $url = substr($value, strlen($needle)); // remove first part, not required
                    $newf = "../web_cache" . $url;
                    // 2/3 save file locally
                    $path_parts = pathinfo($url);
                    $save_path = "../web_cache" . $path_parts['dirname'];

                    // create directory if required
                    if (!is_dir($save_path)) {
                        $flag = @mkdir($save_path . "/", 0775, true);
                    }
                    // delete old file
                    if (file_exists($newf)) {
                        unlink($newf);
                    }
                    // save file on server
                    if (!@copy($value, $newf)) {
                        die("ERROR: unable to create file on " . $newf);
                    }

                    // 3/3 replace the value for local value
                    $haystack[$first_level_key] = "../web_cache" . $url;
                }
            }
        }
        return $haystack;
    }




    /** *******************************************************************************************
     * recover the link where click on image must go
     *
     * @param $fname
     * @return string
     */
    function get_img_link($fname){
        $nam   = substr($fname,0,strrpos($fname, '.'));
        //    ________________________________________
        //      01_Summer-activities_cat-23_extra-info
        //   |sort|    title        | link |  tile   |
        //   -----------------------------------------
        list($sort,$title,$link,$tile) = explode('_',$nam."___");
        list($dest,$idx,$nope)         = explode('-',$link."---");
        $dest=strtolower($dest);
        $imglink = '#.';
        switch($dest){
            case   'cat':$imglink = "categoryview.php?node=".$idx;     break;
            case 'brand':$imglink = "search_by_brand.php?brand=".$idx; break;
            case   'age':$imglink = "search_by_age.php?age=".$idx;     break;
            case  'prod':$imglink = "productview.php?pro_id=".$idx;    break;
            default:$imglink = "#$nam"; break;
        }
        return $imglink;
    }


    /** *******************************************************************************************
     *  create a carrousel on node $node lang $lang  one image or several on folder defined by path
     *  this procedure replace includes/carousel.php
     * @param $prdbanners array
     * @param $vtxt array
     */
    function get_carrousel($prdbanners,$vtxt=array())
    {

        // --------------------- no image found ---------------------------------
        if (count($prdbanners) < 1) {
            return " <p style='text-align: center'><img src='https://familygamesamerica.com/mainsite/no-image.png' alt='' /></p> \n";
        }

        // --------------------- single image found ---------------------------------
        if (count($prdbanners) === 1) {
            $imgfile  = key($prdbanners);
            $oneimg   = $prdbanners[$imgfile];
            $img_link = $this->get_img_link($imgfile);
            $md5 = filemtime($oneimg['url']);
            return "<a href='$img_link'> <img src='" . $oneimg['url'] . "?" . $md5 . "' alt='' width='100%'> </a> \n";
        }

        // -------------------- multiple images --------------------------------------
        $active = 'active'; // first one active
        $slider_counter = 0;
        foreach ($prdbanners as $fname => $oneimg) {
            $img_link = $this->get_img_link($fname);
            $md5 = filemtime($oneimg['url']);
            $top_slider_images .= "
                <div class='carousel-item $active'>
                    <a href='$img_link'><img class='d-block w-100' src='{$oneimg['url']}?{$md5}' alt='Family Games America'></a>
                </div>";
            $top_slider_indicators .= "<li data-target='#season_slider' data-slide-to='$slider_counter' class='$active'></li>\n";
            $active = '';
            $slider_counter++;
        }

    $carrousel = "
    <ol class='carousel-indicators'>
        {$top_slider_indicators}
    </ol>
    <div class='carousel-inner'>
        {$top_slider_images}
    </div>
    ";
        return $carrousel;
    }


    /**
     * remove / convert chars to be html compatible
     * @param $txt
     * @return string
     */
    function html_convert($txt){
        $ret = '';
        $find = array("\n");
        $repl = array("<br>");
        $ret  = str_replace($find,$repl,$txt);
        return $ret;
    }

}




