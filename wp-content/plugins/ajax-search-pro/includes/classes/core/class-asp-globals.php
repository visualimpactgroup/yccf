<?php
if (!defined('ABSPATH')) die('-1');
/**
 * Class WD_ASP_Globals
 *
 * A container class for the global variables
 *
 * @class         WD_ASP_Globals
 * @version       1.0
 * @package       AjaxSearchPro/Classes/Core
 * @category      Class
 * @author        Ernest Marcinko
 */
class WD_ASP_Globals {

    /**
     * The plugin options and defaults
     *
     * @var array
     */
    public $options;

    /**
     * The plugin options and defaults (shorthand)
     *
     * @var array
     */
    public $o;

    /**
     * Instance of the init class
     *
     * @var WD_ASP_Init()
     */
    public $init;

    /**
     * Instance of the instances class
     *
     * @var WD_ASP_Instances()
     */
    public $instances;

    /**
     * Instance of the updates manager
     *
     * @var asp_updates()
     */
    public $updates;

    /**
     * Instance of the database manager
     *
     * @var WD_ASP_DBMan()
     */
    public $db;

    /**
     * Instance of the manager
     *
     * @var WD_ASP_Manager()
     */
    public $manager;

    /**
     * Array of ASP tables
     *
     * @var array
     */
    public $tables;

    /**
     * Session information
     *
     * @var WP_Session()
     */
    public $wp_session;

    /**
     * Holds the correct table prefix for ASP tables
     *
     * @var string
     */
    public $_prefix;

    /**
     * The upload directory for the plugin
     *
     * @var string
     */
    public $upload_dir = "asp_upload";

    /**
     * The upload path
     *
     * @var string
     */
    public $upload_path;

    /**
     * The upload URL
     *
     * @var string
     */
    public $upload_url;
}