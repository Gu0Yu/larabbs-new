<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 生成话题的摘录--excerp字段，将作为文章页面的 description 元标签使用，有利于 SEO 搜索引擎优化
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}