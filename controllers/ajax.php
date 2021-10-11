<?php namespace F13\Sitemap\Controllers;

class Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_f13_sitemap', array($this, 'sitemap'));
        add_action('wp_ajax_f13_sitemap', array($this, 'sitemap'));
    }

    public function sitemap() { $c = new Control(); echo $c->sitemap(); die; }
}