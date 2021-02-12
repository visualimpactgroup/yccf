(function(jQuery, $, window){
jQuery(function($) {

    // Try these search button events
    $("body").on('click touchend', 'p.asp-try a', function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).parent().attr('id').match(/^asp-try-(.*)/)[1];
        var $searchParent = $('#ajaxsearchpro' + id);
        var i = 1;
        while ($searchParent.hasClass('asp_main_container') == false) {
            $searchParent = $searchParent.prev();
            i++;
            if (i>15) return;
        }
        if ($searchParent.hasClass('asp_compact')) {
            var state = $searchParent.attr('asp-compact')  || 'closed';
            if (state == 'closed')
                $('.promagnifier .innericon', $searchParent).click();
        }
        $('input', $searchParent).val('');
        $('input.orig', $searchParent).val($(this).html()).keydown();
        $('form', $searchParent).trigger('submit', 'ajax');
    });

    // Top searches widget
    $(".ajaxsearchprotop").each(function () {

        var params = $(this).data("aspdata");
        var id = params.id;

        if (params.action == 0) {
            $('a', this).click(function (e) {
                e.preventDefault();
            });
        } else if (params.action == 2) {
            $('a', this).click(function (e) {
                e.preventDefault();
                $('div[id*=ajaxsearchpro' + id + '_] .orig').first().val($(this).html());
                $('div[id*=ajaxsearchpro' + id + '_] .promagnifier').first().click();
                $('html,body').animate({
                        scrollTop: $('div[id*=ajaxsearchpro' + id + '_]').first().offset().top - 40
                    },
                    'slow');
            });
        } else if (params.action == 1) {
            ;
        }
    });
});
})(aspjQuery, aspjQuery, window);