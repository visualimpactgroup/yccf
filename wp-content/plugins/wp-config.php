<?php
# Database Configuration
define( 'DB_NAME', 'wp_yccf' );
define( 'DB_USER', 'yccf' );
define( 'DB_PASSWORD', '3cVyK4RQoYOC5zf9xvog' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY', 'lY+})Lp@s`CSm$df+l@@.(%n|cB7pN|*TZzTClfP5F#E2BNzy@17IYXF={%-`5W|');
define('SECURE_AUTH_KEY', 'V9[}L;Ih$oMGiR;ZFQmvpfSoFW0~+Q~D9?Z|MPg>(Qxa9: U8H^igNS-+Ed-m(*h');
define('LOGGED_IN_KEY', 'y-+I5}rdl{)-I[WI(Mv_g[1VSd|ju8}%-B0peP-LB|s8Hjzj<,h(P>5RL-5P/HIW');
define('NONCE_KEY', ']hc32XqI|PV:3~:=?x.EygR `5`|&r@rl6hm]3lZ)&Y<muB;wrRXQvD|z?+|$qe8');
define('AUTH_SALT',        '*pGMw? @iCTS}H3e(1zT>N1KW&Ps.e2>:S<:wM*^o+zxie:2nj9*8&nrPCwR)>At');
define('SECURE_AUTH_SALT', 'pZrhOrX(#uY8A`zW:NOtz.p=JRZ%0:el;G;QL8*I`[q_HQiK*k8xjhf?~z8T3>.&');
define('LOGGED_IN_SALT',   'WuJLME^z#a(p,Bw,x{X}I^?i&>+]GqY+-[~s*ne8t+T_+vOt=S,4fziEjK0SnEQ?');
define('NONCE_SALT',       '+nx ZZjdbUTq{(V~bqebkxxkil,2NQ0Z,GjL*LxA;A@|~?tP2J-z+V3[MU>|p86H');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'yccf' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '50fc5224a876cf250dbcb8855807f3e9888297a9' );

define( 'WPE_CLUSTER_ID', '120342' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'yccf.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-120342', );

$wpe_special_ips=array ( 0 => '35.224.194.109', );

$wpe_ec_servers=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );


# WP Engine ID


# WP Engine Settings







# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
