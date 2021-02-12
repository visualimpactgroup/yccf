<div class="item"><?php
    /*$o = new wpdreamsNumericUnit("resultitemheight", "One result item height", array(
        'value' => $sd['resultitemheight'],
        'units'=>array('px'=>'px')));*/
    $o = new wpdreamsTextSmall("resultitemheight", "One result item height", $sd['resultitemheight']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">Use with units (70px or 50% or auto). Default: <strong>auto</strong></p>
</div>
<div class="item item-flex-nogrow">
    <?php
    $option_name = "image_width";
    $option_desc = "Image width (px)";
    $o = new wpdreamsTextSmall($option_name, $option_desc,
        $sd[$option_name]);
    $params[$o->getName()] = $o->getData();

    $option_name = "image_height";
    $option_desc = "Image height (px)";
    $o = new wpdreamsTextSmall($option_name, $option_desc,
        $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsTextSmall("itemscount", "Results box viewport (in item numbers)", $sd['itemscount']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("resultsborder", "Results box border", $sd['resultsborder']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("resultshadow", "Results box Shadow", $sd['resultshadow']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("resultsbackground","Results box background color", $sd['resultsbackground']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("resultscontainerbackground","Result items container box background color", $sd['resultscontainerbackground']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsGradient("vresulthbg", "Result item mouse hover box background gradient", $sd['vresulthbg']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("spacercolor","Spacer color between results", $sd['spacercolor']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("arrowcolor","Resultbar arrow color", $sd['arrowcolor']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("overflowcolor","Resultbar overflow color", $sd['overflowcolor']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>