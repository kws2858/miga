<?php
include_once('./_common.php');

@mkdir(G5_DATA_PATH."/cache/theme", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/cache/theme", G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH."/cache/theme/blueberry", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/cache/theme/blueberry", G5_DIR_PERMISSION);

$save_file = G5_DATA_PATH.'/cache/theme/blueberry/snslink.php';

$links = array();

$facebook  = str_replace(array("\'", '\"', "'", '"'), '', strip_tags(trim($_POST['facebook'])));
$twitter   = str_replace(array("\'", '\"', "'", '"'), '', strip_tags(trim($_POST['twitter'])));
$instagram = str_replace(array("\'", '\"', "'", '"'), '', strip_tags(trim($_POST['instagram'])));

$links = array('facebook' => $facebook, 'twitter' => $twitter, 'instagram' => $instagram, 'naver' => $naver);

// 캐시파일로 저장
$cache_fwrite = true;
if($cache_fwrite) {
    $handle = fopen($save_file, 'w');
    $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;";
    $cache_content .= "\n\n\$snslink=".var_export($links, true).";";
    fwrite($handle, $cache_content);
    fclose($handle);
}

goto_url('./snslink.php');
?>