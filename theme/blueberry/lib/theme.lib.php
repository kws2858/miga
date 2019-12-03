<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function item_icon2($it)
{
    global $g5;

    $icon = '<span class="sit_icon">';
    // 품절
    if (is_soldout($it['it_id']))
        $icon .= '<img src="'.G5_THEME_IMG_URL.'//icon_soldout.gif" alt="품절">';

    if ($it['it_type1'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_hit.gif" alt="히트상품">';

    if ($it['it_type2'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_rec.gif" alt="추천상품">';

    if ($it['it_type3'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_new.gif" alt="최신상품">';

    if ($it['it_type4'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_best.gif" alt="인기상품">';

    if ($it['it_type5'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_discount.gif" alt="할인상품">';

    // 쿠폰상품
    $sql = " select count(*) as cnt
                from {$g5['g5_shop_coupon_table']}
                where cp_start <= '".G5_TIME_YMD."'
                  and cp_end >= '".G5_TIME_YMD."'
                  and (
                        ( cp_method = '0' and cp_target = '{$it['it_id']}' )
                        OR
                        ( cp_method = '1' and ( cp_target IN ( '{$it['ca_id']}', '{$it['ca_id2']}', '{$it['ca_id3']}' ) ) )
                      ) ";
    $row = sql_fetch($sql);
    if($row['cnt'])
        $icon .= '<img src="'.G5_THEME_IMG_URL.'/icon_cp.gif" alt="쿠폰상품">';

    $icon .= '</span>';

    return $icon;
}

function memo_recv_count($mb_id)
{
    global $g5;

    if(!$mb_id)
        return 0;

    $sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '$mb_id' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row = sql_fetch($sql);
    return $row['cnt'];
}
?>