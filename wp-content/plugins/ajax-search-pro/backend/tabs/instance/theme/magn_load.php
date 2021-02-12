<div class="item">
    <?php
    $o = new wpdreamsCustomSelect("magnifier_position", "Magnifier position", array(
        'selects'=>$sd['settingsimagepos_def'],
        'value'=>$sd['magnifier_position']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("magnifierimage", "Magnifier image", array(
            'images'  => $sd['magnifierimage_selects'],
            'value'=> $sd['magnifierimage']
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("magnifierimage_color", "Magnifier icon color", $sd['magnifierimage_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("magnifierimage_custom", "Custom magnifier icon", $sd['magnifierimage_custom']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsGradient("magnifierbackground", "Magnifier background gradient", $sd['magnifierbackground']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBorder("magnifierbackgroundborder", "Magnifier-icon border", $sd['magnifierbackgroundborder']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsBoxShadow("magnifierboxshadow", "Magnifier-icon box-shadow", $sd['magnifierboxshadow']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>

<div class="item">
    <?php
    $o = new wpdreamsCustomSelect("loader_display_location", "Loading animation display location", array(
        'selects'=>array(
            array("option" => "Auto", "value" => "auto"),
            array("option" => "In search bar", "value" => "search"),
            array("option" => "In results box", "value" => "results"),
            array("option" => "Both", "value" => "both"),
            array("option" => "None", "value" => "none")
        ),
        'value'=>$sd['loader_display_location']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">By default the loader displays in the search bar. If the search bar is hidden, id displays in the results box instead.</p>
</div>
<div class="item" id="magn_ajaxsearchpro_1">
    <div class="probox">
    <?php
    /*$o = new wpdreamsImageRadio("loadingimage", "Loading image", array(
            'images'  => $sd['loadingimage_selects'],
            'value'=> $sd['loadingimage']
        )
    );
    $params[$o->getName()] = $o->getData();*/

    $o = new wpdreamsLoaderSelect( "loader_image", "Loading image", $sd['loader_image'] );
    $params[$o->getName()] = $o->getData();
    ?>
    </div>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("loadingimage_color", "Loader color", $sd['loadingimage_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsUpload("loadingimage_custom", "Custom magnifier icon", $sd['loadingimage_custom']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>