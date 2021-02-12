<div class="item<?php echo class_exists('SitePress') ? "" : " hiddend"; ?>">
    <?php
    $o = new wpdreamsYesNo("wpml_compatibility", "WPML compatibility", $sd['wpml_compatibility']);
    $params[$o->getName()] = $o->getData();
    ?>
	<p class="descMsg">If turned <strong>ON</strong>: return results from current language. If turned <strong>OFF</strong>: return results from any language.</p>
</div>
<div class="item<?php echo function_exists("pll_current_language") ? "" : " hiddend"; ?>">
	<?php
	$o = new wpdreamsYesNo("polylang_compatibility", "Polylang compatibility", $sd['polylang_compatibility']);
	$params[$o->getName()] = $o->getData();
	?>
	<p class="descMsg">If turned <strong>ON</strong>: return results from current language. If turned <strong>OFF</strong>: return results from any language.</p>
</div>
<div class="item">
    <?php
    $o = new wpdreamsCustomSelect("shortcode_op", "What to do with shortcodes in results content?", array(
        'selects'=>array(
            array("option"=>"Remove them, keep the content", "value" => "remove"),
            array("option"=>"Execute them (can by really slow)", "value" => "execute")
        ),
        'value'=>$sd['shortcode_op']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">Removing shortcode is usually <strong>much faster</strong>, especially if you have many of them within posts.</p>
</div>
<div class="item">
	<p class='infoMsg'>If you have a plugin/tweak which enables categories on pages, then you should turn this on.</p>
	<?php
	$o = new wpdreamsYesNo("pageswithcategories", "Enable pages with categories/tags", $sd['pageswithcategories']);
	$params[$o->getName()] = $o->getData();
	?>
</div>
<div class="item">
	<?php
	$o = new wpdreamsText("striptagsexclude", "HTML Tags exclude from stripping content", $sd['striptagsexclude']);
	$params[$o->getName()] = $o->getData();
	?>
</div>
<div class="item">
	<?php
	$o = new wpdreamsCustomFSelect("primary_titlefield", "Primary Title Field for Posts/Pages/CPT", array(
		'selects'=>array(
            array('option' => 'Post Title', 'value' => 0),
            array('option' => 'Post Excerpt', 'value' => 1)
        ),
		'value'=>$sd['primary_titlefield']
	));
	$params[$o->getName()] = $o->getData();
	?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsCustomFSelect("secondary_titlefield", "Secondary Title Field for Posts/Pages/CPT", array(
        'selects'=>array(
            array('option' => 'Disabled', 'value' => -1),
            array('option' => 'Post Title', 'value' => 0),
            array('option' => 'Post Excerpt', 'value' => 1)
        ),
        'value'=>$sd['secondary_titlefield']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
	<?php
	$o = new wpdreamsCustomFSelect("primary_descriptionfield", "Primary Description Field for Posts/Pages/CPT", array(
		'selects'=>array(
            array('option' => 'Post Content', 'value' => 0),
            array('option' => 'Post Excerpt', 'value' => 1),
            array('option' => 'Post Title', 'value' => 2)
        ),
		'value'=>$sd['primary_descriptionfield']
	));
	$params[$o->getName()] = $o->getData();
	?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsCustomFSelect("secondary_descriptionfield", "Secondary Description Field for Posts/Pages/CPT", array(
        'selects'=>array(
            array('option' => 'Disabled', 'value' => -1),
            array('option' => 'Post Content', 'value' => 0),
            array('option' => 'Post Excerpt', 'value' => 1),
            array('option' => 'Post Title', 'value' => 2)
        ),
        'value'=>$sd['secondary_descriptionfield']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<fieldset>
	<legend>Advanced fields</legend>
	<p class='infoMsg'>Example: <b>{titlefield} - {_price}</b> will show the title and price for a woocommerce product. More info in the documentation.</p>
	<div class="item">
		<?php
		$o = new wpdreamsTextarea("advtitlefield", "Advanced Title Field (default: {titlefield})", $sd['advtitlefield']);
		$params[$o->getName()] = $o->getData();
		?>
        <p class="descMsg">HTML is supported! Use {custom_field_name} format to have custom field values.</p>
	</div>
	<div class="item">
		<?php
		$o = new wpdreamsTextarea("advdescriptionfield", "Advanced Description Field (default: {descriptionfield})", $sd['advdescriptionfield']);
		$params[$o->getName()] = $o->getData();
		?>
        <p class="descMsg">HTML is supported! Use {custom_field_name} format to have custom field values.</p>
	</div>
</fieldset>