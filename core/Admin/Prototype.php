<?php

namespace ProCore\Admin;

use ProCore\Pattern\Singleton;
use ProCore\Admin\Utility;

/**
 * Prototype
 *
 * @property-read Input $input
 * @property-read string $base_dir
 * @property-read string $template_dir
 * @property-read string $asset_url
 */
class Prototype extends Singleton
{



    /**
     * Show message on admin screen
     *
     * @param string $msg
     * @param bool $error
     */
    protected function show_message($msg, $error = false)
    {
        add_action("admin_notices", function () use ($msg, $error) {
            printf('<div class="%s"><p>%s</p></div>', $error ? 'error' : 'updated', esc_html($msg));
        });
    }

    /**
     * Getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'input':
                return Utility::get_instance();
                break;
            case 'base_dir':
                return dirname(dirname(dirname(dirname(__DIR__))));
                break;
            case 'template_dir':
                return $this->base_dir . DIRECTORY_SEPARATOR . 'templates';
                break;
            case 'asset_url':
                return str_replace(ABSPATH, home_url('/', is_ssl() ? 'https' : 'http'), $this->base_dir) . '/public';
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Load templates File
     *
     * @param string $name
     * @return file include
     */
    public function load_template($file,$folder="admin")
    {
        if (false !== strpos($file, '../')) {
            return;
        }
        if (file_exists(PRO_LINKS_PLUGIN_DIR . '/templates/'.$folder.'/' . $file . '.phtml')) {
            include(PRO_LINKS_PLUGIN_DIR . '/templates/'.$folder.'/' . $file . '.phtml');
        }
    }
}