(function (){

	alert('exec');

	var INTERVAL = 3600;

	var username = document.getElementsByName('username')[0];
	var password = document.getElementsByName('password')[0];
	var Submit = document.getElementsByName('Submit')[0];


	username.value = '123123';

	setTimeout(function (){
		//window.location.href= "http://wireless-gateway.netease.com/login.html"
	}, INTERVAL);


})();