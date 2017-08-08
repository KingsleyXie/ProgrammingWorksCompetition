//Global functions: Captcha Fresh & Logout
function freshCaptcha() {
	$('#captcha-img').attr('src', '../assets/captcha/captcha.php?'+Math.random());
	$('#captcha').val('');
}

function logout() {
	$.ajax({
		type: 'POST',
		url: 'logout.php',
		success: function(response) {
			if (response.code == 0) {
				alert('退出系统成功，' + response.teamName);
			}
			window.location.href = '../';
		}
	});
}

//Code for Register
var MAXN = 3, showed = 1;

function addOneMember() {
	if (document.getElementById('competition-type').value == 0) {
		alert('请选择队伍参赛类型！');
		return;
	}

	if (document.getElementById('competition-type').value == 1) {
		MAXN = 5;
	}

	document.getElementById('team-member' + showed).style.display = 'block';

	showed = showed + 1;

	if (showed == MAXN) {
		document.getElementById('btn-add').style.display = 'none';
	}
}

function checkForm() {
	if (register.teamName.value == '' || 
		register.password.value == '' || 
		register.passwordConfirm.value == '' || 
		register.competitionType.value == 0) {
		alert('请将队伍基本报名信息填写完整！');
		return false;
	}

	if (register.password.value != register.passwordConfirm.value) {
		alert('两次输入密码不一致！');
		return false;
	}

	if (register.teamLeaderName.value == '' || 
		register.studentNo.value == '' || 
		register.contact.value == '' || 
		register.college.value == '' || 
		register.major.value == '' || 
		register.grade.value == 0 || 
		register.campus.value == 0) {
		alert('请将队长信息填写完整！');
		return false;
	}

	for (var i = 1; i < showed - 1; i++) {
		//Todo: Complete this part
		if (register.teamMemberName1.value == '' || 
			register.studentNo1.value == '' || 
			register.contact1.value == '' || 
			register.college1.value == '' || 
			register.major1.value == '' || 
			register.grade1.value == 0 || 
			register.campus1.value == 0) {
			alert('请将队员 ' + i + ' 信息填写完整！');
			return false;
		}
	}

	if (register.captcha.value == '') {
		alert('请输入验证码!')
		return false;
	}

	return true;
}



