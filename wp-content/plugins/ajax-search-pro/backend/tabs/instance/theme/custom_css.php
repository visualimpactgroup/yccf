<p class='infoMsg'>
    This css will be added before the plugin as inline CSS so it has a precedence
    over plugin CSS. (you can override existing rules)
</p>
<div class="item">
    <?php
    $option_name = "custom_css";
    $option_desc = "Custom CSS";
    $o = new wd_Textarea_B64($option_name, $option_desc, $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item" style="display:none !important;">
    <?php
    $option_name = "custom_css_h";
    $option_desc = "";
    $o = new wd_Textarea_B64($option_name, $option_desc, $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>