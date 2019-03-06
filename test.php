<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/4
 * Time: 22:27
 */

require_once('MyXML.php');

$tableNameAndFields = [
    [
        'tableName' => 'shopnc_cms_article',
        'fileds' => [
            'loc' => 'article_id',
            'lastmod' => 'article_modify_time'
        ],
    ],
    [
        'tableName' => 'shopnc_goods',
        'fileds' => [
            'loc' => 'goods_id',
            'lastmod' => 'goods_edittime',
        ],
    ],
    [
        'tableName' => 'shopnc_goods_class_staple',
        'fileds' => [
            'loc' => 'gc_id_2',
            'lastmod' => '',
        ],
    ],
    [
        'tableName' => 'shopnc_store',
        'fileds' => [
            'loc' => 'store_id',
            'lastmod' => 'store_time',
        ],
    ]
];

new MyXML($tableNameAndFields);
