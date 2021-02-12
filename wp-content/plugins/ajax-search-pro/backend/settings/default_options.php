<?php
/**
 * This is a function wrapper for the options, to avoid variable scope mix ups
 */
function asp_do_init_options() {
    global $wd_asp;

    $wd_asp->options = array();
    $options = &$wd_asp->options;
    $wd_asp->o = &$wd_asp->options;

    $options['asp_glob_d'] = array(
        'additional_tag_posts' => array() // Store post IDs that have additional tags
    );

    /* Performance Tracking options */
    $options['asp_performance_def'] = array(
        'enabled' => 1
    );

    /* Index table options */
    $options['asp_it_def'] = array(
        'it_index_title' => 1,
        'it_index_content' => 1,
        'it_index_excerpt' => 1,
        'it_post_types' => 'post|page',
        'it_index_tags' => 0,
        'it_index_categories' => 0,
        'it_index_taxonomies' => '',
        'it_index_permalinks' => 0,
        'it_index_customfields' => '',
        'it_post_statuses' => 'publish',
        'it_index_author_name' => 0,
        'it_index_author_bio' => 0,
        'it_blog_ids' => '',
        'it_limit' => 25,
        'it_use_stopwords' => 0,
        'it_stopwords' => @file_get_contents(ASP_PATH . '/stopwords.txt'),
        'it_min_word_length' => 1,
        'it_extract_shortcodes' => 1,
        'it_exclude_shortcodes' => 'wpdreams_rpl, wpdreams_rpp',
        'it_index_on_save' => 1,
        'it_cron_enable' => 0,
        'it_cron_period' => "hourly"
    );

    /* Analytics options */
    $options['asp_analytics_def'] = array(
        'analytics' => 0,
        'analytics_string' => "?ajax_search={asp_term}"
    );


    /* Default caching options */
    $options['asp_caching_def'] = array(
        'caching' => 0,
        'image_cropping' => 0,
        'cachinginterval' => 1440
    );


    /* Compatibility Options */

// CSS and JS
    $options['asp_compatibility_def'] = array(
        'jsminified' => 1,
        'js_source' => "min",
        'js_source_def' => array(
            array('option' => 'Non minified', 'value' => 'nomin'),
            array('option' => 'Minified', 'value' => 'min'),
            array('option' => 'Non-minified scoped', 'value' => 'nomin-scoped'),
            array('option' => 'Minified scoped', 'value' => 'min-scoped'),
        ),
        'js_init' => "dynamic",
        'load_in_footer' => 1,
        'detect_ajax' => 0,
        'css_compatibility_level' => "medium",
        'forceinlinestyles' => 0,
        'css_async_load' => 0,
        'loadpolaroidjs' => 1,
        'load_mcustom_js' => 'yes',
        'load_isotope_js' => 1,
        'load_datepicker_js' => 1,
        'load_noui_js' => 1,
        'usetimbthumb' => 1,
        'usecustomajaxhandler' => 0,

        // Query options
        'db_force_case_selects' => array(
            array('option' => 'None', 'value' => 'none'),
            array('option' => 'Sensitivity', 'value' => 'sensitivity'),
            array('option' => 'InSensitivity', 'value' => 'insensitivity')
        ),
        'db_force_case' => 'none',
        'db_force_unicode' => 0,
        'db_force_utf8_like' => 0
    );

    /* Default new search options */
    $options['asp_defaults'] = array(
// General options

        // Behavior
        'search_engine' => 'regular',
        'triggeronclick' => 1,
        'triggeronreturn' => 1,
        'trigger_on_facet' => 1,
        'triggerontype' => 1,
        'charcount' => 0,
        'trigger_delay' => 300, // invisible
        'autocomplete_trigger_delay' => 310, // invisible
        'redirectonclick' => 0,
        'redirect_click_to' => 'results_page',
        'redirect_on_enter' => 0,
        'redirect_enter_to' => 'results_page',
        'redirect_url' => '?s={phrase}',
        'override_default_results' => 0,
        'override_method' => 'post',

        // Mobile Behavior
        'mob_display_search' => 1,
        'desktop_display_search' => 1,
        'mob_trigger_on_type' => 1,
        'mob_trigger_on_click' => 1,
        'mob_hide_keyboard' => 0,
        'mob_force_res_hover' => 0,
        'mob_force_sett_hover' => 0,
        'mob_force_sett_state' => 'closed',

        'searchinposts' => 1,
        'searchinpages' => 1,
        'customtypes' => "",
        'searchinproducts' => 1,
        'searchintitle' => 1,
        'searchincontent' => 1,
        'searchincomments' => 0,
        'searchinexcerpt' => 1,
        'search_in_permalinks' => 0,
        'search_in_ids' => 0,
        'search_all_cf' => 0,
        'customfields' => "",
        'searchinbpusers' => 0,
        'searchinbpgroups' => 0,
        'searchinbpforums' => 0,
        'post_status' => 'publish',
        'exactonly' => 0,
        'exact_m_secondary' => 0,
        'searchinterms' => 0,

// General/Sources 2
        'return_categories' => 0,
        'return_tags' => 0,
        'return_terms' => '',
        'search_term_meta' => '',
        'search_term_descriptions' => 1,
        'display_number_posts_affected' => 0,
        'return_terms_exclude' => '',

// General / Attachments
        'return_attachments' => 0,
        'search_attachments_title' => 1,
        'search_attachments_content' => 1,
        'search_attachments_caption' => 1,
        'search_attachments_terms' => 0,
// base64: image/jpeg, image/gif, image/png, image/tiff, image/x-icon
        'attachment_mime_types' => 'aW1hZ2UvanBlZywgaW1hZ2UvZ2lmLCBpbWFnZS9wbmcsIGltYWdlL3RpZmYsIGltYWdlL3gtaWNvbg==',
        'attachment_use_image' => 1,
        'attachment_link_to' => 'media',
        'attachment_exclude' => "",

// General / Ordering
        'use_post_type_order' => 0,
        'post_type_order' => get_post_types(array(
            "public" => true,
            "_builtin" => false
        ), "names", "OR"),
        'results_order' => 'terms|blogs|bp_activities|comments|bp_groups|bp_users|post_page_cpt|attachments',

// General/Behaviour
        'itemscount' => 4,
        'resultitemheight' => "auto",

// General/Limits
        'posts_limit' => 10,
        'posts_limit_override' => 50,
        'posts_limit_distribute' => 0,
        'taxonomies_limit'  => 10,
        'taxonomies_limit_override' => 20,
        'users_limit' => 10,
        'users_limit_override' => 20,
        'blogs_limit' => 10,
        'blogs_limit_override' => 20,
        'buddypress_limit' => 10,
        'buddypress_limit_override' => 20,
        'comments_limit' => 10,
        'comments_limit_override' => 20,
        'attachments_limit' => 10,
        'attachments_limit_override' => 20,

        'keyword_logic_def' => array(
            array('option' => 'OR', 'value' => 'or'),
            array('option' => 'OR with exact word matches', 'value' => 'orex'),
            array('option' => 'AND', 'value' => 'and'),
            array('option' => 'AND with exact word matches', 'value' => 'andex')
        ),
        'keyword_logic' => 'or',
        'secondary_kw_logic' => 'none',

        'orderby_primary' => 'relevance DESC',
        'orderby' => 'post_date DESC',
        'orderby_primary_cf' => '',
        'orderby_secondary_cf' => '',
        'orderby_primary_cf_type' => 'numeric',
        'orderby_secondary_cf_type' => 'numeric',

// General/Image
        'show_images' => 1,
        'image_transparency' => 1,
        'image_bg_color' => "#FFFFFF",
        'image_width' => 70,
        'image_height' => 70,
        'image_display_mode' => 'cover',
        'image_apply_content_filter' => 0,

        'image_sources' => array(
            array('option' => 'Featured image', 'value' => 'featured'),
            array('option' => 'Post Content', 'value' => 'content'),
            array('option' => 'Post Excerpt', 'value' => 'excerpt'),
            array('option' => 'Custom field', 'value' => 'custom'),
            array('option' => 'Page Screenshot', 'value' => 'screenshot'),
            array('option' => 'Default image', 'value' => 'default'),
            array('option' => 'Post format icon', 'value' => 'post_format'),
            array('option' => 'Disabled', 'value' => 'disabled')
        ),

        'image_source1' => 'featured',
        'image_source2' => 'content',
        'image_source3' => 'excerpt',
        'image_source4' => 'custom',
        'image_source5' => 'default',

        'image_source_featured' => 'original',

        'image_default' => "",
        'image_custom_field' => '',
        'use_timthumb' => 1,

        /* BuddyPress Options */
        'search_in_bp_activities' => 0,
        'search_in_bp_groups' => 0,
        'search_in_bp_groups_public' => 0,
        'search_in_bp_groups_private' => 0,
        'search_in_bp_groups_hidden' => 0,

        /* User Search Options */
        'user_search' => 0,
        'user_login_search' => 1,
        'user_display_name_search' => 1,
        'user_first_name_search' => 1,
        'user_last_name_search' => 1,
        'user_bio_search' => 1,
        'user_search_exclude_roles' => "",
        'user_search_display_images' => 1,
        'user_search_image_source' => 'default',
        'user_search_meta_fields' => "",
        'user_bp_fields' => "",
        'user_search_title_field_def' => array(
            array('option' => 'Login Name', 'value' => 'login'),
            array('option' => 'Display Name', 'value' => 'display_name')
        ),
        'user_search_title_field' => 'display_name',
        'user_search_description_field_def' => array(
            array('option' => 'Biography', 'value' => 'bio'),
            array('option' => 'BuddyPress Last Activity', 'value' => 'buddypress_last_activity'),
            array('option' => 'Nothing', 'value' => 'nothing')
        ),
        'user_search_description_field' => 'bio',
        'user_search_advanced_title_field' => '{titlefield}',
        'user_search_advanced_description_field' => '{descriptionfield}',
        'user_search_redirect_to_custom_url' => 0,
        'user_search_url_source' => 'default',
        'user_search_custom_url' => '?author={USER_ID}',


        /* Multisite Options */
        'searchinblogtitles' => 0,
        'blogresultstext' => "Blogs",
        'blogs' => "",

        /* Frontend search settings Options */
// suggestions
        'frontend_show_suggestions' => 0,
        'frontend_suggestions_text' => "Try these:",
        'frontend_suggestions_text_color' => "rgb(85, 85, 85)",
        'frontend_suggestions_keywords' => "phrase 1, phrase 2, phrase 3",
        'frontend_suggestions_keywords_color' => "rgb(255, 181, 86)",

        // date
        'date_filter_from' => 'disabled|2016-01-01|0,0,0',
        'date_filter_from_t' => 'Content from',
        'date_filter_to' => 'disabled|2016-01-01|0,0,0',
        'date_filter_to_t' => 'Content to',

// general
        'show_frontend_search_settings' => 1,
        'frontend_search_settings_visible' => 0,
        'frontend_search_settings_position_def' => array(
            array('option' => 'Hovering (default)', 'value' => 'hover'),
            array('option' => 'Block or custom', 'value' => 'block')
        ),
        'frontend_search_settings_position' => 'hover',

        'fss_column_layout' => 'column',

        'fss_hover_columns' => 1,
        'fss_block_columns' => "auto",
        'fss_column_width' => 200,


        'showexactmatches' => 1,
        'showsearchintitle' => 1,
        'showsearchincontent' => 1,
        'showsearchincomments' => 1,
        'showsearchinexcerpt' => 1,

        'exactmatchestext' => "Exact matches only",
        'searchintitletext' => "Search in title",
        'searchincontenttext' => "Search in content",
        'searchincommentstext' => "Search in comments",
        'searchinexcerpttext' => "Search in excerpt",
        'searchinbpuserstext' => "Search in users",
        'searchinbpgroupstext' => "Search in groups",
        'searchinbpforumstext' => "Search in forums",

        'showcustomtypes' => '',
        'custom_types_label' => 'Filter by Custom Post Type',
        'cpt_display_mode' => 'checkboxes',
        'cpt_filter_default' => 'post',

        'show_frontend_tags' => "0|checkboxes|all|checked|||",
        'frontend_tags_header' => "Filter by Tags",
        'frontend_tags_logic' => "or",
        'frontend_tags_empty' => 0,

        'display_all_tags_option' => 0,
        'all_tags_opt_text' => 'All tags',
        'display_all_tags_check_opt' => 0,
        'all_tags_check_opt_state' => 'checked',
        'all_tags_check_opt_text' => 'Check/uncheck all',

        'settings_boxes_height' => "220px",
        'showsearchintaxonomies' => 1,
        //'terms_display_mode' => "checkboxes",

        //'showterms' => "",
        "show_terms" => array(
            "op_type" => "include",
            "separate_filter_boxes" => 1,
            "display_mode" => array(),
            "terms" => array(),
            "un_checked" => array() // store unchecked instead of checked, less overhead
        ),

        'term_logic_def' => array(
            array('option' => 'OR', 'value' => 'or'),
            array('option' => 'AND', 'value' => 'and')
        ),
        'term_logic' => 'and',
        'taxonomy_logic' => 'and',
        'frontend_terms_empty' => 1,
        'frontend_term_hierarchy' => 1,
        'frontend_term_order' => 'name||ASC',
        'exsearchincategoriestextfont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgb(26, 71, 98);font-size:13px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',

        'custom_field_items' => '',
        'cf_null_values' => 0,
        'cf_logic_def' => array(
            array('option' => 'AND', 'value' => 'AND'),
            array('option' => 'OR', 'value' => 'OR')
        ),
        'cf_logic' => 'AND',
        'cf_allow_null' => 0,
        'field_order' => 'general|custom_post_types|custom_fields|categories_terms|post_tags|date_filters',

        /* Layout Options */
        // Search box
        'defaultsearchtext' => 'Search here...',
        'box_alignment' => 'inherit',
        'box_sett_hide_box' => 0,
        'auto_populate' => 'disabled',
        'auto_populate_phrase' => '',
        'auto_populate_count' => 10,

        'resultstype_def' => array(
            array('option' => 'Vertical Results', 'value' => 'vertical'),
            array('option' => 'Horizontal Results', 'value' => 'horizontal'),
            array('option' => 'Isotopic Results', 'value' => 'isotopic'),
            array('option' => 'Polaroid style Results', 'value' => 'polaroid')
        ),
        'resultstype' => 'vertical',
        'resultsposition_def' => array(
            array('option' => 'Hover - over content', 'value' => 'hover'),
            array('option' => 'Block - pushes content', 'value' => 'block')
        ),
        'resultsposition' => 'hover',

        'showmoreresults' => 0,
        'showmoreresultstext' => 'More results...',
        'more_results_action' => 'ajax', // ajax, redirect
        'more_redirect_url' => '?s={phrase}',
        'showmorefont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(5, 94, 148, 1);font-size:12px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'showmorefont_bg' => '#FFFFFF',

        'results_click_blank' => 0,
        'scroll_to_results' => 0,
        'resultareaclickable' => 1,
        'close_on_document_click' => 1,
        'show_close_icon' => 1,
        'showauthor' => 0,
        'author_field' => "display_name",
        'showdate' => 0,
        'custom_date' => 0,
        'custom_date_format' => "Y-m-d H:i:s",
        'showdescription' => 1,
        'descriptionlength' => 130,
        'description_context' => 0,
        'noresultstext' => "No results!",
        'didyoumeantext' => "Did you mean:",
        'highlight' => 0,
        'highlightwholewords' => 1,
        'highlightcolor' => "#d9312b",
        'highlightbgcolor' => "#eee",

        /* Layout Options / Compact Search Layout */
        'box_compact_layout' => 0,
        'box_compact_close_on_magn' => 1,
        'box_compact_close_on_document' => 0,
        'box_compact_width' => "100%",
        'box_compact_overlay' => 0,
        'box_compact_overlay_color' => "rgba(255, 255, 255, 0.5)",
        'box_compact_float' => "inherit",
        'box_compact_float_def' => array(
            array('option' => 'No floating', 'value' => 'none'),
            array('option' => 'Left', 'value' => 'left'),
            array('option' => 'Right', 'value' => 'right')
        ),
        'box_compact_position' => "static",
        'box_compact_position_def' => array(
            array('option' => 'Static (default)', 'value' => 'static'),
            array('option' => 'Fixed', 'value' => 'fixed'),
            array('option' => 'Absolute', 'value' => 'absolute')
        ),
        'box_compact_screen_position' => '||20%||auto||0px||auto||',
        'box_compact_position_z' => '1000',

        /* Autocomplete & Keyword suggestion options */
        'keywordsuggestions' => 1,
        'keyword_suggestion_source_def' => array(
            'google' => 'Google keywords',
            'statistics' => 'Statistics database',
            'tags' => 'Post tags',
            'titles' => 'Post titles'
        ),
        'keyword_suggestion_source' => 'google',
        'kws_google_places_api' => '',
        'keywordsuggestionslang' => "en",
        'keyword_suggestion_count' => 10,
        'keyword_suggestion_length' => 60,

        'autocomplete' => 1,
        'autocomplete_mobile' => 1,
        'autocomplete_source' => 'google',
        'autocompleteexceptions' => '',
        'autoc_google_places_api' => '',
        'autocomplete_length' => 60,
        'autocomplete_google_lang' => "en",

// Advanced Options - Content
        'striptagsexclude' => '<abbr><b>',
        'shortcode_op' => 'remove',
        'pageswithcategories' => 0,

        'primary_titlefield' => 0,
        'secondary_titlefield' => -1,

        'primary_descriptionfield' => 1,
        'secondary_descriptionfield' => 0,

        'advtitlefield' => '{titlefield}',
        'advdescriptionfield' => '{descriptionfield}',

        "exclude_content_by_users" => array(
            "op_type" => "exclude",
            "users" => array(),
            "un_checked" => array() // store unchecked instead of checked, less overhead
        ),

        'exclude_post_tags' => '',
        'excludecategories' => '',
        //'excludeterms' => '',
        'exclude_by_terms' => array(
            "op_type" => "exclude",
            "separate_filter_boxes" => 0,
            "display_mode" => array(),
            "terms" => array(),
            "un_checked" => array()
        ),
        'include_by_terms' => array(
            "op_type" => "include",
            "separate_filter_boxes" => 0,
            "display_mode" => array(),
            "terms" => array(),
            "un_checked" => array()
        ),
        'excludeposts' => '',
        'exclude_dates' => "exclude|disabled|date|2000-01-01|2000-01-01|0,0,0|0,0,0",
        'exclude_dates_on' => 0,

        'exclude_cpt' => array(
            'ids' => array(),
            'parent_ids' => array(),
            'op_type' => 'exclude'
        ),

// Advanced Options - Grouping
        'group_by' => 'none',
        'group_header_prefix' => 'Results from',
        'group_header_suffix' => '',

        "groupby_terms" => array(
            "op_type" => "include",
            "terms" => array(),
            "ex_terms" => array(),
            "un_checked" => array() // store unchecked instead of checked, less overhead
        ),
        //"selected-groupby_terms" => array(),

        'groupby_cpt' => array(),

        "groupby_content_type" => array(
                "terms" => "Taxonomy Terms",
                "blogs" => "Blogs",
                "bp_activities" => "BuddyPress Activities",
                "comments" => "Comments",
                "bp_groups" => "BuddyPress groups",
                "users" => "Users",
                "post_page_cpt" => "Blog Content",
                "attachments" => "Attachments"
        ),

        'group_result_no_group' => 'display',
        'group_other_location' => 'bottom',
        'group_other_results_head' => 'Other results',
        'group_exclude_duplicates' => 1,

        'group_exclude_duplicates' => 0,

        'excludewoocommerceskus' => 0,
        'group_result_count' => 1,
        'bpgroupstitle_def' => array(
            array('option' => 'Topic title', 'value' => 'bb_topics.topic_title as title'),
            array('option' => 'Post Content', 'value' => 'bb_posts.post_text as title')
        ),
        'bpgroupstitle' => "bb_topics.topic_title as title",
        'wpml_compatibility' => 1,
        'polylang_compatibility' => 1,

// Advanced Options - Animations
// Desktop
        'sett_box_animation' => "fadedrop",
        'sett_box_animation_duration' => 300,
        'res_box_animation' => "fadedrop",
        'res_box_animation_duration' => 300,
        'res_items_animation' => "fadeInDown",
// Mobile
        'sett_box_animation_m' => "fadedrop",
        'sett_box_animation_duration_m' => 300,
        'res_box_animation_m' => "fadedrop",
        'res_box_animation_duration_m' => 300,
        'res_items_animation_m' => "voidanim",

        // Exceptions
        'kw_exceptions' => "",
        'kw_exceptions_e' => "",

        /* Theme options */
        'themes' => 'Default',
        'box_width' => '100%',
        'boxheight' => '28px',
        'boxmargin' => '4px',
        'boxbackground' => '0-60-rgb(219, 233, 238)-rgb(219, 233, 238)',
        'boxborder' => 'border:0px none rgba(0, 0, 0, 1);border-radius:5px 5px 5px 5px;',
        'boxshadow' => 'box-shadow:0px 10px 18px -13px #000000 ;',
        'inputbackground' => '0-60-rgb(255, 255, 255)-rgb(255, 255, 255)',
        'inputborder' => 'border:1px solid rgb(104, 174, 199);border-radius:3px 3px 3px 3px;',
        'inputshadow' => 'box-shadow:1px 0px 6px -3px rgb(181, 181, 181) inset;',
        'inputfont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgb(0, 0, 0);font-size:12px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',

        'settingsimagepos_def' => array(
            array('option' => 'Left', 'value' => 'left'),
            array('option' => 'Right', 'value' => 'right')
        ),
        'settingsimagepos' => "left",
        'settingsbackground' => '1-185-rgb(104, 174, 199)-rgb(108, 209, 245)',
        'settingsboxshadow' => 'box-shadow:1px 1px 0px 0px rgba(255, 255, 255, 0.63) inset;',
        'settingsbackgroundborder' => 'border:0px solid rgb(104, 174, 199);border-radius:0px 0px 0px 0px;',
        'settingsdropbackground' => '1-185-rgba(109, 204, 237, 1)-rgb(104, 174, 199)',
        'settingsdropfont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgb(255, 255, 255);font-size:12px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'settingsdropboxshadow' => 'box-shadow:2px 2px 3px -1px rgba(170, 170, 170, 1);',
        'settingsdroptickcolor' => 'rgba(255, 255, 255, 1)',
        'settingsdroptickbggradient' => '1-180-rgba(34, 34, 34, 1)-rgba(69, 72, 77, 1)',

        'vresultinanim' => 'rollIn',
        'vresulthbg' => '0-60-rgb(235, 250, 255)-rgb(235, 250, 255)',
        'resultsborder' => 'border:0px none #000000;border-radius:3px 3px 3px 3px;',
        'resultshadow' => 'box-shadow:0px 0px 0px 0px #000000 ;',
        'resultsbackground' => 'rgb(153, 218, 241)',
        'resultscontainerbackground' => 'rgb(255, 255, 255)',
        'resultscontentbackground' => '#ffffff',
        'titlefont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgba(20, 84, 169, 1);font-size:14px;line-height:20px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'import-titlefont' => "@import url(https://fonts.googleapis.com/css?family=Open+Sans:300|Open+Sans:400|Open+Sans:700);",
        'titlehoverfont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgb(46, 107, 188);font-size:14px;line-height:20px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'authorfont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgba(161, 161, 161, 1);font-size:12px;line-height:13px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'datefont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(173, 173, 173, 1);font-size:12px;line-height:15px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'descfont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(74, 74, 74, 1);font-size:13px;line-height:13px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'import-descfont' => "@import url(https://fonts.googleapis.com/css?family=Lato:300|Lato:400|Lato:700);",
        'groupfont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(74, 74, 74, 1);font-size:13px;line-height:13px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'groupingbordercolor' => 'rgb(248, 248, 248)',
        'spacercolor' => 'rgba(204, 204, 204, 1)',
        'arrowcolor' => 'rgba(10, 63, 77, 1)',
        'harrowcolor' => 'rgb(98, 150, 172)',
        'overflowcolor' => 'rgba(255, 255, 255, 1)',

        'magnifierimage_selects' => array(
            "/ajax-search-pro/img/svg/magnifiers/magn1.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn2.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn3.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn4.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn5.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn6.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn7.svg",
            "/ajax-search-pro/img/svg/arrows/arrow1.svg",
            "/ajax-search-pro/img/svg/arrows/arrow2.svg",
            "/ajax-search-pro/img/svg/arrows/arrow3.svg",
            "/ajax-search-pro/img/svg/arrows/arrow4.svg",
            "/ajax-search-pro/img/svg/arrows/arrow5.svg",
            "/ajax-search-pro/img/svg/arrows/arrow6.svg",
            "/ajax-search-pro/img/svg/arrows/arrow7.svg",
            "/ajax-search-pro/img/svg/arrows/arrow8.svg",
            "/ajax-search-pro/img/svg/arrows/arrow9.svg",
            "/ajax-search-pro/img/svg/arrows/arrow10.svg",
            "/ajax-search-pro/img/svg/arrows/arrow11.svg",
            "/ajax-search-pro/img/svg/arrows/arrow12.svg",
            "/ajax-search-pro/img/svg/arrows/arrow13.svg",
            "/ajax-search-pro/img/svg/arrows/arrow14.svg",
            "/ajax-search-pro/img/svg/arrows/arrow15.svg",
            "/ajax-search-pro/img/svg/arrows/arrow16.svg"
        ),

        'magnifierimage' => "/ajax-search-pro/img/svg/magnifiers/magn4.svg",

        'magnifier_position' => 'right',
        'magnifierimage_color' => "rgba(0, 0, 0, 1);",
        'magnifierimage_custom' => "",

// Theme options - Search text button
        'display_search_text' => 0,
        'hide_magnifier' => 0,
        'search_text' => "Search",
        'search_text_position' => "right",
        'search_text_font' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(51, 51, 51, 1);font-size:15px;line-height:normal;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',

// Theme options - Settings image
        'settingsimage_selects' => array(
            "/ajax-search-pro/img/svg/menu/menu1.svg",
            "/ajax-search-pro/img/svg/menu/menu2.svg",
            "/ajax-search-pro/img/svg/menu/menu3.svg",
            "/ajax-search-pro/img/svg/menu/menu4.svg",
            "/ajax-search-pro/img/svg/menu/menu5.svg",
            "/ajax-search-pro/img/svg/menu/menu6.svg",
            "/ajax-search-pro/img/svg/menu/menu7.svg",
            "/ajax-search-pro/img/svg/menu/menu8.svg",
            "/ajax-search-pro/img/svg/menu/menu9.svg",
            "/ajax-search-pro/img/svg/menu/menu10.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow1.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow2.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow3.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow4.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow5.svg",
            "/ajax-search-pro/img/svg/arrows-down/arrow6.svg",
            "/ajax-search-pro/img/svg/control-panel/cp1.svg",
            "/ajax-search-pro/img/svg/control-panel/cp2.svg",
            "/ajax-search-pro/img/svg/control-panel/cp3.svg",
            "/ajax-search-pro/img/svg/control-panel/cp4.svg",
            "/ajax-search-pro/img/svg/control-panel/cp5.svg",
            "/ajax-search-pro/img/svg/control-panel/cp6.svg",
            "/ajax-search-pro/img/svg/control-panel/cp7.svg",
            "/ajax-search-pro/img/svg/control-panel/cp8.svg",
            "/ajax-search-pro/img/svg/control-panel/cp9.svg",
            "/ajax-search-pro/img/svg/control-panel/cp10.svg",
            "/ajax-search-pro/img/svg/control-panel/cp11.svg",
            "/ajax-search-pro/img/svg/control-panel/cp12.svg",
            "/ajax-search-pro/img/svg/control-panel/cp13.svg",
            "/ajax-search-pro/img/svg/control-panel/cp14.svg",
            "/ajax-search-pro/img/svg/control-panel/cp15.svg",
            "/ajax-search-pro/img/svg/control-panel/cp16.svg"
        ),
        'settingsimage' => "/ajax-search-pro/img/svg/arrows-down/arrow1.svg",
        'settingsimage_color' => "rgba(0, 0, 0, 1);",
        'settingsimage_custom' => "",


        /*    'loadingimage_selects' => array(
          "/ajax-search-pro/img/loading/newload1.gif",
          "/ajax-search-pro/img/loading/newload2.gif",
          "/ajax-search-pro/img/loading/newload3.gif",
          "/ajax-search-pro/img/loading/newload4.gif",
          "/ajax-search-pro/img/loading/newload5.gif",
          "/ajax-search-pro/img/loading/newload6.gif",
          "/ajax-search-pro/img/loading/newload7.gif",
          "/ajax-search-pro/img/loading/newload8.gif",
          "/ajax-search-pro/img/loading/newload9.gif",
          "/ajax-search-pro/img/loading/newload10.gif",
          "/ajax-search-pro/img/loading/newload11.gif",
          "/ajax-search-pro/img/loading/newload12.gif",
          "/ajax-search-pro/img/loading/newload13.gif",
          "/ajax-search-pro/img/loading/newload14.gif",
          "/ajax-search-pro/img/loading/newload14r.gif",
          "/ajax-search-pro/img/loading/newload15.gif",
          "/ajax-search-pro/img/loading/newload16.gif",
          "/ajax-search-pro/img/loading/newload17.gif",
          "/ajax-search-pro/img/loading/newload18.gif",
          "/ajax-search-pro/img/loading/loading1.gif",
          "/ajax-search-pro/img/loading/loading2.gif",
          "/ajax-search-pro/img/loading/loading3.gif",
          "/ajax-search-pro/img/loading/loading4.gif",
          "/ajax-search-pro/img/loading/loading5.gif",
          "/ajax-search-pro/img/loading/loading6.gif",
          "/ajax-search-pro/img/loading/loading7.gif",
          "/ajax-search-pro/img/loading/loading8.gif",
          "/ajax-search-pro/img/loading/loading9.gif",
          "/ajax-search-pro/img/loading/loading10.gif",
          "/ajax-search-pro/img/loading/loading11.gif"
        );*/

        'loadingimage_selects' => array(
            "/ajax-search-pro/img/svg/loading/loading-bars.svg",
            "/ajax-search-pro/img/svg/loading/loading-balls.svg",
            "/ajax-search-pro/img/svg/loading/loading-bubbles.svg",
            "/ajax-search-pro/img/svg/loading/loading-cubes.svg",
            "/ajax-search-pro/img/svg/loading/loading-cylon.svg",
            "/ajax-search-pro/img/svg/loading/loading-fb.svg",
            "/ajax-search-pro/img/svg/loading/loading-poi.svg",
            "/ajax-search-pro/img/svg/loading/loading-spin.svg",
            "/ajax-search-pro/img/svg/loading/loading-spinning-bubbles.svg",
            "/ajax-search-pro/img/svg/loading/loading-spokes.svg"
        ),

// Maybe in future releases?
        /*
            'loadingimage_selects' => array(
            "/ajax-search-pro/img/html/loaders/loader1.html",
            "/ajax-search-pro/img/html/loaders/loader2.html",
            "/ajax-search-pro/img/html/loaders/loader3.html",
            "/ajax-search-pro/img/html/loaders/loader4.html",
            "/ajax-search-pro/img/html/loaders/loader5.html",
            "/ajax-search-pro/img/html/loaders/loader6.html",
            "/ajax-search-pro/img/html/loaders/loader7.html",
            "/ajax-search-pro/img/html/loaders/loader8.html"
        );
        */

        'loadingimage' => "/ajax-search-pro/img/svg/loading/loading-spin.svg",
        'loader_display_location' => 'auto',
        'loader_image' => "simple-circle",
        'loadingimage_color' => "rgba(0, 0, 0, 1);",
        'loadingimage_custom' => "",

        'magnifierbackground' => "1-180-rgb(132, 197, 220)-rgb(108, 209, 245)",
        'magnifierbackgroundborder' => 'border:0px solid rgb(104, 174, 199);border-radius:0px 0px 0px 0px;',
        'magnifierboxshadow' => 'box-shadow:-1px 1px 0px 0px rgba(255, 255, 255, 0.61) inset;',
        'groupbytextfont' => 'font-weight:bold;font-family:--g--Open Sans;color:rgba(5, 94, 148, 1);font-size:11px;line-height:13px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'exsearchincategoriesboxcolor' => "rgb(246, 246, 246)",

        'blogtitleorderby_def' => array(
            array('option' => 'Blog titles descending', 'value' => 'desc'),
            array('option' => 'Blog titles ascending', 'value' => 'asc')
        ),
        'blogtitleorderby' => 'desc',

        'hreswidth' => '150px',
        'hor_img_height' => '150px',
        'horizontal_res_height' => 'auto',
        'hressidemargin' => '8px',
        'hrespadding' => '7px',
        'hresultinanim' => 'bounceIn',
        'hboxbg' => '0-60-rgb(136, 197, 219)-rgb(153, 218, 241)',
        'hboxborder' => 'border:5px solid rgb(219, 233, 238);border-radius:0px 0px 0px 0px;',
        'hboxshadow' => 'box-shadow:0px 0px 4px -3px rgb(0, 0, 0) inset;',
        'hresultbg' => '0-60-rgba(255, 255, 255, 1)-rgba(255, 255, 255, 1)',
        'hresulthbg' => '0-60-rgba(255, 255, 255, 1)-rgba(255, 255, 255, 1)',
        'hresultborder' => 'border:0px none rgb(250, 250, 250);border-radius:0px 0px 0px 0px;',
        'hresultshadow' => 'box-shadow:0px 0px 6px -3px rgb(0, 0, 0);',
        'hresultimageborder' => 'border:0px none rgb(250, 250, 250);border-radius:0px 0px 0px 0px;',
        'hresultimageshadow' => 'box-shadow:0px 0px 9px -6px rgb(0, 0, 0) inset;',
        'hhidedesc' => 0,
        'hoverflowcolor' => "rgb(250, 250, 250)",

//Isotopic Syle options
        'i_ifnoimage_def' => array(
            array('option' => 'Show the default image', 'value' => 'defaultimage'),
            array('option' => 'Show the description', 'value' => 'description'),
            array('option' => 'Dont show that result', 'value' => 'removeres')
        ),
        'i_ifnoimage' => "description",
        'i_item_width' => 200,
        'i_item_height' => 200,
        'i_item_margin' => 5,
        'i_res_item_content_background' => 'rgba(0, 0, 0, 0.28);',
        'i_res_magnifierimage_selects' => array(
            "/ajax-search-pro/img/svg/magnifiers/magn1.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn2.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn3.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn4.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn5.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn6.svg",
            "/ajax-search-pro/img/svg/magnifiers/magn7.svg",
            "/ajax-search-pro/img/svg/arrows/arrow1.svg",
            "/ajax-search-pro/img/svg/arrows/arrow2.svg",
            "/ajax-search-pro/img/svg/arrows/arrow3.svg",
            "/ajax-search-pro/img/svg/arrows/arrow4.svg",
            "/ajax-search-pro/img/svg/arrows/arrow5.svg",
            "/ajax-search-pro/img/svg/arrows/arrow6.svg",
            "/ajax-search-pro/img/svg/arrows/arrow7.svg",
            "/ajax-search-pro/img/svg/arrows/arrow8.svg",
            "/ajax-search-pro/img/svg/arrows/arrow9.svg",
            "/ajax-search-pro/img/svg/arrows/arrow10.svg",
            "/ajax-search-pro/img/svg/arrows/arrow11.svg",
            "/ajax-search-pro/img/svg/arrows/arrow12.svg",
            "/ajax-search-pro/img/svg/arrows/arrow13.svg",
            "/ajax-search-pro/img/svg/arrows/arrow14.svg",
            "/ajax-search-pro/img/svg/arrows/arrow15.svg",
            "/ajax-search-pro/img/svg/arrows/arrow16.svg"
        ),

        'i_res_magnifierimage' => "/ajax-search-pro/img/svg/magnifiers/magn4.svg",
        'i_res_custom_magnifierimage' => "",

        'i_overlay' => 1,
        'i_overlay_blur' => 1,
        'i_hide_content' => 1,
        'i_animation' => 'bounceIn',
        'i_rows' => 2,
        'i_res_container_margin' => "||0px||0px||0px||0px||",
        'i_res_container_padding' => "||0px||0px||0px||0px||",
        'i_res_container_bg' => 'rgba(255, 255, 255, 0);',


        'i_pagination_position_def' => array(
            array('option' => 'Top', 'value' => 'top'),
            array('option' => 'Bottom', 'value' => 'bottom')
        ),
        'i_pagination_position' => "top",
        'i_pagination_background' => "rgb(228, 228, 228);",
        'i_pagination_arrow_selects' => array(
            "/ajax-search-pro/img/svg/arrows/arrow1.svg",
            "/ajax-search-pro/img/svg/arrows/arrow2.svg",
            "/ajax-search-pro/img/svg/arrows/arrow3.svg",
            "/ajax-search-pro/img/svg/arrows/arrow4.svg",
            "/ajax-search-pro/img/svg/arrows/arrow5.svg",
            "/ajax-search-pro/img/svg/arrows/arrow6.svg",
            "/ajax-search-pro/img/svg/arrows/arrow7.svg",
            "/ajax-search-pro/img/svg/arrows/arrow8.svg",
            "/ajax-search-pro/img/svg/arrows/arrow9.svg",
            "/ajax-search-pro/img/svg/arrows/arrow10.svg",
            "/ajax-search-pro/img/svg/arrows/arrow11.svg",
            "/ajax-search-pro/img/svg/arrows/arrow12.svg",
            "/ajax-search-pro/img/svg/arrows/arrow13.svg",
            "/ajax-search-pro/img/svg/arrows/arrow14.svg",
            "/ajax-search-pro/img/svg/arrows/arrow15.svg",
            "/ajax-search-pro/img/svg/arrows/arrow16.svg",
            "/ajax-search-pro/img/svg/arrows/arrow17.svg",
            "/ajax-search-pro/img/svg/arrows/arrow18.svg"
        ),
        'i_pagination_arrow' => "/ajax-search-pro/img/svg/arrows/arrow1.svg",
        'i_pagination_arrow_background' => "rgb(76, 76, 76);",
        'i_pagination_arrow_color' => "rgb(255, 255, 255);",
        'i_pagination_page_background' => "rgb(244, 244, 244);",
        'i_pagination_font_color' => "rgb(126, 126, 126);",


//Polaroid Style options
        'pifnoimage' => "removeres",
        'pshowdesc' => 1,
        'prescontainerheight' => '400px',
        'preswidth' => '200px',
        'presheight' => '240px',
        'prespadding' => '25px',
        'prestitlefont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(167, 160, 162, 1);font-size:16px;line-height:20px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'pressubtitlefont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(133, 133, 133, 1);font-size:13px;line-height:18px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'pshowsubtitle' => 0,

        'presdescfont' => 'font-weight:normal;font-family:--g--Open Sans;color:rgba(167, 160, 162, 1);font-size:14px;line-height:17px;text-shadow:0px 0px 0px rgba(255, 255, 255, 0);',
        'prescontainerbg' => '0-60-rgba(221, 221, 221, 1)-rgba(221, 221, 221, 1)',
        'pdotssmallcolor' => '0-60-rgba(170, 170, 170, 1)-rgba(170, 170, 170, 1)',
        'pdotscurrentcolor' => '0-60-rgba(136, 136, 136, 1)-rgba(136, 136, 136, 1)',
        'pdotsflippedcolor' => '0-60-rgba(85, 85, 85, 1)-rgba(85, 85, 85, 1)',

// Custom CSS
        'custom_css' => '',
        'custom_css_h' => '',

//Relevance options
        'userelevance' => 1,
        'weight_def' => array(
            array('option' => '10 - Highest weight', 'value' => 10),
            array('option' => '9', 'value' => 9),
            array('option' => '8', 'value' => 8),
            array('option' => '7', 'value' => 7),
            array('option' => '6', 'value' => 6),
            array('option' => '5', 'value' => 5),
            array('option' => '4', 'value' => 4),
            array('option' => '3', 'value' => 3),
            array('option' => '2', 'value' => 2),
            array('option' => '1 - Lowest weight', 'value' => 1)
        ),
        'etitleweight' => 10,
        'econtentweight' => 9,
        'eexcerptweight' => 9,
        'etermsweight' => 7,
        'titleweight' => 3,
        'contentweight' => 2,
        'excerptweight' => 2,
        'termsweight' => 2,

        'it_title_weight' => 100,
        'it_content_weight' => 20,
        'it_excerpt_weight' => 10,
        'it_terms_weight' => 10,
        'it_cf_weight' => 8,
        'it_author_weight' => 8
    );

}

