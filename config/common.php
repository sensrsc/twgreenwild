<?php

return [

    'ver'                => '1.00',
    'meta'               => [
        'title'       => '管理系統',
        'description' => '管理系統',
        'author'      => '',
    ],
    'company'            => [
        'name'        => 'Green',
        'since'       => '2015',
        'office_tele' => '',
        'office_fax'  => '',
    ],
    'admin_status'       => [
        '0' => '停用',
        '1' => '啟用',
        '2' => '刪除',
    ],
    'status'             => [
        '0' => '下架',
        '1' => '上架',
        '2' => '刪除',
    ],
    'item_status'        => [
        '0' => '下架',
        '1' => '上架',
    ],
    'general_status'     => [
        '0' => '停用',
        '1' => '啟用',
    ],
    'description_types'  => [
        '1' => '純文字',
        '2' => '圖文編輯器',
    ],
    'coach_meta_types'   => [
        '1' => '相關訓練',
        '2' => '證照',
        '3' => '經歷',
    ],
    'reserve_type'       => [
        'airport' => '機場接送',
        'car'     => '商務包車',
    ],
    'gender'             => [
        '0' => '女',
        '1' => '男',
    ],
    'order_status'       => [
        '1' => '訂單審核中',
        '2' => '訂單待付款',
        '3' => '訂單完成',
        '4' => '訂單付款失敗',
        '5' => '訂單取消',
    ],
    'order_status_css'       => [
        '1' => 'btn-secondary',
        '2' => 'btn-primary',
        '3' => 'btn-light',
        '4' => 'btn-warring',
        '5' => 'btn-danger',
    ],
    
    'order_front_status'       => [
        '1' => '確認中',
        '2' => '待付款',
        '3' => '完成',
        '4' => '失敗',
        '5' => '取消',
    ],
    'category_cache_key' => 'front_category_cache_key',
    'area_cache_key'     => 'front_area_cache_key',
    'menu'               => [
        'admin'        => [
            'title'      => '管理者管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/admin',
        ],
        'slide'        => [
            'title'      => '首頁輪播管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/slide',
        ],
        'news'         => [
            'title'      => '最新消息管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/news',
        ],
        'category'     => [
            'title'      => '分類管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/category',
        ],
        'album'        => [
            'title'      => '相簿管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/album',
        ],
        'video'        => [
            'title'      => '活動影音管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/video',
        ],
        'tour'         => [
            'title'      => '行程管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/tour',
        ],
        'coach'        => [
            'title'      => '教練管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/coach',
        ],
        'notes'        => [
            'title'      => '活動筆記管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/notes',
        ],
        'user'         => [
            'title'      => '會員資料',
            'icon_class' => 'icon-home',
            'link'       => '/admin/user',
        ],
        'reserveorder' => [
            'title'      => '預約叫車訂單',
            'icon_class' => 'icon-home',
            'link'       => '/admin/reserveorder',
        ],
        'order'        => [
            'title'      => '訂單管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/order',
        ],
        'system'       => [
            'title'      => '系統變數管理',
            'icon_class' => 'icon-home',
            'link'       => '/admin/system',
        ],
    ],
];
