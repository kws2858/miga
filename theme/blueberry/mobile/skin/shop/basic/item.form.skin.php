<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);



// $str = '';
// $exists = false;

// $ca_id_len = strlen($ca_id);
// $len2 = $ca_id_len + 2;
// $len4 = $ca_id_len + 4;

// $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$ca_id%' and length(ca_id) = $len2 and ca_use = '1' order by ca_order, ca_id ";
// $result = sql_query($sql);
// while ($row=sql_fetch_array($result)) {

//     $row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");

//     $str .= '<li><a href="./list.php?ca_id='.$row['ca_id'].'">'.$row['ca_name'].' </a></li>';
//     $exists = true;
// }





?>

<!-- 상품분류 1 시작 { -->
<!-- <aside id="sct_ct_1" class="sct_ct">
    <h2>현재 상품 분류와 관련된 분류</h2>
    <ul>
        <?php echo $str; ?>
    </ul>
</aside> -->
<!-- } 상품분류 1 끝 -->
<!--분류-->


<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>


<form name="fitem" action="<?php echo $action_url; ?>" method="post" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it['it_id']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">
<div id="sit_ov_wrap">
    <?php
    // 이미지(중) 썸네일
    $thumb_img = '';
    $thumb_img_w = 500; // 넓이
    $thumb_img_h = 500; // 높이
    for ($i=1; $i<=10; $i++)
    {
        if(!$it['it_img'.$i])
            continue;

        $thumb = get_it_thumbnail($it['it_img'.$i], $thumb_img_w, $thumb_img_h);

        if(!$thumb)
            continue;

        $thumb_img .= '<div class="item">';
        $thumb_img .= '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" class="popup_item_image slide_img" target="_blank">'.$thumb.'</a>';
        $thumb_img .= '</div>'.PHP_EOL;
    }
    if ($thumb_img)
    {
        echo '<div id="sit_pvi">'.PHP_EOL;
        echo '<div id="sit_pvi_slide" >'.PHP_EOL;
        echo $thumb_img;
        echo '</div>'.PHP_EOL;
        echo '</div>';
    }
    ?>

<script>
$(document).ready(function() {
    $("#sit_pvi_slide").owlCarousel({
        autoPlay : false,
        navigation : true, // Show next and prev buttons
        slideSpeed : 500,
        pagination:false,
        singleItem:true,

    });
});
</script>
    <section id="sit_ov">
        <div class="sit_ov_wr">

            <h2>상품간략정보 및 구매기능</h2>
            <strong id="sit_title"><?php echo stripslashes($it['it_name']); ?></strong>
            <?php if($is_orderable) { ?>
            <p id="sit_opt_info">
                상품 선택옵션 <?php echo $option_count; ?> 개, 추가옵션 <?php echo $supply_count; ?> 개
            </p>
            <?php } ?>
            <div id="sit_star">
                <?php
                $sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
                $sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

                if ($score = get_star_image($it['it_id'])) { ?>
                <span class="sound_only"> 고객선호도별<?php echo $score?>개</span>
                <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $score?>.png" alt="" class="sit_star">
                <?php } ?>

            </div>
            <div class="sit_ov_tbl ">
                <table >
                <colgroup>
                    <col class="grid_2">
                    <col>
                </colgroup>
                <tbody>
                <?php if ($it['it_maker']) { ?>
                <tr>
                    <th scope="row">사이즈</th>
                    <td><?php echo $it['it_1']; ?></td>
                </tr>
                <?php } ?>                    
                <?php if ($it['it_maker']) { ?>
                <tr>
                    <th scope="row">제조사</th>
                    <td><?php echo $it['it_maker']; ?></td>
                </tr>
                <?php } ?>

                <?php if ($it['it_origin']) { ?>
                <tr>
                    <th scope="row">원산지</th>
                    <td><?php echo $it['it_origin']; ?></td>
                </tr>
                <?php } ?>

                <?php if ($it['it_brand']) { ?>
                <tr>
                    <th scope="row">브랜드</th>
                    <td><?php echo $it['it_brand']; ?></td>
                </tr>
                <?php } ?>
                <?php if ($it['it_model']) { ?>
                <tr>
                    <th scope="row">모델</th>
                    <td><?php echo $it['it_model']; ?></td>
                </tr>
                <?php } ?>
                <?php if (!$it['it_use']) { // 판매가능이 아닐 경우 ?>
                <tr>
                    <th scope="row">렌탈문의</th>
                    <td>판매중지</td>
                </tr>
                <?php } else if ($it['it_tel_inq']) { // 전화문의일 경우 ?>
                <tr>
                    <th scope="row">렌탈문의</th>
                    <td><b style="color:black"><a href="tel:010-3206-3701">010-3206-3701</a></b></td>
                </tr>
                <?php } else { // 전화문의가 아닐 경우?>
                <?php if ($it['it_cust_price']) { // 1.00.03?>
                <tr>
                    <th scope="row">시중가격</th>
                    <td><?php echo display_price($it['it_cust_price']); ?></td>
                </tr>
                <?php } ?>

                <tr>
                    <th scope="row">렌탈문의</th>
                    <td>
                        <b style="color:black"><a href="tel:010-3206-3701">010-3206-3701</a></b>
<!--                         <?php echo display_price(get_price($it)); ?>
                        <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>"> -->
                    </td>
                </tr>
                <?php } ?>

                <?php
                /* 재고 표시하는 경우 주석 해제
                <tr>
                    <th scope="row">재고수량</th>
                    <td><?php echo number_format(get_it_stock_qty($it_id)); ?> 개</td>
                </tr>
                */
                ?>

