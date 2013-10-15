<html>
    <head>
        <title>Auswahl</title>
        <style>
            body {
            	margin: 20px;
            	padding: 0;
            	background: #f2f2f2;
                font-family: arial;
            }
            .box {
            	border-top: 5px solid #ff9900;
            	border-left: 1px solid #ff9900;
            	border-right: 1px solid #ff9900;
                border-bottom: 1px solid #ff9900;
                /* padding: 20px 30px 20px 30px; */
                margin: 20px 20px 20px 0;
                background: #999999;
                float: left;
            }
            .box:first-of-type {
                padding: 20px 30px 20px 30px;
            }
            h2 a, h2 {
                color: #000000;
                font-size: 13px;
                 margin: 0;
                 padding: 30px;
            }
            .box h2 a { padding: 0;
                display: inline-block;
            }
            a, a:visited{
                text-decoration: none;
            }
            .box ul {
                margin-left:0;
                padding-left:0;
            }
            ul li {
                list-style-type: none;
                font-size: 11px;
                margin-left:5px;
            }
            ul li a {
                color: #000000;
            }
        </style>
    </head>

    <body>
        <div class="box" style="border-color:#999999; background: #e3e3e3;">
            <h2>Utilities</h2>
            <ul>
                <li><a href="http://localhost/MAMP/phpinfo.php">phpInfo</a></li>
                <li><a href="http://localhost/MAMP/xcache-admin/?language=English">xCache</a></li>
                <li><a href="http://localhost/MAMP/phpmyadmin.php?lang=en-iso-8859-1&language=English">phpMyAdmin</a></li>
                <li><a href="http://localhost/MAMP/English/faq.php?language=English">FAQ</a></li>
            </ul>
        </div>

        <?php

            function getDirColorHexString($cnt, $i){
                $onlyGreen = false;
                $ing = 256;
                $step = floor($ing/$cnt);
                if( $onlyGreen == false ){
                    if( $i < $cnt/2){
                        $val = dechex(($cnt-$i)*$step);
                        if( strlen($val) == 1 ) $val = '0' . $val;	
                        return '#00' . $val . '00';
                    }else{
                        $val = dechex($i*$step);
                        if( strlen($val) == 1 ) $val = '0' . $val;	
                        return '#' . $val . '0000';
                    }
                }else{
                    $val = dechex(($cnt-$i)*$step);
                    if( strlen($val) == 1 ) $val = '0' . $val;
                    return '#00' . $val . '00';
                }
            }

            $dirs = array();
            if ($handle = opendir(dirname(__FILE__))){
                while (false !== ($dir = readdir($handle))) {
                    if( is_dir($dir) && substr($dir, 0, 1) != '.' ){
                        if( array_key_exists(fileatime($dir), $dirs) ){
                            $dirs[fileatime($dir).'_'.$dir] = $dir;	
                        }else{
                            $dirs[fileatime($dir)] = $dir;
                        }
                    }
                }
            }
            closedir($handle);
            krsort($dirs);
            $i = 0;
            foreach( $dirs AS $dir ){
                $url = $dir;
                if( is_dir( $dir . '/htdocs')){
                    $url = $dir . '/htdocs';
                }
                $wp_admin = is_dir( $url . '/wp-admin') ? (' [ <a class="wp" href="' . $url . '/wp-admin">WP</a> ]') : '';
                echo '<div class="box" style="border-color: ' . getDirColorHexString(count($dirs), $i) . '"><h2><a href="/' . $url . '">' . $dir . '</a>' . $wp_admin . '</h2></div>'."\n";	
                $i++;
            }
        ?>
    </body>
</html>