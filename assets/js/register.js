var MAXN = 3, showed = 1;

function addOneMember() {
	if (document.getElementById('competitionType').value == 0) {
		alert("请选择队伍参赛类型！");
		return;
	}

	if (document.getElementById('competitionType').value == 1) {
		MAXN = 5;
	}

	document.getElementById("teamMember"+showed).style.display="block";

	showed = showed + 1;

	if (showed == MAXN) {
		document.getElementById("addButton").style.display="none";
	}
}

function Checker() {
	if (registerform.teamName.value == "" || 
		registerform.password.value == "" || 
		registerform.passwordConfirm.value == "" || 
		registerform.competitionType.value == 0) {
		alert("请将队伍基本报名信息填写完整！");
		return false;
	}

	if (registerform.password.value != registerform.passwordConfirm.value) {
		alert("两次输入密码不一致！");
		return false;
	}

	if (registerform.teamLeaderName.value == "" || 
		registerform.studentNo.value == "" || 
		registerform.contact.value == "" || 
		registerform.college.value == "" || 
		registerform.major.value == "" || 
		registerform.grade.value == 0 || 
		registerform.campus.value == 0) {
		alert("请将队长信息填写完整！");
		return false;
	}

	for (var i = 1; i < showed - 1; i++) {
		if (registerform.teamMemberName1.value == "" || 
			registerform.studentNo1.value == "" || 
			registerform.contact1.value == "" || 
			registerform.college1.value == "" || 
			registerform.major1.value == "" || 
			registerform.grade1.value == 0 || 
			registerform.campus1.value == 0) {
			alert("请将队员 " + i + " 信息填写完整！");
			return false;
		}
	}

	if (registerform.captcha.value == "") {
		alert("请输入验证码!")
		return false;
	}

	return true;
}
