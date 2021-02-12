<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

if (!class_exists('ASP_Query')) {
    /**
     * Class ASP_Query
     *
     * A similar class to WP_Query
     */
    class ASP_Query {
        /*
         * Results array
         */
        public $posts;

        /**
         * The real results count
         *
         * @var int
         */
        public $found_posts = 0;

        /**
         * Default query parameter values
         *
         * @var array
         */
        public static $defaults = array(
            // ----------------------------------------------------------------
            // 1. GENERIC arguments
            // ----------------------------------------------------------------
            's' => '',                  // search query
            /**
             *  @param string|array search_type
             *      cpt -> posts, pages, custom post types
             *      taxonomies -> tags, categories and taxonomy terms based on taxonomy slug
             *      users -> users
             *      blogs -> multisite blog titles
             *      buddypress -> buddypress groups or activities
             *      comments -> comment results
             *      attachments -> file attachments
             */
            'search_type' => 'cpt',
            'engine' => 'regular',      // regular|index -> index only used on cpt
            'posts_per_page' => 10,     // posts per page, for non ajax requests only
            'page' => 1,                // which page of results, starts from 1
            'keyword_logic' => 'OR',    // OR|AND|OREX|ANDEX
            'secondary_logic' => '',    // OR|AND|OREX|none or empty string
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 2. POST and CUSTOM POST TYPE related arguments
            // ----------------------------------------------------------------
            'post_type' => array('post', 'page'),       // post types to look for
            'post_status' => array('publish'),          // post statuses
            'post_fields' => array(                     // post fields to search within
                // (title, content, excerpt, terms, permalink)
                'title', 'ids', 'excerpt', 'terms'
            ),
            'post_custom_fields_all' => 0,              // search all custom fields
            'post_custom_fields' => array(),            // ..or search within custom fields
            'post_in' => array(),                       // string|array -> limit potential results pool to array of IDs
            'post_not_in' => array(),                   // string|array -> explicity exclude IDs from search results
            'post_not_in2' => array(),                  // array -> secondary exclusion for manual override
            'post_tax_filter' => array(                 // taxonomy filter support
                /*
                array(
                    'taxonomy'  => 'category',          // taxonomy name
                    'include'   => array(1, 2, 3, 4),   // array of taxonomy term IDs to include
                    'exclude'   => array(5, 6, 7, 8)    // array of taxonomy term IDs to exclude
                )
                */
            ),
            'post_meta_filter' => array(      // meta_query support
                /*
                array(
                    'key'     => 'age',         // meta key
                    'value'   => array( 3, 4 ), // mixed|array
                     // @param string|array compare
                     // Numeric Operators
                     //      '<' -> less than
                     //      '>' -> more than
                     //      '<>' -> not equals
                     //      '=' -> equals
                     //      'BETWEEN' -> between two values
                     // String Operators
                     //      'LIKE'
                     //      'NOT LIKE'
                     //
                    'operator' => 'BETWEEN'
                )
                */
            ),
            'post_date_filter' => array(        // date_query support
                /*
                array(
                    'year'  => 2015,            // year, month, day ...
                    'month' => 6,
                    'day'   => 1,
                    'date'  => "2015-06-01",     // .. or date parameter in y-m-d format
                    'operator' => 'include',    // include|exclude
                    'interval' => 'before'      // before|after
                )
                */
            ),
            'post_user_filter' => array(
                /*
                'include' => (1, 2, 3, 4),  // include by IDs
                'exclude' => (5, 6, 7, 8)   // exclude by IDs
                */
            ),
            'post_primary_order' => "relevance DESC",
            'post_secondary_order' => "post_date DESC",
            // ADVANCED
            '_post_get_content' => false,
            '_post_get_excerpt' => false,
            '_post_allow_empty_tax_term' => false,
            '_post_use_relevance' => true,
            // Special post tag filtering
            '_post_tags_active'  => false,
            '_post_tags_include' => array(),
            '_post_tags_exclude' => array(),
            '_post_tags_logic' => "OR",
            '_post_tags_empty' => 0,
            '_post_meta_logic' => "AND",
            '_post_meta_allow_null' => 0,
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 3. ATTACHMENT search related arguments
            // ----------------------------------------------------------------
            'attachments_search_title'  => true,
            'attachments_search_content' => true,
            'attachments_search_caption' => true,
            'attachments_search_terms' => false,
            'attachment_use_image' => true,
            'attachment_mime_types' => array('image/jpeg', 'image/gif', 'image/png', 'image/tiff', 'image/x-icon'),
            'attachment_exclude'    => array(), // array of IDs
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 4. BUDDYPRESS related arguments
            'bp_groups_search'          => false,
            'bp_groups_search_public'   => true,
            'bp_groups_search_private'  => true,
            'bp_groups_search_hidden'   => true,
            'bp_activities_search'      => true,
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 5. COMMENTS related arguments
            // Nothing here yet..
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 6. TAXONOMY TERM search related arguments
            // ----------------------------------------------------------------
            'taxonomy_include' => array("category", "post_tag"), // taxonomies to search for terms
            'taxonomy_terms_exclude' => array(),     // string|array terms to exclude by ID
            'taxonomy_terms_exclude2'=> array(),     // array only
            'taxonomy_terms_search_description' => true,
            // ADVANCED
            '_taxonomy_posts_affected' => true,
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 7. USER SEARCH
            // ----------------------------------------------------------------
            'user_login_search' => true,
            'user_display_name_search' => true,
            'user_first_name_search' => true,
            'user_last_name_search' => true,
            'user_bio_search' => true,
            'user_search_meta_fields' => array(),
            'user_search_bp_fields' => array(),
            'user_search_exclude_roles' => array(),
            'user_search_exclude_ids' => array(),
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 8. BLOG NAME SEARCH
            // ----------------------------------------------------------------
            'blog_exclude' => array(),
            // ----------------------------------------------------------------

            /**
             * OTHER ADVANCED ATTRIBUTES
             *
             * Don't use/override these, unless you know what you are doing.
             */
            '_id' => -1,
            '_o'  => false,
            // LIMITS
            'limit' => 0, // overall results limit, if >=0, then evenly distributed between sources
            '_limit' => 0, // calculated limit based on the previous limit parameter
            /**
             * _call_num ->
             *  Number of the consecutive ajax requests with the same configuration triggered by
             *  clicking on the 'More results..' link
             *  This is required to calculate the correct start of the result slicing
             */
            '_call_num' => 0,
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

            '_charcount'        => 0,
            '_exact_matches'   => false,
            '_qtranslate_lang' => "en",         // qtranslatex language data
            '_wpml_lang'       => "",           // WPML language
            '_polylang_lang'       => "",       // Polylang language
            '_exclude_page_parent_child' => "", // parent page exclusion data (comma separated list)
            '_taxonomy_group_logic' => 'AND',
            '_db_force_case'        => 'none',
            '_db_force_utf8_like'   => 0,
            '_db_force_unicode'     => 0,
            '_ajax_search'          => false     // Needs to be set explicitly to TRUE in search Ajax Handler class
        );

        /*
         * Array of phrases of all synonym variations
         */
        private $finalPhrases = array();

        /*
         * Constructor args
         */
        private $args = array();

        /**
         * ASP_Query constructor.
         *
         * @param $args array of arguments
         * @param int $search_id search ID
         * @param array $options options from $_POST
         */
        public function __construct($args, $search_id = -1, $options = false ) {
            // Expressions not allowed in static context
            self::$defaults['_selected_blogs'] = array(get_current_blog_id());

            if ( $search_id > -1 ) {
                // Translate search data and options to args
                $search_args = ASP_Helpers::toQueryArgs($search_id, $options);
                $search_args = wp_parse_args( $search_args, self::$defaults );
                $args = wp_parse_args( $args, $search_args );
            } else {
                // No search instance, use default args
                $args = wp_parse_args( $args, self::$defaults );
            }

            $args = apply_filters("asp_query_args", $args, $search_id);
            $this->args = $args;

            do_action('asp_before_search', $args['s']);

            if ( !$args['_ajax_search'] )
                $this->args['s'] = ASP_Helpers::clear_phrase($this->args['s']);

            $this->processOptions();
            $this->posts = $this->get_posts();
        }

        private function processOptions() {
            $args = &$this->args;
            // ---------------- Part 1. Query variables --------------------

            // These parameters can be arrays and strings/numeric as well -> convert them to array
            $array_param_keys = array(
                'post_type',
                'post_status',
                'post_fields',
                'post_custom_fields',
                //'post_not_in',
                '_post_tags_include',
                '_post_tags_exclude',
                'attachment_mime_types',
                'taxonomy_include'
                //'taxonomy_terms_exclude'
            );
            foreach ($array_param_keys as $k)
                $args[$k] = !is_array($args[$k]) ? array($args[$k]) : $args[$k];

            if ( !is_array($args['search_type']) )
                $args['search_type'] = array($args['search_type']);
            if ( $args['limit'] > 0 && count($args['search_type']) > 0 )
                $args['_limit'] = floor($args['limit']/count($args['search_type']));
            $args['posts_per_page'] = get_option('posts_per_page');

            $args['keyword_logic'] = strtolower($args['keyword_logic']);

            // ------------------ Part 2. Search data ----------------------

            // Break after this point, if no search data is provided
            if ( !isset($this->args['_sd']) )
                return false;

            $sd = &$this->args['_sd'];

            // Disabled compact layout if the box is hidden anyways
            if ( $sd['box_sett_hide_box'] == 1 ) {
                $sd['box_compact_layout'] = 0;
                $sd['frontend_search_settings_visible'] = 1;
                $sd['show_frontend_search_settings'] = 1;
                $sd['frontend_search_settings_position'] = "block";
                $sd['resultsposition'] = "block";
                $sd['charcount'] = 0;
                $sd['trigger_on_facet'] = 1;
            }

            $args['_charcount'] = $sd['charcount'];

            $sd['image_options'] = array(
                'image_cropping' => wd_asp()->o['asp_caching']['image_cropping'],
                'show_images' => $sd['show_images'],
                'image_bg_color' => $sd['image_bg_color'],
                'image_transparency' => $sd['image_transparency'],
                'apply_content_filter' => $sd['image_apply_content_filter'],
                'image_width' => $sd['image_width'],
                'image_height' => $sd['image_height'],
                'image_source1' => $sd['image_source1'],
                'image_source2' => $sd['image_source2'],
                'image_source3' => $sd['image_source3'],
                'image_source4' => $sd['image_source4'],
                'image_source5' => $sd['image_source5'],
                'image_default' => $sd['image_default'],
                'image_source_featured' => $sd['image_source_featured'],
                'image_custom_field' => $sd['image_custom_field']
            );

            if (isset($_POST['asp_get_as_array']))
                $sd['image_options']['show_images'] = 0;

            // ----------------- Recalculate image width/height ---------------
            switch ($sd['resultstype']) {
                case "horizontal":
                    /* Same width as height */
                    $sd['image_options']['image_width'] = wpdreams_width_from_px($sd['hreswidth']);
                    $sd['image_options']['image_height'] = wpdreams_width_from_px($sd['hor_img_height']);
                    break;
                case "polaroid":
                    $sd['image_options']['image_width'] = (int)($sd['preswidth']);
                    $sd['image_options']['image_height'] = (int)($sd['preswidth']);
                    break;
                case "isotopic":
                    $sd['image_options']['image_width'] = (int)($sd['i_item_width'] * 1.5);
                    $sd['image_options']['image_height'] = (int)($sd['i_item_height'] * 1.5);
                    break;
            }

        }

        public function get_posts() {
            $args = $this->args;
            $_args = $args; // copy to store changes

            $ra = array(
                'blogresults' => array(),

                'allbuddypresults' => array(
                    'groupresults' => array(),
                    'activityresults' => array()
                ),

                'alltermsresults' => array(),
                'allpageposts' => array(),
                'pageposts' => array(),
                'repliesresults' => array(),
                'allcommentsresults' => array(),
                'commentsresults' => array(),
                'userresults' => array(),
                'attachment_results' => array()
            );

            // True if only CPT search in the index table is active
            $search_only_it_posts =
                $args['engine'] != 'regular' &&
                count($args['search_type']) == 1 &&
                in_array('cpt', $args['search_type']);

            $s = $this->applyExceptions( $args['s'] );

            // Allow empty search phrases only if the char count is 0
            if ( $s != "" ||
                ($s == "" && ( isset($args['force_order']) || isset($args['force_count']) )) ||
                ($s == "" && $args['_charcount'] == 0)
            )
                $this->finalPhrases[] = $s;

            $this->finalPhrases = apply_filters("asp_final_phrases", $this->finalPhrases);

            $logics = array( $args['keyword_logic'] );
            if ( !empty($args['secondary_logic']) && $args['secondary_logic'] !== 'none' && $args['_call_num'] == 0 )
                $logics[] = strtolower($args['secondary_logic']);

            // ---- Search Porcess Starts Here ----
            foreach ($this->finalPhrases as $s) {

                if (is_multisite() && $search_only_it_posts && $s != "") {
                    // Save huge amounts of server resources by not swapping all the blogs around

                    $args['_switch_on_preprocess'] = 1;
                    $search_index = new ASP_Search_INDEX($args);
                    $ra['pageposts'] = $search_index ->search();
                    $this->found_posts += $search_index->results_count;

                    do_action('asp_after_pagepost_results', $s, $ra['pageposts']);
                    $ra['allpageposts'] = array_merge( $ra['allpageposts'], $ra['pageposts'] );
                } else {

                    foreach ($args['_selected_blogs'] as $blog) {
                        if (is_multisite()) switch_to_blog($blog);

                        if ( in_array('taxonomies', $args['search_type']) && count($args['taxonomy_include']) > 0 ) {
                            foreach ( $logics as $lk => $logic ) {
                                $args['keyword_logic'] = $logic;
                                if ( $lk > 0 )
                                    $args['_exact_matches'] = 0;

                                $_terms = new ASP_Search_TERMS($args);
                                $ra['alltermsresults'] = array_merge($ra['alltermsresults'], $_terms->search($s));
                                if ($lk > 0)
                                    $this->found_posts += $_terms->return_count;
                                else
                                    $this->found_posts += $_terms->results_count;
                                $args['taxonomies_limit'] -= $_terms->return_count;
                                $args['taxonomies_limit_override'] -= $_terms->return_count;

                                $args['_exact_matches'] = $_args['_exact_matches'];
                            }
                        }

                        if ( in_array('cpt', $args['search_type']) && count($args['post_type']) > 0 ) {

                            if ( $args['posts_limit_distribute'] == 1) {
                                if ( isset($args['_sd']) && $args['_sd']['use_post_type_order'] == 1 ) {
                                    $_temp_ptypes = array();
                                    foreach ($args['_sd']['post_type_order'] as $pk => $p_order) {
                                        if ( in_array($p_order, $args['post_type']) )
                                            $_temp_ptypes[] = $p_order;
                                    }
                                    $_temp_ptypes = array_unique( array_merge($_temp_ptypes, $args['post_type']) );
                                } else {
                                    $_temp_ptypes = $args['post_type'];
                                }

                                $_temp_ptype_limits = array();

                                foreach ( $_temp_ptypes as $_tptype ) {
                                    $_temp_ptype_limits[$_tptype] = array(
                                        (int)($args['posts_limit'] / count($_temp_ptypes)),
                                        (int)($args['posts_limit_override'] / count($_temp_ptypes))
                                    );
                                }

                                foreach ( $_temp_ptypes as $_tptype ) {
                                    foreach ( $logics as $lk => $logic ) {
                                        if ( $lk > 0 )
                                            $args['_exact_matches'] = 0;
                                        $args['keyword_logic'] = $logic;
                                        $args['post_type'] = array($_tptype);
                                        // Change the limits temporarly for the search
                                        $args['posts_limit'] = $_temp_ptype_limits[$_tptype][0];
                                        $args['posts_limit_override'] = $_temp_ptype_limits[$_tptype][1];
                                        // For exact matches the regular engine is used
                                        if ($args['engine'] == 'regular' || $args['_exact_matches'] == 1 || $s == "")
                                            $_posts = new ASP_Search_CPT($args);
                                        else
                                            $_posts = new ASP_Search_INDEX($args);
                                        $_posts_res = $_posts->search($s);
                                        $ra['allpageposts'] = array_merge($ra['allpageposts'], $_posts_res);
                                        if ($lk > 0)
                                            $this->found_posts += $_posts->return_count;
                                        else
                                            $this->found_posts += $_posts->results_count;
                                        $_temp_ptype_limits[$_tptype][0] -= $_posts->return_count;
                                        $_temp_ptype_limits[$_tptype][1] -= $_posts->return_count;
                                        $args['post_not_in2'] = array_merge($args['post_not_in2'], $this->getResIdsArr($_posts_res));
                                        $args['_exact_matches'] = $_args['_exact_matches'];
                                    }
                                }
                                $args['post_type'] = $_temp_ptypes;
                            } else {
                                foreach ( $logics as $lk => $logic ) {
                                    $args['keyword_logic'] = $logic;
                                    if ( $lk > 0 )
                                        $args['_exact_matches'] = 0;

                                    // For exact matches the regular engine is used
                                    if ($args['engine'] == 'regular' || $args['_exact_matches'] == 1 || $s == "")
                                        $_posts = new ASP_Search_CPT($args);
                                    else
                                        $_posts = new ASP_Search_INDEX($args);
                                    $_posts_res = $_posts->search($s);
                                    $ra['allpageposts'] = array_merge($ra['allpageposts'], $_posts_res);
                                    if ($lk > 0)
                                        $this->found_posts += $_posts->return_count;
                                    else
                                        $this->found_posts += $_posts->results_count;
                                    $args['posts_limit'] -= $_posts->return_count;
                                    $args['posts_limit_override'] -= $_posts->return_count;
                                    $args['post_not_in2'] = array_merge($args['post_not_in2'], $this->getResIdsArr($_posts_res));
                                    $args['_exact_matches'] = $_args['_exact_matches'];
                                }
                            }

                            do_action('asp_after_pagepost_results', $s, $ra['allpageposts']);
                        }

                        if ( in_array('comments', $args['search_type']) ) {
                            foreach ( $logics as $lk => $logic ) {
                                $args['keyword_logic'] = $logic;
                                if ( $lk > 0 )
                                    $args['_exact_matches'] = 0;
                                $_comments = new ASP_Search_COMMENTS($args);
                                $ra['allcommentsresults'] = array_merge($ra['allcommentsresults'], $_comments->search($s));
                                if ($lk > 0)
                                    $this->found_posts += $_comments->return_count;
                                else
                                    $this->found_posts += $_comments->results_count;
                                $args['comments_limit'] -= $_comments->return_count;
                                $args['comments_limit_override'] -= $_comments->return_count;
                                $args['_exact_matches'] = $_args['_exact_matches'];
                            }
                        }
                        do_action('asp_after_comments_results', $s, $ra['allcommentsresults']);

                        if ( in_array('attachments', $args['search_type']) ) {
                            foreach ( $logics as $lk => $logic ) {
                                $args['keyword_logic'] = $logic;
                                if ( $lk > 0 )
                                    $args['_exact_matches'] = 0;
                                $_attachments = new ASP_Search_ATTACHMENTS($args);
                                $_att_res = $_attachments->search($s);
                                $ra['attachment_results'] = array_merge($ra['attachment_results'], $_att_res);
                                if ($lk > 0)
                                    $this->found_posts += $_attachments->return_count;
                                else
                                    $this->found_posts += $_attachments->results_count;
                                $args['attachments_limit'] -= $_attachments->return_count;
                                $args['attachments_limit_override'] -= $_attachments->return_count;
                                $args['attachment_exclude'] = array_merge($args['attachment_exclude'], $this->getResIdsArr($_att_res));
                                $args['_exact_matches'] = $_args['_exact_matches'];
                            }
                        }
                        do_action('asp_after_attachment_results', $s, $ra['attachment_results']);

                        if (is_multisite()) restore_current_blog();
                    }

                }

                if ( in_array('buddypress', $args['search_type']) ) {
                    $_buddyp = new ASP_Search_BUDDYPRESS($args);
                    $buddypresults = $_buddyp->search($s); // !!! returns array for each result (group, user, reply) !!!
                    foreach ($buddypresults as $k => $v) {
                        $ra['allbuddypresults'][$k] = array_merge($ra['allbuddypresults'][$k], $v);
                    }
                    $this->found_posts += $_buddyp->results_count;
                }
                do_action('asp_after_buddypress_results', $s, $ra['allbuddypresults']);

                if ( in_array('users', $args['search_type']) ) {
                    foreach ( $logics as $lk => $logic ) {
                        $args['keyword_logic'] = $logic;
                        if ( $lk > 0 )
                            $args['_exact_matches'] = 0;
                        $_users = new ASP_Search_USERS($args);
                        $_users_res = $_users->search($s);
                        $ra['userresults'] = array_merge($ra['userresults'], $_users_res);
                        if ($lk > 0)
                            $this->found_posts += $_users->return_count;
                        else
                            $this->found_posts += $_users->results_count;
                        $args['user_search_exclude_ids'] = array_merge($args['user_search_exclude_ids'], $this->getResIdsArr($_users_res));
                        $args['_exact_matches'] = $_args['_exact_matches'];
                    }
                }
                do_action('asp_after_user_results', $s, $ra['userresults']);

                if ( in_array('blogs', $args['search_type']) && is_multisite() ) {
                    foreach ( $logics as $lk => $logic ) {
                        $args['keyword_logic'] = $logic;
                        if ( $lk > 0 )
                            $args['_exact_matches'] = 0;
                        $_blogs = new ASP_Search_BLOGS($args);
                        $_blog_res = $_blogs->search($s);
                        $ra['blogresults'] = array_merge($ra['blogresults'], $_blog_res);
                        if ($lk > 0)
                            $this->found_posts += $_blogs->return_count;
                        else
                            $this->found_posts += $_blogs->results_count;
                        $args['blog_exclude'] = array_merge($args['blog_exclude'], $this->getResIdsArr($_blog_res));
                        $args['_exact_matches'] = $_args['_exact_matches'];
                    }
                }
            }
            // ---- Search Porcess Stops Here ----


            $ra['alltermsresults'] = apply_filters('asp_terms_results', $ra['alltermsresults'], $args["_id"]);
            $ra['allpageposts'] = apply_filters('asp_pagepost_results', $ra['allpageposts'], $args["_id"]);
            $ra['allcommentsresults'] = apply_filters('asp_comment_results', $ra['allcommentsresults'], $args["_id"]);
            $ra['allbuddypresults'] = apply_filters('asp_buddyp_results', $ra['allbuddypresults'], $args["_id"]);
            $ra['blogresults'] = apply_filters('asp_blog_results', $ra['blogresults'], $args["_id"]);
            $ra['userresults'] = apply_filters('asp_user_results', $ra['userresults'], $args["_id"]);
            $ra['attachment_results'] = apply_filters('asp_attachment_results', $ra['attachment_results'], $args["_id"]);

            // Results as array, unordered
            $results_arr = array(
                'terms' => $ra['alltermsresults'],
                'blogs' => $ra['blogresults'],
                'bp_activities' => $ra['allbuddypresults']['activityresults'],
                'comments' => $ra['allcommentsresults'],
                'bp_groups' => $ra['allbuddypresults']['groupresults'],
                'bp_users' => $ra['userresults'],
                'post_page_cpt' => $ra['allpageposts'],
                'attachments' => $ra['attachment_results']
            );

            foreach ( $results_arr as $k => $v ) {
                $final = array();
                foreach ( $results_arr[$k] as $kk => $current ) {
                    $found = false;
                    foreach ($final as $item) {
                        if ($item->id == $current->id && $item->blogid == $current->blogid) {
                            $found = true;
                            break;
                        }
                    }
                    if ( !$found )
                        $final[] = $current;
                }
                $results_arr[$k] = $final;
            }

            // Order if search data is set
            if ( isset($args['_sd']) ) {
                $results_order = $args['_sd']['results_order'];

                if (strpos($results_order, 'attachments') === false)
                    $results_order .= "|attachments";

                // These keys are in the right order
                $results_order_arr = explode('|', $results_order);

                $results = array();
                foreach ($results_order_arr as $rk => $rv) {
                    $results = array_merge($results, $results_arr[$rv]);
                }

                $results = apply_filters('asp_results', $results, $args['_id'], $args['_ajax_search']);

                // Group if neccessary
                if (
                    $args['_sd']['resultstype'] == 'vertical' &&
                    $args['_sd']['group_by'] != "none" &&
                    $args['_ajax_search']
                ) {
                    $results = $this->group( $results );
                }
            } else {
                $results = array();
                foreach ($results_arr as $rk => $rv) {
                    $results = array_merge($results, $rv);
                }
                $results = apply_filters('asp_results', $results, -1, false);
            }

            // For non-ajax searches, we need the WP_Post objects
            if ( !$args['_ajax_search'] )
                $results = asp_results_to_wp_obj($results, $args['posts_per_page'] * ($args['page'] - 1), $args['posts_per_page']);

            return $results;
        }

        public function kwSuggestions() {
            if ( !isset($this->args['_sd']) )
                return array();

            $keywords = array();
            $types = array();
            $sd = &$this->args['_sd'];
            $results = array();

            if ($sd['searchinposts'] == 1)
                $types[] = "post";
            if ($sd['searchinpages'] == 1)
                $types[] = "page";
            if (isset($sd['selected-customtypes']) && count($sd['selected-customtypes']) > 0)
                $types = array_merge($types, $sd['selected-customtypes']);

            $remaining_count = 0;
            $possible_phrases = $this->kwPossiblePhrases( $this->args['s'] );

            foreach ($possible_phrases as $phrase) {
                $phrase = trim($phrase);
                if ( $phrase == "" ) continue;

                foreach (w_isset_def($sd['selected-keyword_suggestion_source'], array('google')) as $source) {
                    $remaining_count = $sd['keyword_suggestion_count'] - count($keywords);
                    if ($remaining_count <= 0) break;

                    $taxonomy = "";
                    // Check if this is a taxonomy
                    if (strpos($source, 'xtax_') !== false) {
                        $taxonomy = str_replace('xtax_', '', $source);
                        $source = "terms";
                    }

                    //$class_name = "wpd_" . $source . "KeywordSuggest";

                    $t = new  wpd_keywordSuggest($source, array(
                        'maxCount' => $remaining_count,
                        'maxCharsPerWord' => $sd['keyword_suggestion_length'],
                        'postTypes' => $types,
                        'lang' => $sd['keywordsuggestionslang'],
                        'overrideUrl' => '',
                        'taxonomy' => $taxonomy,
                        'api_key' => $sd['kws_google_places_api']
                    ));

                    $keywords = array_merge($keywords, $t->getKeywords($phrase));
                }

                if ($remaining_count <= 0) break;
            }


            if ($keywords != false) {
                $results['keywords'] = $keywords;
                $results['nores'] = 1;
                $results = apply_filters('asp_only_keyword_results', $results);
            }

            return $results;
        }

        private function kwPossiblePhrases( $phrase ) {
            $pa = explode(" ", $phrase);
            if ( ASP_mb::strlen($pa[0]) > 3 ) {
                return array(
                    $pa[0], ASP_mb::substr($pa[0], 0, -1), ASP_mb::substr($pa[0], 1)
                );
            } else {
                return $pa;
            }
        }

        private function group( $results ) {
            if ( !isset($this->args['_sd']) )
                return false;

            $sd = &$this->args['_sd'];
            $id = $this->args['_id'];

            $groups = array();

            $other_res_group = array(
                "title" => asp_icl_t( "Group (".$id."):", $sd["group_other_results_head"]),
                "items" => array()
            );

            $group_prefix = asp_icl_t( "Group header prefix (".$id.")", $sd['group_header_prefix']);
            $group_suffix = asp_icl_t( "Group header suffix (".$id.")", $sd['group_header_suffix']);

            if ( $sd['group_by'] == "post_type" ) {
                foreach ( $sd['groupby_cpt'] as $k => $v ) {
                    $groups[$v["post_type"]] = array(
                        "title" => $group_prefix . " " . asp_icl_t( "Group (".$id."): " . $v["name"], $v["name"]) . " " . $group_suffix,
                        "items" => array()
                    );
                }
                foreach ($results as $k=>$r) {
                    if ( $r->content_type == "pagepost" && isset($groups[$r->post_type]) ) {
                        $groups[$r->post_type]['items'][] = $r;
                    } else if($sd["group_result_no_group"] != "remove") {
                        $other_res_group['items'][] = $r;
                    }
                }
            } else if ( $sd['group_by'] == "categories_terms" ) {
                $taxonomies = array();
                foreach ( $sd['groupby_terms']['terms'] as $k => $t ) {
                    if ( $t['id'] == -1) {
                        $terms = get_terms($t['taxonomy']);
                        foreach ($terms as $tt) {
                            $groups["_" . $tt->term_id] = array(
                                "title" => $group_prefix . " " . $tt->name . " " . $group_suffix,
                                "items" => array()
                            );
                        }
                    } else {
                        $tt = get_term($t['id'], $t['taxonomy']);
                        $groups["_" . $t['id']] = array(
                            "title" => $group_prefix . " " . $tt->name . " " . $group_suffix,
                            "items" => array()
                        );
                    }
                    if ( !in_array($t['taxonomy'], $taxonomies) )
                        $taxonomies[] = $t['taxonomy'];
                }
                foreach ($results as $k=>$r) {
                    if ( $r->content_type == "pagepost" && count($taxonomies) > 0 ) {
                        $terms = wp_get_object_terms( $r->id, $taxonomies, array('fields'=>'ids') );
                        $matched_a_term = false;
                        foreach ($terms as $tt) {
                            if ( isset($groups["_" . $tt]) ) {
                                $groups["_" . $tt]['items'][] = $r;
                                $matched_a_term = true;
                            }
                            if ($sd['group_exclude_duplicates'] == 1)
                                break;
                        }
                        if ( !$matched_a_term )
                            $other_res_group['items'][] = $r;
                    } else if($sd["group_result_no_group"] != "remove") {
                        $other_res_group['items'][] = $r;
                    }
                }
            } else if ( $sd['group_by'] == "content_type" ) {
                foreach ( $sd['groupby_content_type'] as $k => $v ) {
                    $groups[$k] = array(
                        "title" => $group_prefix . " " . asp_icl_t( "Group (".$id."): " . $v, $v) . " " . $group_suffix,
                        "items" => array()
                    );
                }
                foreach ($results as $k=>$r) {
                    if ( isset($groups[$r->g_content_type]) ) {
                        $groups[$r->g_content_type]['items'][] = $r;
                    } else if($sd["group_result_no_group"] != "remove") {
                        $other_res_group['items'][] = $r;
                    }
                }
            }

            $groups["_other_res"] = $other_res_group;

            // Remove empty groups
            foreach ($groups as $k => $g) {
                if (count($g['items']) == 0) {
                    unset($groups[$k]);
                    continue;
                }
                if ( $sd['group_result_count'] == 1 )
                    $groups[$k]['title'] .= " (".count($groups[$k]['items']).")";
            }

            if ( count($groups) > 0)
                return array("grouped" => 1, "groups" => $groups);
            else
                return array();
        }

        private function applyExceptions( $s ) {
            if ( !isset($this->args['_sd']) )
                return false;

            $sd = &$this->args['_sd'];

            if ($sd["kw_exceptions"] == "" && $sd["kw_exceptions_e"] == "") return $s;

            if ($sd["kw_exceptions"] != "") {
                $exceptions = str_replace(array(" ,", ", ", " , "), ",", $sd["kw_exceptions"]);
                $s = trim( str_replace( explode(",", $exceptions), "", $s) );
                $s = preg_replace('/\s+/', ' ', $s);
            }

            if ($sd["kw_exceptions_e"] != "") {
                $exceptions = str_replace(array(" ,", ", ", " , "), ",", $sd["kw_exceptions_e"]);
                $exceptions = explode(',', $exceptions);
                foreach ($exceptions as $k => &$v)
                    $v = '/\b' . $v . '\b/u';
                unset($v);
                if ( count($exceptions) > 0 ) {
                    $s = trim(preg_replace($exceptions, '', $s));
                    $s = preg_replace('/\s+/', ' ', $s);
                }
            }

            return $s;
        }

        private function getResIdsArr( $r ) {
            $ret = array();
            foreach ($r as $k => $v)
                if ( isset($v->id) )
                    $ret[] = $v->id;
            return $ret;
        }
    }
}