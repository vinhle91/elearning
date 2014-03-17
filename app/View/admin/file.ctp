<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Uploaded Files
		</div>
		<div class="tools">
			<span class="pull-left" style="padding-right: 20px">Sort by: Last update | Total 6 files • Page 1</span>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="collapse"></a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th scope="col">
							File ID
						</th>
						<th scope="col">
							<a link="">Lesson</a>
						</th>
						<th scope="col">
							File Link
						</th>
						<th scope="col">
							File Extension
						</th>
						<th scope="col">
							<a link="">Uploader</a>
						</th>
						<th scope="col">
							<a link="">Created time</a>
						</th>
						<th scope="col">
							<a link="">Last update</a>
						</th>
						
					</tr>
				</thead>
				<tbody>
				<?php if (isset($all_files) && $all_files['Total'] != 0) { ?>
					<?php foreach ($all_files['Data'] as $key => $file) { ?>
					<tr>
						<td>
							<?php echo $file['File']['FileId']?>
						</td>
						<td>
							<a href="/elearning/admin/lesson/<?php echo $file['File']['LessonId']?>"><?php echo $file['File']['LessonId']?></a>
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
					</tr>
					<?php } ?>
				<?php } ?>
				
				</tbody>
			</table>
		</div>
	</div>
</div>