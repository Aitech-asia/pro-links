<?php

/**
 * Admin page setup
 *
 * @since      1.0.0
 * @author     Do Quang Thanh
 *
 */

namespace ProCore\Data;

class Database
{
    public static function db_install()
    {
        if (!get_option('pro_links_db_installed')) {
            $wp_pro_link_clicks_table = "wp_pro_link_clicks";
            $wp_pro_link_metas_table = "wp_pro_link_metas";
            $wp_pro_links_table = "wp_pro_links";
            /* Run sql to create the proper tables we need. */
            $sql = "
               CREATE TABLE `{$wp_pro_link_clicks_table}`  (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `btype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `bversion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `os` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `referer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      `robot` tinyint(4) NULL DEFAULT 0,
                      `first_click` tinyint(4) NULL DEFAULT 0,
                      `created_at` datetime NOT NULL,
                      `link_id` int(11) NULL DEFAULT NULL,
                      `vuid` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                      PRIMARY KEY (`id`) USING BTREE,
                      INDEX `link_id`(`link_id`) USING BTREE,
                      INDEX `ip`(`ip`(191)) USING BTREE,
                      INDEX `browser`(`browser`(191)) USING BTREE,
                      INDEX `btype`(`btype`(191)) USING BTREE,
                      INDEX `bversion`(`bversion`(191)) USING BTREE,
                      INDEX `os`(`os`(191)) USING BTREE,
                      INDEX `referer`(`referer`(191)) USING BTREE,
                      INDEX `host`(`host`(191)) USING BTREE,
                      INDEX `uri`(`uri`(191)) USING BTREE,
                      INDEX `robot`(`robot`) USING BTREE,
                      INDEX `first_click`(`first_click`) USING BTREE,
                      INDEX `vuid`(`vuid`) USING BTREE
                    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;
                
                CREATE TABLE `{$wp_pro_link_metas_table}`  (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                          `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
                          `meta_order` int(4) NULL DEFAULT 0,
                          `link_id` int(11) NOT NULL,
                          `created_at` datetime NOT NULL,
                          PRIMARY KEY (`id`) USING BTREE,
                          INDEX `meta_key`(`meta_key`(191)) USING BTREE,
                          INDEX `link_id`(`link_id`) USING BTREE
                          ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;
                
               CREATE TABLE `{$wp_pro_links_table}`  (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                          `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
                          `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
                          `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                          `nofollow` tinyint(1) NULL DEFAULT 0,
                          `sponsored` tinyint(1) NULL DEFAULT 0,
                          `track_me` tinyint(1) NULL DEFAULT 1,
                          `param_forwarding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                          `param_struct` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                          `redirect_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '307',
                          `link_status` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'enabled',
                          `created_at` datetime NOT NULL,
                          `updated_at` datetime NULL DEFAULT NULL,
                          `group_id` int(11) NULL DEFAULT NULL,
                          `link_cpt_id` int(11) NULL DEFAULT 0,
                          PRIMARY KEY (`id`) USING BTREE,
                          INDEX `link_cpt_id`(`link_cpt_id`) USING BTREE,
                          INDEX `group_id`(`group_id`) USING BTREE,
                          INDEX `link_status`(`link_status`) USING BTREE,
                          INDEX `nofollow`(`nofollow`) USING BTREE,
                          INDEX `sponsored`(`sponsored`) USING BTREE,
                          INDEX `track_me`(`track_me`) USING BTREE,
                          INDEX `param_forwarding`(`param_forwarding`(191)) USING BTREE,
                          INDEX `redirect_type`(`redirect_type`(191)) USING BTREE,
                          INDEX `slug`(`slug`(191)) USING BTREE,
                          INDEX `created_at`(`created_at`) USING BTREE,
                          INDEX `updated_at`(`updated_at`) USING BTREE
                        ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

                ";

            if (!function_exists('dbDelta')) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            }
            dbDelta($sql);
            update_option('pro_links_db_installed', true);
        }

    }

}