<!--                 <?php if ($config['cf_use_point']) { // 포인트 사용한다면 ?>
                <tr>
                    <th scope="row"><label for="disp_point">포인트</label></th>
                    <td>
                        <?php
                        if($it['it_point_type'] == 2) {
                            echo '구매금액(추가옵션 제외)의 '.$it['it_point'].'%';
                        } else {
                            $it_point = get_item_point($it);
                            echo number_format($it_point).'점';
                        }
                        ?>
                    </td>
                </tr>
                <?php } ?> -->
  <!--               <?php
                $ct_send_cost_label = '배송비결제';

                if($it['it_sc_type'] == 1)
                    $sc_method = '무료배송';
                else {
                    if($it['it_sc_method'] == 1)
                        $sc_method = '수령후 지불';
                    else if($it['it_sc_method'] == 2) {
                        $ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
                        $sc_method = '<select name="ct_send_cost" id="ct_send_cost">
                                          <option value="0">주문시 결제</option>
                                          <option value="1">수령후 지불</option>
                                      </select>';
                    }
                    else
                        $sc_method = '주문시 결제';
                }
                ?>
                <tr>
                    <th><?php echo $ct_send_cost_label; ?></th>
                    <td><?php echo $sc_method; ?></td>
                </tr> -->
                <?php if($it['it_buy_min_qty']) { ?>
                <tr>
                    <th>최소구매수량</th>
                    <td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td>
                </tr>
                <?php } ?>
                <?php if($it['it_buy_max_qty']) { ?>
                <tr>
                    <th>최대구매수량</th>
                    <td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
            </div>
            <script>
                $(function(){
                    $(".sit_ov_tbl_btn").click(function(){
                        $(".sit_ov_tbl table").toggle();
                    });
                });
            </script>
            <?php
            if($option_item) {
            ?>
            <section>
                <h3>선택옵션</h3>
                <table class="sit_op_sl">
                <colgroup>
                    <col class="grid_2">
                    <col>
                </colgroup>
                <tbody>
                <?php // 선택옵션
                echo $option_item;
                ?>
                </tbody>
                </table>
            </section>
            <?php
            }
            ?>

            <?php
            if($supply_item) {
            ?>
            <section>
                <h3>추가옵션</h3>
                <table class="sit_op_sl">
                <colgroup>
                    <col class="grid_2">
                    <col>
                </colgroup>
                <tbody>
                <?php // 추가옵션
                echo $supply_item;
                ?>
                </tbody>
                </table>
            </section>
            <?php
            }
            ?>

<!--             <?php if ($it['it_use'] && !$it['it_tel_inq'] && !$is_soldout) { ?>
            <div id="sit_sel_option">
            <?php
            if(!$option_item) {
                if(!$it['it_buy_min_qty'])
                    $it['it_buy_min_qty'] = 1;
            ?>
                <ul id="sit_opt_added">
                    <li class="sit_opt_list">
                        <input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
                        <input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
                        <input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
                        <input type="hidden" class="io_price" value="0">
                        <input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
                        <span class="sit_opt_subj"><?php echo $it['it_name']; ?></span>
                        <span class="sit_opt_prc">(+0원)</span>
                        <div class="sit_opt_qty">
                            <input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" class="frm_input" size="5">
                            <button type="button" class="sit_qty_plus">증가</button>
                            <button type="button" class="sit_qty_minus">감소</button>
                        </div>
                    </li>
                </ul>
                <script>
                $(function() {
                    price_calculate();
                });
                </script>
            <?php } ?>
            </div> -->

            <div id="sit_tot_price"></div>
            <?php } ?>

            <?php if($is_soldout) { ?>
            <p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
            <?php } ?>

<!--             <div id="sit_ov_btn">
                <?php if ($is_orderable) { ?>
                <input type="submit" onclick="document.pressed=this.value;" value="장바구니" id="sit_btn_cart">
                <input type="submit" onclick="document.pressed=this.value;" value="바로구매" id="sit_btn_buy">
                <?php } ?>
                <?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
                <a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_buy">재입고알림</a>
                <?php } ?>
                <a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" id="sit_btn_wish"><i class="fa fa-heart" aria-hidden="true"></i><span class="sound_only">위시리스트</span></a>
                
            </div> -->
            <?php if ($naverpay_button_js) { ?>
            <div class="naverpay-item"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
            <?php } ?>
        </div>
    </section>