/**
 * Merge the default options with the stored options.
 */
function asp_parse_options() {
    foreach ( wd_asp()->o as $def_k => $o ) {
        if ( preg_match("/\_def$/", $def_k) ) {
            $ok = preg_replace("/\_def$/", '', $def_k);

            // Dang, I messed up this elegant solution..
            if ( $ok == "asp_it")
                $ok = "asp_it_options";

            wd_asp()->o[$ok] = get_option($ok, wd_asp()->o[$def_k]);
            wd_asp()->o[$ok] = array_merge(wd_asp()->o[$def_k], wd_asp()->o[$ok]);
        }
    }
    // Long previous version compatibility
    if ( wd_asp()->o['asp_caching'] === false )
        wd_asp()->o['asp_caching'] = wd_asp()->o['asp_caching_def'];

    // The globals are a sitewide options
    wd_asp()->o['asp_glob'] = get_site_option('asp_glob', wd_asp()->o['asp_glob_d']);
    wd_asp()->o['asp_glob'] = array_merge(wd_asp()->o['asp_glob_d'], wd_asp()->o['asp_glob']);
}

/*
 * Updates the option value from the wd_asp()->o[key] array to the database
 */
function asp_save_option($key, $global = false) {
    if ( !isset(wd_asp()->o[$key]) )
        return false;

    if ( $global ) {
        return update_site_option($key, wd_asp()->o[$key]);
    } else {
        return update_option($key, wd_asp()->o[$key]);
    }
}

asp_do_init_options();
asp_parse_options();