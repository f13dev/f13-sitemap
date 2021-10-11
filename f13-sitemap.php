<?php
/*
Plugin Name: F13 Sitemap
Plugin URI: https://f13.dev/wordpress-plugins/wordpress-plugin-sitemap/
Description: Generate XML and text sitemaps located at /wp-admin/admin-ajax.php?action=f13-sitemap&mode={xml|text}
Version: 0.0.1
Author: Jim Valentine
Author URI: https://f13.dev
Text Domain: f13-sitemap
*/

namespace F13\Sitemap;

if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!defined('F13_SITEMAP')) define('F13_SITEMAP', get_plugin_data(__FILE__, false, false)['Version']);
if (!defined('F13_SITEMAP_PATH')) define('F13_SITEMAP_PATH', plugin_dir_path( __FILE__ ));
if (!defined('F13_SITEMAP_URL')) define('F13_SITEMAP_URL', plugin_dir_url(__FILE__));

class Plugin
{
    public function init()
    {
        spl_autoload_register(__NAMESPACE__.'\Plugin::loader');

        $c = new Controllers\Control();

        if (is_admin()) {
            $a = new Controllers\Admin();
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            $ajax = new Controllers\Ajax();
        }
    }

    public static function loader($name)
    {
        $name = trim(ltrim($name, '\\'));
        if (strpos($name, __NAMESPACE__) !== 0) {
            return;
        }
        $file = str_replace(__NAMESPACE__, '', $name);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $file = plugin_dir_path(__FILE__).strtolower($file).'.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            die('Class not found: '.$name);
        }
    }
}

$p = new Plugin();
$p->init();