<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>アップロードされたファイル
		</div>
		<div class="tools">
			<span class="pull-left" style="padding-right: 20px"></span>
			<div class="pull-right no-list-style">
				<li class="dropdown menu-right" id="header_notification_bar">
					<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
					
					<ul class="dropdown-menu extended" style="width: 200px !important">
						<li>
							<ul class="dropdown-menu-list no-space no-list-style">
								<li>  
									<a link onclick="block_file(this, event)">
									<span class="label label-sm label-icon label-warning"><i class="fa fa-ban"></i></span>
                                        ファイルをブロック
									</a>
								</li>
								<li>  
									<a link="" onclick="active_file(event)">
									<span class="label label-sm label-icon label-success"><i class="fa fa-pencil"></i></span>
                                        ファイルをアクティブ
									</a>
								</li>
								<li>  
                                    <a link="" onclick="report_file(event)">
                                        <span class="label label-sm label-icon label-danger"><i class="fa fa-bell-o"></i></span>
                                        授業をレポート
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
		<div class="update-notif">
			<span></span>
			<label class="ajax-loader"></label>
		</div>
		<div class="table-scrollable">
			<table class="table table-striped table-bordered table-hover" id="file-table">
				<thead>
					<tr>
						<th>
							<!-- <input type="checkbox" class="checkbox all" onclick="checkAll(this, event)"> -->
						</th>
						<th scope="col">
                            <a link>ファイルID</a>
						</th>
						<th scope="col">
							<a link>ファイル名</a>
						</th>
						<th scope="col">
                            <a link> ファイルリンク</a>
						</th>
						<th scope="col">
                            <a link>ファイル種類</a>
						</th>
						<th scope="col">
							<a link>アップロードユーザ</a>
						</th>
						<th scope="col">
							<a link>作成時間</a>
						</th>
						<th scope="col">
							<a link>最後変更</a>
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
							<a class="popup-file" href="/elearning/admin/viewFile/<?php echo $file['File']['FileId']?>"><?php echo $file['File']['FileName']?></a>
						</td>
						<td>
							<?php echo $file['File']['FileLink']?>
						</td>
						<td>
							<?php echo $file['File']['Extension']?>
						</td>
						<td>
							<a href="/elearning/admin/teacher/<?php echo $file['Lesson']['Author']['Username'] ?>"><?php echo $file['Lesson']['Author']['Username'] ?></a>
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
	$(".popup-file").fancybox({
	    width  : 900,
	    height : 500,
	    type   :'iframe',
        'enableEscapeButton': false,
        'overlayShow': true,
        'overlayOpacity': 0,
        'hideOnOverlayClick': false,
        'fitToView': false,
        'autoSize': false,
        'helpers'         : {
	        'overlay'     : {
	            'css'     : {
	                // 'background-color' : '#fff',
	            }
	        }
	    },
       	'onComplete' : function() {
       		$(document).scrollTop(0);
          	$("#fancybox-wrap").css({'top':'150px', 'bottom':'auto'});
		},
	});


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
			$(".update-notif span").css({"visibility": "visible", "opacity": 1});
			$(".update-notif span").text("IPアドレスを変更している...");
			$(".ajax-loader").fadeIn(10);
			$.ajax({
	           type: "POST",
	           url: '/elearning/admin/updatefile/block',
	           data: {'data':submit_data },
	           success: function(data)
	           {
					data = $.parseJSON(data);
					$("#file-table tbody tr").each(function(){
						if ($(this).find("input").is(":checked")) {
				 			$(this).find("td:last").html("<label class='label label-sm label-warning line-8' >ブロック</label>");
						}
					});
					$("#add-ip").removeClass("disabled");
               		$(".update-notif span").text("変更が成功");
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
				$("#file-table tbody tr").each(function(){
					if ($(this).find("input").is(":checked")) {
						$(this).find("td:last").html("<label class='label label-sm label-success line-8' >アクティブ</label>");
					}
				});

           }
       	});

	}

    function report_file(e) {
        e = $.event.fix(e);
        e.preventDefault();
        var buff = [];
        var submit_data = [];
        $("#file-table tbody tr").each(function() {
            if ($(this).find("input").is(":checked")) {
                submit_data.push(parseInt($(this).find("td:eq(1)").html()));
            }
        });
        console.log(submit_data);
        $.ajax({
            type: "POST",
            url: '/elearning/admin/updateFile/report',
            data: {'data': submit_data},
            success: function(data)
            {
                alert("レポート成功した！");
            }
        });
    }

	$("input[type='checkbox']").on("click", function(){
		$(this).prop("checked", !$(this).prop("checked"));
	});

	$("tbody tr td:not(:nth-child(3))").on("click", function(){
		checkbox = $(this).closest("tr").find("input");
		$(this).closest("tr").find("input").prop("checked", !checkbox.prop("checked"));
	})

	function checkAll(checkbox, e) {
		// checkbox = $(checkbox);
		// $("input[type='checkbox']").prop("checked", checkbox.prop("checked"));
		// checkbox.prop("checked", !checkbox.prop("checked"));
	};
</script>