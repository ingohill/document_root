<?php

	clearstatcache();
	$dirs = array();
    if ($handle = opendir($_SERVER['DOCUMENT_ROOT'])){
        while (false !== ($dir = readdir($handle))) {
            if( is_dir($dir) && substr($dir, 0, 1) != '.' ){
                $pos = fileatime($dir);
                do{
                    $pos--;
                } while( array_key_exists($pos, $dirs ));

                $url = $dir;
                if( is_dir( $dir . '/htdocs')){
                    $url = $dir . '/htdocs';
                }
                $wp_admin = is_dir( $url . '/wp-admin') ? (' [<a href="' . $url . '/wp-admin">WP</a>]') : '';

                $dirs[$pos] = array(
                    'dir'  => $dir,
                    'wp'   => $wp_admin,
                    'mage' => '',
                    'url'  => $url
                );
            }
        }
    }
    closedir($handle);
    krsort($dirs);

?>
<html>
    <head>
        <title>Auswahl</title>
        <script type="text/javascript">

            function setColor(color, id){
                document.getElementById( id ).style.borderColor = color;
            }

            function setDirColorHexString(cnt, i, id)
            {
                var mode = get_value('mode');

                var ing = 256;
                var step = Math.floor(ing/cnt);

                switch( mode )
                {
        			case "blue":
                        setColor('#0000FF', id);
        				break;
        			case "green":
                        setColor('#00FF00', id);
        				break;
        			case "red":
                        setColor('#FF0000', id);
        				break;
        			default:
        			case "black":
                        setColor('#000000', id);
        				break;
        			case "grey":
                        setColor('#a0a0a0', id);
        				break;
        			case "white":
                        setColor('#FFFFFF', id);
        				break;
        			case "greenred":
                        if( i < (cnt/2))
                        {
        	                var val = ((cnt-i)*step).toString(16);
            	            if( i === 0 ) val = 'FF';
                	        if( val.length === 1 ) val = '0' + val;
                            setColor('#00' + val + '00', id);
                        }else
                        {
        	                val = (i*step).toString(16);
            	            if( i === (cnt-1) ) val = 'FF';
                	        if( val.length === 1 ) val = '0' + val;
                            setColor('#' + val + '0000', id);
                        }
        				break;
        			case "greenblack":
            	        var val = ((cnt-i)*step).toString(16);
        				if( i === 0 ) val = 'FF';
        				if( i === (cnt-1) ) val = '00';
                        if( val.length === 1 ) val = '0' + val;
                        setColor('#00' + val + '00', id);
        				break;
        			case "whiteblack":
                        val = ((cnt-i)*step).toString(16);
        				if( i === 0 ) val = 'FF';
        				if( i === (cnt-1) ) val = '00';
            	        if( val.length === 1 ) val = '0' + val;
                	    setColor('#' + val + val + val, id);
        				break;
        			case "blackwhite":
                        var val = ((i)*step).toString(16);
        				if( i === 0 ) val = '00';
        				if( i === (cnt-1) ) val = 'FF';
            	        if( val.length === 1 ) val = '0' + val;
                	    setColor('#' + val + val + val, id);
                        break;
                }
            }

            function set_value(key,value)
            {
                localStorage.setItem(key, value);
            }

            function get_value(key) {
                return localStorage.getItem(key);
            }

            function delete_value(key) {
                localStorage.removeItem(key);
            }

            if( get_value('style') == ''||get_value('style') == null ){
                set_value('style', 'light' );
            }

            if( get_value('fontsize') == ''||get_value('fontsize') == null ){
                set_value('fontsize', 'medium' );
            }
            if( get_value('mode') == ''||get_value('mode') == null ){
                set_value('mode', 'greenblack' );
            }
            if( get_value('settings') == ''||get_value('settings') == null ){
                set_value('settings', true );
            }

            var style    = get_value('style');
            var fontsize = get_value('fontsize');
            var mode     = get_value('mode');
            var settings = get_value('settings');


        </script>
    </head>

    <body id="body" class="">
        <noscript>
            <link rel="stylesheet" href="./index.light.css" type="text/css">
        </noscript>
        <script type="text/javascript">
            document.write('<link rel="stylesheet" href="./index.' + style + '.css" type="text/css">');
        </script>
        <div class="utility box" id="utility"">
            <h2>Helferlein</h2>
            <ul>
                <li><a href="http://localhost/MAMP/phpinfo.php">phpInfo</a></li>
                <li><a href="http://localhost/MAMP/xcache-admin/?language=English">xCache</a></li>
                <li><a href="http://localhost/MAMP/phpmyadmin.php?lang=en-iso-8859-1&language=English">phpMyAdmin</a></li>
                <li><a href="http://localhost/MAMP/English/faq.php?language=English">FAQ</a></li>
            </ul>
            <a onclick="set_value('settings', false);window.location.reload()" id="closeSettings" style="cursor: pointer">- Optionen</a>
            <a onclick="set_value('settings', true);window.location.reload()" id="openSettings" style="cursor: pointer">+ Optionen</a>
            <div id="settings" style="margin-top: 10px;">
                <h3>Hintergund</h3>
                <ul class="select">
                    <li>
                        <select name="" onchange="if(this.value!=''){set_value('style', this.value);window.location.reload();}">
                            <option value="">Bitte w&auml;hlen</option>
                            <option value="light">Hell</option>
                            <option value="dark">Dunkel</option>
                            <option value="fancy">Modern</option>
                        </select>
                    </li>
                </ul>
                <h3>Farben</h3>
                <ul class="select">
                    <li>
                        <select name="" onchange="if(this.value!=''){set_value('mode', this.value);window.location.reload();}">
                            <option value="">Bitte w&auml;hlen</option>
                            <option value="blue">Blau</option>
                            <option value="grey">Grau</option>
                            <option value="green">Gr&uuml;n</option>
                            <option value="red">Rot</option>
                            <option value="black">Schwarz</option>
                            <option value="white">Wei&szlig;</option>
                            <option value="greenred">Gr&uuml;n > Rot</option>
                            <option value="greenblack">Gr&uuml;n > Schwarz</option>
                            <option value="blackwhite">Schwarz > Wei&szlig;</option>
                            <option value="whiteblack">Wei&szlig; > Schwarz</option>
                        </select>
                    </li>
                </ul>
                <h3>Schriftgr&ouml;&szlig;e</h3>
                <ul class="select">
                    <li>
                        <select name="" onchange="if(this.value!=''){set_value('fontsize', this.value);window.location.reload();}">
                            <option value="">Bitte w&auml;hlen</option>
                            <option value="small">Klein</option>
                            <option value="medium">Mittel</option>
                            <option value="big">Gro&szlig;</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>

		<?php
            $ids   = array();
            $ids[] = 'utility';
            foreach( $dirs AS $key=>$item ){
                $ids[] = $key;
                echo '<div class="box" id="' . $key . '"><h2><a href="/' . $item['url'] . '">' . $item['dir'] . '</a>' . $item['wp'] . '</h2></div>'."\n";
            }
        ?>
        <script>
            var dircnt = <?php echo count($dirs); ?>;
            var ids    = new Array('<?php echo join("','", $ids); ?>');
            init();

            function init(){
                if( get_value('settings') == "true"){
                    document.getElementById("settings").style.display = 'block';
                    document.getElementById("openSettings").style.display = 'none';
                    document.getElementById("closeSettings").style.display = 'block';
                }
                else{
                    document.getElementById("settings").style.display = 'none';
                    document.getElementById("openSettings").style.display = 'block';
                    document.getElementById("closeSettings").style.display = 'none';
                }
                document.getElementById("body").setAttribute("class", get_value('fontsize'));
                for(i=0;i<ids.length;i++){
                    setDirColorHexString(dircnt, i, ids[i]);
                }
            }
        </script>
    </body>
</html>