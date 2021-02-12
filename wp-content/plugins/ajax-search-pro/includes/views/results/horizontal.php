<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

/**
 * This is the default template for one horizontal result
 *
 * !!!IMPORTANT!!!
 * Do not make changes directly to this file! To have permanent changes copy this
 * file to your theme directory under the "asp" folder like so:
 *    wp-content/themes/your-theme-name/asp/horizontal.php
 *
 * It's also a good idea to use the actions to insert content instead of modifications.
 *
 * You can use any WordPress function here.
 * Variables to mention:
 *      Object() $r - holding the result details
 *      Array[]  $s_options - holding the search options
 *
 * DO NOT OUTPUT ANYTHING BEFORE OR AFTER THE <div class='item'>..</div> element
 *
 * You can leave empty lines for better visibility, they are cleared before output.
 *
 * MORE INFO: https://wp-dreams.com/knowledge-base/result-templating/
 *
 * @since: 4.0
 */
?>
<div class='item'>

    <?php do_action('asp_res_horizontal_begin_item'); ?>

    <?php if (!empty($r->image)): ?>
        <a class='asp_res_image_url' href='<?php echo $r->link; ?>'<?php echo ($s_options['results_click_blank'])?" target='_blank'":""; ?>>
            <div class='asp_image<?php echo $s_options['image_display_mode'] == "contain" ? " asp_image_auto" : ""; ?>'
                 style="background-image: url('<?php echo $r->image; ?>');">
                <?php if ( $s_options['image_display_mode'] == "contain"): ?>
                <img src="<?php echo $r->image; ?>" style="opacity: 0;">
                <?php endif; ?>
                <div class='void'></div>
            </div>
        </a>
    <?php endif; ?>

    <?php do_action('asp_res_horizontal_after_image'); ?>

    <div class='asp_content'>

        <h3><a class="asp_res_url" href='<?php echo $r->link; ?>'<?php echo ($s_options['results_click_blank'])?" target='_blank'":""; ?>><?php echo $r->title; ?>
            <?php if ($s_options['resultareaclickable'] == 1): ?>
            <span class='overlap'></span>
            <?php endif; ?>
        </a></h3>

        <div class='etc'>

            <?php if ($s_options['showauthor'] == 1): ?>
                <span class='asp_author'><?php echo $r->author; ?></span>
            <?php endif; ?>

            <?php if ($s_options['showdate'] == 1): ?>
                <span class='asp_date'><?php echo $r->date; ?></span>
            <?php endif; ?>

        </div>

        <?php if ($s_options['showdescription'] == 1): ?>
            <?php if (!empty($r->image) && $s_options['hhidedesc'] == 0): ?>
            <p class='desc'><?php echo $r->content; ?></p>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <?php do_action('asp_res_horizontal_after_content'); ?>

    <div class='clear'></div>

    <?php do_action('asp_res_horizontal_end_item'); ?>

</div>