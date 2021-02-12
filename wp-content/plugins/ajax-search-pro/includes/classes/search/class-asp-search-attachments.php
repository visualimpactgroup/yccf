<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

if (!class_exists('ASP_Search_ATTACHMENTS')) {
    /**
     * Attachment search
     *
     * @class       ASP_Search_ATTACHMENTS
     * @version     1.0
     * @package     AjaxSearchPro/Classes
     * @category    Class
     * @author      Ernest Marcinko
     */
    class ASP_Search_ATTACHMENTS extends ASP_Search_CPT
    {

        /**
         * @var array of query parts
         */
        protected $parts = array();
        /**
         * @var array of custom field query parts
         */
        protected $cf_parts = array();
        /**
         * @var int the remaining limit (number of items to look for)
         */
        protected $remaining_limit;
        /**
         * @var int the start of the limit
         */
        protected $limit_start = 0;
        /**
         * @var string the final search query
         */
        protected $query;

        /**
         * Content search function
         *
         * @return array|string
         */
        protected function do_search() {
            global $wpdb;
            global $q_config;

            $args = &$this->args;
            if (isset($args["_sd"]))
                $sd = &$args["_sd"];
            else
                $sd = array();

            // Prefixes and suffixes
            $pre_field = $this->pre_field;
            $suf_field = $this->suf_field;
            $pre_like = $this->pre_like;
            $suf_like = $this->suf_like;

            $kw_logic = $args['keyword_logic'];
            $q_config['language'] = $args['_qtranslate_lang'];

            $s = $this->s; // full keyword
            $_s = $this->_s; // array of keywords

            if ( $args['_limit'] > 0 ) {
                $this->remaining_limit = $args['_limit'];
            } else {
                if ( $args['_ajax_search'] )
                    $this->remaining_limit = $args['attachments_limit'];
                else
                    $this->remaining_limit = $args['attachments_limit_override'];
            }
            $query_limit = $this->remaining_limit * 3;

            if ($this->remaining_limit <= 0)
                return array();

            /*------------------------- Statuses ----------------------------*/
            // Attachments are inherit only
            $post_statuses = "(" . $pre_field . $wpdb->posts . ".post_status" . $suf_field . " = 'inherit' )";
            /*---------------------------------------------------------------*/

            /*----------------------- Gather Types --------------------------*/
            $post_types = "($wpdb->posts.post_type = 'attachment' )";
            /*---------------------------------------------------------------*/

            // ------------------------ Categories/taxonomies ----------------------
            $term_query = $this->build_term_query( $wpdb->posts.".ID" );
            // ---------------------------------------------------------------------

            // ------------------------- TAGS QUERY --------------------------------
            $tag_query = $this->build_tag_query( $wpdb->posts.".ID", $wpdb->posts.".post_type" );
            // ---------------------------------------------------------------------

            /*------------------------- Mime Types --------------------------*/
            $mime_types = "";
            if (!empty($args['attachment_mime_types']))
                $mime_types = "AND ( $wpdb->posts.post_mime_type IN ('" . implode("','", $args['attachment_mime_types']) . "') )";
            /*---------------------------------------------------------------*/

            /*------------------------ Exclude id's -------------------------*/
            $exclude_posts = "";
            if (!empty($args['attachment_exclude']))
                $exclude_posts = "AND ($wpdb->posts.ID NOT IN (" . implode(",", $sd['attachment_exclude']) . "))";
            /*---------------------------------------------------------------*/


            /*------------------------ Term JOIN -------------------------*/
            // If the search in terms is not active, we don't need this unnecessary big join
            $term_join = "";
            if ($args['attachments_search_terms']) {
                $term_join = "
                LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
                LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
                LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id";
            }
            /*---------------------------------------------------------------*/

            /*----------------------- Date filtering ------------------------*/
            $date_query = "";
            $date_query_parts = $this->get_date_query_parts();
            if (count($date_query_parts) > 0)
                $date_query = " AND (" . implode(" AND ", $date_query_parts) . ") ";
            /*---------------------------------------------------------------*/

            /*----------------------- Exclude USER id -----------------------*/
            $user_query = "";
            if ( isset($args['post_user_filter']['include']) ) {
                if ( !in_array(-1, $args['post_user_filter']['include']) )
                    $user_query = "AND $wpdb->posts.post_author IN (".implode(", ", $args['post_user_filter']['include']).")
                    ";
            }
            if ( isset($args['post_user_filter']['exclude']) ) {
                if ( !in_array(-1, $args['post_user_filter']['exclude']) )
                    $user_query = "AND $wpdb->posts.post_author NOT IN (".implode(", ", $args['post_user_filter']['exclude']).") ";
                else
                    return array();
            }
            /*---------------------------------------------------------------*/

            if ( strpos($args['post_primary_order'], 'customfp') !== false )
                $orderby_primary = 'relevance DESC';
            else
                $orderby_primary = str_replace("post_", $wpdb->posts . ".post_", $args['post_primary_order']);

            if ( strpos($args['post_secondary_order'], 'customfs') !== false )
                $orderby_secondary = 'date DESC';
            else
                $orderby_secondary = str_replace("post_", $wpdb->posts . ".post_", $args['post_secondary_order']);

            /**
             * This is the main query.
             *
             * The ttid field is a bit tricky as the term_taxonomy_id doesn't always equal term_id,
             * so we need the LEFT JOINS :(
             */
            $this->query = "
    		SELECT
    		DISTINCT($wpdb->posts.ID) as id,
    		$this->c_blogid as blogid,
            $wpdb->posts.post_title as title,
            $wpdb->posts.post_date as date,
            $wpdb->posts.post_content as content,
            $wpdb->posts.post_excerpt as excerpt,
            $wpdb->posts.post_type as post_type,
            $wpdb->posts.post_mime_type as post_mime_type,
            $wpdb->posts.guid as guid,
            'pagepost' as content_type,
            'attachments' as g_content_type,
            (SELECT
                $wpdb->users." . w_isset_def($sd['author_field'], 'display_name') . " as author
                FROM $wpdb->users
                WHERE $wpdb->users.ID = $wpdb->posts.post_author
            ) as author,
            '' as ttid,
            $wpdb->posts.post_type as post_type,
            100 AS priority,
            {relevance_query} as relevance
            FROM $wpdb->posts
            $term_join
            WHERE
                    $post_types
                AND $post_statuses
                AND {like_query}
                $exclude_posts
                $mime_types
                $term_query
                $tag_query
                $date_query
                $user_query
            ORDER BY priority DESC, $orderby_primary, $orderby_secondary
            LIMIT $query_limit";


            $words = $args["_exact_matches"] == 1 ? array($s) : $_s;

            /*----------------------- Title query ---------------------------*/
            if ($s != "") {
                if ($args['attachments_search_title']) {
                    $parts = array();
                    $relevance_parts = array();

                    if ($kw_logic == 'or' || $kw_logic == 'and') {
                        $op = strtoupper($kw_logic);
                        if (count($_s) > 0)
                            $_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'%", $words);
                        else
                            $_like = $s;
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
                    } else {
                        $_like = array();
                        $op = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ($words as $word) {
                            $_like[] = "
                           ( " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode(' ' . $op . ' ', $_like) . ")";
                    }

                    $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%$s%')
                 then " . w_isset_def($sd['etitleweight'], 10) . " else 0 end)";

                    // The first word relevance is higher
                    if (count($_s) > 0)
                        $relevance_parts[] = "(case when
                  (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%" . $_s[0] . "%')
                   then " . w_isset_def($sd['etitleweight'], 10) . " else 0 end)";

                    $this->parts[] = array($parts, $relevance_parts);
                }
                /*---------------------------------------------------------------*/

                /*---------------------- Content query --------------------------*/
                if ($args['attachments_search_content']) {
                    $parts = array();
                    $relevance_parts = array();

                    if ($kw_logic == 'or' || $kw_logic == 'and') {
                        $op = strtoupper($kw_logic);
                        if (count($_s) > 0)
                            $_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'%", $words);
                        else
                            $_like = $s;
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
                    } else {
                        $_like = array();
                        $op = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ($words as $word) {
                            $_like[] = "
                           (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode(' ' . $op . ' ', $_like) . ")";
                    }

                    if (count($_s) > 0)
                        $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%" . $_s[0] . "%')
                     then " . w_isset_def($sd['contentweight'], 10) . " else 0 end)";
                    $relevance_parts[] = "(case when
                (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%$s%')
                 then " . w_isset_def($sd['econtentweight'], 10) . " else 0 end)";

                    $this->parts[] = array($parts, $relevance_parts);
                }
                /*---------------------------------------------------------------*/

                /*------------------- Caption/Excerpt query ---------------------*/
                if ($args['attachments_search_caption']) {
                    $parts = array();
                    $relevance_parts = array();

                    if ($kw_logic == 'or' || $kw_logic == 'and') {
                        $op = strtoupper($kw_logic);
                        if (count($_s) > 0)
                            $_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'%", $words);
                        else
                            $_like = $s;
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
                    } else {
                        $_like = array();
                        $op = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ($words as $word) {
                            $_like[] = "
                           (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                        OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode(' ' . $op . ' ', $_like) . ")";
                    }

                    if (count($_s) > 0)
                        $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE '%" . $_s[0] . "%')
                     then " . w_isset_def($sd['contentweight'], 10) . " else 0 end)";

                    $this->parts[] = array($parts, $relevance_parts);
                }
                /*---------------------------------------------------------------*/

                /*------------------------ Term query ---------------------------*/
                if ($args['attachments_search_terms']) {
                    $parts = array();
                    $relevance_parts = array();

                    if ($kw_logic == 'or' || $kw_logic == 'and') {
                        $op = strtoupper($kw_logic);
                        if (count($_s) > 0) {
                            $_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'%", $words);
                        } else {
                            $_like = $s;
                        }
                        $parts[] = "( " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'%" . $_like . "%'$suf_like )";
                    } else {
                        $_like = array();
                        $op = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ($words as $word) {
                            $_like[] = "
                           (" . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                        OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode(' ' . $op . ' ', $_like) . ")";
                    }

                    $this->parts[] = array($parts, $relevance_parts);
                }
                /*---------------------------------------------------------------*/
            }

            $querystr = $this->build_query($this->parts, true);
            $attachments = $wpdb->get_results($querystr, OBJECT);
            $this->results_count = count($attachments);

            // For non-ajax search, results count needs to be limited to the maximum limit,
            // ..as nothing is parsed beyond that
            if ($args['_ajax_search'] == false && $this->results_count > $this->remaining_limit) {
                $this->results_count = $this->remaining_limit;
            }

            $attachments = array_slice($attachments, $args['_call_num'] * $this->remaining_limit, $this->remaining_limit);

            $this->results = $attachments;
            $this->return_count = count($this->results);

            return $attachments;
        }

        protected function post_process() {
            parent::post_process();

            $args = &$this->args;
            if (isset($args["_sd"]))
                $sd = &$args["_sd"];
            else
                $sd = array();

			foreach ($this->results as $k => $r) {
                if ($args['attachment_use_image'] == 1 && strpos($r->post_mime_type, 'image/') !== false && $r->guid != "")
                    $this->results[$k]->image = wp_get_attachment_url( $r->id );

                /* Remove the results in polaroid mode */
                if ($args['_ajax_search'] && empty($r->image) && isset($sd['resultstype']) &&
                    $sd['resultstype'] == 'polaroid' && $sd['pifnoimage'] == 'removeres') {
                    unset($this->results[$k]);
                    continue;
                }

                // --------------------------------- DATE -----------------------------------
                if (isset($sd["attachment_link_to"]) && $sd["attachment_link_to"] == 'file') {
                    $_url = wp_get_attachment_url( $r->id );
                    if ( $_url !== false )
                        $this->results[$k]->link = $_url;
                }
                // --------------------------------------------------------------------------

                // --------------------------------- DATE -----------------------------------
                if (isset($sd["showdate"]) && $sd["showdate"] == 1) {
                    $post_time = strtotime($this->results[$k]->date);

                    if ($sd['custom_date'] == 1) {
                        $date_format = w_isset_def($sd['custom_date_format'], "Y-m-d H:i:s");
                    } else {
                        $date_format = get_option('date_format', "Y-m-d") . " " . get_option('time_format', "H:i:s");
                    }

                    $this->results[$k]->date = @date_i18n($date_format, $post_time);
                }
                // --------------------------------------------------------------------------
            }

			return $this->results;
		}

        protected function group() {
            return $this->results;
        }
    }
}