<?php
// $shop_id="2_1398397253_34";
$shop_id = $_GET["sid"];
if("" != $shop_id):
?>
	<?php
	//定义emitong文件夹路径
	if(!defined('EMITONG_DIR')) {
		define('EMITONG_DIR', dirname(dirname(__FILE__)) );
	}
	//定义shop文件夹路径
	if(!defined('SHOP_DIR')) {
		define('SHOP_DIR', dirname(dirname(dirname(__FILE__))));
	}
	//引用Util包
	require_once(SHOP_DIR."/admin/Util/CommonUtil.php");
	require_once(SHOP_DIR."/admin/Util/MyBCSUtil.php");
	require_once(EMITONG_DIR."/Util/ShopMySQL.php");

	$model_all_shop_more = ShopMySQL::getAllShopMore($shop_id);
	?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no ">
	<title>更多优惠</title>
	<link rel="stylesheet" href="../static/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../static/css/preferential.css">
	<link rel="stylesheet" type="text/css" href="../static/css/nav-footer.css">
</head>
<body>
	<div class="container">
		<div id="more-preferential">
			<div class="preferential-list">
			<?php foreach($model_all_shop_more as $model_shop_more):?>
			<?php
			//基本字段
			$more_name      = $model_shop_more->getMoreName();
			$more_emi_price = $model_shop_more->getMoreEmiPrice();
			$more_price     = $model_shop_more->getMorePrice();
			$more_img_name  = $model_shop_more->getMoreImgName();
			//图片
			$prefix             = CommonUtil::getPhotoDirPrefix("1", $shop_id);
			$more_img_url        = CommonUtil::getPhotoUrl($prefix."/".$more_img_name);
			?>
				<div class="preferential-pic">
					<div class = "pre-picture">
						<img src="<?=$more_img_url?>" alt="<?=$more_name?>" >
					</div>	
					<div class="preferential-info">
						<span class = "product-name"><?=$more_name?></span>
						<br>
						<span class = "
						<?php if(0 == $more_emi_price):?>
							old-price
						<?php else:?>
							current-price
						<?php endif;?>

						">益米价：<span><?=$more_emi_price?>元</span></span>
						<span class = "old-price"><?=$more_price?>元</span>
					</div>
					<!-- <div class = "link-pic">
						<a href="#" class="links"><img src="../static/images/links.png"></a>
					</div> -->
				</div>
			<?php endforeach;?>
			</div>
			<div id="add-load">
				<a href="#" id="" class="add-load">点击加载更多</a>
			</div>
			<input type="hidden" value="<?=$shop_id?>" id="sid"/>
		</div>
	</div>	
	<div id="footer">	
			<ul class="navbar-fixed-bottom">
				<a href="index.php?sid=<?=$shop_id?>" ><li class="link1"><img src="../static/images/house.png" class = "button-img3">商家后院</li></a>
				<a href="emirecommend.php?sid=<?=$shop_id?>"><li class="link link2"><img src="../static/images/star.png" class="button-img1">益米推荐</li></a>
				<a href="preferential.php?sid=<?=$shop_id?>"><li class="link link3"><img src="../static/images/gift.png" class="button-img2" >更多优惠</li></a>
			</ul>
	</div>
</body>
<script type="text/javascript" src="../static/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="../static/js/nav-footer.js"></script>
<script type="text/javascript" src="../static/js/preferential.js"></script>
</html>
<?php endif;?>