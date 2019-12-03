<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

set_cart_id(0);
$tmp_cart_id = get_session('ss_cart_id');
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 0);

?>


<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <?php if ($is_admin) {  ?>
    <div class="hd-admin">
        <a href="<?php echo G5_ADMIN_URL ?>/shop_admin/" target="_blank">관리자</a>
    </div>
    <?php } ?>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
     } ?>

    <div id="hd_wrapper">
        <div id="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_DATA_URL; ?>/common/logo_img" alt="<?php echo $config['cf_title']; ?>"></a></div>

        <div id="hd_tnb">
            <div id="hd_sch">
                <h2>쇼핑몰 검색</h2>
                <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
                    <div class="sch_inner">
                        <h2>상품 검색</h2>
                        <label for="sch_str" class="sound_only">상품명<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required placeholder="검색어를 입력해주세요">
                        <button type="submit" value="검색" class="sch_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </form>
                <script>
                function search_submit(f) {
                    if (f.q.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.q.select();
                        f.q.focus();
                        return false;
                    }
                    return true;
                }
                </script>
               
            </div> 
            <button type="button" class="tnb_btn hd_user_btn"><i class="fa fa-user"></i></button>
            <button type="button" class="tnb_btn hd_cart_btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="sound_only">장바구니</span> <span class="cart-num"> <?php echo get_cart_count($tmp_cart_id); ?></span></button>
            <button type="button" class="tnb_btn hd_menu_btn"><i class="fa fa-bars"></i></button>

        </div>

        <?php echo outlogin('theme/shop_basic'); // 아웃로그인 ?>
        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>

    </div>
    
    <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>
    <?php include_once(G5_THEME_SHOP_PATH.'/category.php'); // 분류 ?>
    
</div>

<script>

$(".hd_user_btn").click(function(e) {
    $(".ol").show();
});

$(".hd_cart_btn").click(function(e) {
    $("#sbsk").show();
});

$(".tnb_con .btn_close").click(function(e) {
     $(".tnb_con").hide();
});

</script>


<div id="wrapper">
    <?php if (!defined("_INDEX_")) { ?><div id="wrapper_title"><?php echo $g5['title'] ?></div><?php } ?>

    <!-- 콘텐츠 시작 { -->
    <div id="container" class="container">
