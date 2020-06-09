<?php
/*
Plugin Name: Pro Links
Plugin URI: https://aitech.asia/wordpress/#prolinks
Description: Short Link, track and share any URL using your website and brand!
Version: 1.1.1
Author:  Aitech Asia
Author URI: https://aitech.asia
Text Domain: pro-link
Copyright: 2020 aitech Asia
*/
if (!defined('ABSPATH'))
    exit;
if (defined('WP_CLI') && WP_CLI)
    require('command.php');
if (!defined('PRO_LINKS_NAME'))
    define('PRO_LINKS_NAME', 'Pro Affiliate Link ');
if (!defined('PRO_LINKS_VERSION'))
    define('PRO_LINKS_VERSION', '1.1');
if (!defined('PRO_LINKS_SLUG'))
    define('PRO_LINKS_SLUG', 'pro-links');
if (!defined('PRO_LINKS_PLUGIN_DIR'))
    define('PRO_LINKS_PLUGIN_DIR', plugin_dir_path(__FILE__));
if (!defined('PRO_LINKS_PLUGIN_DIRNAME'))
    define('PRO_LINKS_PLUGIN_DIRNAME', __FILE__);
const  LIMIT_PAGE = 20;
use ProCore\Admin\Main;
use ProCore\Data\Database;

// Require plugin autoload
require_once(PRO_LINKS_PLUGIN_DIR . 'vendor/autoload.php');

if (!class_exists('Prolinks')) :
    class Prolinks
    {
        /**
         * The single instance of the class
         *
         * @since 1.0.0
         */
        private static $_instance = null;

        /**
         * Get instance
         *
         * @return Core
         * @since 1.0.0
         */
        public static function instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Constructor
         *
         * @since 1.0.0
         */
        public function __construct()
        {

            // Initialize plugin parts
            add_action('plugins_loaded', array($this, 'init'));
            // Plugin updates
            add_action('admin_init', array($this, 'admin_init'));

            if (is_admin()) {
                // Plugin activation
                add_action('activated_plugin', array($this, 'plugin_activation'));
            }
        }


        /**
         * Init
         *
         * @since 1.0.0
         */
        public function init()
        {
            if (is_admin()) {
                //Load page Admin layout
                new Main();
            }
        }

        /**
         * Admin init
         */
        public function admin_init()
        {
            if (is_admin()) {
                // Check plugin version
                $this->check_version();

                // Add the plugin page Settings and Docs links
                add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_links'));
                // Register plugin deactivation hook
                register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));
                // Plugin activation
                add_action('activated_plugin', array($this, 'plugin_activation'));

            }
            // Enqueue styles
            add_action('admin_enqueue_scripts', array($this, 'register_style'));

            // Enqueue scripts
            add_action('admin_enqueue_scripts', array($this, 'register_script'));

        }

        public function register_style()
        {
            wp_enqueue_style('base_global_styles', plugins_url('assets/css/global.css', __FILE__),'proLinks',PRO_LINKS_VERSION);
            wp_enqueue_style('base_app_styles', plugins_url('/assets/css/app.css', __FILE__),'proLinks',PRO_LINKS_VERSION);
        }

        public function register_script()
        {
        }

        /**
         * Check version
         *
         * @since 1.0.0
         */
        public function check_version()
        {
        }

        /**
         * Plugin activation
         *
         * @param $plugin
         * @since 1.0.0
         */
        public function plugin_activation($plugin)
        {
            if ($plugin == plugin_basename(__FILE__)) {
                // Active install database
                Database::db_install();
            }
        }

        /**
         * Plugin deactivation
         */
        public function plugin_deactivation()
        {
        }

        /**
         * Plugin plugin_links
         */
        public function plugin_links($links)
        {
            $more_links[] = '<a href="'. esc_url( 'https://github.com/Aitech-asia/pro-links' ) .'" class="pro-Link-green">'.esc_html__('Pro License', 'pro-link').'</a>';
            return array_merge($more_links, $links);
        }

    }

    new Prolinks();

endif;