<?php
function test_helper() {
    return 'OK';
}
// 每一页的 class 设置
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}