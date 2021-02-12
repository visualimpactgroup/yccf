<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_Deletecache_Handler")) {
    /**
     * Class WD_MS_Search_Handler
     *
     * Cache delete ajax request handler
     *
     * @class         WD_ASP_Handler_Abstract
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Ajax
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_Deletecache_Handler extends WD_ASP_Handler_Abstract {

        /**
         * Deletes the Ajax Search Pro directory
         */
        public function handle() {
            if ( wd_asp()->upload_path !== "" )
                print $this->delFiles(wd_asp()->upload_path);
            exit;
        }

        /**
         * Delete *.wpd files in directory
         *
         * @param $dir string
         * @return int files and directories deleted
         */
        private function delFiles($dir) {
            global $wp_filesystem;

            $count = 0;
            $files = @glob($dir . '*.wpd', GLOB_MARK);
            foreach ($files as $file) {
                $wp_filesystem->delete($file);
                $count++;
            }
            return $count;
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