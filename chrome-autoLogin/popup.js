(function (){


	document.addEventListener('DOMContentLoaded', function () {
	  var start = document.getElementById('start');
	  var reset = document.getElementById('reset');
	  var username = document.getElementById('username');
	  var password = document.getElementById('password');
	  var period = document.getElementById('period');
	  var info = document.getElementById('info');


	  start.addEventListener('click', function (ev) {
	  	info.innerText = '';
		if (isParamValid()) {
			excuteSchduler(username.value, password.value, period.value);
		} else {
			info.innerText = 'Please check your parameters...';
		}

	  });

	  function getFnString (u, p) {
	  	var arr = [];
	  	arr.push("username.value="+u+";");
	  	arr.push("password.value="+u+";");
	  	
	  	var ajaxString = "$.ajax({url : url,data : $('form').first().serialize(),type : 'post',dataType : 'text', success : function (){console.log(new Date(), 'login successfully!');},error : function (){console.error(arguments);}});";
	  	arr.push(ajaxString);

	  	return arr.join('');
	  }

	  function excuteSchduler (u, p, v) {
	  	var codes = [];
			codes.push("var url = 'http://wireless-gateway.netease.com/fs/customwebauth/login.html?switch_url=http://wireless-gateway.netease.com/login.html&ap_mac=c0:62:6b:66:d8:00&client_mac=e0:ac:cb:81:1d:3c&wlan=NetEase_Guest';");
			codes.push("var username = document.getElementsByName('username')[0];");
			codes.push("var password = document.getElementsByName('password')[0];");
			codes.push("var form = document.getElementsByTagName('form')[0];");
			var fnString = getFnString(u, p);
			codes.push(fnString);
			codes.push("var timer=setInterval(function(){"+ fnString +"}, "+ v*1000 +")");

		var temp = [];
		temp.push("var n=window.navigator;");
		temp.push("Object.defineProperty(n, 'userAgent', {'value':'xxx', writable:true});");
		temp.push("alert(window.navigator.userAgent);");
		temp.push("console.log(window.navigator.userAgent);");

	  	chrome.tabs.executeScript(null,{code:temp.join("")});

  		window.close();
	  };

	  function isParamValid () {
	  	if (isNaN(username.value)) return false;
	  	if (isNaN(password.value)) return false;
	  	if (isNaN(period.value)) return false;

	  	return true;
	  }

	});
})();