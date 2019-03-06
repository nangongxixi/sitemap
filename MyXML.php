<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/4
 * Time: 22:27
 */

require_once('MysqliDb.php');

Class MyXML
{
    private $db;
    private $list;
    private $tableName;

    public function __construct($tableNameAndFields)
    {
        //数据库链接
        $this->db = new Mysqlidb ('192.168.0.234', 'root', 'root', 'shopncupdate');
        try {
            foreach ($tableNameAndFields as $item) {
                $this->tableName = $item['tableName'];
                $dataList = $this->db->get($this->tableName);

                $this->addXML($dataList, $item['fileds']);
            }
        } catch (Exception $e) {
        }
    }

    protected function getUrl($id)
    {
        if ($this->tableName == 'shopnc_cms_article') {
            $url = 'http://www.fhjcjjc.com/cms/article-' . $id . '.html';
        }
        if ($this->tableName == 'shopnc_goods') {
            $url = 'http://www.fhjcjjc.com/shop/item-' . $id . '.html';
        }
        if ($this->tableName == 'shopnc_goods_class_staple') {
            $url = 'http://www.fhjcjjc.com/shop/cate-' . $id . '-0-0-0-0-0-0-0-0-0.html';
        }
        if ($this->tableName == 'shopnc_store') {
            $url = 'http://www.fhjcjjc.com/shop/shop-' . $id . '.html';
        }
        return $url;
    }

    protected function addXML($dataList, $fileds)
    {


        $this->list = [];
        foreach ($dataList as $index => $v) {
            $xmlArr = array(
                'loc' => $this->getUrl($v[$fileds['loc']]),
                'priority' => '1.0',
                'lastmod' => !empty($v[$fileds['lastmod']]) ? date('Y-m-d H:i:s',
                    $v[$fileds['lastmod']]) : date("Y-m-d H:i:s"),
                'changefreq' => 'always',
            );
            $this->list[$index] = $xmlArr;
        }
        $arrList = array_chunk($this->list, 50000);

        echo '<hr>当前表 【' . $this->tableName . '】 文件个数 ' . count($arrList) . ' 个, 总共 ' . count($this->list) . ' 条数据';

        for ($i = 0; $i < count($arrList); $i++) {
            $this->getList($arrList[$i], $i);
        }
    }

    protected function getList($arr, $i)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>
                    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
                   ';
        foreach ($arr as $data) {
            $content .= $this->create_item($data);
        }
        $content .= '</urlset>';
        $fp = fopen('xml/' . $this->tableName . '-sitemap' . $i . '.xml', 'w+');
        $fw = fwrite($fp, $content);
        if ($fw) {
            echo '<br>第 ' . ($i + 1) . ' 个生成成功！';
            fclose($fp);
            return;
        }
        echo '<br>faill';
        return;
    }

    protected function create_item($data)
    {
        $item = "<url>\n";
        $item .= "<loc>" . $data['loc'] . "</loc>\n";
        $item .= "<priority>" . $data['priority'] . "</priority>\n";
        $item .= "<lastmod>" . $data['lastmod'] . "</lastmod>\n";
        $item .= "<changefreq>" . $data['changefreq'] . "</changefreq>\n";
        $item .= "</url>\n";
        return $item;
    }
}
