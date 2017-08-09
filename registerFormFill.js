//jQuery Vesion
$("[name=teamName]").val('我们唱着东方红');
$("[name=password]").val('666666');
$("[name=passwordConfirm]").val('666666');
$("[name=competitionType]").val(1);

$("[name=teamLeaderName]").val('当家做主站起来');
$("[name=studentNo]").val('201122335566');
$("[name=contact]").val('13723332333');
$("[name=college]").val('生命学院');
$("[name=major]").val('膜法与长寿技术');
$("[name=grade]").val('2016级');
$("[name=campus]").val('大学城校区');

for (var i = 1; i < 5; i++) {
	addOneMember();
	$("[name=studentNo" + i + "]").val('201122335566');
	$("[name=contact" + i + "]").val('13723332333');
	$("[name=college" + i + "]").val('生命学院');
	$("[name=major" + i + "]").val('膜法与长寿技术');
	$("[name=grade" + i + "]").val('2016级');
	$("[name=campus" + i + "]").val('五山校区');
}

$("[name=teamMemberName1").val('我们讲着春天的故事');
$("[name=teamMemberName2]").val('改革开放富起来');
$("[name=teamMemberName3]").val('继往开来的领路人');
$("[name=teamMemberName4]").val('带领我们走进那新时代');

//高举旗帜 开创未来
//同志们好~ 同志们辛苦了~






/*
//Initial Vesion: Native Operation
register.teamName.value = "我们唱着东方红";
register.password.value = "666666";
register.passwordConfirm.value = "666666";
register.competitionType.value = 1;

register.teamLeaderName.value = "当家做主站起来";
register.studentNo.value = "201122335566";
register.contact.value = "13723332333";
register.college.value = "生命学院";
register.major.value = "膜法与长寿技术";
register.grade.value = "2016级";
register.campus.value = "大学城校区";

addOneMember();
register.teamMemberName1.value = "我们讲着春天的故事";
register.studentNo1.value = "201122335566";
register.contact1.value = "13723332333";
register.college1.value = "生命学院";
register.major1.value = "膜法与长寿技术";
register.grade1.value = "2016级";
register.campus1.value = "五山校区";

addOneMember();
register.teamMemberName2.value = "改革开放富起来";
register.studentNo2.value = "201122335566";
register.contact2.value = "13723332333";
register.college2.value = "生命学院";
register.major2.value = "膜法与长寿技术";
register.grade2.value = "2016级";
register.campus2.value = "五山校区";

addOneMember();
register.teamMemberName3.value = "继往开来的领路人";
register.studentNo3.value = "201122335566";
register.contact3.value = "13723332333";
register.college3.value = "生命学院";
register.major3.value = "膜法与长寿技术";
register.grade3.value = "2016级";
register.campus3.value = "五山校区";

addOneMember();
register.teamMemberName4.value = "带领我们走进那新时代";
register.studentNo4.value = "201122335566";
register.contact4.value = "13723332333";
register.college4.value = "生命学院";
register.major4.value = "膜法与长寿技术";
register.grade4.value = "2016级";
register.campus4.value = "五山校区";

//高举旗帜 开创未来
//同志们好~ 同志们辛苦了~
*/
