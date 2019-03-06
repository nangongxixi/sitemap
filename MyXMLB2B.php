<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/4
 * Time: 22:27
 */

require_once('MysqliDb.php');

Class MyXMLB2B
{
    private $db;
    private $list;
    private $tableName;

    public function __construct($tableNameAndFields)
    {
        //数据库链接
        $this->db = new Mysqlidb ('192.168.0.234', 'root', 'root', 'baike');
        try {
            foreach ($tableNameAndFields as $item) {
                $this->tableName = $item['tableName'];
                $dataList = $this->db->get($this->tableName, 60000, 'id, cdate');

                $this->addXML($dataList, $item['fileds']);
            }
        } catch (Exception $e) {
        }
    }

    protected function getUrl($id)
    {
        if ($this->tableName == 'fuheqiao_news') {
            $url = 'http://b2b.fhjcjjc.com/information/baike/show/' . $id . '.html';
        }
        if ($this->tableName == 'fuheqiao_news11') {
            $url = 'http://www.fhjcjjc.com/know/baike/show/' . $id . '.html';
        }
        /*if ($this->tableName == 'goods') {
            $url = 'http://b2b.fhjcjjc.com/goods-detail/id-' . $id . '.html';
        }
        if ($this->tableName == 'shop') {
            $url = 'http://b2b.fhjcjjc.com/shop-' . $id . '/';
        }
        if ($this->tableName == 'news') {
            $url = 'http://b2b.fhjcjjc.com/news-detail/id-' . $id . '.html';
        }
        if ($this->tableName == 'gdclass') {
            $url = 'http://b2b.fhjcjjc.com/goods/gc-' . $id;
        }*/

        return $url;
    }

    protected function addXML($dataList, $fileds)
    {
        $this->list = [];
        foreach ($dataList as $index => $v) {
            $xmlArr = array(
                'loc' => $this->getUrl($v[$fileds['loc']]),
                'priority' => '1.0',
                'lastmod' => !empty($v[$fileds['lastmod']]) ? $v[$fileds['lastmod']] : date("Y-m-d H:i:s"),
                'changefreq' => 'always',
            );
            $this->list[$index] = $xmlArr;
        }
        $arrList = array_chunk($this->list, 50000);

        echo ' <hr>当前表 【' . $this->tableName . '】 文件个数 ' . count($arrList) . ' 个, 总共 ' . count($this->list) . ' 条数据';

        for ($i = 0; $i < count($arrList); $i++) {
            $this->getList($arrList[$i], $i);
        }
    }

    protected function getList($arr, $i)
    {
        $content = '<?xml version = "1.0" encoding = "UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    ';
        foreach ($arr as $data) {
            $content .= $this->create_item($data);
        }
        $content .= '
</urlset>';
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
        $item = "
<url>\n";
        $item .= "
    <loc>" . $data['loc'] . "</loc>
    \n";
        $item .= "
    <priority>" . $data['priority'] . "</priority>
    \n";
        $item .= "
    <lastmod>" . $data['lastmod'] . "</lastmod>
    \n";
        $item .= "
    <changefreq>" . $data['changefreq'] . "</changefreq>
    \n";
        $item .= "
</url>\n";
        return $item;
    }
}
