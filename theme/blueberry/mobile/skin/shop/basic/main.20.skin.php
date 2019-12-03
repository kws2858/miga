<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.shop.list.js"></script>', 10);
?>
<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<!-- 상품진열 10 시작 { -->
<?php
$li_width = intval(100 / $this->list_mod);
$li_width_style = ' style="width:'.$li_width.'%;"';

for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i == 0) {
        if ($this->css) {
            echo "<div class=\"{$this->css}\">\n";
        } else {
            echo "<div class=\"sct sct_20\">\n";
        }
    }

    if($i % $this->list_mod == 0)
        $li_clear = ' sct_clear';
    else
        $li_clear = '';

    echo "<div class=\"item\">\n";

    echo "<div class=\"sct_img\">\n";

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a>\n";
    }

    echo "</div>\n";
    echo "<div class=\"sct_txt\">\n";


    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_name\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

    if ($this->view_it_name) {
        echo "사이즈 : ";
        echo stripslashes($row['it_1'])."\n";
    }      
    // if ($this->view_it_cust_price || $this->view_it_price) {

    //     echo "<div class=\"sct_cost\">\n";

    //     if ($this->view_it_cust_price && $row['it_cust_price']) {
    //         echo "<strike>".display_price($row['it_cust_price'])."</strike>\n";
    //     }

    //     if ($this->view_it_price) {
    //         echo display_price(get_price($row), $row['it_tel_inq'])."\n";
    //     }

    //     echo "</div>\n";

    // }
    if ($this->view_it_icon) {
        echo "<div class=\"sct_icon_wr\">".item_icon2($row)."</div>\n";
    }


    echo "</div>\n";


    echo "</div>\n";
}



if ($i > 0) echo "</div>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>



<script>
$(document).ready(function() {
    $(".sct_20").owlCarousel({
        items : 5,
        itemsDesktop : [1199,5],
        itemsDesktopSmall : [971,4],
        itemsTablet: [640,3],
        itemsMobile: [320,2],
        pagination:false,
        navigation : true,
    });
});
</script>
<!-- } 상품진열 10 끝 -->
