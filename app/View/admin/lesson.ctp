<div class="portlet">
	<div class="portlet-title padding-top-8">
		<div class="caption padding-top-3">
			<i class="fa fa-book"></i>アップロードされた授業
		</div>
		<div class="tools">
			<div class="pull-right no-list-style">
				<li class="dropdown menu-right" id="header_notification_bar">
					<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>Options</span>
					
					<ul class="dropdown-menu extended" style="width: 200px !important">
						<li>
							<ul class="dropdown-menu-list no-space no-list-style">
								<li>  
									<a link="" onclick="block_lesson(this, event)">
									<span class="label label-sm label-icon label-warning"><i class="fa fa-ban"></i></span>
                                        授業をブロック
									</a>
								</li>
								<li>  
									<a link="" onclick="active_lesson(event)">
									<span class="label label-sm label-icon label-success"><i class="fa fa-pencil"></i></span>
                                        授業をアクティブ
									</a>
								</li>
								<li>  
									<a link="" onclick="report_lesson(event)">
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
		<div class="table-scrollable">
			<table class="table table-striped table-bordered table-hover tablesorter" id="lesson-table">
				<thead>
				<tr>
					<th>
						<input type="checkbox" class="checkbox all" onclick="checkAll(this, event)">
					</th>
					<th scope="col">
						<a link>ID</a>
					</th>
					<th scope="col">
						<a link>タイトル</a>
					</th>
					<th scope="col">
						<a link>種類</a>
					</th>
					<th scope="col" style="width: 200px;">
						Abstract
					</th>
					<th scope="col">
						<a link>著者</a>
					</th>
					<th scope="col">
						<a link>作成した時間</a>
					</th>
					<th scope="col">
						<a link>いいね回数</a>
					</th>
					<th scope="col">
						<a link>勉強回数</a>
					</th>
					<th scope="col">
						<a link>レポート回数</a>
					</th>
					<th scope="col">
						<a link>状態</a>
					</th>
				</tr>
				</thead>
				<tbody>
					<?php if (isset($all_lessons) && $all_lessons['Total'] != 0) { ?>
						<?php foreach ($all_lessons['Data'] as $key => $lesson) { ?>
						<tr>
							<td>
								<input type="checkbox" class="checkbox">
							</td>
							<td>
								<?php echo $lesson['Lesson']['LessonId']?>
							</td>
							<td>
								<?php echo $lesson['Lesson']['Title']?>
							</td>
							<td>
								<?php echo $lesson['Lesson']['Title']?>
							</td>
							<td>
								<p style = "width: 200px; text-overflow:ellipsis; overflow: hidden"> <?php echo $lesson['Lesson']['Abstract']?></p>
							</td>
							<td>
								<a href="/elearning/admin/teacher/<?php echo $lesson['Author']['Username'] ?>" target="_blank"><?php echo $lesson['Author']['Username'] ?></a>
							</td>
							<td>
								<?php echo $lesson['Lesson']['created']?>
							</td>
							<td>
								<?php echo $lesson['Lesson']['LikeNumber']?>
							</td>
							<td>
								<?php echo $lesson['Lesson']['ViewNumber']?>
							</td>
							<td>
								<?php echo count($lesson['Report'])?>
							</td>
							<td>
								<label class="label label-sm label-<?php echo $status_label[$lesson['Lesson']['IsBlocked'] == 1 ? 3 : 1]?> line-8" ><?php echo $status[$lesson['Lesson']['IsBlocked'] == 1 ? 3 : 1]?></label>
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

	function block_lesson(target, e) {
		e = $.event.fix(e);
		e.preventDefault();
		var submit_data = [];
		$("#lesson-table tbody tr").each(function(){
			if ($(this).find("input").is(":checked")) {
				submit_data.push(parseInt($(this).find("td:eq(1)").html()));
			}
		});
		if (submit_data.length == 0) { 
			alert("No selected!");
		} else {
			$.ajax({
	           type: "POST",
	           url: '/elearning/admin/updateLesson/block',
	           data: {'data':submit_data },
	           success: function(data)
	           {
					data = $.parseJSON(data);
					$("#lesson-table tbody tr").each(function(){
						if ($(this).find("input").is(":checked")) {
				 			$(this).find("td:last").html("<label class='label label-sm label-warning line-8' >Blocked</label>");
						}
					});
	           }
	       	});
		}
	}

	function active_lesson(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var buff = [];
		var submit_data = [];
		$("#lesson-table tbody tr").each(function(){
			if ($(this).find("input").is(":checked")) {
				submit_data.push(parseInt($(this).find("td:eq(1)").html()));
			}
		});
		console.log(submit_data);
		$.ajax({
           type: "POST",
           url: '/elearning/admin/updateLesson/active',
           data: {'data':submit_data },
           success: function(data)
           {
				data = $.parseJSON(data);
				$("#lesson-table tbody tr").each(function(){
					if ($(this).find("input").is(":checked")) {
						$(this).find("td:last").html("<label class='label label-sm label-success line-8' >Active</label>");
					}
				});

           }
       	});
	}

	function report_lesson(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var buff = [];
		var submit_data = [];
		$("#lesson-table tbody tr").each(function(){
			if ($(this).find("input").is(":checked")) {
				submit_data.push(parseInt($(this).find("td:eq(1)").html()));
			}
		});
		console.log(submit_data);
		$.ajax({
           type: "POST",
           url: '/elearning/admin/updateLesson/report',
           data: {'data':submit_data},
           success: function(data)
           {
				alert("Report lessons successful!")
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