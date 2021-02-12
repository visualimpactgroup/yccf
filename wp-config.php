<?php
# Database Configuration
define( 'DB_NAME', 'yccf' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );
define( 'DB_HOST_SLAVE', 'localhost' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         ']dm>^?TEX`|G8+RDj^9`j#q,(mvBdNsL8f^G}/NLv3-@6)kaPC*D[cXf!|.{rEi=');
define('SECURE_AUTH_KEY',  'hxf`j00n^U1|md1P;-;;}}1L4MaFpL-paVd6Y`xPCD-F^Z+f#+:h#5x:FVWg+$Zf');
define('LOGGED_IN_KEY',    'K^m@gm!-Qc,V|=)D>JIqPPO*E;5_lHfp>-b`kdff2.{E+3CnHd.|UjzY1IuJT%+I');
define('NONCE_KEY',        'E7R;p@J}D@l80~+-|qkpxo).~&|6n`p&K4>&}AFY0RGS0!}%[|^$!,?0@(f > 5p');
define('AUTH_SALT',        '#74QI51`%81lbpAr;$!.c&n1b;QO|rd/<%5]^!9bh)o7WZ{tSm]y=fM0/]>d`2x*');
define('SECURE_AUTH_SALT', '2rX^*wVHVO}=+*D}D{FDH(ZrZJEjX tmQEYM5;:hzDW-R]&mJRRXCCz5Wkg][.X;');
define('LOGGED_IN_SALT',   'V+/BX`T+ZLv&TZ{6d+W#kNpCEFfk<Wdux+Z4rlx!#Sw9~WGoEjdvlospS>vB_}E=');
define('NONCE_SALT',       'r56z?r@_-|{jxxv!||i(_?mNj!+@PvO|_:ALw]vVgs_g!F)!veo}XqpNt)M~-70@');




@ini_set( 'upload_max_size', '500M' );
@ini_set( 'post_max_size', '13M');
@ini_set( 'memory_limit', '15M' );




# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
