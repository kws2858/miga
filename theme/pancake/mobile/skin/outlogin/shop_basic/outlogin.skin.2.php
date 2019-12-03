<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}
?>

<!-- 로그인 후 외부로그인 시작 -->
<aside id="ol_after" class="ol">
   
    <h2>나의 회원정보</h2>
    <div id="ol_after_hd">
        <div class="profile_img">
            <?php echo get_member_profile_img($member['mb_id'], 60, 60); ?> <?php echo $nick ?>

        </div>
        <ul class="ol_my_link">
            <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info">정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout">로그아웃</a></li>

        </ul>
      
    </div>        
     <ul class="ol_after_pt">
        <li>
            <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point">포인트<strong><?php echo $point ?></strong></a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_point">
                 쪽지
                <strong class="count"><?php echo $memo_not_read ?></strong>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_SHOP_URL ?>/coupon.php" target="_blank" id="ol_after_scrap" class="win_scrap">쿠폰
            <strong><?php echo number_format($cp_count); ?></strong>
            </a>
        </li>
    </ul>

</aside>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- 로그인 후 외부로그인 끝 -->
