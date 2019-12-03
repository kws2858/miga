<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<header id="hd">
    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>

    <div id="hd_wr">
        <div id="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img" alt="<?php echo $config['cf_title']; ?> 메인"></a></div>
        <div id="hd_btn">
            <button type="button" id="btn_hdcate" class="cate_btn"><i class="fa fa-bars" aria-hidden="true"></i><span class="sound_only">분류</span></button>
            <button type="button" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> </button>
            <a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="sound_only">장바구니</span><span class="cart-count"><?php echo get_boxcart_datas_count(); ?></span></a>

        </div>
    </div>
    <?php include_once(G5_THEME_MSHOP_PATH.'/category.php'); // 분류 ?>

  
    <aside id="hd_sch">
    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
        <div class="sch_inner">
            <h2>상품 검색</h2>
            <label for="sch_str" class="sound_only">상품명<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required class="frm_input" placeholder="검색어를 입력해주세요">
            <button type="submit" value="검색" class="sch_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
    </form>
    <button type="button" class="btn_close"><span class="sound_only">닫기</span><i class="fa fa-times"></i></button>
    </aside>
</header>



<div id="container">
    <?php if (!defined("_INDEX_")) { ?><h1 id="container_title"><?php echo $g5['title'] ?><a href="javascript:history.back()" class="btn_back"><i class="fa fa-angle-left"></i><span class="sound_only">뒤로</span></a></h1><?php } ?>
