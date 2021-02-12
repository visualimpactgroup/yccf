<div class="item">
    <?php
    $o = new wpdreamsCustomSelect("settingsimagepos", "Settings icon position", array(
        'selects'=>$sd['settingsimagepos_def'],
        'value'=>$sd['settingsimagepos']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("settingsimage", "Settings icon", array(
            'images'  => $sd['settingsimage_selects'],
            'value'=> $sd['settingsimage']
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("settingsimage_color", "Settings icon color", $sd['settingsimage_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("settingsimage_custom", "Custom settings icon", $sd['settingsimage_custom']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsbackground", "Settings-icon background gradient", $sd['settingsbackground']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("settingsbackgroundborder", "Settings-icon border", $sd['settingsbackgroundborder']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("settingsboxshadow", "Settings-icon box-shadow", $sd['settingsboxshadow']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsdropbackground", "Settings drop-down background gradient", $sd['settingsdropbackground']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("settingsdropboxshadow", "Settings drop-down box-shadow", $sd['settingsdropboxshadow']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("settingsdropfont", "Settings drop down font", $sd['settingsdropfont']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsFontComplete("exsearchincategoriestextfont", "Settings box header text font", $sd['exsearchincategoriestextfont']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("settingsdroptickcolor","Settings drop-down tick color", $sd['settingsdroptickcolor']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpdreamsGradient("settingsdroptickbggradient", "Settings drop-down tick background", $sd['settingsdroptickbggradient']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>