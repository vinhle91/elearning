<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<?php $this->log($list_user)?>
<div class="row">
	<div class="col-md-6">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-reorder"></i>IP アドレス</div>
				<div class="actions">
					<a href="#" class="btn btn-info btn-xs" id="add-ip" onclick="addNewIp(event)"><i class="fa fa-plus"></i> 追加</a>
				</div>
			</div>
			<div class="portlet-body" id="ip-info">
				<div class="table-responsive">
					<table class="table table-hover" id="ip-table">
						<thead>
							<tr>
								<th class="col-md-1">番号</th>
								<th class="col-md-2">IP</th>
								<th class="col-md-4">ユーザー</th>
								<th class="col-md-3"></th>
							</tr>
						</thead>
						<?php  if (isset($ip_addrs)) { ?>
						<tbody>
							<?php foreach ($ip_addrs as $key => $ip) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><?php echo $ip['Ip']['IpAddress']?></td>
								<td><a href="/elearning/moderator/<?php echo $ip['User']['Username']?>"><?php echo $ip['User']['Username']?></a></td>
								<td><a type="reset" class="btn btn-xs btn-warning cancel pull-right <?php if ($ip['Ip']['IpAddress'] == $this->Session->read('User.currentIp')) echo "disabled"?>" onclick="removeIp(event)"><span>削除</span></a></td>
							</tr>
							<?php } ?>
						</tbody>
						<?php } else { ?>
						<div class="portlet-body">
                            登録がIPアドレスがありません。
						</div>
						<?php } ?>
					</table>
					<div class="update-notif">
						<span></span>
						<label class="ajax-loader"></label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 ">
		<form id="form1">	
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder"></i>設定テーブル
					</div>
				</div>
				<div class="portlet-body" id="config-info">
					<div class="table-responsive">
						<table class="table table-hover margin-bottom-5" >
							<tbody>
								<tr>
									<td class="col-md-4">自動セッション終了時間</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="session_timeout" name="session_timeout" value="<?php echo $configs[0]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">秒</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">自動バックアップ時刻</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="auto_backup" name="auto_backup" value="<?php echo $configs[1]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">秒</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">ログイン誤り回数</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="login_fail" name="login_fail" value="<?php echo $configs[2]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">回</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">ロッグ時間</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="lock_time" name="lock_time" value="<?php echo $configs[3]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">秒</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">一回受講料</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="lesson_cost" name="lesson_cost" value="<?php echo $configs[4]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">VND</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">受講可能時間</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="test_time" name="test_time" value="<?php echo $configs[5]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">秒</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-4">報酬%</td>
									<td class="col-md-6 align-right">
										<input type="text" class="padding-5 no-border align-right" id="share_rate" name="share_rate" value="<?php echo $configs[6]['Config']['ConfigValue']?>"></input>
									</td>
									<td class="col-md-2">
										<span style="line-height: 1.7; margin-left: 5px">%</span>
									</td>
								</tr>
								

							</tbody>
						</table>
						<div class="update-notif">
							<span></span>
							<label class="ajax-loader"></label>
						</div>
						<div class="clear-fix"></div>
						<div class="padding-5 align-right">
							<input type="submit" class="btn btn-info btn-xs button-save" data-icon="check" value="保存"></input>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	function getUserList() {
		$.ajax({
			type: "POST",
			url: "/elearning/admin/getUserList/admin",
			data: {data: "request"},
			success: function(data){
				data = $.parseJSON(data);
				console.log(data._data);
				if (data.result == "Success") {
					return data._data;
				}
			}
		});
	}

	function addNewIp(e) {
		e = $.event.fix(e);
		e.preventDefault();

		var next = parseInt($("#ip-table tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td class="col-md-1">' + next + '</td>'
						+ '<td class="col-md-2"><input type="text" name="" rows="1" class="no-border padding-5" style="resize: none" id="new-ip" placeholder="IPアドレス"></input></td>'
						+ '<td class="col-md-4"><input type="text" name="" rows="1" class="no-border padding-5" style="resize: none" id="new-user" placeholder="ユーザー"></input></td>'
						+ '<td class="col-md-3"><a href="#" class="pull-right btn btn-xxs btn-warning margin-left-5" onclick="cancel(event)"><?php echo __("キャンセル")?></a><a class="pull-right btn btn-xxs btn-success" onclick="submitNewIp()"><?php echo __("保存") ?></a></td>'
						+ '</tr>';
		$("#add-ip").addClass("disabled");
		$("#ip-table tr:last").after(buff);
		$("#ip-table tr:last td:eq(1) input").focus();
	}	

	$("#new-user").live("focusin focusout", function(){
		var availableTags = [];
		<?php foreach ($list_user as $key => $user) { ?>
			availableTags.push("<?php echo $user['User']['Username']?>");
		<?php } ?>
		$(this).autocomplete({
	        source: availableTags,
	        minLength:0
	    }).bind('focus', function(){ $(this).autocomplete("search"); } );
	});

	function checkIpValidate(str) {
		var regexIPv4 = /^(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))$/;

		if (str.match(regexIPv4)) return true;
		else return false;
	}

	function submitNewIp() {
		var time = "<?php echo date("Y-m-d h:i:s"); ?>";
		var submit_data = $("#ip-table tr:last td:eq(1) input").val();
		var submit_data2 = $("#ip-table tr:last td:eq(2) input").val();
		if (checkIpValidate(submit_data)) {
			if (submit_data2 != '') {
				var availableTags = [];
				<?php foreach ($list_user as $key => $user) { ?>
					availableTags.push("<?php echo $user['User']['Username']?>");
				<?php } ?>
				if (availableTags.indexOf(submit_data2) != -1) {
					$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
					$("#ip-info .update-notif span").text("IPアドレスを変更している...");
					$("#ip-info .ajax-loader").fadeIn(10);
					$("#ip-info .button-save").addClass("disabled");
					$.ajax({
				           type: "POST",
				           url: "/elearning/admin/updateConfig/ip",
				           data: {IpAddress: submit_data, Username: submit_data2}, 
				           success: function(data)
				           {
								$(".ajax-loader").fadeOut(10);
								data = $.parseJSON(data);
				               	if (data.result == "Success") {
				               		$("#ip-table tr:last td:eq(1)").html('<span>' + submit_data + '</span>');
									$("#ip-table tr:last td:eq(2)").html('<span><a href="/elearning/moderator/"' + submit_data2 + '">' + submit_data2 + '</a></span>');
									$("#ip-table tr:last td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right" onclick="removeIp(event)"><span>削除</span></a>');
									$("#ip-info #add-ip").removeClass("disabled");
				               		$("#ip-info .update-notif span").text("変更が成功");
			               			
				               	} else if (data.result == "Fail") {
				               		$("#ip-info .update-notif span").text("変更が失敗");
				               		
				               	}
				               	setTimeout(function(){
		               				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
									  	$('#ip-info .update-notif span').css("visibility", "hidden");   
									});
		               			}, 2000);
				           }
				         });
				} else {
					$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
					$("#ip-info .update-notif span").text("ユーザーがいません!");
					setTimeout(function(){
		   				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
						  	$('#ip-info .update-notif span').css("visibility", "hidden");   
						});
		   			}, 2000);
				}
				
			} else {
				$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
				$("#ip-info .update-notif span").text("ユーザーがなければならない!");
				setTimeout(function(){
	   				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
					  	$('#ip-info .update-notif span').css("visibility", "hidden");   
					});
	   			}, 2000);
			}
				
		} else {
			$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#ip-info .update-notif span").text("IPアドレスが一致しない!");
			setTimeout(function(){
   				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
				  	$('#ip-info .update-notif span').css("visibility", "hidden");   
				});
   			}, 2000);
		}
	}

	function cancel(e) {
		e = $.event.fix(e);
		e.preventDefault();
		$("#ip-table tr:last").remove();		
		$("#add-ip").removeClass("disabled");
	}

	function removeIp(event) {
		parent = $(event.target).closest("tr");
		window.abc = parent;
		submit_data = parent.find("td:eq(1)").html();
		r = confirm("あなたは、このIPアドレスを削除しますか?");
		if (r == true) {
			$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#ip-info .update-notif span").text("IPアドレスを削除している...");
			$("#ip-info .ajax-loader").fadeIn(10);
			$("#ip-info .button-save").addClass("disabled");
			$.ajax({
	           type: "POST",
	           url: "/elearning/admin/updateConfig/removeIp",
	           data: {IpAddress: submit_data}, 
	           success: function(data)
	           {
	           		console.log(data);
					$(".ajax-loader").fadeOut(10);
					data = $.parseJSON(data);
	               	if (data.result == "Success") {
	               		$("#ip-info .update-notif span").text("変更が成功");
						parent.remove();
	               	} else if (data.result == "Fail") {
	               		$("#ip-info .update-notif span").text("変更が失敗");
	               		
	               	}
	               	setTimeout(function(){
           				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
						  	$('#ip-info .update-notif span').css("visibility", "hidden");   
						});
           			}, 2000);
	           }
	        });

			

		} 

		//submit to server
	}

	function submitKey(key) {
		if (key == 13) {
	        event.preventDefault();
	        submitNewIp();
	    }
	}

	$(document).ready(function(){
		
	});

	$("#form1 input[type='text']").on("click", function(){
		$("#config-info .button-save").removeClass("disabled");			
	});


	$('#form1').validate({
	    rules: {
	        session_timeout: {
	            required: true,
	            number: true
	        },
	        auto_backup: {
	            required: true,
	            number: true
	        },
	        login_fail: {
	            required: true,
	            number: true
	        },
	        lock_time: {
	            required: true,
	            number: true
	        },
	        lesson_cost: {
	            required: true,
	            number: true
	        },
	        test_time: {
	            required: true,
	            number: true
	        },
	        share_rate: {
	            required: true,
	            number: true
	        },

	    },
	    messages: {
	        session_timeout: {
	            number: "Please enter valid variable.",
	            required: "自動セッション終了時間 は必須です",
	        },
	        auto_backup: {
	            number: "Please enter valid variable.",
	            required: "自動バックアップ時刻 は必須です",
	        },
	        login_fail: {
	            number: "Please enter valid variable.",
	            required: "ログイン誤り回数 は必須です",
	        },
	        lock_time: {
	            number: "Please enter valid variable.",
	            required: "ロッグ時間 は必須です",
	        },
	        lesson_cost: {
	            number: "Please enter valid variable.",
	            required: "一回受講料 は必須です",
	        },
	        test_time: {
	            number: "Please enter valid variable.",
	            required: "受講可能時間 は必須です",
	        },
	        share_rate: {
	            number: "Please enter valid variable.",
	            required: "報酬% は必須です",
	        },
	    },
	    errorPlacement: function (error, element) {
	        error.appendTo(element.parent());
	    },
	    submitHandler: function (form) {
	        $.mobile.changePage('#success', {
	            transition: "slide"
	        });
	        return false;
	    },
	});

	$("#form1").live("submit", function(e){
		if ($("#form1").validate().checkForm() == false) {
			return;
		} else {
			var url = "/elearning/admin/updateConfig/config";
			var submit_data = {
				1 : $("#session_timeout").val().trim(),
				2 : $("#auto_backup").val().trim(),
				3 : $("#login_fail").val().trim(),
				4 : $("#lock_time").val().trim(),
				5 : $("#lesson_cost").val().trim(),
				6 : $("#test_time").val().trim(),
				7 : $("#share_rate").val().trim(),
			};
			console.log(submit_data);
			
			$("#config-info .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#config-info .update-notif span").text("Updating infomation...");
			$("#config-info .ajax-loader").fadeIn(10);
			// $("#config-info .button-save").addClass("disabled");

		    $.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						$(".ajax-loader").fadeOut(10);
						data = $.parseJSON(data);
						console.log(data);
		               	if (data.result == "Success") {
		           			$("#config-info .update-notif span").text("Updated successfully");
		           			setTimeout(function(){
		           				$('#config-info .update-notif span').fadeTo(500, 0, function(){
								  	$('#config-info .update-notif span').css("visibility", "hidden");   
								});
		           			}, 2000);
		               	} else if (data.result == "Fail") {
		           			$("#config-info .update-notif span").text("Updated fail");
		               		setTimeout(function(){
		           				$('#config-info .update-notif span').fadeTo(500, 0, function(){
								  	$('#config-info .update-notif span').css("visibility", "hidden");   
								});
		           			}, 2000);
		               	}
		           }
		         });

			e.preventDefault();
			return false;
		}

		
	});
</script>
