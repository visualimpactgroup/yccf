<div class="item">
    <?php
    $o = new wd_DateFilter("date_filter_from", "Display 'Posts from date' filter", $sd['date_filter_from']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item" style="border-bottom: 1px dashed #E5E5E5;padding-bottom: 26px;">
    <?php
    $o = new wpdreamsText("date_filter_from_t", "Filter text", $sd['date_filter_from_t']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wd_DateFilter("date_filter_to", "Display 'Posts to date' filter", $sd['date_filter_to']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpdreamsText("date_filter_to_t", "Filter text", $sd['date_filter_to_t']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>