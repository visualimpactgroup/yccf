<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_SearchOverride_Filter")) {
    /**
     * Class WD_ASP_SearchOverride_Filter
     *
     * Handles search override filters
     *
     * @class         WD_ASP_SearchOverride_Filter
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Filters
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_SearchOverride_Filter extends WD_ASP_Filter_Abstract {

        public function handle() {}

        public function override($posts, $wp_query) {

            // Is this a search query
            // !isset() instead of empty(), because it can be an empty string
            if (!isset($wp_query->query_vars['s'])) {
                return $posts;
            }
            // If get method is used, then the session is not loaded at all
            if (isset($_GET['p_asp_data']) || isset($_GET['np_asp_data'])) {
                $_p_data = isset($_GET['p_asp_data']) ? $_GET['p_asp_data'] : $_GET['np_asp_data'];
                $_p_id = isset($_GET['p_asid']) ? $_GET['p_asid'] : $_GET['np_asid'];
                parse_str(base64_decode($_p_data), $s_data);
            } else {
                // Is this just a NEW regular search?
                if ( isset($_POST['asp_active']) ) {
                    // Then clear the override
                    wd_asp()->wp_session['asp_override'] = false;
                }

                // Memorize the data across pagination for the form values..
                if (isset($_POST['p_asp_data']) || isset($_POST['np_asp_data'])) {
                    $_p_data = isset($_POST['p_asp_data']) ? $_POST['p_asp_data'] : $_POST['np_asp_data'];
                    $_p_id = isset($_POST['p_asid']) ? $_POST['p_asid'] : $_POST['np_asid'];
                    wd_asp()->wp_session['asp_form_data'] = array(
                        "data" => $_p_data,
                        "id"   => $_p_id
                    );
                } else if ( !empty(wd_asp()->wp_session['asp_form_data']) ) {
                    // Get the memorized data if exists
                    if ( is_object(wd_asp()->wp_session['asp_form_data']['data']) )
                        $_POST['np_asp_data'] = wd_asp()->wp_session['asp_form_data']['data']->toArray();
                    else
                        $_POST['np_asp_data'] = wd_asp()->wp_session['asp_form_data']['data'];
                    $_POST['np_asid'] = wd_asp()->wp_session['asp_form_data']['id'];
                }

                if (isset($_POST['p_asp_data']) && $_POST['p_asp_data'] != '') {
                    $_method = &$_POST;
                    parse_str($_method['p_asp_data'], $s_data);
                    $_p_id =  $_POST['p_asid'];

                    // this is a new POST search, so set the session
                    wd_asp()->wp_session['asp_override'] = array(
                        "asp_data" => $s_data,
                        "asid" => $_POST['p_asid']
                    );
                } else  {
                    // Is this a paginated search?
                    if ( !empty(wd_asp()->wp_session['asp_override']) ) {
                        // ->toArray() method needs to be invoked, if the session handler converts the recursive array
                        if ( is_object(wd_asp()->wp_session['asp_override']['asp_data']) )
                            $s_data = wd_asp()->wp_session['asp_override']['asp_data']->toArray();
                        else
                            $s_data = wd_asp()->wp_session['asp_override']['asp_data'];
                        $_p_id =  wd_asp()->wp_session['asp_override']['asid'];
                    } else {
                        return $posts;
                    }
                }
            }

            // The get_query_var() is malfunctioning in some cases!!! use $_GET['paged']
            //$paged = (get_query_var('paged') != 0) ? get_query_var('paged') : 1;
            if ( isset($_GET['paged']) ) {
                $paged = $_GET['paged'];
            } else if ( isset($wp_query->query_vars['paged']) ) {
                $paged = $wp_query->query_vars['paged'];
            } else {
                $paged = 1;
            }

            $paged = $paged <= 0 ? 1 : $paged;
            $posts_per_page = (int)get_option('posts_per_page');

            $asp_query = new ASP_Query(array(
                "s" => $_GET['s'],
                "_ajax_search" => false,
                "posts_per_page"    => $posts_per_page,
                "page"  => $paged
            ), $_p_id, $s_data);
            $res = $asp_query->posts;

            $wp_query->found_posts = $asp_query->found_posts;
            if (($wp_query->found_posts / $posts_per_page) > 1)
                $wp_query->max_num_pages = ceil($wp_query->found_posts / $posts_per_page);
            else
                $wp_query->max_num_pages = 0;

            return $res;
        }

        public function fixUrls( $url, $post, $leavename ) {
            if (isset($post->asp_guid))
                return $post->asp_guid;
            return $url;
        }

        // ------------------------------------------------------------
        //   ---------------- SINGLETON SPECIFIC --------------------
        // ------------------------------------------------------------
        public static function getInstance() {
            if ( ! ( self::$_instance instanceof self ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }
}