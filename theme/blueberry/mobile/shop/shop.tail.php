<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
add_javascript('<script src="'.G5_THEME_JS_URL.'/Ublue-jQueryTabs-1.2.js"></script>', 10);

?>
    </div>
</div><!-- container End -->

<div id="ft">
    <button type="button" id="top_btn"><img src="<?php echo G5_THEME_IMG_URL; ?>/top_btn.png" alt="상단으로"></button>
    <script>
    
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>

    <div class="ft_wr">
<!--         <ul id="ft_link">
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보 취급방침</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/faq.php">고객센터</a></li>
        </ul> -->

        <div id="ft_if"> 
            <h2><?php echo $config['cf_title']; ?> 정보</h2>
            <span><b></b> <?php echo $default['de_admin_company_name']; ?></span><br>
            <span><b>주소.</b> <?php echo $default['de_admin_company_addr']; ?></span><br>
            <span><b>사업자 등록번호.</b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
            <span><b>대표.</b> <?php echo $default['de_admin_company_owner']; ?></span>
            <span><b>전화.</b> <?php echo $default['de_admin_company_tel']; ?></span>
            <span><b>팩스.</b> <?php echo $default['de_admin_company_fax']; ?></span><br>
            <!-- <span><b>운영자</b> <?php echo $admin['mb_name']; ?></span><br> -->
            <!-- <span><b>통신판매업신고번호.</b> <?php echo $default['de_admin_tongsin_no']; ?></span> -->
            <!-- <span><b>개인정보관리책임자.</b> <?php echo $default['de_admin_info_name']; ?></span> -->

            <!-- <?php if ($default['de_admin_buga_no']) echo '<span><b>부가통신사업신고번호</b> '.$default['de_admin_buga_no'].'</span>'; ?><br> -->
            Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.
        </div>
        <div id="ft_cs">
            <!-- <h2><a href="<?php echo G5_BBS_URL; ?>/faq.php">CS CENTER</a></h2> -->
            <div>
                <?php
                $save_file = G5_DATA_PATH.'/cache/theme/blueberry/footerinfo.php';
                if(is_file($save_file))
                    include($save_file);
                ?>
                CS CENTER
                <strong class="cs_tel"><?php echo get_text($footerinfo['tel']); ?></strong>
                <p class="cs_info"><?php echo get_text($footerinfo['etc'], 1); ?></p>
            </div>
        </div>
<!--         <div id="ft_sns">
            <ul>
                <?php
                $save_file = G5_DATA_PATH.'/cache/theme/blueberry/snslink.php';
                if(is_file($save_file))
                    include($save_file);
                ?>
                <?php if(isset($snslink['facebook']) && $snslink['facebook']) { ?>
                <li><a href="<?php echo set_http($snslink['facebook']); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i><span class="sound_only">페이스북</span></a></li>
                <?php } ?>
                <?php if(isset($snslink['twitter']) && $snslink['twitter']) { ?>
                <li><a href="<?php echo set_http($snslink['twitter']); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i><span class="sound_only">트위터</span></a></li>
                <?php } ?>
                <?php if(isset($snslink['instagram']) && $snslink['instagram']) { ?>
                <li><a href="<?php echo set_http($snslink['instagram']); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i><span class="sound_only">인스타그램</span></a></li>
                <?php } ?>
            </ul>
        </div> -->
    </div>
</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