</div>

</form>


<!-- 상품 정보 시작 { -->
<section id="sit_inf">
    <h2 class="contents_tit"><span>상품 정보</span></h2>


    <?php if ($it['it_explan']) { // 상품 상세설명 ?>
    <h3>상품 상세설명</h3>
    <div id="sit_inf_explan">
        <?php echo conv_content($it['it_explan'], 1); ?>
    </div>
    <?php } ?>


    <?php
    if ($it['it_info_value']) { // 상품 정보 고시
        $info_data = unserialize(stripslashes($it['it_info_value']));
        if(is_array($info_data)) {
            $gubun = $it['it_info_gubun'];
            $info_array = $item_info[$gubun]['article'];
    ?>
    <h3>상품 정보 고시</h3>
    <table id="sit_inf_open">
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <?php
    foreach($info_data as $key=>$val) {
        $ii_title = $info_array[$key][0];
        $ii_value = $val;
    ?>
    <tr>
        <th scope="row"><?php echo $ii_title; ?></th>
        <td><?php echo $ii_value; ?></td>
    </tr>
    <?php } //foreach?>
    </tbody>
    </table>
    <!-- 상품정보고시 end -->
    <?php
        } else {
            if($is_admin) {
                echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
            }
        }
    } //if
    ?>

</section>
<!-- } 상품 정보 끝 -->




<?php
$od_ids = array();
$sql = " select distinct od_id from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status in ('입금', '준비', '배송', '완료') order by od_id desc limit 50 ";
$result = sql_query($sql);
for($k=0; $row=sql_fetch_array($result); $k++) {
    if($row['od_id'])
        $od_ids[] = $row['od_id'];
}

if(!empty($od_ids)) {
    $sql = " select it_id, it_name, sum(ct_qty) as qty from {$g5['g5_shop_cart_table']} where od_id in ( '".implode("', '", $od_ids)."' ) and it_id <> '$it_id' group by it_id order by qty desc limit 10 ";
    $result = sql_query($sql);

    if(sql_num_rows($result)) {
?>

<!-- 같이구매한상품 시작 { -->
<section id="sit_relbuy">
    <h2>같이 구매한 상품 </h2>
    <div id="sct_relbuyitem">
        <?php
        for($k=0; $row=sql_fetch_array($result); $k++) {
            $name = get_text($row['it_name']);
            $img  = get_it_image($row['it_id'], 230, 230, false, '', $name);
            $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

            if(!$img)
                continue;
        ?>
        <div class="item">
            <a href="<?php echo $href; ?>" class="sct_a"><?php echo $img; ?></a>
        </div>
        <?php
        }
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    $("#sct_relbuyitem").owlCarousel({
        items : 6,
        itemsDesktop : [1199,6],
        itemsDesktopSmall : [971,5],
        itemsTablet: [640,3],
        itemsMobile: [320,2],
        pagination:false,
        navigation : true,
    });
});
</script>
<?php
    }
}
?>
<script>
$("#sit_tab").UblueTabs({
    eventType:"click"
});

$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});

$(function(){
    // 상품이미지 슬라이드


    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});

// 상품보관
function item_wish(f, it_id)
{
    f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
    f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
    f.submit();
}

// 추천메일
function popup_item_recommend(it_id)
{
    if (!g5_is_member)
    {
        if (confirm("회원만 추천하실 수 있습니다."))
            document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL."/item.php?it_id=$it_id"); ?>";
    }
    else
    {
        url = "<?php echo G5_SHOP_URL; ?>/itemrecommend.php?it_id=" + it_id;
        opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
        popup_window(url, "itemrecommend", opt);
    }
}

// 재입고SMS 알림
function popup_stocksms(it_id)
{
    url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
    opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
    popup_window(url, "itemstocksms", opt);
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}
</script>

<!-- 상세페이지 -->

<section style="text-align: center;">
<a href="<?=G5_SHOP_URL?>/list.php?ca_id=<?=$it[ca_id]?>">
    <div class="btn_submit" style="width: 50%;height: 40px;    padding: 0;margin: 10px 0;line-height: 40px;font-weight: bold;border-radius: 5px;display: block;color: #fff;text-align: center;    margin: 0 auto;margin-top: 25px;">
        <i class=" fa fa-list" aria-hidden="true" style=""> 목록보기</i>
    </div>
</a>
</section>

