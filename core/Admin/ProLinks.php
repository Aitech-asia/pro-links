<?php

namespace ProCore\Admin;

class ProLinks
{

    public function __construct()
    {

    }

    public static function getLinkAll($limit = 20, $offset = 0, $condition = 'id', $sortby = 'DESC')
    {
        global $wpdb;
        $whereis = 1;
        $table = "{$wpdb->prefix}pro_links";;
        $result =" 
        SELECT *
        FROM `{$table}`
        WHERE {$whereis}
        ORDER BY {$condition} {$sortby} 
        LIMIT {$offset},{$limit}
        ";
        return $wpdb->get_results($result, ARRAY_A);
    }

}