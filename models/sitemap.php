<?php namespace F13\Sitemap\Models;

class Sitemap
{
    public static function get_list_links()
    {
        $pages = get_pages();
        $posts = get_posts(array('numberposts' => -1));

        $posts = array_merge($posts, $pages);

        $links = array();

        foreach ($posts as $post) {
            if ($post->post_status == 'publish') {
                $post_url = get_permalink($post->ID);
                $post_data = array(
                    'ID'                => $post->ID,
                    'permalink'         => $post_url,
                    'post_date'         => $post->post_date,
                    'post_date_gmt'     => $post->post_date_gmt,
                    'post_title'        => $post->post_title,
                    'post_status'       => $post->post_status,
                    'post_modified'     => $post->post_modified,
                    'post_modified_gmt' => $post->post_modified_gmt,
                );
                $links[$post_url] = (object) $post_data;
            }
        }

        ksort($links);

        return (object) $links;
    }
}