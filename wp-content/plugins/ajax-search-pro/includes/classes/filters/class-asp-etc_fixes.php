<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_EtcFixes_Filter")) {
    /**
     * Class WD_ASP_EtcFixes_Filter
     *
     * Other 3rd party plugin related filters
     *
     * @class         WD_ASP_EtcFixes_Filter
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Filters
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_EtcFixes_Filter extends WD_ASP_Filter_Abstract {

        /**
         * Fix for the Download Monitor plugin download urls
         *
         * @param $r
         * @param $sid
         * @return mixed
         */
        function plug_DownloadMonitorLink($r, $sid) {
            if ( $r->post_type == "dlm_download" && class_exists("DLM_Download") ) {
                $dl = new DLM_Download($r->id);
                if ( $dl->exists() ) {
                    $r->link = $dl->get_the_download_link();
                }
            }
            return $r;
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