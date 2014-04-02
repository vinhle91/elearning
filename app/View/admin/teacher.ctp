<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>

<?php if (!isset($teacherInfo)) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="row" id="new-teachers">
				<div class="col-md-6">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-user"></i>今月中新しい学生</div>
							<div class="tools">
								<a href="javascript:;" class="reload"></a>
							</div>
						</div>
						<?php if (isset($new_teachers) && $new_teachers['Total'] != 0) { ?>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>氏名</th>
											<th>ユーザー名</th>
											<th>登録日時</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($new_teachers['Data'] as $key => $new_teacher) { ?>
										<tr>
											<td><?php echo ($key + 1)?></td>
											<td><a href="/elearning/admin/teacher/<?php echo $new_teacher['User']['Username']?>"><?php echo $new_teacher['User']['FullName']?></a></td>
											<td><a href="/elearning/admin/teacher/<?php echo $new_teacher['User']['Username']?>"><?php echo $new_teacher['User']['Username']?></a></td>
											<td><?php echo $new_teacher['User']['created']?></td>
											<td><span class="label label-sm label-<?php echo $status_label[$new_teacher['User']['Status']]?> line-6"><?php echo $status[$new_teacher['User']['Status']]?></span></td>
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
						
							<a href="">Other</a>&nbsp; 
						</strong>
					</div>
				</div>
				<div class="portlet-body flip-scroll" style="display: block; overflow: auto">
					<?php if (isset($all_teachers) && $all_teachers['Total'] != 0) { ?>
					<table class="table table-hover table-striped table-condensed">
						<thead class="flip-content">
							<tr>
								<th>ID</th>
								<th>ユーザー名</th><th>メール</th>
								<th class="numeric">氏名</th>
								<th class="numeric">生年月日</th>
								<th class="numeric">性</th>
								<th class="numeric">電話番号</th>
								<th class="numeric"><a link>登録日時</a></th>
								<th class="numeric"><a link>Modified</a></th>
								<th class="numeric"><a link>Violated</a></th>
								<th class="numeric">状態</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_teachers['Data'] as $key => $teacher) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><a href="/elearning/admin/teacher/<?php echo $teacher['User']['Username']?>"><?php echo $teacher['User']['Username']?></a></td>
								<td><?php echo $teacher['User']['Email']?></td>
								<td><?php echo $teacher['User']['FullName']?></td>
								<td><?php echo $teacher['User']['Birthday']?></td>
								<td><?php echo $teacher['User']['Gender'] == 0 ? __("Female") : __("Male")?></td>
								<td><?php echo $teacher['User']['Phone']?></td>
								<td><?php echo $teacher['User']['created']?></td>
								<td><?php echo $teacher['User']['modified']?></td>
								<td class="align-right"><?php echo $teacher['User']['Violated'] == 0 ? null : $teacher['User']['Violated']; ?></td>
								<td><span class="label label-sm label-<?php echo $status_label[$teacher['User']['Status']]?> line-8" ><?php echo $status[$teacher['User']['Status']]?></span></td>
							</tr>
							<?php } ?>							
						</tbody>
					</table>
					<?php }  else { ?>
					<div class="portlet-body">
						There isn't new teacher registed today.
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } else { //end if !isset($teacherInfo) ?>
<?php //have $teacherInfo?>
	<div class="row">
		<div class="col-md-12">			
			<div class="row">
				<div class="note note-success user-info" style="margin-top:  20px;">
						<div class="pull-left" style="padding: 10px">
                    		<img class="imageThumb" src="<?php echo $teacherInfo['ImageProfile'] ? $teacherInfo['ImageProfile'] : '/elearning/img/photo/no-avatar.jpg'?>" id="preview" width="96" height="96" style="margin-top: -50px;">
                		</div>
						<h4 class="block" style="margin-bottom: 0; margin-top: -10px;"><?php echo $teacherInfo['FullName'] ?></h4> 
						<span class="gender male"></span><?php echo $teacherInfo['Gender'] == 1 ? "男" : "女" ?>
						<span class="bday"></span><?php echo $teacherInfo['Birthday'] ?>
						<span class="addr"></span><?php echo $teacherInfo['Address'] ? $teacherInfo['Address'] : "住所  <i class='margin-left-5'> 更新している...</i>" ?>
						<span class="phone"><label class="fa fa-phone"></label><?php echo $teacherInfo['Phone'] ? $teacherInfo['Phone'] : "<i class=''> 更新している...</i>" ?></span>
				</div>
			</div>
			<?php if ($teacherInfo['Status'] == 2) { ?>
			<button class="btn btn-sm btn-info pull-right">
				<i class="fa fa-exclamation-triangle"></i>
				<span>
					 未確定
				</span>
			</button>
			<?php } ?>
			<?php if ($teacherInfo['Status'] == 0) { ?>
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
					<div class="caption"><i class="fa fa-reorder"></i><?php echo $teacherInfo['FullName'] ?>'s 情報</div>
					<?php if ($teacherInfo['Status'] != 2) {?>
					<div class="pull-right no-list-style">
						<li class="dropdown menu-left" id="options">
							<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
							<ul class="dropdown-menu extended" style="width: auto !important; margin-left: 77px; margin-top: -50px;">
								<li>
									<ul class="dropdown-menu-list no-space no-list-style">
										<li>  
											<a href="">
											<span class="label label-sm label-icon label-info"><i class="fa fa-pencil"></i></span>
                                                基本データを編集
											</a>
										</li>
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
										<li>  
											<a href="">
											<span class="label label-sm label-icon label-danger"><i class="fa fa-ban"></i></span>
                                                ユーザーを拒否
											</a>
										</li>
										<li>  
											<a href="">
											<span class="label label-sm label-icon label-default"><i class="fa fa-ban"></i></span>
											    ユーザーを削除
											</a>
										</li>
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
										<td><section class="pull-left padding-5" id="Username"><?php echo $teacherInfo['Username'] ?></section></td>

									</tr>
									<tr>
										<td>性</td>
										<td><section class="pull-left padding-5" id="Gender"><?php echo $teacherInfo['Gender'] == 1 ? "男" : "女" ?></section></td>
										
									</tr>
									<?php if ($teacherInfo['Status'] != 2 && $teacherInfo['Status'] != 0) { ?>
									<tr>
										<td>状態</td>
										<td><section class="pull-left padding-5" id="Status"><span class="label label-<?php echo $status_label[$teacherInfo['Status']] ?> line-6"><?php echo $status[$teacherInfo['Status']] ?></span></section></td>
									</tr>		
									<?php } ?>				
									<tr>
										<td>生年月日</td>
										<td><section class="pull-left editable padding-5" id="Birthday"><?php echo $teacherInfo['Birthday']  ? $teacherInfo['Birthday'] : "<i>更新している... </i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
										
									</tr>
									<tr>
										<td>クレジットカード情報</td>
										<td><section class="pull-left editable padding-5" id="BankInfo"><?php echo $teacherInfo['BankInfo'] ? $teacherInfo['BankInfo'] : "<i>更新している...</i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>住所</td>
										<td><section class="pull-left editable padding-5" id="Address"><?php echo $teacherInfo['Address']  ? $teacherInfo['Address'] : "<i>更新している...</i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>							
								</tbody>
							</table>
							<div class="notif">
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

	$(document).ready(function(){

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
				UserId: "<?php echo $teacherInfo['UserId']?>",
				Username: '\''+$('#Username').text()+'\'',
				Birthday: '\''+$('#Birthday').text()+'\'',
				BankInfo: '\''+$('#BankInfo').text()+'\'',
				Address: '\''+$('#Address').text()+'\''
			};
			
			$(".user-info .notif span").css("visibility", "visible");
			$(".user-info .notif span").text("Updating infomation...");
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
		               	if (data.Status == "Success") {
	               			$(".user-info .notif span").text("Updated successfully");
	               			setTimeout(function(){
	               				//$(".user-info .notif span").text("");
	               				$('.user-info .notif span').fadeTo(500, 0, function(){
								  	$('.user-info .notif span').css("visibility", "hidden");   
								});
	               			}, 2000);
		               	} else if (data.Status == "Fail") {
	               			$(".user-info .notif span").text("Updated fail");
		               		setTimeout(function(){
	               				//$(".user-info .notif span").text("");
	               				$('.user-info .notif span').fadeTo(500, 0, function(){
								  	$('.user-info .notif span').css("visibility", "hidden");   
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
			if (confirm("Do you want to reset <?php echo $teacherInfo['FullName']?>'s password?") == true) {
				var url = "/elearning/admin/resetPassword";
				var submit_data = {
					UserId: "<?php echo $teacherInfo['UserId']?>",
					Username: "<?php echo $teacherInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.Status == "Success") {
			               		alert("<?php echo $teacherInfo['FullName']?>'s password has been reset to Initial password!");
			               	} else if (data.Status == "Fail") {
			               		alert("Reset password failed!");
			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".reset-ver-cod").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			if (confirm("Do you want to reset <?php echo $teacherInfo['FullName']?>'s verify code?") == true) {
				var url = "/elearning/admin/resetVerifyCode";
				var submit_data = {
					UserId: "<?php echo $teacherInfo['UserId']?>",
					Username: "<?php echo $teacherInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.Status == "Success") {
			               		alert("<?php echo $teacherInfo['FullName']?>'s verify code has been reset!");
			               	} else if (data.Status == "Fail") {
			               		alert("Reset password failed!");
			               	}
			           }
			         });
			    return false;

			} 				
		});
	});


</script>

<?php } //end else-if !isset($teacherInfo)?>