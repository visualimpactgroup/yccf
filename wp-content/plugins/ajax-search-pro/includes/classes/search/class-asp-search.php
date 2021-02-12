<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

if (!class_exists('ASP_Search')) {
    /**
     * Search class Abstract
     *
     * All search classes should be descendants to this abstract.
     *
     * @class       ASP_Search
     * @version     2.0
     * @package     AjaxSearchPro/Abstracts
     * @category    Class
     * @author      Ernest Marcinko
     */
    abstract class ASP_Search {

        // Total results count (unlimited)
        public $results_count = 0;

        // Actual results count, results which are returned
        public $return_count = 0;

        /**
         * @var array of parameters
         */
        protected $args;

        protected $pre_field = '';
        protected $suf_field = '';
        protected $pre_like  = '';
        protected $suf_like  = '';

        /**
         * @var array of submitted options from the front end
         */
        protected $options;
        /**
         * @var int the ID of the current search instance
         */
        protected $searchId;
        /**
         * @var array of the current search options
         */
        protected $searchData;
        /**
         * @var array of results
         */
        protected $results;
        /**
         * @var string the search phrase
         */
        protected $s;
        /**
         * @var array of each search phrase
         */
        protected $_s;
        /**
         * @var string the reversed search phrase
         */
        protected $sr;
        /**
         * @var array of each reversed search phrase
         */
        protected $_sr;

        /**
         * @var int the current blog ID
         */
        protected $c_blogid;

        /**
         * Create the class
         *
         * @param $params
         */
        public function __construct($args) {
            $this->args = $args;

            $this->c_blogid = get_current_blog_id();
        }

        /**
         * Initiates the search operation
         *
         * @return array
         */
        public function search( $s = false ) {
            if ( $s !== false )
                $keyword = $s;
            else
                $keyword = $this->args['s'];

            $keyword = $this->compatibility($keyword);
            $keyword_rev = ASP_Helpers::reverseString($keyword);

            $this->s = ASP_Helpers::escape( $keyword );
            $this->sr = ASP_Helpers::escape( $keyword_rev );

            // Avoid double escape, explode the $keyword instead of $this->s
            $this->_s = ASP_Helpers::escape( array_slice(array_unique( explode(" ", $keyword) ), 0, 6) );
            $this->_sr = ASP_Helpers::escape( array_slice(array_unique( array_reverse( explode(" ", $keyword_rev ) ) ), 0, 6) );


            $this->do_search();
            $this->post_process();

            return is_array($this->results) ? $this->results : array();
        }

        /**
         * The search function
         */
        protected function do_search() {}

        /**
         * Post processing abstract
         */
        protected function post_process() {

            if (is_array($this->results) && count($this->results) > 0) {
                foreach ($this->results as $k => $v) {

                    $r = & $this->results[$k];

                    if (!is_object($r) || count($r) <= 0) continue;
                    if (!isset($r->id)) $r->id = 0;
                    $r->image = isset($r->image) ? $r->image : "";
                    $r->title = apply_filters('asp_result_title_before_prostproc', $r->title, $r->id);
                    $r->content = apply_filters('asp_result_content_before_prostproc', $r->content, $r->id);
                    $r->image = apply_filters('asp_result_image_before_prostproc', $r->image, $r->id);
                    $r->author = apply_filters('asp_result_author_before_prostproc', $r->author, $r->id);
                    $r->date = apply_filters('asp_result_date_before_prostproc', $r->date, $r->id);


                    $r->title = apply_filters('asp_result_title_after_prostproc', $r->title, $r->id);
                    $r->content = apply_filters('asp_result_content_after_prostproc', $r->content, $r->id);
                    $r->image = apply_filters('asp_result_image_after_prostproc', $r->image, $r->id);
                    $r->author = apply_filters('asp_result_author_after_prostproc', $r->author, $r->id);
                    $r->date = apply_filters('asp_result_date_after_prostproc', $r->date, $r->id);

                }
            }

        }

        /**
         * Converts the keyword to the correct case and sets up the pre-suff fields.
         *
         * @param $s
         * @return string
         */
        protected function compatibility($s) {
            /**
             *  On forced case sensitivity: Let's add BINARY keyword before the LIKE
             *  On forced case in-sensitivity: Append the lower() function around each field
             */
            if ( $this->args['_db_force_case'] === 'sensitivity' ) {
                $this->pre_like = 'BINARY ';
            } else if ( $this->args['_db_force_case'] === 'insensitivity' ) {
                if ( function_exists( 'mb_convert_case' ) )
                    $s = mb_convert_case( $s, MB_CASE_LOWER, "UTF-8" );
                else
                    $s = strtoupper( $s );
                // if no mb_ functions :(

                $this->pre_field .= 'lower(';
                $this->suf_field .= ')';
            }

            /**
             *  Check if utf8 is forced on LIKE
             */
            if ( w_isset_def( $this->args['_db_force_utf8_like'], 0 ) == 1 )
                $this->pre_like .= '_utf8';

            /**
             *  Check if unicode is forced on LIKE, but only apply if utf8 is not
             */
            if ( w_isset_def( $this->args['_db_force_unicode'], 0 ) == 1
                && w_isset_def( $this->args['_db_force_utf8_like'], 0 ) == 0
            )
                $this->pre_like .= 'N';

            return $s;
        }
    }
}