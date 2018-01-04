<?php

return [

    'ver'          => '1.00',
    'meta'         => [
        'title'       => '管理系統',
        'description' => '管理系統',
        'author'      => '',
    ],
    'company'      => [
        'name'        => 'Green',
        'since'       => '2015',
        'office_tele' => '',
        'office_fax'  => '',
    ],
    'admin_status' => [
        '0' => '停用',
        '1' => '啟用',
        '2' => '刪除',
    ],
    'status'       => [
        '0' => '下架',
        '1' => '上架',
        '2' => '刪除',
    ],
    'menu'         => [
        'admin'    => [
            'title'      => '管理者管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/admin',
        ],
        // 'indexslide' => [
        //     'title'      => '首頁輪播管理',
        //     'icon_class' => 'icon-home',
        //     'link'       => '/admin/indexslide',
        // ],
        'news'     => [
            'title'      => '最新消息管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/news',
        ],
        'category' => [
            'title'      => '分類管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/category',
        ],
        'product'  => [
            'title'      => '商品管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/product',
        ],
        'system'   => [
            'title'      => '系統變數管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/systemvariable',
        ],
    ],
];
