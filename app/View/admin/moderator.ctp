<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<script type="text/javascript">
	$(function() {
		$("table").tablesorter({debug: true});
	});
</script>

<?php if (!isset($moderatorInfo)) { ?>
<div class="user-info">		
	<div class="col-md-6">
		<div class="portlet">
			<div class="nav portlet-title padding-top-8">
				<div class="caption">すべての管理者</div>
				<div class="pull-right">
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="btn btn-info btn-xs" id="add-mod" onclick="addModerator(event)"><i class="fa fa-plus"></i>追加</a>
					</li>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
				<?php if (isset($all_moderators) && $all_moderators['Total'] != 0) { ?>

					<table class="table table-hover" id="mod-tbl">
						<thead>
							<tr>
								<th class="col-md-1">#</th>
								<th class="col-md-3">ユーザー名</th>
								<th>登録日時</th>
								<th class="col-md-3">状態</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_moderators['Data'] as $key => $moderator) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><a href="/elearning/admin/moderator/<?php echo $moderator['User']['Username']?>"><?php echo $moderator['User']['Username']?></a></td>
								<td><?php echo $moderator['User']['created']?></td>
								<td><label class="line-8 label label-sm label-<?php echo $moderator['User']['IsOnline'] == 1 ? "success" : "default disabled"?>"><?php echo $moderator['User']['IsOnline'] == 1 ? "Online" : "Offline"?></label></td>
							</tr>	
							<?php } ?>
						</tbody>
					</table>
					<div class="update-notif">
						<span></span>
						<label class="ajax-loader"></label>
					</div>
				<?php } else {?>
				<div>
					NO ADMIN!
				</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	function addModerator(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var next = parseInt($("#mod-tbl tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td>' + next + '</td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border mod-info name" style="resize: none" id="" placeholder="username"></input></td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border mod-info password" style="resize: none" id="" placeholder="password"></input></td>'
						+ '<td><a href="#" class="btn btn-xs btn-success" onclick="submitNewMod(event)"><?php echo __("Save") ?></a><a href="#" class="btn btn-xs btn-warning margin-left-5" onclick="cancel(event)"><?php echo __("Cancel")?></a></td>'
						+ '</tr>';
		$("#add-new-mod").addClass("disabled");
		$("#mod-tbl tr:last").after(buff);
		$("#mod-tbl tr:last td:eq(1) input").focus();
	}

	

	function submitNewMod(e) {
		e = $.event.fix(e);
		e.preventDefault();
		$(".user-info .update-notif span").css("visibility", "visible");
		$(".user-info .update-notif").html("<span>Updating infomation...</span>");
		$(".ajax-loader").fadeIn(10);
		
		var now = new Date();
		var time = now.toUTCString();
		var url = "/elearning/admin/updateUserInfo/insert";
		var submit_data = {
			Username: $("input.name").val(), 
			Password: $("input.password").val(), 
			InitialPassword: $("input.password").val(), 
			UserType: 3,
            VerifyCodeQuestion: "Default Question",
            InitialCodeQuestion: "12345678",
            VerifyCodeAnswer: "Default Answer",
            InitialCodeAnswer: "12345678",
            Status: 1,
            Gender: 1,
		};

		$.ajax({
	           type: "POST",
	           url: url,
	           data: submit_data, 
	           success: function(data)
	           {
					$(".ajax-loader").fadeOut(10);
					console.log(data);
					data = $.parseJSON(data);
					console.log(data);
	               	if (data.result == "Success") {
               			$(".user-info .update-notif span").text("更新することは成功した");
               			$("#mod-tbl tr:last td:eq(1)").html('<a href="">' + $("#mod-tbl tr:last td:eq(1) input").val() + '</a>');
						$("#mod-tbl tr:last td:eq(2)").html(time);
						$("#mod-tbl tr:last td:eq(3)").html('<label class="label label-sm label-default disabled">Offline</label>');
						$("#add-mod").removeClass("disabled");
               			setTimeout(function(){
               				$(".user-info .update-notif span").text("");
               			}, 2000);
	               	} else if (data.result == "Fail") {
               			$(".user-info .update-notif span").text("更新することは失敗した");
               			$(".user-info .update-notif").append("<p>"+data.msg+"<p>");
	               		setTimeout(function(){
               				$(".user-info .update-notif span").text("");
               				$(".user-info .update-notif p").text("");
               			}, 4000);
	               	}
	           }
	         });
	         

	    return false;
	}

	function cancel(e) {
		e = $.event.fix(e);
		e.preventDefault();
		$("#mod-tbl tr:last").remove();		
		$("#add-new-mod").removeClass("disabled");
	}

	$(document).ready(function(){
		$("input.mod-info").live("keypress", function(event) {
		    if (event.which == 13) {
		        event.preventDefault();
		        submitNewMod();
		    }
		});	
	});
</script>

<?php } else { //end if !isset($moderatorInfo) ?>
<?php //have $moderatorInfo?>
	<div class="row">
		<div class="col-md-12">			
			<div class="row">
				<div class="note note-success user-info" style="margin-top:  20px;">
						<div class="pull-left" style="padding: 10px">
                    		<img class="imageThumb" src="<?php echo $moderatorInfo['ImageProfile'] ? $moderatorInfo['ImageProfile'] : '/elearning/img/photo/no-avatar.jpg'?>" id="preview" width="96" height="96" style="margin-top: -50px;">
                		</div>
						<h4 class="block" style="margin-bottom: 0; margin-top: -10px;"><?php echo $moderatorInfo['FullName'] ?></h4> 
						<span class="gender male"></span><?php echo $moderatorInfo['Gender'] == 1 ? "男" : "女" ?>
						<span class="bday"></span><?php echo $moderatorInfo['Birthday'] ?>
						<span class="addr"></span><?php echo $moderatorInfo['Address'] ? $moderatorInfo['Address'] : "住所  <i class='margin-left-5'> 更新している...</i>" ?>
						<span class="phone"><label class="fa fa-phone"></label><?php echo $moderatorInfo['Phone'] ? $moderatorInfo['Phone'] : "<i class=''> 更新している...</i>" ?></span>
				</div>
			</div>
			<?php if ($moderatorInfo['Status'] == 2) { ?>
			<div class = "handle-user pull-right">
				<button class="btn btn-sm btn-info disabled pull-right" id = "notif-pending">
					<i class='fa fa-exclamation-triangle margin-right-5'></i>
					<span>
						 未確定
					</span>
				</button>
				<button class="btn btn-sm btn-success margin-right-5 pull-right" id = "first-active">
					
					<span>
						 Active
					</span>
				</button>
			</div>			
			<?php } ?>
			<?php if ($moderatorInfo['Status'] == 0) { ?>
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
					<div class="caption"><i class="fa fa-reorder"></i><?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s 情報</div>
					<?php if ($moderatorInfo['Status'] != 2 && $moderatorInfo['Status']!=0) {?>
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
										<?php if ($moderatorInfo['Status'] == 1) { ?>
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
										<?php if ($moderatorInfo['Status'] != 1) { ?>
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
										<td><section class="pull-left padding-5" id="Username"><?php echo $moderatorInfo['Username'] ?></section></td>

									</tr>
									<tr>
										<td>性</td>
										<td><section class="pull-left padding-5" id="Gender"><?php echo $moderatorInfo['Gender'] == 1 ? "男" : "女" ?></section></td>
										
									</tr>
									<?php if ($moderatorInfo['Status'] != 2 && $moderatorInfo['Status'] != 0) { ?>
									<tr>
										<td>状態</td>
										<td><section class="pull-left padding-5" id="Status"><span class="label label-<?php echo $status_label[$moderatorInfo['Status']] ?> line-6"><?php echo $status[$moderatorInfo['Status']] ?></span></section></td>
									</tr>		
									<?php } ?>				
									<tr>
										<td>生年月日</td>
										<td><section class="pull-left editable padding-5" id="Birthday"><?php echo $moderatorInfo['Birthday']  ? $moderatorInfo['Birthday'] : "<i>更新している... </i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
										
									</tr>
									<tr>
										<td>メール</td>
										<td><section class="pull-left editable padding-5" id="Email"><?php echo $moderatorInfo['Email']  ? $moderatorInfo['Email'] : "<i>更新している... </i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
										
									</tr>
									<tr>
										<td>クレジットカード情報</td>
										<td><section class="pull-left editable padding-5" id="BankInfo"><?php echo $moderatorInfo['BankInfo'] ? $moderatorInfo['BankInfo'] : "<i>更新している...</i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>住所</td>
										<td><section class="pull-left editable padding-5" id="Address"><?php echo $moderatorInfo['Address']  ? $moderatorInfo['Address'] : "<i>更新している...</i>"?></section><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
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
			$("li.dropdown#options").removeClass("open");
			var url = "/elearning/admin/updateUserInfo/update";
			var submit_data = {
				UserId: "<?php echo $moderatorInfo['UserId']?>",
				Username: '\''+$('#Username').text()+'\'',
				Birthday: '\''+$('#Birthday').text()+'\'',
				Email: '\''+$('#Email').text()+'\'',
				BankInfo: '\''+$('#BankInfo').text()+'\'',
				Address: '\''+$('#Address').text()+'\'',
			};
			
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".user-info .update-notif span").text("Updating infomation...");
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
	               			$(".user-info .update-notif span").text("Updated successfully");
	               			setTimeout(function(){
	               				//$(".user-info .update-notif span").text("");
	               				$('.user-info .update-notif span').fadeTo(500, 0, function(){
								  	$('.user-info .update-notif span').css("visibility", "hidden");   
								});
	               			}, 2000);
		               	} else if (data.result == "Fail") {
	               			$(".user-info .update-notif span").text("Updated fail");
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
			$("li.dropdown#options").removeClass("open");
			if (confirm("Do you want to reset <?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s password?") == true) {
				var url = "/elearning/admin/resetPassword";
				var submit_data = {
					UserId: "<?php echo $moderatorInfo['UserId']?>",
					Username: "<?php echo $moderatorInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s password has been reset to Initial password!");
			               	} else if (data.result == "Fail") {
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
			$("li.dropdown#options").removeClass("open");
			if (confirm("Do you want to reset <?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s verify code?") == true) {
				var url = "/elearning/admin/resetVerifyCode";
				var submit_data = {
					UserId: "<?php echo $moderatorInfo['UserId']?>",
					Username: "<?php echo $moderatorInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s verify code has been reset!");
			               	} else if (data.result == "Fail") {
			               		alert("Reset password failed!");
			               	}
			           }
			         });
			    return false;

			} 				
		});

		$(".update-block").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			$("li.dropdown#options").removeClass("open");
			if (confirm("Do you want to block <?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s account?") == true) {
				var url = "/elearning/admin/updateUserInfo/block";
				var submit_data = {
					UserId: "<?php echo $moderatorInfo['UserId']?>",
					Username: "<?php echo $moderatorInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s account has been blocked!");
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
			$("li.dropdown#options").removeClass("open");
			$("li.dropdown#options").removeClass("open");
			if (confirm("Do you want to delete <?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s account?") == true) {
				var url = "/elearning/admin/updateUserInfo/delete";
				var submit_data = {
					UserId: "<?php echo $moderatorInfo['UserId']?>",
					Username: "<?php echo $moderatorInfo['Username']?>",
				};
				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							data = $.parseJSON(data);
			               	if (data.result == "Success") {
			               		alert("<?php echo !empty($moderatorInfo['FullName'])?$moderatorInfo['FullName']:$moderatorInfo['Username'] ?>'s account has been delete!");
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
			$("li.dropdown#options").removeClass("open");
			var url = "/elearning/admin/updateUserInfo/active";
			var submit_data = {
				UserId: "<?php echo $moderatorInfo['UserId']?>",
				Username: "<?php echo $moderatorInfo['Username']?>",
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
		               		alert("Reactive user fail!");
		               	}
		           }
		         });
		    return false;
		});

		$("#first-active").on("click", function(e){
			e = $.event.fix(e);
			e.preventDefault();
			$("li.dropdown#options").removeClass("open");
			var url = "/elearning/admin/updateUserInfo/active";
			var submit_data = {
				UserId: "<?php echo $moderatorInfo['UserId']?>",
				Username: "<?php echo $moderatorInfo['Username']?>",
			};

			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		$(".handle-user #notif-pending").hide("slide", { direction: "right" }, 1000);
							$(".handle-user #first-active").delay(1000).prepend('<i class="fa fa-check margin-right-5"></i>');
		               	} else if (data.result == "Fail") {
		               		alert("Reactive user fail!");
		               	}
		           }
		         });

		    return false;
		});

	});
</script>

<?php } //end else-if !isset($moderatorInfo)?>