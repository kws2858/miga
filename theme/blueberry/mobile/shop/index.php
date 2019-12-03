<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_THEME_MSHOP_PATH.'/index.shop.head.php');
?>


<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<div class="idx_wr">
    <div id="sbn_side" class="content_box">
        <h2>쇼핑몰 배너</h2>
        <?php echo display_banner('왼쪽', 'boxbanner.skin.php'); ?>
    </div>
    <div class="idx_shop content_box">
        <div class="idx_shop_wr">
            <h2>recommend item</h2>
      
            <?php if($default['de_mobile_type2_list_use']) { ?>
            <?php
            $list = new item_list();
            $list->set_mobile(true);
            $list->set_type(2);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', false);
            echo $list->run();
            ?>
            <?php } ?>
        </div>
    </div>
</div>



<?php
if($default['de_type4_list_use']) {
    $save_file = G5_DATA_PATH.'/cache/theme/blueberry/mainbestcategory.php';
    if(is_file($save_file))
        include($save_file);

    $cnt = 0;
    $first_ca_id = '';

    if(!empty($mainbestcategory)) {
        foreach($mainbestcategory as $val) {
            $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id = '$val' and ca_use = '1' ";
            $row = sql_fetch($sql);

            if(!$row['ca_id'])
                continue;

            $tab_class = '';
            $tab_selected = '';

           if($cnt == 0) {
                echo '<section id="cate_best">'.PHP_EOL;
                echo '<header>'.PHP_EOL;
                echo '<h2>best seller</h2>'.PHP_EOL;
                echo '</header>'.PHP_EOL;
                echo '<div class="tab">'.PHP_EOL;
                echo '<ul>'.PHP_EOL;
                $tab_class = ' class="tab-1"';
                $tab_selected = ' tab_selected';
                $first_ca_id = $val;
            }
        ?>
            <li<?php echo $tab_class; ?>><button type="button" data-ca_id="<?php echo $val; ?>" class="category_best<?php echo $tab_selected; ?>"><?php echo get_text($row['ca_name']); ?></button></li>
        <?php
            $cnt++;
        }

        if($cnt > 0) {
            echo '</ul>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
            $_GET['ca_id'] = $first_ca_id;
            echo '<div id="cate_best_item">'.PHP_EOL;
            include_once(G5_THEME_SHOP_PATH.'/ajax.mainbestitem.php');
            echo '</div>'.PHP_EOL;
            echo '</section>'.PHP_EOL;
        }
    }
?>

<script>
$(function() {
    $(".category_best").on("click", function() {
        var $this = $(this);
        if($this.hasClass("tab_selected"))
            return false;

        var ca_id = $this.data("ca_id");

        $.ajax({
            type: "GET",
            url: g5_theme_shop_url+"/ajax.mainbestitem.php",
            data: { ca_id: ca_id },
            async: true,
            cache: false,
            success: function(data) {
                $("#cate_best_item").html(data);
                $(".category_best").removeClass("tab_selected");
                $this.addClass("tab_selected");
            }
        });
    });
});
</script>
<?php
}
?>
<div class="idx_wr">
    <div class="idx_ev content_box">
        <h2>EVENT</h2>
        <?php include_once(G5_MSHOP_SKIN_PATH.'/main.event.skin.php'); // 이벤트 ?>
    </div>

    <div class="idx_shop content_box">
      <h2>new item</h2>
        <?php if($default['de_mobile_type3_list_use']) { ?>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(3);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', false);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', true);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
        <?php } ?>
    </div>
</div>


<script>
equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.content_box');
});


$(window).resize(function(){
  equalheight('.content_box');
});

</script>



<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>