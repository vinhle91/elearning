<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<script type="text/javascript">
	$(function() {
		$("table").tablesorter({debug: true});
	});
</script>

<?php if (!isset($studentInfo)) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="row" id="new-students">
				<div class="col-md-6">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-user"></i>今月中新しい学生</div>
							<div class="tools">
								<a href="javascript:;" class="reload"></a>
							</div>
						</div>
						<?php if (isset($new_students) && $new_students['Total'] != 0) { ?>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-hover tablesorter">
									<thead>
										<tr>
											<th>#</th>
											<th><a link>氏名</a></th>
											<th><a link>ユーザー名</a></th>
											<th><a link>登録日時</a></th>
											<th><a link></a></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($new_students['Data'] as $key => $new_student) { ?>
										<tr>
											<td><?php echo ($key + 1)?></td>
											<td><a href="/elearning/admin/student/<?php echo $new_student['User']['Username']?>"><?php echo $new_student['User']['FullName']?></a></td>
											<td><a href="/elearning/admin/student/<?php echo $new_student['User']['Username']?>"><?php echo $new_student['User']['Username']?></a></td>
											<td><?php echo $new_student['User']['created']?></td>
											<td><span class="label label-sm label-<?php echo $status_label[$new_student['User']['Status']]?> line-6"><?php echo $status[$new_student['User']['Status']]?></span></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php }  else { ?>
						<div class="portlet-body">
							今日は新しい学生がいません。
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">#すべてのユ学生</div>
					
					<div class="tools">
						<a href="javascript:;" class="reload"></a>
					</div>
					<div class="pull-right">
						<strong style="font-size: `.95em;">
		
							<a href="">すべて</a>&nbsp;
						
							<a href="">A</a>&nbsp; 
						
							<a href="">B</a>&nbsp; 
						
							<a href="">C</a>&nbsp; 
						
							<a href="">D</a>&nbsp; 
						
							<a href="">E</a>&nbsp; 
						
							<a href="">F</a>&nbsp; 
						
							<a href="">G</a>&nbsp; 
						
							<a href="">H</a>&nbsp; 
						
							<a href="">I</a>&nbsp; 
						
							<a href="">J</a>&nbsp; 
						
							<a href="">K</a>&nbsp; 
						
							<a href="">L</a>&nbsp; 
						
							<a href="">M</a>&nbsp; 
						
							<a href="">N</a>&nbsp; 
						
							<a href="">O</a>&nbsp; 
						
							<a href="">P</a>&nbsp; 
						
							<a href="">Q</a>&nbsp; 
						
							<a href="">R</a>&nbsp; 
						
							<a href="">S</a>&nbsp; 
						
							<a href="">T</a>&nbsp; 
						
							<a href="">U</a>&nbsp; 
						
							<a href="">V</a>&nbsp; 
						
							<a href="">W</a>&nbsp; 
						
							<a href="">X</a>&nbsp; 
						
							<a href="">Y</a>&nbsp; 
						
							<a href="">Z</a>&nbsp; 

							<a href="">ほかの</a>&nbsp;
						</strong>
					</div>
				</div>
				<div class="portlet-body flip-scroll" style="display: block; overflow: auto">
					<?php if (isset($all_students) && $all_students['Total'] != 0) { ?>
					<table class="table table-hover table-striped table-condensed tablesorter">
						<thead class="flip-content">
							<tr>
								<th><a link>ID</a></th>
								<th><a link>ユーザー名</a></th>
								<th><a link>メール</a></th>
								<th class="numeric"><a link>氏名</a></th>
								<th class="numeric"><a link>生年月日</a></th>
								<th class="numeric"><a link>性</a></th>
								<th class="numeric"><a link>電話番号</a></th>
								<th class="numeric"><a link>登録日時</a></th>
								<th class="numeric"><a link>変更</a></th>
								<th class="numeric"><a link>レポート</a></th>
								<th class="numeric"><a link>状態</a></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_students['Data'] as $key => $student) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><a href="/elearning/admin/student/<?php echo $student['User']['Username']?>"><?php echo $student['User']['Username']?></a></td>
								<td><?php echo $student['User']['Email']?></td>
								<td><?php echo $student['User']['FullName']?></td>
								<td><?php echo $student['User']['Birthday'] ? date_format(date_create($student['User']['Birthday']), 'Y年m月d日') : null?></td>
								<td><?php echo $student['User']['Gender'] == 0 ? __("Female") : __("Male")?></td>
								<td><?php echo $student['User']['Phone']?></td>
								<td><?php echo $student['User']['created']?></td>
								<td><?php echo $student['User']['modified']?></td>
								<td class="align-right"><?php echo $student['User']['Violated'] == 0 ? null : $student['User']['Violated']; ?></td>
								<td><label class="label label-sm label-<?php echo $status_label[$student['User']['Status']]?> line-8" ><?php echo $status[$student['User']['Status']]?></label></td>
							</tr>
							<?php } ?>							
						</tbody>
					</table>
					<?php }  else { ?>
					<div class="portlet-body">
                        今日登録が新入生はありません。
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>


<?php } else { //end if !isset($studentInfo) ?>
<?php //have $studentInfo?>
	<div class="row">
		<div class="col-md-12">			
			<div class="row">
				<div class="note note-success user-info" style="margin-top:  20px;">
						<div class="pull-left" style="padding: 10px">
                    		<img class="imageThumb" src="<?php echo $studentInfo['ImageProfile'] ? $studentInfo['ImageProfile'] : '/elearning/img/photo/no-avatar.jpg'?>" id="preview" width="96" height="96" style="margin-top: -50px;">
                		</div>
						<h4 class="block" style="margin-bottom: 0; margin-top: -10px;"><?php echo $studentInfo['FullName'] ?></h4> 
						<span class="gender male"></span><?php echo $studentInfo['Gender'] == 1 ? "男" : "女" ?>
						<span class="bday"></span><?php echo $studentInfo['Birthday'] ?>
						<span class="addr"></span><?php echo $studentInfo['Address'] ? $studentInfo['Address'] : "住所  <i class='margin-left-5'> </i>" ?>
						<span class="phone"><label class="fa fa-phone"></label><?php echo $studentInfo['Phone'] ? $studentInfo['Phone'] : "<i class=''> </i>" ?></span>
				</div>
			</div>
			<?php if ($studentInfo['Status'] == 2) { ?>
			<div class = "handle-user pull-right">
				<button class="btn btn-sm btn-info disabled pull-right" id = "notif-pending">
					<i class='fa fa-exclamation-triangle margin-right-5'></i>
					<span>
						 未確定
					</span>
				</button>
				<button class="btn btn-sm btn-success margin-right-5 pull-right" id = "first-active">
					<span>
						 アクティブ
					</span>
				</button>
				<button class="btn btn-sm btn-danger margin-right-5 pull-right" id = "first-deny">
					<span>
						 否定
					</span>
				</button>
			</div>			
			<?php } ?>
			<?php if ($studentInfo['Status'] == 0) { ?>
			<label class="label label-xl label-default pull-right">
				<i class="fa fa-exclamation-triangle"></i>
				<span>
					 削除
				</span>
			</label>
			<?php } ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="portlet">
				<div class="nav portlet-title padding-top-8">
					<div class="caption"><i class="fa fa-reorder"></i><?php echo $studentInfo['FullName'] ?>'s 情報</div>
					<?php if ($studentInfo['Status'] != 2 && $studentInfo['Status']!=0) {?>
					<div class="pull-right no-list-style">
						<li class="dropdown menu-left" id="options">
							<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
							<ul class="dropdown-menu extended" style="width: auto !important; margin-left: 77px; margin-top: -50px;">
								<li>
									<ul class="dropdown-menu-list no-space no-list-style">
										<!-- <li>  
											<a href="">
											<span class="label label-sm label-icon label-info"><i class="fa fa-pencil"></i></span>
                                                基本データを編集
											</a>
										</li> -->
										<li>  
											<a class="reset-pw" href="">
											<span class="label label-sm label-icon label-success"><i class="fa fa-refresh"></i></span>
                                                パスワードをリセット
											</a>
										</li>
										<li>  
											<a class="reset-ver-cod" href="">
											<span class="label label-sm label-icon label-success"><i class="fa fa-refresh"></i></span>
                                                verifycodeをリセット
											</a>
										</li>
										<?php if ($studentInfo['Status'] == 1) { ?>
										<li>  
											<a class="update-block" href="">
											<span class="label label-sm label-icon label-danger"><i class="fa fa-ban"></i></span>
                                                ユーザーを拒否
											</a>
										</li>
										<?php } ?>
										<li>  
											<a class="update-delete" href="">
											<span class="label label-sm label-icon label-default"><i class="fa fa-ban"></i></span>
											    ユーザーを削除
											</a>
										</li>
										<?php if ($studentInfo['Status'] != 1) { ?>
										<li>  
											<a class="update-active" href="">
											<span class="label label-sm label-icon label-info"><i class="fa fa-check"></i></span>
											    ユーザーをActive
											</a>
										</li>
										<?php } ?>
									</ul>
								</li>
							</ul>
						</li>
					</div>
					<?php } ?>
				</div>
				<div class="portlet-body user-info">
					<div class="row">
						<div class="col-md-12">
							<table id="user" class="table table-bordered table-striped">
								<tbody>
									
									<tr>
										<td class="col-md-3">ユーザー名</td>
										<td><section class="pull-left padding-5" id="Username"><?php echo $studentInfo['Username'] ?></section></td>
									</tr>
									<tr>
										<td>性</td>
										<td><section class="pull-left padding-5" id="Gender"><?php echo $studentInfo['Gender'] == 1 ? "男" : "女" ?></section></td>
									</tr>
									<?php if ($studentInfo['Status'] != 2 && $studentInfo['Status'] != 0) { ?>
									<tr>
										<td>状態</td>
										<td><section class="pull-left padding-5" id="Status"><span class="label label-<?php echo $status_label[$studentInfo['Status']] ?> line-6"><?php echo $status[$studentInfo['Status']] ?></span></section></td>
									</tr>		
									<?php } ?>
									<tr>
										<td class="col-md-3">名前</td>
										<td><section class="pull-left editable padding-5" id="Fullname"><?php echo $studentInfo['FullName'] ?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>生年月日</td>
										<td><section class="pull-left editable padding-5" id="Birthday"><?php echo $studentInfo['Birthday']  ? $studentInfo['Birthday'] : "<i> </i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
										
									</tr>
									<tr>
										<td>メール</td>
										<td><section class="pull-left editable padding-5" id="Email"><?php echo $studentInfo['Email']  ? $studentInfo['Email'] : "<i> </i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
										
									</tr>
									<tr>
										<td>クレジットカード情報</td>
										<td><section class="pull-left editable padding-5" id="BankInfo"><?php echo $studentInfo['BankInfo'] ? $studentInfo['BankInfo'] : "<i></i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>住所</td>
										<td><section class="pull-left editable padding-5" id="Address"><?php echo $studentInfo['Address']  ? $studentInfo['Address'] : "<i></i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									
								</tbody>
							</table>
							<div class="update-notif">
								<span></span>
								<label class="ajax-loader"></label>
							</div>
							<div class="padding-5 align-right">
								<a href="#" class="btn btn-info btn-xs button-save disabled"><i class="fa fa-pencil"></i> 保存</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	function checkEmailValidate(str) {
		var regex = /^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/;
		if (str.match(regex)) return true;
		else return false;
	}

	function checkDateValidate(str) {
		var regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
		if (str.match(regex)) return true;
		else return false;
	}

	$(document).ready(function(){
		var origin = {};
		origin.Password = $('#Password').text();
		origin.Birthday = $('#Birthday').text();
		origin.Email = $('#Email').text();
		origin.BankInfo = $('#BankInfo').text();
		origin.Address = $('#Address').text();

		$(".editable").on("click", function(){
			$(this).attr("contenteditable", "true");
			$(this).css("background-color", "#fff");
			$(this).focus();
			$(".button-save").removeClass("disabled");			
		});

		$(".edit-btn").on("click", function() {
			editElm = $(this).closest("td").find("section");
			editElm.attr("contenteditable", "true");
			editElm.css("background-color", "#fff");
			editElm.focus();
			$(".button-save").removeClass("disabled");	

		});

		$(".button-save").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/update";
			var submit_data = {
				UserId: "<?php echo $studentInfo['UserId']?>",
				Username: '\''+$('#Username').text()+'\'',
			};
			if ($('#Password').text() != origin.Password) {
				submit_data.Password = '\''+$('#Password').text()+'\'';
			}
			if ($('#Birthday').text() != origin.Birthday) {
				submit_data.Birthday = '\''+$('#Birthday').text()+'\'';
			}
			if ($('#Email').text() != origin.Email) {
				submit_data.Email = '\''+$('#Email').text()+'\'';
			}
			if ($('#BankInfo').text() != origin.BankInfo) {
				submit_data.BankInfo = '\''+$('#BankInfo').text()+'\'';
			}
			if ($('#Address').text() != origin.Address) {
				submit_data.Address = '\''+$('#Address').text()+'\'';
			}

			if (!checkEmailValidate($('#Email').text())) {
				$(".update-notif span").css({"visibility": "visible", "opacity": 1});
				$(".update-notif span").text("メールが正しくない!");
				setTimeout(function(){
	   				$('.update-notif span').fadeTo(500, 0, function(){
					  	$('.update-notif span').css("visibility", "hidden");   
					});
	   			}, 1000);
	   			return;
			}

			if (!checkDateValidate($('#Birthday').text())) {
				$(".update-notif span").css({"visibility": "visible", "opacity": 1});
				$(".update-notif span").text("生年月日が正しくない!");
				setTimeout(function(){
	   				$('.update-notif span').fadeTo(500, 0, function(){
					  	$('.update-notif span').css("visibility", "hidden");   
					});
	   			}, 1000);
	   			return;
			}
			
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".user-info .update-notif span").text("情報が更新...");
			$(".ajax-loader").fadeIn(10);
			$(".button-save").addClass("disabled");

		    $.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						$(".ajax-loader").fadeOut(10);
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
	               			$(".user-info .update-notif span").text("更新が成功した");
	               			setTimeout(function(){
	               				//$(".user-info .update-notif span").text("");
	               				$('.user-info .update-notif span').fadeTo(500, 0, function(){
								  	$('.user-info .update-notif span').css("visibility", "hidden");   
								});
	               			}, 2000);
		               	} else if (data.result == "Fail") {
	               			$(".user-info .update-notif span").text("更新が失敗した");
		               		setTimeout(function(){
	               				//$(".user-info .update-notif span").text("");
	               				$('.user-info .update-notif span').fadeTo(500, 0, function(){
								  	$('.user-info .update-notif span').css("visibility", "hidden");   
								});
	               			}, 2000);
		               	}
		           }
		         });
		    return false;
		});
		

		$(".reset-pw").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			if (confirm("<?php echo $studentInfo['FullName']?>のパスワードをリセットしたいですか?") == true) {
				var url = "/elearning/admin/resetPassword";
				var submit_data = {
					UserId: "<?php echo $studentInfo['UserId']?>",
					Username: "<?php echo $studentInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo $studentInfo['FullName']?>のパスワードは最初パスワードをリセットした！");
			               	} else if (data.result == "Fail") {
			               		alert("パスワードをリセットすることが失敗した");
			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".reset-ver-cod").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			if (confirm("<?php echo $studentInfo['FullName']?>の verify codeをリセットしたいですか?") == true) {
				var url = "/elearning/admin/resetVerifyCode";
				var submit_data = {
					UserId: "<?php echo $studentInfo['UserId']?>",
					Username: "<?php echo $studentInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo $studentInfo['FullName']?>の verify codeをリセットした");
			               	} else if (data.result == "Fail") {
			               		alert("verify codeをリセットすることが失敗っした!");
			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".update-block").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			if (confirm("<?php echo $studentInfo['FullName']?>のアカウントをブロックしますか") == true) {
				var url = "/elearning/admin/updateUserInfo/block";
				var submit_data = {
					UserId: "<?php echo $studentInfo['UserId']?>",
					Username: "<?php echo $studentInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo $studentInfo['FullName']?>のアカウントをブロックした");
			               		location.reload();
			               	} else if (data.result == "Fail") {

			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".update-delete").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			if (confirm("<?php echo $studentInfo['FullName']?>のアカウントを削除しますか") == true) {
				var url = "/elearning/admin/updateUserInfo/delete";
				var submit_data = {
					UserId: "<?php echo $studentInfo['UserId']?>",
					Username: "<?php echo $studentInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo $studentInfo['FullName']?>のアカウントを削除した!");
			               		location.reload();
			               	} else if (data.result == "Fail") {

			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".update-active").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/active";
			var submit_data = {
				UserId: "<?php echo $studentInfo['UserId']?>",
				Username: "<?php echo $studentInfo['Username']?>",
			};
			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {

		               		location.reload();
		               	} else if (data.result == "Fail") {
		               		alert("ユーザーを回復は失敗!");
		               	}
		           }
		         });
		    return false;
		});

		$("#first-active").on("click", function(e) {
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/active";
			var submit_data = {
				UserId: "<?php echo $studentInfo['UserId']?>",
				Username: "<?php echo $studentInfo['Username']?>",
			};
			$(".handle-user #notif-pending").hide("slide", { direction: "right" }, 1000);
			$(".handle-user #first-deny").hide("slide", { direction: "right" }, 1000);
			setTimeout(function(){
				$(".handle-user #first-active").prepend('<i class="fa fa-check margin-right-5"></i>');
			}, 1000);
			$("#first-active").unbind();
			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		
		               	} else if (data.result == "Fail") {

		               	}
		           }
		         });

		    return false;
		});

		$("#first-deny").on("click", function(e) {
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/deny";
			var submit_data = {
				UserId: "<?php echo $studentInfo['UserId']?>",
				Username: "<?php echo $studentInfo['Username']?>",
			};
			$(".handle-user #notif-pending").hide("slide", { direction: "right" }, 1000);
			$(".handle-user #first-active").hide("slide", { direction: "right" }, 1000);
			setTimeout(function(){
				$(".handle-user #first-deny").prepend('<i class="fa fa-check margin-right-5"></i>');
			}, 1000);
			$("#first-deny").unbind();
			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		
		               	} else if (data.result == "Fail") {

		               	}
		           }
		         });

		    return false;
		});

	});
</script>

<?php } //end else-if !isset($studentInfo)?>