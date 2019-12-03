<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<?php
if($this->total_count > 0) {
    $li_width = intval(100 / $this->list_mod);
    $li_width_style = ' style="width:'.$li_width.'%;"';
    $k = 1;
    $slide_btn = '<button type="button" class="bst_sl">'.$k.'번째 리스트</button>';

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        if($i == 0) {
            echo '<section id="best_item">'.PHP_EOL;
            echo '<h2>베스트상품</h2>'.PHP_EOL;
            echo '<div class="sct_best">'.PHP_EOL;
        }

        if($i > 0 && ($i % $this->list_mod == 0)) {
            echo '</ul>'.PHP_EOL;
            echo '<div class="sct_best">'.PHP_EOL;
            $k++;
            $slide_btn .= '<button type="button">'.$k.'번째 리스트</button>';
        }

        echo '<div class="sct_li item">'.PHP_EOL;

        if ($this->href) {
            echo '<div class="sct_img"><a href="'.$this->href.$row['it_id'].'" class="sct_a"><span class="best_icon">BEST ITEM</span>'.PHP_EOL;
        }

        if ($this->view_it_img) {
            echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name'])).PHP_EOL;
        }

        if ($this->href) {
            echo '</a></div>'.PHP_EOL;
        }

        if ($this->view_it_id) {
            echo '<div class="sct_id">&lt;'.stripslashes($row['it_id']).'&gt;</div>'.PHP_EOL;
        }

        if ($this->href) {
            echo '<div class="sct_txt"><a href="'.$this->href.$row['it_id'].'" class="sct_a">'.PHP_EOL;
        }

        if ($this->view_it_name) {
            echo stripslashes($row['it_name']).PHP_EOL;
        }

        if ($this->href) {
            echo '</a></div>'.PHP_EOL;
        }

        // if ($this->view_it_price) {
        //     echo '<div class="sct_cost">'.display_price(get_price($row), $row['it_tel_inq']).'</div>'.PHP_EOL;
        // }

        echo '</div>'.PHP_EOL;
    }

    if($i > 0) {
        echo '</div>'.PHP_EOL;
        echo '</section>'.PHP_EOL;
    }
?>


<script>
$(document).ready(function() {
    $(".sct_best").owlCarousel({
       pagination:true,
       navigation : false,
       itemsScaleUp : false,
       items : 4,
       itemsDesktop : [1199,4],
       itemsDesktopSmall : false,
       itemsTablet :  [640,2],
       itemsMobile :false,
    });
});
</script>
<?php
}
?>