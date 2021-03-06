//Global functions: Captcha Fresh, Modal Alert & Logout
function freshCaptcha() {
	$("#captcha-img").attr('src', '../assets/captcha/captcha.php');
}

function modalAlert(alertMsg, func) {
	$("nav").after(
	'<div class="modal fade" id="alertModal" tabindex="-1">' +
		'<div class="modal-dialog">' +
			'<div class="modal-content">' +
				'<div class="modal-header">' +
					'<button type="button" class="close" data-dismiss="modal">' +
						'<span aria-hidden="true">&times;</span>' +
					'</button>' +
					'<h5 class="modal-title text-center">系统提示</h5>' +
				'</div>' +

				'<div class="modal-body text-center">' +
					'<h4>' + alertMsg + '</h4>' +
				'</div>' +

				'<div class="modal-footer">' +
					'<button type="button" class="btn btn-primary center-block" data-dismiss="modal">我知道了</button>' +
				'</div>' +
			'</div>' +
		'</div>' +
	'</div>');

	$("#alertModal").modal();
	if (typeof func === 'function') {
		$('#alertModal').on('hide.bs.modal', function () { func(); });
	}
}

function logout() {
	$.ajax({
		type: 'POST',
		url: 'logout.php',
		success: function(response) {
			if (response.code == 0) {
				modalAlert('退出系统成功，' + response.teamName, function () {
					window.location.href = '../';
				});
			}
		}
	});
}

//Code for reset password in login submodule
function resetPassword() {
	$("#reset-segment").attr('class', '');
	$("#reset-segment").hide();
	
	$("#page-title").text('重置密码');
	$("#page-btn").val('确定');
	$("#reset-segment").slideDown(1000);
	$("#login-segment").slideUp(700);
}

//Code for Register: Add or reduce team member & form check
var MAXN = 3, showed = 1;

function addOneMember() {
	if ($("#competition-type").val() == 0) {
		modalAlert('请选择队伍参赛类型！');
		return;
	}

	if ($("#competition-type").val() == 1)  MAXN = 5;
	if ($("#competition-type").val() == 2)  MAXN = 3;
	
	$("#btn-reduce").attr('class', 'btn btn-info');
	$("#team-member" + showed).show(1000);
	$("#btn-reduce").show(300);
	showed = showed + 1;
	if (showed == MAXN) $("#btn-add").hide(300);
}

function reduceOneMember() {
	showed = showed - 1;
	$("[name=teamMemberName" + showed + "]").val('');
	$("[name=studentNo" + showed + "]").val('');
	$("[name=contact" + showed + "]").val('');
	$("[name=college" + showed + "]").val('');
	$("[name=major" + showed + "]").val('');
	$("[name=grade" + showed + "]").val(0);
	$("[name=campus" + showed + "]").val(0);
	$("#team-member" + showed).hide(1000);
	$("#btn-add").show(300);
	if (showed == 1) $("#btn-reduce").hide(300);
}

function checkForm() {
	if (register.teamName.value == '' || 
		register.password.value == '' || 
		register.passwordConfirm.value == '' || 
		register.competitionType.value == 0) {
		modalAlert('请将队伍基本报名信息填写完整！');
		return false;
	}

	if (register.password.value != register.passwordConfirm.value) {
		modalAlert('两次输入密码不一致！');
		return false;
	}

	if (register.teamLeaderName.value == '' || 
		register.studentNo.value == '' || 
		register.contact.value == '' || 
		register.college.value == '' || 
		register.major.value == '' || 
		register.grade.value == 0 || 
		register.campus.value == 0) {
		modalAlert('请将队长信息填写完整！');
		return false;
	}

	for (var i = 1; i <= showed - 1; i++) {
		if ($("[name=teamMemberName" + i + "]").val() == '' || 
			$("[name=studentNo" + i + "]").val() == '' || 
			$("[name=contact" + i + "]").val() == '' || 
			$("[name=college" + i + "]").val() == '' || 
			$("[name=major" + i + "]").val() == '' || 
			$("[name=grade" + i + "]").val() == 0 || 
			$("[name=campus" + i + "]").val() == 0) {
			modalAlert('请将队员 ' + i + ' 信息填写完整！');
			return false;
		}
	}

	if (register.captcha.value == '') {
		modalAlert('请输入验证码!')
		return false;
	}

	return true;
}



//Code for 5 Pages: Load or Send Data
function registerPrepare() {
	$(document).ready(function() {
		$("#register").submit(function(e) {
			e.preventDefault();
			if (checkForm()) {
				$.ajax({
					type: 'POST',
					url: 'register.php',
					data: $(this).serialize(),
					success: function(response) {
						if (response.code == 0) {
							var competitionName =
								response.competitionType == 1 ?
								'作品赛' : '创意赛';
							modalAlert(
								'报名成功！<br><br>' + 
								'<h5>请记住队伍 ID ：' + response.teamID + 
								'<br><br>队伍名：' + response.teamName + 
								'<br><br>参赛类型 ：' + competitionName +
								'</h5>', function () {
								freshCaptcha();
								window.location.href = '../teams';
							});
						} else {
							modalAlert(response.errMsg);
							freshCaptcha();
						}
					}
				});
			}
		});
	});
}

