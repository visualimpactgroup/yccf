<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");
?>
<div id='ajaxsearchprores<?php echo $id; ?>' class='<?php echo $style['resultstype']; ?> ajaxsearchpro wpdreams_asp_sc'>

    <?php if ($style['resultstype'] == "isotopic" && $style['i_pagination_position'] == 'top'): ?>
        <nav class="asp_navigation">

            <a class="asp_prev">
                <?php echo file_get_contents(WP_PLUGIN_DIR . '/' . $style['i_pagination_arrow']); ?>
            </a>

            <a class="asp_next">
                <?php echo file_get_contents(WP_PLUGIN_DIR . '/' . $style['i_pagination_arrow']); ?>
            </a>

            <ul></ul>

            <div class="clear"></div>

        </nav>
    <?php endif; ?>

    <?php do_action('asp_layout_before_results', $id); ?>

    <div class="results">

        <?php do_action('asp_layout_before_first_result', $id); ?>

        <div class="resdrg">
        </div>

        <?php do_action('asp_layout_after_last_result', $id); ?>

    </div>

    <?php do_action('asp_layout_after_results', $id); ?>

    <?php if ($style['showmoreresults'] == 1): ?>
        <?php do_action('asp_layout_before_showmore', $id); ?>
        <p class='showmore'>
            <a><?php echo asp_icl_t("More results text" . " ($real_id)", $style['showmoreresultstext']) . " <span></span>"; ?></a>
        </p>
        <?php do_action('asp_layout_after_showmore', $id); ?>
    <?php endif; ?>

    <?php if ($style['resultstype'] == "isotopic" && $style['i_pagination_position'] == 'bottom'): ?>
        <nav class="asp_navigation">

            <a class="asp_prev">
                <?php echo file_get_contents(WP_PLUGIN_DIR . '/' . $style['i_pagination_arrow']); ?>
            </a>

            <ul></ul>

            <a class="asp_next">
                <?php echo file_get_contents(WP_PLUGIN_DIR . '/' . $style['i_pagination_arrow']); ?>
            </a>

            <div class="clear"></div>

        </nav>
    <?php endif; ?>


    <div class="asp_res_loader hiddend">
        <div class="asp_loader">
            <div class="asp_loader-inner asp_<?php echo $asp_loader_class; ?>">
            <?php
            for($i=0;$i<$asp_loaders[$asp_loader_class];$i++) {
                echo "
                <div></div>
                ";
            }
            ?>
            </div>
        </div>
    </div>
</div>