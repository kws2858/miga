<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';
?>

<!-- 장바구니 간략 보기 시작 { -->
<aside id="sbsk">
    <form name="frmcartlist" method="post" action="<?php echo $cart_action_url; ?>">
    <input type="hidden" name="act" value="buy">

    <h2>장바구니</h2>

    <ul class="nav_cart scrollator">
    <?php
    $total_price = 0;
    $sql  = " select it_id, it_name
                from {$g5['g5_shop_cart_table']}
                where od_id = '".get_session('ss_cart_id')."'
                group by it_id ";
    $result = sql_query($sql);

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $price = 0;

        echo '<li>'.PHP_EOL;
        $it_name = get_text($row['it_name']);
        $it_img = get_it_image($row['it_id'], 100, 100, true);

        echo '<span class="cart_img">'.$it_img.'</span>'.PHP_EOL;
        echo '<span class="cart_if">'.PHP_EOL;
        echo '<input type="hidden" name="it_id['.$i.']" value="'.$row['it_id'].'">'.PHP_EOL;
        echo '<input type="hidden" name="it_name['.$i.']" value="'.$it_name.'">'.PHP_EOL;
        echo '<label for="ct_chk_'.$i.'" class="sound_only">'.$it_name.' 선택</label>'.PHP_EOL;
        echo '<span class="sound_only"><input type="checkbox" name="ct_chk['.$i.']" value="1" id="ct_chk_'.$i.'" checked="checked" class="sound_only"></span>'.PHP_EOL;
        echo '<a href="./item.php?it_id='.$row['it_id'].'" class="cart_tit">'.$it_name.'</a>'.PHP_EOL;

        // 상품별 옵션
        $sql2 = " select ct_option, ct_qty, (IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price
                    from {$g5['g5_shop_cart_table']}
                    where od_id = '".get_session('ss_cart_id')."'
                      and it_id = '{$row['it_id']}'
                    order by ct_id ";
        $res2 = sql_query($sql2);

        for($k=0; $row2 = sql_fetch_array($res2); $k++) {
            echo '<span class="cart_op">'.get_text($row2['ct_option']).'</span>'.PHP_EOL;
            echo '<span class="cart_qty">수량 : '.number_format($row2['ct_qty']).'</span>'.PHP_EOL;
            $price += (int)$row2['price'];
            $total_price += (int)$row2['price'];
        }

        echo '<span class="cart_pr">'.display_price($price).'</span>'.PHP_EOL;
        echo '</span>'.PHP_EOL;
        echo '<button class="cart_del" type="button" data-it_id="'.$row['it_id'].'">삭제</button>'.PHP_EOL;
        echo '</li>'.PHP_EOL;
    }

    if ($i==0)
        echo '<li id="sbsk_empty">장바구니 상품 없음</li>'.PHP_EOL;
    ?>
    </ul>
    <div class="cart_al">총 합계  <strong><?php echo number_format($total_price); ?> 원</strong></div>
    <div class="cart_btn">
        <button type="submit">주문하기</button>
    </div>
    </form>
</aside>

<script>
$(function () {
    $(".nav_cart").scrollator();

    $(".cart_del").on("click", function() {
        var it_id = $(this).data("it_id");
        var $wrap = $(this).closest("li");

        $.ajax({
            url: g5_theme_shop_url+"/ajax.cartdelete.php",
            type: "POST",
            data: {
                "it_id" : it_id
            },
            dataType: "json",
            async: true,
            cache: false,
            success: function(data, textStatus) {
                if(data.error != "") {
                    alert(data.error);
                    return false;
                }

                $wrap.remove();
            }
        });
    });
});
</script>
<!-- } 장바구니 간략 보기 끝 -->