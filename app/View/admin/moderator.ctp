<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>

<div class="user-info">		
	<div class="col-md-6">
		<div class="portlet">
			<div class="nav portlet-title padding-top-8">
				<div class="caption">すべての管理者</div>
				<div class="pull-right">
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="btn btn-info btn-xs" id="add-mod" onclick="addModerator()"><i class="fa fa-plus"></i>追加</a>
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
								<td><a href=""><?php echo $moderator['User']['Username']?></a></td>
								<td><?php echo $moderator['User']['created']?></td>
								<td><label class="line-8 label label-sm label-<?php echo $moderator['User']['IsOnline'] == 1 ? "success" : "default disabled"?>"><?php echo $moderator['User']['IsOnline'] == 1 ? "Online" : "Offline"?></label></td>
							</tr>							
						</tbody>
					</table>
					<div class="notif">
						<span></span>
						<label class="ajax-loader"></label>
					</div>
				<?php } ?>
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

	function addModerator() {
		var next = parseInt($("#mod-tbl tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td>' + next + '</td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border mod-info name" style="resize: none" id="" placeholder="username"></input></td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border mod-info password" style="resize: none" id="" placeholder="password"></input></td>'
						+ '<td><a href="#" class="btn btn-xs btn-success" onclick="submitNewMod()"><?php echo __("Save") ?></a><a href="#" class="btn btn-xs btn-warning margin-left-5" onclick="cancel()"><?php echo __("Cancel")?></a></td>'
						+ '</tr>';
		$("#add-new-mod").addClass("disabled");
		$("#mod-tbl tr:last").after(buff);
		$("#mod-tbl tr:last td:eq(1) input").focus();
	}

	

	function submitNewMod() {
		$(".user-info .notif span").css("visibility", "visible");
		$(".user-info .notif span").text("Updating infomation...");
		$(".ajax-loader").fadeIn(10);
		
		var now = new Date();
		var time = now.toUTCString();
		var url = "/elearning/admin/updateUserInfo/insert";
		var submit_data = {
			Username: '\''+$("input.name").val()+'\'', 
			Password: '\''+$("input.password").val()+'\'', 
			InitialPassword: '\''+$("input.password").val()+'\'', 
			UserType: 3,
            VerifyCodeQuestion: "",
            InitialCodeQuestion: "",
            VerifyCodeAnswer: "",
            InitialCodeAnswer: "",
            created: time,
            Status: 1,
		};

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
               			$("#mod-tbl tr:last td:eq(1)").html('<a href="">' + $("#mod-tbl tr:last td:eq(1) input").val() + '</a>');
						$("#mod-tbl tr:last td:eq(2)").html(time);
						$("#mod-tbl tr:last td:eq(3)").html('<label class="label label-sm label-default disabled">Offline</label>');
						$("#add-mod").removeClass("disabled");
               			setTimeout(function(){
               				$(".user-info .notif span").text("");
               			}, 2000);
	               	} else if (data.Status == "Fail") {
               			$(".user-info .notif span").text("Updated fail");
	               		setTimeout(function(){
               				$(".user-info .notif span").text("");
               			}, 2000);
	               	}
	           }
	         });
	    return false;
	}

	function cancel() {
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