<div class="item"><?php
    $o = new wpdreamsCustomSelect("i_pagination_position", "Navigation position",  array(
        'selects'=>$sd['i_pagination_position_def'],
        'value'=>$sd['i_pagination_position']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_background", "Pagination background", $sd['i_pagination_background']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsImageRadio("i_pagination_arrow", "Arrow image", array(
            'images'  => $sd['i_pagination_arrow_selects'],
            'value'=> $sd['i_pagination_arrow']
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_arrow_background", "Arrow background color", $sd['i_pagination_arrow_background']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_arrow_color", "Arrow color", $sd['i_pagination_arrow_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_page_background", "Active page background color", $sd['i_pagination_page_background']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpdreamsColorPicker("i_pagination_font_color", "Font color", $sd['i_pagination_font_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>