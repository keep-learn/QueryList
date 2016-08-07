<?php
/**
 *  QueryList使用示例
 *  
 * 入门教程:http://doc.querylist.cc/site/index/doc/4
 * 
 * QueryList::Query(采集的目标页面,采集规则[,区域选择器][，输出编码][，输入编码][，是否移除头部])
* //采集规则
* $rules = array(
*   '规则名' => array('jQuery选择器','要采集的属性'[,"标签过滤列表"][,"回调函数"]),
*   '规则名2' => array('jQuery选择器','要采集的属性'[,"标签过滤列表"][,"回调函数"]),
*    ..........
*    [,"callback"=>"全局回调函数"]
* );
 */

require 'vendor/autoload.php';

use QL\QueryList;

//采集某页面所有的图片
/**
$data = QueryList::Query('http://www.lovezbs.com/UPLOAD/?/article/281',array(
    'image' => array('img','src')
    ))->data;
//打印结果
print_r($data);
**/
// 采集文字
/**
$data = QueryList::Query('http://www.lovezbs.com/UPLOAD/?/article/281',array(
    'image' => array('h1','html')
))->data;
//打印结果
print_r($data);
**/
/**
$data = QueryList::Query('http://www.lovezbs.com/UPLOAD/?/article/281',array(
    'word' => array('.markitup-box','html')
))->data;
//打印结果
print_r($data);
**/
//需要采集的目标页面
$page = 'http://www.jb51.net/article/74165.htm';
//采集规则
$reg = array(
    //采集文章标题
    'title'     => array('h1','text'),
    //采集文章发布日期,这里用到了QueryList的过滤功能，过滤掉span标签和a标签
    'time'      => array('.article-content .title p','html','-a'),
    'content'   => array('#content','html')
);

$ql = QueryList::Query($page,$reg,'','UTF-8','GB2312');
$data = $ql->getData();
//打印结果
print_r($data);

die;



/*************************************************/
die;
//使用插件
$urls = QueryList::run('Request',array(
        'target' => 'http://cms.querylist.cc/news/list_2.html',
        'referrer'=>'http://cms.querylist.cc',
        'method' => 'GET',
        'params' => ['var1' => 'testvalue', 'var2' => 'somevalue'],
        'user_agent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
        'cookiePath' => './cookie.txt',
        'timeout' =>'30'
    ))->setQuery(array('link' => array('h2>a','href','',function($content){
    //利用回调函数补全相对链接
    $baseUrl = 'http://cms.querylist.cc';
    return $baseUrl.$content;
})),'.cate_list li')->getData(function($item){
    return $item['link'];
});

print_r($urls);
