<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>アップロードされたファイル
		</div>
		<div class="tools">
			<span class="pull-left" style="padding-right: 20px">ソート: 最後変更</span>
			<div class="pull-right no-list-style">
				<li class="dropdown menu-right" id="header_notification_bar">
					<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
					
					<ul class="dropdown-menu extended" style="width: 200px !important">
						<li>
							<ul class="dropdown-menu-list no-space no-list-style">
								<li>  
									<a link="" onclick="block_file(this, event)">
									<span class="label label-sm label-icon label-warning"><i class="fa fa-ban"></i></span>
                                        ファイルが選択されたをブロック
									</a>
								</li>
								<li>  
									<a link="" onclick="active_file(event)">
									<span class="label label-sm label-icon label-success"><i class="fa fa-pencil"></i></span>
                                        ファイルが選択されたをアクティブ
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</div>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			<table class="table table-striped table-bordered table-hover" id="file-table">
				<thead>
					<tr>
						<th>
							<input type="checkbox" class="checkbox all" onclick="checkAll(this, event)">
						</th>
						<th scope="col">
                            ファイルID
						</th>
						<th scope="col">
							<a link="">ファイル名</a>
						</th>
						<th scope="col">
                            ファイルリンク
						</th>
						<th scope="col">
                            ファイル種類
						</th>
						<th scope="col">
							<a link="">アップロードユーザ</a>
						</th>
						<th scope="col">
							<a link="">作成時間</a>
						</th>
						<th scope="col">
							<a link="">最後変更</a>
						</th>
						<th scope="col">
							<a link>状態</a>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php if (isset($all_files) && $all_files['Total'] != 0) { ?>
					<?php foreach ($all_files['Data'] as $key => $file) { ?>
					<tr>
						<td>
							<input type="checkbox" class="checkbox">
						</td>
						<td>
							<?php echo $file['File']['FileId']?>
						</td>
						<td>
							<a href="/elearning/admin/file/<?php echo $file['File']['FileId']?>"><?php echo $file['File']['FileName']?></a>
						</td>
						<td>
							 <?php echo $file['File']['FileLink']?>
						</td>
						<td>
							 <?php echo $file['File']['Extension']?>
						</td>
						<td>
							 NULL
						</td>
						<td>
							 <?php echo $file['File']['created']?>
						</td>
						<td>
							 <?php echo $file['File']['modified']?>
						</td>
						<td>
							<label class="label label-sm label-<?php echo $status_label[$file['File']['IsBlocked'] == 1 ? 3 : 1]?> line-8" ><?php echo $status[$file['File']['IsBlocked'] == 1 ? 3 : 1]?></label>
						</td>
					</tr>
					<?php } ?>
				<?php } ?>
				
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

	$(function() {
		$("table").tablesorter({debug: true});
		$("thead th:first").removeClass("header");
	});

	function block_file(target, e) {
		e = $.event.fix(e);
		e.preventDefault();
		var submit_data = [];
		$("#file-table tbody tr").each(function(){
			if ($(this).find("input").is(":checked")) {
				submit_data.push(parseInt($(this).find("td:eq(1)").html()));
			}
		});
		if (submit_data.length == 0) { 
			alert("No selected!");
		} else {
			$.ajax({
	           type: "POST",
	           url: '/elearning/admin/updatefile/block',
	           data: {'data':submit_data },
	           success: function(data)
	           {
					data = $.parseJSON(data);
					$("#file-table tbody tr").each(function(){
						if ($(this).find("input").is(":checked")) {
				 			$(this).find("td:last").html("<label class='label label-sm label-warning line-8' >Blocked</label>");
						}
					});
	           }
	       	});
		}
	}

	function active_file(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var buff = [];
		var submit_data = [];
		$("#file-table tbody tr").each(function(){
			if ($(this).find("input").is(":checked")) {
				submit_data.push(parseInt($(this).find("td:eq(1)").html()));
			}
		});
		console.log(submit_data);
		$.ajax({
           type: "POST",
           url: '/elearning/admin/updatefile/active',
           data: {'data':submit_data },
           success: function(data)
           {
				data = $.parseJSON(data);
				$("#file-table tbody tr").each(function(){
					if ($(this).find("input").is(":checked")) {
						$(this).find("td:last").html("<label class='label label-sm label-success line-8' >Active</label>");
					}
				});

           }
       	});

	}

	$("input[type='checkbox']").on("click", function(){
		$(this).prop("checked", !$(this).prop("checked"));
	});

	$("tbody tr").on("click", function(){
		checkbox = $(this).find("input");
		$(this).find("input").prop("checked", !checkbox.prop("checked"));
	})

	function checkAll(checkbox, e) {
		checkbox = $(checkbox);
		$("input[type='checkbox']").prop("checked", checkbox.prop("checked"));
	};
</script>