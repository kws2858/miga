<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<?php
for ($i=0; $row=sql_fetch_array($result); $i++)
{

    if ($i==0) echo '<aside id="sbn_side" ><h2>쇼핑몰 배너</h2><ul class="sb_bn">'.PHP_EOL;
    //print_r2($row);
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if (file_exists($bimg))
    {

        $banner = '';
        $size = getimagesize($bimg);

        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        if($max_height < $size[1])
            $max_height = $size[1];

        echo '<li'.$bn_first_class.'>'.PHP_EOL;
        
            echo $banner.'<div  style="background-image:url('.G5_DATA_URL.'/banner/'.$row['bn_id'].');" class="bn-img">';
            echo $banner.'<div class="bn-txt-wr"><div class="bn-txt">'.$row['bn_alt'].'';

            if ($row['bn_url'][0] == '#')
                $banner .= '<a href="'.$row['bn_url'].'">';
            else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
                $banner .= '<br><a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'&amp;url='.urlencode($row['bn_url']).'"'.$bn_new_win.' class="btn_b02">';
            
                echo $banner.'자세히보기';
                if($banner)
                    echo '</a>'.PHP_EOL;
            }
            else {
                echo $banner.'';
            }
        echo '</div></div></div>'.PHP_EOL;
        echo '</li>'.PHP_EOL;
            
    }
}
if ($i>0) echo '</ul></aside>'.PHP_EOL;
?>

<script>
$(document).ready(function(){
    $('.sb_bn ').bxSlider({
        pager:true,
        auto:true,
    });
});

 function parallax(){
    var scrolled = $(window).scrollTop();
    $('.sb_bn .bn-img').css('background-position',"0 "+  (scrolled * 1 ) + 'px');
}
$(window).scroll(function(){
    parallax();
});



</script>