//Code for 5 Pages: Load or Send Data
function teamsPrepare() {
	$.ajax({
		type: 'POST',
		url: 'showteams.php',
		success: function(response)
		{
			if (response[0].loggedIn == 1) {
				document.getElementById('logged-in-team').innerHTML +=
				'<button class="btn btn-lg btn-primary btn-block" onclick="window.location.href=\'../login\'">登录以查看</button>';
			}
			if (response[0].loggedIn == 0) {
				document.getElementById('logged-in-team').innerHTML +=
				'<div class="table-responsive">' +
					'<table class="table table-bordered">' +
						'<thead>' +
							'<th> 姓名 </th>' +
							'<th> 学号 </th>' +
							'<th> 联系方式 </th>' +
							'<th> 校区 </th>' +
							'<th> 学院 </th>' +
							'<th> 专业 </th>' +
							'<th> 年级 </th>' +
						'</thead>' +
						'<tbody id="logged-in-team-info"></tbody>' +
					'</table>' +
				'</div>';
			}

			for(var i = 1; i < response.length; i++) {
				if (response[0].loggedIn == 0 && !(response[i].teamID > 1000)) {
					document.getElementById('logged-in-team-info').innerHTML +=
					'<tr>' +
						'<td>' + response[i].studentName + '</td>' +
						'<td>' + response[i].studentNo + '</td>' +
						'<td>' + response[i].contact + '</td>' +
						'<td>' + response[i].campus + '</td>' +
						'<td>' + response[i].college + '</td>' +
						'<td>' + response[i].major + '</td>' +
						'<td>' + response[i].grade + '</td>' +
					'</tr>';
				}

				if(response[i].teamID > 1000) {
					var teamType = response[i].teamID > 2000 ? 'creativity-teams' : 'production-teams';

					document.getElementById(teamType + '-placeholder').style.display = 'none';
					document.getElementById(teamType).innerHTML +=
					'<div class="container">' +
						'<div class="row clearfix">' +
							'<div class="col-md-12 column">' +
								'<div class="panel panel-default" id="team' + response[i].teamID + '">' +
									'<div class="panel-heading msg-heading">' +
										'<div class="panel-title">' +
											'<div class="pull-left msg-no"> #' + response[i].teamID + ' ' + '</div>' +
											'<div class="pull-left">' + response[i].teamName + '</div>' +
											'<div class="pull-right msg-time">' +
												//Note: The following two icons are surrounded with 3 spaces, 
												//in order to make an easier separation
												'<i class="fa fa-calendar"></i> ' + response[i].calendarTime +
												' <i class="fa fa-clock-o"></i> ' + response[i].clockTime +
											'</div>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>';

					document.getElementById('team' + response[i].teamID).innerHTML +=
					'<table class="table table-bordered">' +
						'<thead>' +
							'<th> 姓名 </th>' +
							'<th> 校区 </th>' +
							'<th> 学院 </th>' +
							'<th> 专业 </th>' +
							'<th> 年级 </th>' +
						'</thead>' +
						'<tbody id="teaminfo' + response[i].teamID + '"></tbody>' +
					'</table>';

					document.getElementById('teaminfo' + response[i].teamID).innerHTML +=
					'<tr class="teams-leader">' +
						'<td>' + response[i].students[0].studentName + '</td>' +
						'<td>' + response[i].students[0].campus + '</td>' +
						'<td>' + response[i].students[0].college + '</td>' +
						'<td>' + response[i].students[0].major + '</td>' +
						'<td>' + response[i].students[0].grade + '</td>' +
					'</tr>';
					
					for (var stu = 1; stu < response[i].students.length; stu++) {
						document.getElementById('teaminfo' + response[i].teamID).innerHTML +=
						'<tr>' +
							'<td>' + response[i].students[stu].studentName + '</td>' +
							'<td>' + response[i].students[stu].campus + '</td>' +
							'<td>' + response[i].students[stu].college + '</td>' +
							'<td>' + response[i].students[stu].major + '</td>' +
							'<td>' + response[i].students[stu].grade + '</td>' +
						'</tr>';
					}
				}
			}

			if (response[0].loggedIn == 0) {
				document.getElementById('logged-in-team').innerHTML +=
				'<input class="btn btn-primary btn-lg btn-left" onclick="window.location.href=\'../upload\'" type="submit" value="上传作品"/>' +
				'<input class="btn btn-primary btn-lg btn-right" onclick="logout()" type="submit" value="退出系统"/>';
			}
		}
	});
}

function loginPrepare() {
	$(document).ready(function() {
		$('#login-form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: 'login.php',
				data: $(this).serialize(),
				success: function(response)
				{
					if (response.code == 1)
						alert('验证码错误！');
					if (response.code == 2)
						alert('队伍 ID 或登录密码错误！');
					if (response.code == 3)
						alert('不要调皮哦');
					if (response.code == 0) {
						alert('欢迎回来，' + response.teamName);
						window.location.href = '../teams';
					}
				}
			});
		});
	});
}

function forumPrepare() {
	$.ajax({
		type: 'POST',
		url: 'showMsg.php',
		success: function(response)
		{
			for (var i = 0; i < response.length; i++) {
				document.getElementById('messages').innerHTML +=
				'<div class="container">' +
					'<div class="row clearfix">' +
						'<div class="col-md-12 column">' +
							'<div class="panel panel-default">' +
								'<div class="panel-heading msg-heading">' +
									'<div class="panel-title">' +
										'<div class="pull-left msg-no"> #' + (response.length - i) +  '</div>' +
										'<div class="pull-left">' + response[i].nickname + '</div>' +
										'<div class="pull-right msg-time">' +
											//Note: The following two icons are surrounded with 3 spaces, 
											//in order to make an easier separation
											'<i class="fa fa-calendar"></i> ' + response[i].calendarTime +
											' <i class="fa fa-clock-o"></i> ' + response[i].clockTime + 
										'</div>' +
									'</div>' +
								'</div>' +
								'<div class="row panel-body">' +
									'<div class="col-md-9 msg">' + response[i].message + '</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>';
			}
		}
	});
	
	$(document).ready(function() {
		$('#leave-msg-form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: 'leaveMsg.php',
				data: $(this).serialize(),
				success: function(response)
				{
					if (response.code == 0) {
						alert('留言成功！');
						window.location.href = './';
					}
					if (response.code == 1) {
						alert('验证码错误！');
					}
					if (response.code == 2) {
						alert('昵称太长啦~ 精简一下吧');
					}
					if (response.code == 3) {
						alert('你们呐，不要老喜欢搞个大新闻，就说自己是管理员\n\n再不改昵称，将来留言板上出了偏差你们是要负责任的');
					}
					if (response.code == 4) {
						alert('留言失败，请尝试重新提交');
					}
				}
			});
		});
	});
}

