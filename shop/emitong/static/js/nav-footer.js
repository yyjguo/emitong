/*highligh the navigation tag*/
$(function(){
	var $myNav = $("#footer ul a ");
	$myNav.each(function(){
		var links = $(this).attr("href");
		var myUrl = document.URL;
		if(myUrl.indexOf(links) != -1){
			$(this).children("li").css({"background-color":"#850005","background-image":'url()'});
		}
	});	

	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
		WeixinJSBridge.call('hideToolbar');
	});

	$("#footer a").click(function() {
		  window.history.go(-1);
	});
});