<?php
/**
 * @Author: Marte
 * @Date:   2018-02-28 09:31:44
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-03-05 14:33:18
 */
function getImgPath( $img ) {
    $root = C('upload_dir');
    $p1 = substr($img,0,4);
    $p2 = substr($img,4,4);
    $url = '/'.$root.$p1.'/'.$p2.'/'.$img;
    return $url;
}

// 转换kinds 变 name
function transKindsName($kinds)
{
    $kinds =  D('category')->getKindsName($kinds);
    return implode('<br>',$kinds);
}

function transTime($t)
{
    if ( empty($t) ) {
        return '';
    }
    $t = rtrim($t,'000');
    return date('Y-m-d H:i');
}

function getNewsHtmlTime($id)
{
    $news_dir = C('news_dir');
    $file = $news_dir.$id.'.js';
    if ( $t = filemtime($file) ) {
        return date('Y-m-d<b\r>H:i:s',$t);
    }
    return '未创建';
}