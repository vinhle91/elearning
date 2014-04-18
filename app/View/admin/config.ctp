<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
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
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>設定テーブル
				</div>
			</div>
			<div class="portlet-body" id="config-info">

				<div class="table-responsive">
					<table class="table table-hover" >
						<thead>
							<tr>
								<th class=""># (設定)</th>
								<th class="col-md-5"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($configs as $key => $config) { ?>
							<tr>
								<td class="col-md-4"><?php echo $config['Config']['ConfigName']?></td>
								<td class="col-md-6 align-right">
									<section class="editable padding-5" id="config-<?php echo $config['Config']['ConfigId']?>"><?php echo $config['Config']['ConfigValue']  ? $config['Config']['ConfigValue'] : ""?></section>
								</td>
								<td class="col-md-2">
									<span style="line-height: 1.7; margin-left: 5px"><?php echo $config['Config']['ConfigUnit']?></span>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<div class="update-notif">
						<span></span>
						<label class="ajax-loader"></label>
					</div>
					<div class="clear-fix"></div>
					<div class="padding-5 align-right">
						<a href="#" class="btn btn-info btn-xs button-save disabled"><i class="fa fa-pencil"></i> 保存</a>
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
			$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#ip-info .update-notif span").text("Updating infomation...");
			$("#ip-info .ajax-loader").fadeIn(10);
			$("#ip-info .button-save").addClass("disabled");
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
							$("#ip-info #add-ip").removeClass("disabled");
		               		$("#ip-info .update-notif span").text("Updated successfully");
	               			
		               	} else if (data.result == "Fail") {
		               		$("#ip-info .update-notif span").text("Updated fail");
		               		
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
			$("#ip-info .update-notif span").text("IP address not match!");
			setTimeout(function(){
   				$('#ip-info .update-notif span').fadeTo(500, 0, function(){
				  	$('#ip-info .update-notif span').css("visibility", "hidden");   
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
			$("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#ip-info .update-notif span").text("Removing ip...");
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
	               		$("#ip-info .update-notif span").text("Updated successfully");
						parent.remove();
	               	} else if (data.result == "Fail") {
	               		$("#ip-info .update-notif span").text("Updated fail");
	               		
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

	$(".editable").on("click", function(){
		$(this).attr("contenteditable", "true");
		$(this).css("background-color", "#fff");
		$(this).focus();
		$("#config-info .button-save").removeClass("disabled");			
	});

	$("#config-info .button-save").on("click", function(e){
		e = $.event.fix(e);
		e.preventDefault();
		var url = "/elearning/admin/updateConfig/config";
		var submit_data = {
		<?php foreach ($configs as $key => $config) { ?>
			<?php echo $config['Config']['ConfigId'] ?>: $("#config-<?php echo $config['Config']['ConfigId'] ?>").text(),
		<?php } ?>
		};
		console.log(submit_data);
		
		$("#config-info .update-notif span").css({"visibility": "visible", "opacity": 1});
		$("#config-info .update-notif span").text("Updating infomation...");
		$("#config-info .ajax-loader").fadeIn(10);
		$("#config-info .button-save").addClass("disabled");

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
	    return false;
	});
</script>