function teamsPrepare() {
	$.ajax({
		type: 'POST',
		url: 'showteams.php',
		success: function(response) {
			if (response[0].loggedIn) {
				$("#logged-in-team").append(
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
				'</div>');
				
				$("#btn-log").attr('onclick', null);
				$('#btn-log').on('click', function() {logout();});
				$("#btn-log").text('退出系统');
			}

			for(var i = 1; i < response.length; i++) {
				if (response[0].loggedIn && !(response[i].teamID > 1000)) {
					$("#logged-in-team-info").append(
					'<tr>' +
						'<td>' + response[i].studentName + '</td>' +
						'<td>' + response[i].studentNo + '</td>' +
						'<td>' + response[i].contact + '</td>' +
						'<td>' + response[i].campus + '</td>' +
						'<td>' + response[i].college + '</td>' +
						'<td>' + response[i].major + '</td>' +
						'<td>' + response[i].grade + '</td>' +
					'</tr>');
				}

				if(response[i].teamID > 1000) {
					var teamType =
						response[i].teamID > 2000 ?
						'creativity-teams' : 'production-teams';
					$("#" + teamType + "-placeholder").hide();

					$("#" + teamType).append(
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
					'</div>');

					$("#team" + response[i].teamID).append(
					'<table class="table table-bordered">' +
						'<thead>' +
							'<th> 姓名 </th>' +
							'<th> 校区 </th>' +
							'<th> 学院 </th>' +
							'<th> 专业 </th>' +
							'<th> 年级 </th>' +
						'</thead>' +
						'<tbody id="team-info' + response[i].teamID + '"></tbody>' +
					'</table>');

					$("#team-info" + response[i].teamID).append(
					'<tr class="teams-leader">' +
						'<td>' + response[i].students[0].studentName + '</td>' +
						'<td>' + response[i].students[0].campus + '</td>' +
						'<td>' + response[i].students[0].college + '</td>' +
						'<td>' + response[i].students[0].major + '</td>' +
						'<td>' + response[i].students[0].grade + '</td>' +
					'</tr>');
					
					for (var stu = 1; stu < response[i].students.length; stu++) {
						$("#team-info" + response[i].teamID).append(
						'<tr>' +
							'<td>' + response[i].students[stu].studentName + '</td>' +
							'<td>' + response[i].students[stu].campus + '</td>' +
							'<td>' + response[i].students[stu].college + '</td>' +
							'<td>' + response[i].students[stu].major + '</td>' +
							'<td>' + response[i].students[stu].grade + '</td>' +
						'</tr>');
					}
				}
			}
		}
	});
}

function loginPrepare() {
	$(document).ready(function() {
		$("#login-or-reset").submit(function(e) {
			e.preventDefault();
			var url = $("[name=studentNo]").val() === '' ? 'login.php' : 'reset.php';

			$.ajax({
				type: 'POST',
				url: url,
				data: $(this).serialize(),
				success: function(response) {
					if (response.code == 0) {
						if (url == 'login.php')
							modalAlert('欢迎回来，' + response.teamName, function () {
								freshCaptcha();
								window.location.href = '../teams/#logged-in-team';
							});
						if (url == 'reset.php')
							modalAlert('密码重置成功，请使用新密码登录系统', function () {
								window.location.href = './';
							});
					} else {
						modalAlert(response.errMsg);
						freshCaptcha();
					}
				}
			});
		});
	});
}

function uploadPrepare() {
	$.ajax({
		type: 'JSON',
		url: 'status.php',
		success: function(response) {
			if (!response.loggedIn) {
				modalAlert('请登录系统后提交文件！', function () {
					window.location.href = '../login';
				});
			}

			if (response.dirExist) {
				$("#init-info-text").html('<h3>您已提交队伍作品文件，若需要更新可覆盖上传</h3>');
			}
		}
	});

	$("#file").fileinput({
		theme: 'explorer',
		language: 'zh',
		uploadUrl: 'upload.php',
		browseLabel: '浏览',
		msgFilesTooMany: '请将所有要上传的文件打包成 <strong>一个</strong> 压缩包',
		dropZoneTitle: '请以压缩包格式上传队伍作品文件<br><br><strong>将文件拖拽到这里</strong> 或 <strong>点击浏览按钮选择文件</strong>',
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

	$("#file").on('fileuploaded', function(event, data, previewId, index) {
		$("#init-info").hide(); $("#info").show();
		if (data.response.code == 0) {
			$("#info-text").html(
				'参赛作品上传成功！<br><br>' +
				'<h4>文件名：' + data.response.filename +
				' 文件大小：' + data.response.filesize + 'MB</h4>');
			$("#info").attr('class', 'alert alert-info text-center');
			setTimeout(function() {
				$("#info-text").html('您已提交队伍作品文件，若需要更新可覆盖上传');
				$('#file').fileinput('refresh');
			}, 5000);
		} else {
			$("#info-text").html(data.response.errMsg);
			$("#info").attr('class', 'alert alert-danger text-center');
			$('#file').fileinput('refresh');
		}
	});
}

function forumPrepare() {
	$.ajax({
		type: 'POST',
		url: 'showMsg.php',
		success: function(response) {
			for (var i = 0; i < response.length; i++) {
				$("#messages").append(
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
				'</div>');
			}
		}
	});
	
	$(document).ready(function() {
		$("#leave-msg").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: 'leaveMsg.php',
				data: $(this).serialize(),
				success: function(response) {
					if (response.code == 0) {
						$('#leave-msg-modal').modal('toggle');
						modalAlert('留言成功！', function () {
							window.location.href = './';
						});
					} else {
						$('#leave-msg-modal').modal('toggle');
						modalAlert(response.errMsg, function () {
							$('#leave-msg-modal').modal('toggle'); 
							freshCaptcha();
						});
					}
				}
			});
		});
	});
}
