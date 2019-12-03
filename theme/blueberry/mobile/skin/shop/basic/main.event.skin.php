<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 이벤트 정보
$hsql = " select ev_id, ev_subject, ev_subject_strong from {$g5['g5_shop_event_table']} where ev_use = '1' order by ev_id desc limit 2";
$hresult = sql_query($hsql);

if(sql_num_rows($hresult)) {
    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

    <ul id="sev">
    <?php
    for ($i=0; $row=sql_fetch_array($hresult); $i++)
    {

        echo '<li class="sev_li"><div class="ev_wr">';
        $href = G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'];
        $event_img = G5_DATA_PATH.'/event/'.$row['ev_id'].'_m'; // 이벤트 이미지
        echo '<strong>event</strong>';
        echo '<a href="'.$href.'" class="sev_text">';
        if ($row['ev_subject_strong']) echo '<strong>';
        echo $row['ev_subject'];
        if ($row['ev_subject_strong']) echo '</strong>';
        echo '</a>'.PHP_EOL;


            // 이벤트 상품
        $sql2 = " select b.*
                            from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id)
                            where a.ev_id = '{$row['ev_id']}'
                            order by it_id desc
                            limit 0, 3 ";
        $result2 = sql_query($sql2);
        for($k=1; $row2=sql_fetch_array($result2); $k++) {
            if($k == 1) {
                echo '<div class="ev_prd">'.PHP_EOL;
            }

            $item_href = G5_SHOP_URL.'/item.php?it_id='.$row2['it_id'];

            echo '<div class="ev_prd_'.$k.' item">'.PHP_EOL;
            echo '<span class="ev_prd_img">'.get_it_image($row2['it_id'], 500, 500, get_text($row2['it_name'])).'</span>'.PHP_EOL;
            echo '<div class="ev_txt_wr"><a href="'.$item_href.'" class="ev_prd_tit">'.$row2['it_name'].'</a>'.PHP_EOL;
            echo '<div class="ev_txt_wr"><a href="'.$item_href.'" class="ev_prd_tit"> 사이즈 : '.$row2['it_1'].'</a>'.PHP_EOL;
             // echo '<span class="ev_prd_price">'.display_price(get_price($row2), $row2['it_tel_inq']).'</span>'.PHP_EOL;             
            echo '</div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;            
            echo '</div>'.PHP_EOL;
        }

        if($k > 1) {
            echo '</div>'.PHP_EOL;
        }

        if($k == 1) {
            echo '<div class="ev_prd">'.PHP_EOL;
            echo '<span class="no_prd">등록된 상품이 없습니다.</span>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        echo '</div></li>'.PHP_EOL;

    }



    if ($i==0)
        echo '<li id="sev_empty">이벤트 없음</li>'.PHP_EOL;
    ?>
    </ul>
    <script>
    $(document).ready(function() {
        $(".ev_prd").owlCarousel({
            autoPlay : true,
            navigation : false, 
            pagination: true,
            paginationSpeed : 400,
            singleItem:true
        });
    });
    </script>
<?php
}
?>