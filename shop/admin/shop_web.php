<?php session_start();?>
<?php require_once("redirect.php")?>
<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>商家网站</title>

	<?php include("header.php"); ?>

	<style>
		#update {
			display: none;
		}
	</style>

</head>
<body>
<div class="container">

	<div id="nav_bar">
		<?php include("nav_bar.php");?>
	</div>

	<?php include("shop_web_menu.php");?>

	<?php
	require_once("wechat/Util/MySQL.php");
	require_once("Util/CommonUtil.php");
	$model_man_news = MySQL::getNewsMessage($shop_id);

	?>


	<?php if(null != $model_man_news):?>

		<?php
		$article_id = $model_man_news->getId();
		$shop_online = $model_man_news->getShopOnline();
		$article_order = $model_man_news->getArticleOrder();
		$article_title = $model_man_news->getArticleTitle();
		$article_description = $model_man_news->getArticleDescription();
		$article_img_name = $model_man_news->getArticleImgName();
		?>

		<!--存在微信店铺图文资料，显示相关的微信店铺信息图文资料-->
		<div class="shop_web_content">
			<form class="form-horizontal" role="form" method="post" action="do_news_logo.php" enctype="multipart/form-data">

				<div class="form-group">
					<label for="pic_url" class="col-sm-3 control-label">图片</label>
					<div class="col-sm-7 form-inline">
						<?php
						if("" != $article_img_name):?>
							<?php
							$dir = CommonUtil::getPhotoDirPrefix("3", $shop_id);
							$article_img_url = CommonUtil::getPhotoUrl($dir."/".$article_img_name);
							?>
							<!--有图片-->
							<img width="64px" src="<?=$article_img_url?>" alt="">
							<button type="submit" class="btn btn-danger"  id="pic_delete" name="pic_delete" disabled="disabled">
								<span class="glyphicon glyphicon-trash"></span> 删除图片
							</button>
						<?php else:?>
							<!--没图片-->
							<input type="file" class="form-control" id="img_name" name="img_name" style="width:400px" disabled="disabled">
							<button type="submit" class="btn btn-warning"  id="pic_upload" name="pic_upload" disabled="disabled">
								<span class="glyphicon glyphicon-upload"></span> 上传图片
							</button>
						<?php endif;?>
					</div>
				</div>

				<hr/>

				<div class="form-group">
					<label for="title" class="col-sm-3 control-label">图文名称 <span class="text-muted">*</span></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="title" name="title" disabled="disabled" value="<?=$article_title?>">
					</div>
				</div>

				<div class="form-group">
					<label for="description" class="col-sm-3 control-label">图文描述</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="description" name="description" disabled="disabled" value="<?=$article_description?>" placeholder="默认为空，只有排序为1商家的才会显示该描述">
					</div>
				</div>

				<div class="form-group">
					<label for="online" class="col-sm-3 control-label">在线状态 <span class="text-muted">*</span></label>
					<div class="col-sm-7">
						<select class="form-control" name="online" id="online" disabled="disabled">
							<?php if(1 == $shop_online):?>
								<option value="1" selected>是</option>
								<option value="0">否</option>
							<?php else: ?>
								<option value="1">是</option>
								<option value="0" selected>否</option>
							<?php endif;?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="order" class="col-sm-3 control-label">同类排序 <span class="text-muted">*</span></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="order" name="order" disabled="disabled" value="<?=$article_order?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-7">
						<button type="button" class="btn btn-warning"  id="edit" name="edit">
							<span class="glyphicon glyphicon-edit"></span> 编辑资料
						</button>
					</div>
					<div class="col-sm-offset-3 col-sm-7">
						<button type="submit" class="btn btn-warning"  id="update" name="update">
							<span class="glyphicon glyphicon-edit"></span> 提交修改
						</button>
					</div>
				</div>
				<input type="hidden" name="nid" id="nid" value="<?=$article_id?>"/>
				<input type="hidden" name="sid" id="sid" value="<?=$shop_id?>"/>
				<input type="hidden" name="siid" id="siid" value="<?=$shop_info_id?>"/>
			</form>
		</div>
	<?php else: ?>
		<!--没有生成微信店铺图文资料-->
		<div class="shop_web_header">
			<button type="button" class="btn btn-warning" id="new" name="new">点击生成网站信息</button>
		</div>

	<?php endif;?>



	<hr/>
	<div class="alert alert-warning" id="alert" style="">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>本页面进行网站相关配置</strong>
	</div>

	<input type="hidden" name="sid" id="sid" value="<?=$shop_id?>"/>
	<input type="hidden" name="siid" id="siid" value="<?=$shop_info_id?>"/>
</div>

<script>

	//生成店铺微信图文资料
	$("#new").live("click", function() {
		var siid = $("#siid").val().trim();

		$.ajax({
			type: "post",
			url: "do_man_news.php?action=new",
			dataType: "json",
			data: {
				siid: siid
			},
			beforeSend: function() {
				$("button").button("loading");
			},
			success: function(msg) {
				$("strong").text(msg.tips);
				$("button").button('reset');
			}
		});
		return false;
	});

	//上传图片
	$("#pic_upload").click(function() {
		if ("" == $("#img_name").val()) {
			alert("请选择文件再点击上传！");
			return false;
		}

	});
	//删除图片
	$("#pic_delete").click(function() {
		if (confirm("确认删除？")) {
			return true;
		}
	});

	//修改生成店铺微信图文资料
	$("#update").click(function() {
		var nid         = $("#nid").val().trim();
		var online      = $("#online").val().trim();
		var title       = $("#title").val().trim();
		var description = $("#description").val().trim();
		var order       = $("#order").val().trim();

		$.ajax({
			type: "post",
			url: "do_man_news.php?action=update",
			dataType: "json",
			data: {
				nid         : nid,
				online      : online,
				title       : title,
				description : description,
				order       : order
			},
			beforeSend: function() {
				$("button").button("loading");
			},
			success: function(msg) {
				$("strong").text(msg.tips);
				$("button").button('reset');
			}
		})
		return false;
	});

	$("#edit").live("click", function() {
		$(":disabled").attr('disabled',false);
		$(this).hide();
		$("#update").show();
	});


</script>

</body>

</html>                                                       