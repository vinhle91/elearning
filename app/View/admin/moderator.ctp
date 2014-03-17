<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>

<div class="row">		
	<div class="col-md-6">
		<div class="portlet">
			<div class="nav portlet-title padding-top-8">
				<div class="caption"># すべての管理者</div>
				<div class="pull-right">
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="btn btn-info btn-xs" id="add-mod" onclick="addModerator()"><i class="fa fa-plus"></i>追加</a>
					</li>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
				<?php if (isset($all_moderators) && $all_moderators['Total'] != 0) { ?>

					<table class="table table-hover" id="moderators-table">
						<thead>
							<tr>
								<th>#</th>
								<th class="col-md-4">ユーザー名</th>
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
								<td><label class="label label-sm label-<?php echo $moderator['User']['IsOnline'] == 1 ? "success" : "default"?>"><?php echo $moderator['User']['IsOnline'] == 1 ? "オンライン" : "Offline"?></label></td>
							</tr>							
						</tbody>
					</table>
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
		var next = parseInt($("#moderators-table tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td>' + next + '</td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border" style="resize: none" id="" placeholder="username"></input></td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border" style="resize: none" id="" placeholder="password"></input></td>'
						+ '<td><a href="#" class="btn btn-xs btn-success" onclick="submitNewMod()"><?php echo __("Save") ?></a><a href="#" class="btn btn-xs btn-warning margin-left-5" onclick="cancel()"><?php echo __("Cancel")?></a></td>'
						+ '</tr>';
		$("#add-new-mod").addClass("disabled");
		$("#moderators-table tr:last").after(buff);
		$("#moderators-table tr:last td:eq(1) input").focus();
	}

	

	function submitNewMod() {
		var now = new Date();
		var time = now.toUTCString();
		$("#moderators-table tr:last td:eq(1)").html('<a href="">' + $("#moderators-table tr:last td:eq(1) input").val() + '</a>');
		$("#moderators-table tr:last td:eq(2)").html(time);
		$("#moderators-table tr:last td:eq(3)").html('<label class="label label-sm label-info disabled">オフライン</label>');
		$("#add-mod").removeClass("disabled");
	}

	function cancel() {
		$("#moderators-table tr:last").remove();		
		$("#add-new-mod").removeClass("disabled");
	}

	$(document).ready(function(){
		$("input").live("keypress", function(event) {
		    if (event.which == 13) {
		        event.preventDefault();
		        submitNewMod();
		    }
		});	
	});
</script>