<?php
define('ROOT_PATH', str_replace('public', '', $_SERVER["DOCUMENT_ROOT"]));
$parse = parse_url($_SERVER["REQUEST_URI"]);
// ファイル名が省略されていた場合、index.phpを補填する
if(mb_substr($parse['path'], -1) === '/') {
    $parse['path'] .= $_SERVER["SCRIPT_NAME"];
}
require_once(ROOT_PATH.'Views'.$parse['path']);