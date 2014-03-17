<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>

<div class="row">
	<div class="col-md-6">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-reorder"></i>IP アドレス</div>
				<div class="actions">
					<a href="#" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> 追加</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-hover" id="ip-table">
						<thead>
							<tr>
								<th class="col-md-1">#</th>
								<th>IP</th>
								<th class="col-md-5">最も近い使うこと</th>
								<th class="col-md-1"></th>
							</tr>
						</thead>
						<?php  if (isset($ip_addrs)) { ?>
						<tbody>
							<?php foreach ($ip_addrs as $key => $ip) { ?>
							<tr>
								<td><?php echo $key?></td>
								<td><?php echo $ip['Ip']['IpAddress']?></td>
								<td><?php echo $ip['Ip']['LastUsed']?></td>
								<td><a type="reset" class="btn btn-xs btn-warning cancel"><span>削除</span></a></td>
							</tr>
							<?php } ?>
						</tbody>
						<?php } else { ?>
						<div class="portlet-body">
							There is no registed IP Address.
						</div>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 ">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>設定テーブル
				</div>
			</div>
			<div class="portlet-body">

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class=""># (設定)</th>
								<th class="col-md-5"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="">セッションタイムアウト</td>
								<td class="col-md-5 align-right">
									<textarea name="" rows="1" class="no-border align-right" style="resize: none" cols="10" id=""><?php echo $configs[0]['Config']['ConfigValue']?></textarea><span style="line-height: 1.7; margin-left: 5px">Seconds</span>
								</td>
							</tr>
							<tr>
								<td>最大ログインが間違えられる回</td>
								<td class="col-md-5 align-right">
									<textarea name="" rows="1" class="no-border align-right" style="resize: none" cols="10" id=""><?php echo $configs[1]['Config']['ConfigValue']?></textarea>
								</td>
							</tr>
							<tr>
								<td>課金の金額</td>
								<td class="col-md-5 align-right">
									<textarea name="" rows="1" class="no-border align-right" style="resize: none" cols="10" id=""><?php echo $configs[2]['Config']['ConfigValue']?></textarea> <span style="line-height: 1.7">VND</span>
								</td>
							</tr>
							<tr>
								<td>報酬の割合</td>
								<td class="col-md-5 align-right">
									<textarea name="" rows="1" class="no-border align-right" style="resize: none" cols="2" id=""><?php echo $configs[3]['Config']['ConfigValue']?></textarea><span style="line-height: 1.7">%</span>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="clear-fix"></div>
					<div class="padding-5 align-right">
						<a href="#" class="btn btn-info btn-xs" disabled="disabled"><i class="fa fa-pencil"></i> 保存</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script>

	function addNewIp() {
		var next = parseInt($("#ip-table tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td>' + next + '</td>'
						+ '<td><input type="textarea" name="" rows="1" class="no-border padding-5" style="resize: none" id="" placeholder="IP Address"></input></td>'
						+ '<td></td>'
						+ '<td><a class="btn btn-xs btn-success" onclick="submitNewIp()"><?php echo __("Save") ?></a><a href="#" class="btn btn-xs btn-warning margin-left-5" onclick="cancel()"><?php echo __("Cancel")?></a></td>'
						+ '</tr>';
		$("#add-new-ip").addClass("disabled");
		$("#ip-table tr:last").after(buff);
		$("#ip-table tr:last td:eq(1) input").focus();
	}	

	function submitNewIp() {
		var time = "<?php echo date("Y-m-d h:i:s"); ?>";
		$("#ip-table tr:last td:eq(1)").html('<span>' + $("#ip-table tr:last td:eq(1) input").val() + '</span>');
		$("#ip-table tr:last td:eq(2)").html(time);
		$("#ip-table tr:last td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right"><span>Remove</span></a>');
		$("#add-new-ip").removeClass("disabled");
	}

	function cancel() {
		$("#ip-table tr:last").remove();		
		$("#add-new-ip").removeClass("disabled");
	}

	function removeIp(event) {
		r = confirm("Do you want to remove this IP Address?");
		if (r == true) {
			parent = $(event.target).closest("tr");
			parent.remove();
		} 

		//submit to server
	}

	$(document).ready(function(){
		$("input").live("keypress", function(event) {
		    if (event.which == 13) {
		        event.preventDefault();
		        submitNewIp();
		    }
		});	
	});
</script>
