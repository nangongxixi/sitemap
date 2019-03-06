<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/4
 * Time: 22:27
 */

require_once('MyXMLB2B.php');

$tableNameAndFields = [
    [
        'tableName' => 'fuheqiao_news',
        'fileds' => [
            'loc' => 'id',
            'lastmod' => 'cdate',
        ],
    ],
    [
        'tableName' => 'fuheqiao_news11',
        'fileds' => [
            'loc' => 'id',
            'lastmod' => 'cdate',
        ],
    ]
    /*[
        'tableName' => 'goods',
        'fileds' => [
            'loc' => 'id',
            'lastmod' => 'cdate'
        ],
    ],
    [
        'tableName' => 'shop',
        'fileds' => [
            'loc' => 'id',
            'lastmod' => 'cdate',
        ],
    ],
    [
        'tableName' => 'news',
        'fileds' => [
            'loc' => 'id',
            'lastmod' => '',
        ],
    ],
    [
        'tableName' => 'gdclass',
        'fileds' => [
            'loc' => 'pid',
            'lastmod' => '',
        ],
    ]*/
];

new MyXMLB2B($tableNameAndFields);
