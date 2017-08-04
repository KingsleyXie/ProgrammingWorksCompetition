function freshCaptcha()
{
	$("#captchaImg").attr("src", "../assets/captcha/captcha.php?"+Math.random());
	$("#captcha").val("");
}

function logout() {
	$.ajax({
		type: "JSON",
		url: "logout.php",
		success: function(response) {
			if (response.code == 0) {
				alert("退出系统成功，" + response.teamName);
			}
			window.location.href = "../"
		}
	});
}
