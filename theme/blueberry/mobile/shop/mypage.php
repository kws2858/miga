<?php
include_once('./_common.php');

$g5['title'] = '마이페이지';

include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');

add_javascript('<script src="'.G5_THEME_JS_URL.'/Ublue-jQueryTabs-1.2.js"></script>', 10);
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
<div id="smb_my">

    <section id="smb_my_ov">
        <h2>회원정보 개요</h2>
        <div class="hello_name">
            <i class="fa fa-user" aria-hidden="true"></i>  <strong><?php echo $member['mb_id'] ? $member['mb_name'] : '비회원'; ?></strong>님
            <ul class="smb_my_act">
                <?php if ($is_admin == 'super') { ?><li><a href="<?php echo G5_ADMIN_URL; ?>/" class="btn_admin">관리자</a></li><?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn02">회원정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn02">회원탈퇴</a></li>
            </ul>
        </div>
        <div class="my_cou my_po">보유쿠폰<a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank" class="win_coupon"><?php echo number_format($cp_count); ?></a></div>
        <div class="my_point my_po">보유포인트
        <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><?php echo number_format($member['mb_point']); ?>점</a></div>
        <div class="my_point my_po">쪽지함<a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_coupon"><?php echo number_format(memo_recv_count($member['mb_id'])); ?></a></div>
        <div class="my_info">

            <div class="my_info_wr">
                <strong>연락처</strong>
                <span><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></span>
            </div>
            <div class="my_info_wr">
                <strong>E-Mail</strong>
                <span><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></span>
            </div>
            <div class="my_info_wr">
                <strong>최종접속일시</strong>
                <span><?php echo $member['mb_today_login']; ?></span>
             </div>
            <div class="my_info_wr">
            <strong>회원가입일시</strong>
                <span><?php echo $member['mb_datetime']; ?></span>
            </div>
            <div class="my_info_wr ov_addr">
                <strong>주소</strong>
                <span><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></span>
            </div>
        </div>
    </section>

    <div id="smb_my_tab" >
        <ul class="tabsTit">
            <li class="tabsTab tabsHover">주문내역</li>
            <li class="tabsTab">위시리스트</li>
        </ul>
        <div class="tabsCon">
            <section id="smb_my_od" class="tabsList" readonly="true">
                <h2>최근 주문내역</h2>
                <?php
                // 최근 주문내역
                define("_ORDERINQUIRY_", true);

                $limit = " limit 0, 5 ";
                include G5_MSHOP_PATH.'/orderinquiry.sub.php';
                ?>
                <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php" class="more_btn">더보기</a>
            </section>

            <section id="smb_my_wish" class="tabsList" >
                <h2>최근 위시리스트</h2>

                <ul>
                    <?php
                    $sql = " select *
                               from {$g5['g5_shop_wish_table']} a,
                                    {$g5['g5_shop_item_table']} b
                              where a.mb_id = '{$member['mb_id']}'
                                and a.it_id  = b.it_id
                              order by a.wi_id desc
                              limit 0, 8 ";
                    $result = sql_query($sql);
                    for ($i=0; $row = sql_fetch_array($result); $i++)
                    {
                        $image_w = 260;
                        $image_h = 260;
                        $image = get_it_image($row['it_id'], $image_w, $image_h, true);
                        $list_left_pad = $image_w + 10;
                    ?>

                    <li>
                        <div class="wish_img"><?php echo $image; ?></div>
                        <div class="wish_info">
                            <a href="./item.php?it_id=<?php echo $row['it_id']; ?>" class="info_link"><?php echo stripslashes($row['it_name']); ?></a>
                            <span class="info_date"><?php echo $row['wi_time']; ?></span>
                        </div>
                    </li>

                    <?php
                    }

                    if ($i == 0)
                        echo '<li class="empty_list">보관 내역이 없습니다.</list>';
                    ?>
                </ul>
                <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php" class="more_btn">더보기</a>
            </section>
        </div>
    </div>

    <script>
    $("#smb_my_tab").UblueTabs({
        eventType:"click"
    });
    </script>

</div>

<script>
$(function() {
    $(".win_coupon").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=400, scrollbars=1");
        new_win.focus();
        return false;
    });
});

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>