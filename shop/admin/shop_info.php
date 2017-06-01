<?php session_start();?>
<?php require_once("redirect.php")?>
<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>商家资料</title>

	<?php include("header.php"); ?>


</head>
<body>
	<div class="container">

		<div id="nav_bar">
			<?php include("nav_bar.php");?>
		</div>
		<div class="shop_info_header">
			<a href="shop_insert.php" class="btn btn-default btn-lg" role="button">添加商家</a>
		</div>
		<hr/>

		<?php
		require_once("Util/MySQLUtil.php");
		$model_all_shop_info = MySQLUtil::getAllShopInfo();
		$model_all_shop_type = MySQLUtil::getAllShopType();

		foreach ($model_all_shop_type as $model_shop_type) {
			$type_id = $model_shop_type->getId();
			$type_name = $model_shop_type->getTypeName();
			//$type_count = $model_shop_type->getTypeCount();
			$typeArray[$type_id] = $type_name;
		}
		?>

		<form role="form">
			<table class="table table-striped table-hover">
				<thead>
				<tr class="table_header">
					<th class="table_col_num">#</th>
					<th class="table_col_name">名称</th>
					<th class="table_col_web">网站管理</th>

					<th class="table_col_oper">资料管理</th>
					<th class="table_col_delete">删除</th>
				</tr>
				</thead>
				<tbody>

				<?php
				//默认显示所有商户 todo 分页处理
				$num = 1;
				foreach($model_all_shop_info as $model_shop_info):?>
				<?php
					$id = $model_shop_info->getId();
					$shop_id = $model_shop_info->getShopId();
					$shop_name = $model_shop_info->getShopName();
					$shop_type = $model_shop_info->getShopType();
				?>
				<tr>
					<th><?=$num++?></th>
					<th><?=$shop_name?></th>


					<th>
						<a href="shop_web.php?siid=<?=$id?>&sid=<?=$shop_id?>" class="btn btn-info btn-sm" role="button" title="网站">
							<span class="glyphicon glyphicon-home"></span>
						</a>
					</th>


					<th>
						<a href="shop_update.php?upd_id=<?=$id?>" class="btn btn-success btn-sm" role="button" title="编辑">
							<span class="glyphicon glyphicon-edit" ></span>
						</a>&nbsp;|&nbsp;

						<a href="shop_see.php?see_id=<?=$id?>" class="btn btn-primary btn-sm" role="button" title="查看">
							<span class="glyphicon glyphicon-list-alt"></span>
						</a>
					</th>

					<th>
						<a href="shop_delete.php?siid=<?=$id?>&sid=<?=$shop_id?>" class="btn btn-danger btn-sm" role="button" title="删除">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</th>

				</tr>
				<?php endforeach;?>

				</tbody>

			</table>


		</form>


	</div>

	<style>
		.btn-sm {
			padding: 1px 8px;
		}
		.table_col_num {
			width: 150px;
		}

		.table_col_oper {
			width:100px;
		}
		.table_col_web {
			width:90px;
		}
		.table_col_delete {
			width:60px;
		}
		tr {
			color: #333;
		}
		th {
			font-weight: normal;
		}
	</style>


</body>
</html>                                                       