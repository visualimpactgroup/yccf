<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

$real_id = $id;
$id = $id . '_' . self::$perInstanceCount[$real_id];

$ana_options = wd_asp()->o['asp_analytics'];
$comp_options = wd_asp()->o['asp_compatibility'];

if (ASP_DEBUG < 1 && strpos(w_isset_def($comp_options['js_source'], 'min-scoped'), "scoped") !== false) {
    $scope = "aspjQuery";
} else {
    $scope = "jQuery";
}

$extra_class .= $style['box_compact_layout'] == 1 ? ' asp_compact' : '';
$extra_class .= $style['box_sett_hide_box'] == 1 ? ' hiddend' : '';
?>
<div class='wpdreams_asp_sc ajaxsearchpro asp_main_container <?php echo $extra_class; ?>' id='ajaxsearchpro<?php echo $id; ?>'>
<?php

/******************** PROBOX INCLUDE ********************/
include('asp.shortcode.probox.php');

/******************** RESULTS INCLUDE ********************/
include('asp.shortcode.results.php');

$blocking = w_isset_def($style['frontend_search_settings_position'], 'hover');
if ($blocking == 'block'): ?>
</div>
<div id='ajaxsearchprobsettings<?php echo $id; ?>' class="wpdreams_asp_sc ajaxsearchpro searchsettings">
<?php else: ?>
    <div id='ajaxsearchprosettings<?php echo $id; ?>' class="wpdreams_asp_sc ajaxsearchpro searchsettings">
<?php endif;

/******************* SETTINGS INCLUDE *******************/
include('asp.shortcode.settings.php');
?>

</div>

<?php if ($blocking != 'block'): ?>
</div>
<?php endif;
/******************* CLEARFIX *******************/
if (w_isset_def($style['box_compact_float'], 'none') != 'none') {
    echo '<div class="wpdreams_clear"></div>';
}

/***************** SUGGESTED PHRASES ******************/
if (w_isset_def($style['frontend_show_suggestions'], 0) == 1) {
    $sugg_keywords = trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $style['frontend_suggestions_keywords']));
    $sugg_keywords = str_replace(array(" ,", ", ", " , "), ",", $sugg_keywords);

    $sugg_keywords_arr = apply_filters("asp_suggested_phrases", explode(",", $sugg_keywords), $real_id);

    $s_phrases = implode('</a>, <a href="#">', $sugg_keywords_arr);
    ?>
    <p id="asp-try-<?php echo $id; ?>" class="asp-try"><?php echo $style['frontend_suggestions_text'].' <a href="#">'.$s_phrases.'</a>'; ?></p><?php
}

/******************** DATA INCLUDE ********************/
if (!self::$dataPrinted){
    include('asp.shortcode.data.php');
    self::$dataPrinted = true;
}

/**************** USER CUSTOM CSS ECHO ****************/
if (w_isset_def($style['custom_css'], "") != ""): ?>
    <?php
    if ( base64_decode($style['custom_css'], true) == true )
        $asp_c_css = stripcslashes( base64_decode($style['custom_css']) );
    else
        $asp_c_css = stripcslashes( $style['custom_css'] );
    $asp_c_css = str_replace( "_aspid", $id, $asp_c_css );
    ?>
    <style type="text/css">
        /* User defined Ajax Search Pro Custom CSS */
        <?php echo $asp_c_css; ?>
    </style>
    <?php
endif;

/************* THEME CUSTOM CSS ECHO ******************/
if (w_isset_def($style['custom_css_h'], "") != ""): ?>
    <?php
    if ( base64_decode($style['custom_css_h'], true) == true )
        $asp_c_css = stripcslashes( base64_decode($style['custom_css_h']) );
    else
        $asp_c_css = stripcslashes( $style['custom_css_h'] );
    $asp_c_css = str_replace( "_aspid", $id, $asp_c_css );
    ?>
    <style type="text/css">
        /* Theme defined Ajax Search Pro Custom CSS */
        <?php echo $asp_c_css; ?>
    </style>
    <?php
endif;

/******************** SCRIPT INCLUDE ********************/
include('asp.shortcode.script.php');
