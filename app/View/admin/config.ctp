<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<?php $this->log($ip_addrs)?>
<div class="row">
	<div class="col-md-6">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-reorder"></i>IP アドレス</div>
				<div class="actions">
					<a href="#" class="btn btn-info btn-xs" id="add-ip" onclick="addNewIp(event)"><i class="fa fa-plus"></i> 追加</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-hover" id="ip-table">
						<thead>
							<tr>
								<th class="col-md-1">#</th>
								<th class="col-md-3">IP</th>
								<th class="col-md-3">最も近い使うこと</th>
								<th class="col-md-3"></th>
							</tr>
						</thead>
						<?php  if (isset($ip_addrs)) { ?>
						<tbody>
							<?php foreach ($ip_addrs as $key => $ip) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><?php echo $ip['Ip']['IpAddress']?></td>
								<td><?php echo $ip['Ip']['modified']?></td>
								<td><a type="reset" class="btn btn-xs btn-warning cancel pull-right" onclick="removeIp(event)"><span>Remove</span></a></td>
							</tr>
							<?php } ?>
						</tbody>
						<?php } else { ?>
						<div class="portlet-body">
							There is no registed IP Address.
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

	function addNewIp(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var next = parseInt($("#ip-table tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td class="col-md-1">' + next + '</td>'
						+ '<td class="col-md-3"><input type="textarea" name="" rows="1" class="no-border padding-5" style="resize: none" id="submit-ip" placeholder="IP Address" onkeypress="submitKey(event.which)"></input></td>'
						+ '<td class="col-md-3"></td>'
						+ '<td class="col-md-3"><a href="#" class="pull-right btn btn-xs btn-warning margin-left-5" onclick="cancel(event)"><?php echo __("Cancel")?></a><a class="pull-right btn btn-xs btn-success" onclick="submitNewIp()"><?php echo __("Save") ?></a></td>'
						+ '</tr>';
		$("#add-ip").addClass("disabled");
		$("#ip-table tr:last").after(buff);
		$("#ip-table tr:last td:eq(1) input").focus();
	}	

	function checkIpValidate(str) {
		var regexIPv4 = /^(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))$/;

		if (str.match(regexIPv4)) return true;
		else return false;
	}

	function submitNewIp() {
		var time = "<?php echo date("Y-m-d h:i:s"); ?>";
		var submit_data = $("#ip-table tr:last td:eq(1) input").val();
		if (checkIpValidate(submit_data)) { 
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".update-notif span").text("Updating infomation...");
			$(".ajax-loader").fadeIn(10);
			$(".button-save").addClass("disabled");
			$.ajax({
		           type: "POST",
		           url: "/elearning/admin/updateConfig/ip",
		           data: {IpAddress: submit_data}, 
		           success: function(data)
		           {
						$(".ajax-loader").fadeOut(10);
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		$("#ip-table tr:last td:eq(1)").html('<span>' + submit_data + '</span>');
							$("#ip-table tr:last td:eq(2)").html(time);
							$("#ip-table tr:last td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right" onclick="removeIp(event)"><span>Remove</span></a>');
							$("#add-ip").removeClass("disabled");
		               		$(".update-notif span").text("Updated successfully");
	               			
		               	} else if (data.result == "Fail") {
		               		$(".update-notif span").text("Updated fail");
		               		
		               	}
		               	setTimeout(function(){
               				$('.update-notif span').fadeTo(500, 0, function(){
							  	$('.update-notif span').css("visibility", "hidden");   
							});
               			}, 2000);
		           }
		         });
		} else {
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".update-notif span").text("IP address not match!");
			setTimeout(function(){
   				$('.update-notif span').fadeTo(500, 0, function(){
				  	$('.update-notif span').css("visibility", "hidden");   
				});
   			}, 1000);
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
		r = confirm("Do you want to remove this IP Address?");		
		if (r == true) {
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".update-notif span").text("Removing ip...");
			$(".ajax-loader").fadeIn(10);
			$(".button-save").addClass("disabled");
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
	               		$(".update-notif span").text("Updated successfully");
						parent.remove();
	               	} else if (data.result == "Fail") {
	               		$(".update-notif span").text("Updated fail");
	               		
	               	}
	               	setTimeout(function(){
           				$('.update-notif span').fadeTo(500, 0, function(){
						  	$('.update-notif span').css("visibility", "hidden");   
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
</script>
