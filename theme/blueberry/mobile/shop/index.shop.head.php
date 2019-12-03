<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_THEME_JS_URL.'/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/owl.carousel.css">', 10);

set_cart_id(0);
$tmp_cart_id = get_session('ss_cart_id');


?>

<header id="hd">
    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>
    <div class="hd_wr">
        <div id="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_URL; ?>/img/logo.jpg" alt="<?php echo $config['cf_title']; ?> 메인"></a></div>
        <div id="logo_res"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_URL; ?>/img/m_logo.jpg" alt="<?php echo $config['cf_title']; ?> 메인"></a>
                <div class="menu-icon2" onclick="location.href='tel:010-3206-3701'"></div>
        </div>

        <!--<div id="logo"><img src="https://www.designevo.com/res/templates/thumb_small/brown-circle-and-chocolate-coffee.png" alt=""></div>-->
        
            
       
        <button type="button" id="btn_cate"><i class="fa fa-bars" aria-hidden="true"></i><span class="sound_only">전체메뉴</span></button>

    </div>
    
    <?php include_once(G5_THEME_MSHOP_PATH.'/category.php'); // 분류 ?>
    <script>

    $("#btn_cate").on("click", function() {
        $("#category").toggle();
    });


    </script>
</header>

<div id="container">
    <div id="admin_link">
        <?php if ($is_admin) {  ?>
        <!-- <a href="<?php echo G5_ADMIN_URL ?>/shop_admin" target="_blank"><b>관리자</b></a> -->
        <a href="<?php echo G5_THEME_ADM_URL; ?>/" target="_blank"><b>테마관리</b></a>
        <?php } ?>
    </div>
    <div class="hdqk_wr" id="cart_wr">
    </div>
    <script>
    $(function(){
        $(".cart_op_btn").on("click", function() {
            var $this = $(this);

            $("#cart_wr").load(
                g5_theme_shop_url+"/ajax.cart.php",
                function() {
                    $this.next(".hdqk_wr").show();
                }
            );
        });
    });
    </script>
    <div id="container_wr"  class="idx-container">
        
        <ul id="tnb" style="display:none;">
            <?php if ($is_member) { ?>
            <?php if ($is_admin) {  ?>
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php">정보수정</a></li>
            <?php } ?>
            <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">로그아웃</a></li>
            <!-- <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></li> -->
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>">로그인</a></li>
            <!-- <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join">회원가입</a></li> -->

            <?php } ?>
            <!-- <li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문/배송</a></li> -->
            <!-- <li><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php">쿠폰존</a></li> -->
            <!-- <li class="tnb_cart"><button type="button" class="cart_op_btn"><span class="btn_txt">cart<span class="cart-count"><?php echo get_cart_count($tmp_cart_id); ?></span></span><span class="btn_bottom"></span></button></li> -->


        </ul>
        <script>
        $(function(){
            $(".cart_op_btn").on("click", function() {
                $("#cart_wr").slideToggle(500);
            });
            
        });

        </script>
        <?php
        if(basename($_SERVER['SCRIPT_NAME']) == 'faq.php')
            $g5['title'] = '고객센터';
        ?>

        <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><h1 id="container_title"><?php echo $g5['title'] ?></h1><?php } ?>