function registerPrepare() {
	$(document).ready(function() {
		$('#register').submit(function(e) {
			e.preventDefault();
			if (checkForm()) {
				$.ajax({
					type: 'POST',
					url: 'register.php',
					data: $(this).serialize(),
					success: function(response)
					{
						if (response.code == 1)
							alert('验证码错误！');
						if (response.code == 2)
							alert('两次输入密码不一致！');
						if (response.code == 3)
							alert('该队名已存在，请更换');
						if (response.code == 4)
							alert('不要调皮哦');
						if (response.code == 5)
							alert('注册失败，请重新报名');
						if (response.code == 0) {
							var competitionName = response.competitionType == 1 ? '作品赛' : '创意赛';
							alert('报名成功！\n\n\n请记住队伍 ID ：' + response.teamID + '\n\n队伍名：' + response.teamName + '\n\n参赛类型 ：' + competitionName);
							freshCaptcha();
							window.location.href = '../teams';
						}
					}
				});
			}
		});
	});
}

function uploadPrepare() {
	$.ajax({
		type: 'JSON',
		url: 'status.php',
		success: function(response) {
			if (response.loggedIn == 0) {
				alert('请登录系统后提交文件！');
				window.location.href = '../login';
			}

			if (response.loggedIn == 1 && response.dirExist == 1) {
				document.getElementById('info-text').innerHTML = '<h3> 您已提交队伍作品文件，若需要更新可覆盖上传 </h3>';
			}
		}
	});

	$('#file').fileinput({
		theme: 'explorer',
		language: 'zh',
		uploadUrl: 'upload.php',
		browseLabel: '浏览',
		msgFilesTooMany: '请将所有要上传的文件打包成 <strong>一个</strong> 压缩包',
		dropZoneTitle: '请以压缩包格式上传队伍作品文件<br> <br> <strong> 将文件拖拽到这里 </strong> 或 <strong> 点击浏览按钮选择文件 </strong>',
		allowedFileExtensions: ['zip', 'rar', 'tar', 'gzip', 'gz', '7z'],
		maxFileSize: 500000,
		maxFileCount: 1,
		preferIconicPreview: true, 
		previewFileIconSettings: { 
			'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
			'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			'htm': '<i class="fa fa-file-code-o text-info"></i>',
			'txt': '<i class="fa fa-file-text-o text-info"></i>',
			'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			'jpg': '<i class="fa fa-file-photo-o text-danger"></i>', 
			'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			'png': '<i class="fa fa-file-photo-o text-primary"></i>'    
		},
		previewFileExtSettings: {
			'doc': function(ext) {
				return ext.match(/(doc|docx)$/i);
			},
			'xls': function(ext) {
				return ext.match(/(xls|xlsx)$/i);
			},
			'ppt': function(ext) {
				return ext.match(/(ppt|pptx)$/i);
			},
			'zip': function(ext) {
				return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			},
			'htm': function(ext) {
				return ext.match(/(htm|html)$/i);
			},
			'txt': function(ext) {
				return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			},
			'mov': function(ext) {
				return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			},
			'mp3': function(ext) {
				return ext.match(/(mp3|wav)$/i);
			},
		},
		slugCallback: function(filename) {
			return filename.replace('(', '_').replace(']', '_');
		},
	});

	$('#file').on('fileuploaded', function(event, data, previewId, index) {
		var msg = ['文件上传成功！', '请<a href=\'../login\'>登录</a>系统后提交文件！', '请选择上传文件！', '很抱歉，上传文件过大，请联系管理员', '上传失败，请使用简体中文、英文或数字命名文件', '上传失败，请尝试重新上传'];
		if (data.response.code != 0) {
			document.getElementById('info').className = 'alert alert-danger';
			document.getElementById('info-text').innerHTML = msg[data.response.code];
		}
		else {
			document.getElementById('info').className = 'alert alert-info';
			document.getElementById('info-text').innerHTML = msg[data.response.code] +  '<h4> 文件名：' + data.response.filename + '</h4> <h4> 文件大小：' + data.response.filesize + 'MB </h4>';
			setTimeout(function() {
				window.location.href = './';
			}, 6000);  
		}
	});
}
