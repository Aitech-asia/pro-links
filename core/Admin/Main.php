<?php

namespace ProCore\Admin;

use ProCore\Admin\ProLinks;
use ProCore\Admin\Prototype;
use ProCore\Systems\DLog;
use ProCore\Data\Database;
use ProCore\Pagination\PaginationData;


class Main extends Prototype
{
    private $home_url;
    private $setting_tabs = array();

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->hooks();
    }

    /**
     * Setup Hooks
     *
     * @since 1.0.0
     */
    public function hooks()
    {
        add_action('admin_menu', array($this, 'app_menu'));
        add_action('admin_init', array($this, 'admin_init'));

    }

    /**
     * Sidebar tab
     *
     * @since 1.0.0
     */
    public function app_menu()
    {
        // Add to admin_menu
        add_menu_page(__(PRO_LINKS_NAME), __(PRO_LINKS_NAME), 'edit_theme_options', PRO_LINKS_SLUG, [
            $this,
            'main_page_content'
        ], 'dashicons-products', 10);


        $this->home_url = admin_url('admin.php?page='.PRO_LINKS_SLUG);
        $this->add_tab("data", "Data");
        $this->add_tab("setting", "Setting");
    }

    /**
     * Parse Token
     */
    public function admin_init()
    {

    }

    /**
     * Main page content.
     *
     * @since 1.0.0
     */
    public function main_page_content()
    {
        $this->load_template('page-index', 'admin');
    }

    /**
     * Add Tab Core
     *
     * @param string $name
     * @return file include
     */
    public function add_tab($slug, $title)
    {
        if (!isset($this->setting_tabs[$slug])) {
            $this->setting_tabs[$slug] = $title;
            return true;
        }
        return false;
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
            case 'core_options':
                return get_option('core_options');
                break;
            case 'getLinkAll':
                if (isset($_GET["paged"])) {
                    $page = preg_replace("#[^0-9]#", "", $_GET["paged"]);
                    $offset = ($page - 1) * LIMIT_PAGE;
                } else {
                    $page = 1;
                    $offset = ($page - 1) * LIMIT_PAGE;
                }

                $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';

                $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

                return ProLinks::getLinkAll(LIMIT_PAGE, $offset, $orderby, $order);
                break;
            default:
                return parent::__get($name);
                break;
        }
    }

    /**
     * Pagination
     *
     * @since    1.0.0
     */
    public static function Pagination($argv)
    {
        $pagi = new PaginationData($argv);
        $data = $pagi->compute();
        if ($data == null) {
            return;
        }
        $transPageOf = sprintf(_(''), $pagi->getPageIndex(), $pagi->getPageCount());
        $trans_dots = "...";
        echo '<div  class="pagination">';
        foreach ($data['items'] as $one_element) {
            if ($one_element['selected'] == true) {
                echo '<a class="active">';
                echo $one_element['page'];
                echo '</a>';
            } elseif ($one_element['page'] == 'startdot' || $one_element['page'] == 'enddot') {
            } else {
                echo '<a href="' . $one_element['link'] . '" id="page-' . $one_element['page'] . '">';
                echo $one_element['page'];
                echo '</a>';
            }
        }
        echo '</div>';
    }
}