<?php namespace F13\Sitemap\Controllers;

class Control
{
    public $request_method;

    public function __construct()
    {
        $this->request_method = ($_SERVER['REQUEST_METHOD'] === 'POST') ? INPUT_POST : INPUT_GET;
    }

    public function sitemap()
    {
        $mode = filter_input($this->request_method, 'mode');

        if (empty($mode)) {
            $mode = 'xml';
        }

        $data = \F13\Sitemap\Models\Sitemap::get_list_links();

        if ($mode == 'xml') {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($data as $link) {
                $xml .= '<url>';
                    $xml .= '<loc>'.$link->permalink.'</loc>';
                    $date = explode(' ', $link->post_modified_gmt);
                    $date = $date[0];
                    $xml .= '<lastmod>'.$date.'</lastmod>';
                $xml .= '</url>';
            }
            $xml .= '</urlset>';
            header('Content-type: text/xml');
            echo $xml;
            die;
        }

        if ($mode == 'text') {
            header("Content-Type: text/plain");
            foreach ($data as $link) {
                echo $link->permalink."\r\n";
            }
            die;
        }
    }
}