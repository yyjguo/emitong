<?php
/**
 * Description: 
 *
 * Author: Yip
 * Date: 14-4-26 下午10:08
 */

if(!defined('SHOP_DIR')) {
	define('SHOP_DIR', dirname(dirname(dirname(__FILE__))));
}
//引用model包
require_once(SHOP_DIR. '/admin/wechat/Model/News.php');

class WXMySQL {
	/*
	 * 获取数据库连接
	 *
	 * @return
	 * */
	private function getConn() {

		/*微信端图文菜单设置，参数配置*/
		$dbName = "HZVFWjWuFxywySSSXteG";
		$host = "sqld.duapp.com";
		$port = "4050";
		$ak = "fgTXqN699OOvUKTRnO1OQNty";
		$sk = "RQDDy90TjPiGN4s5tjG6kO3L92jlnu6T";

		//本地测试
		// $dbName = "HZVFWjWuFxywySSSXteG";
		// $host = "localhost";
		// $ak = "root";
		// $sk = "trf153.";

		try {
			$conn = new mysqli($host, $ak, $sk, $dbName, $port);
			// $conn = new mysqli($host, $ak, $sk, $dbName);
			if(!$conn) {
				die("Connect Server Failed: " . mysqli_error($conn));
			}
			$conn->set_charset("utf8");//设置编码utf8
			return $conn;
		}
		catch (mysqli_sql_exception $e) {
			throw $e;
		}

	}

	public static function getShopListByType($type, $index=9, $amount=8, $online=1) {
		$sql = "select * from emi_man_news where shop_type=? and shop_online=? order by article_order limit ?,?";
		$newsMessageList = array();

		try {
			$mysql = new WXMySQL();
			$conn = $mysql->getConn();
			$ps = $conn->prepare($sql);
			$ps->bind_param("iiii", $type, $online, $index, $amount);
			$ps->execute();
			$ps->bind_result($id, $shopId, $shopType, $shopOnline, $articleOrder, $articleTitle, $articleDescription, $articleImgName);

			while($ps->fetch()) {
				$newsMessage = new News();
				$newsMessage->setId($id);
				$newsMessage->setShopId($shopId);
				$newsMessage->setShopType($shopType);
				$newsMessage->setShopOnline($shopOnline);
				$newsMessage->setArticleOrder($articleOrder);
				$newsMessage->setArticleTitle($articleTitle);
				$newsMessage->setArticleDescription($articleDescription);
				$newsMessage->setArticleImgName($articleImgName);
				array_push($newsMessageList, $newsMessage);
			}
			$ps->close();
			$conn->close();

		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
		return $newsMessageList;
	}
}