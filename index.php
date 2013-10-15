<html>
    <head>
        <title>Auswahl</title>
        <link rel="stylesheet" href="./index.light.css" type="text/css">
    </head>

    <body>
        <div class="utility box">
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
                $onlyGreen = true;
                $ing = 256;
                $step = floor($ing/$cnt);
                if( $onlyGreen == false ){
                    if( $i < $cnt/2){
                        (string)$val = dechex(($cnt-$i)*$step);
                        if( $i === 0 ) $val = 'FF';
                        if( strlen($val) === 1 ) $val = '0' . $val;
                        return '#00' . $val . '00';
                    }else{
                        (string)$val = dechex($i*$step);
                        if( $i === ($cnt-1) ) $val = 'FF';
                        if( strlen($val) === 1 ) $val = '0' . $val;
                        return '#' . $val . '0000';
                    }
                }else{
                    (string)$val = dechex(($cnt-$i)*$step);
					if( $i === 0 ) $val = 'FF';
					if( $i === ($cnt-1) ) $val = '00';
                    if( strlen($val) === 1 ) $val = '0' . $val;
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
                $wp_admin = is_dir( $url . '/wp-admin') ? (' [<a class="wp" href="' . $url . '/wp-admin">WP</a>]') : '';
                echo '<div class="box" style="border-color: ' . getDirColorHexString(count($dirs), $i) . '"><h2><a href="/' . $url . '">' . $dir . '</a>' . $wp_admin . '</h2></div>'."\n";
                $i++;
            }
        ?>
    </body>
</html>