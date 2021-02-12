<style>
    .wpdreamsTextSmall {
        display: inline-block;
    }
</style>
<div class="item"><?php
    $o = new wpdreamsCustomSelect("i_ifnoimage", "If no image found",  array(
        'selects'=>$sd['i_ifnoimage_def'],
        'value'=>$sd['i_ifnoimage']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_item_width", "Result width", $sd['i_item_width']);
    $params[$o->getName()] = $o->getData();
    ?>px
    <p class="descMsg">The search will try to stick close to this value when filling the width of the results list.</p>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_item_height", "Result height", $sd['i_item_height']);
    $params[$o->getName()] = $o->getData();
    ?>px
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_item_margin", "Result margin space", $sd['i_item_margin']);
    $params[$o->getName()] = $o->getData();
    ?>px
    <p class="descMsg">Margin (gutter) between the items on the isotope grid.</p>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_res_item_content_background", "Result content background", $sd['i_res_item_content_background']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("i_res_magnifierimage", "Hover background icon", array(
            'images'  => $sd['i_res_magnifierimage_selects'],
            'value'=> $sd['i_res_magnifierimage']
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("i_res_custom_magnifierimage", "Custom hover background icon", $sd['i_res_custom_magnifierimage']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_overlay", "Show overlay on mouseover?", $sd['i_overlay']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_overlay_blur", "Blur overlay image on mouseover?", $sd['i_overlay_blur']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">This might not work on some browsers.</p>
</div>
<div class="item">
    <?php
    $o = new wpdreamsYesNo("i_hide_content", "Hide the content when overlay is active?", $sd['i_hide_content']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsAnimations("i_animation", "Display animation", $sd['i_animation']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("i_rows", "Rows count", $sd['i_rows']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">If the item would exceed the row limit, it gets placed to a new page.</p>
</div>
<div class="item">
    <?php
    $option_name = "i_res_container_padding";
    $option_desc = "Result container padding";
    $option_expl = "Include the unit as well, example: 10px or 1em or 90%";
    $o = new wpdreamsFour($option_name, $option_desc,
        array(
            "desc" => $option_expl,
            "value" => $sd[$option_name]
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $option_name = "i_res_container_margin";
    $option_desc = "Result container margin";
    $option_expl = "Include the unit as well, example: 10px or 1em or 90%";
    $o = new wpdreamsFour($option_name, $option_desc,
        array(
            "desc" => $option_expl,
            "value" => $sd[$option_name]
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_res_container_bg", "Result box background", $sd['i_res_container_bg']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>