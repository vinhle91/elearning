<div class="portlet">
	<div class="portlet-title padding-top-8">
		<div class="caption padding-top-3">
			<i class="fa fa-book"></i>Uploaded lessons
		</div>
		<div class="tools">
			<span class="pull-left" style="padding-right: 20px">Sort by: Last update | Total 6  • Page 1</span>
			<div class="pull-right no-list-style">
				<li class="dropdown menu-right" id="header_notification_bar">
					<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>Options</span>
					
					<ul class="dropdown-menu extended" style="width: 200px !important">
						<li>
							<ul class="dropdown-menu-list no-space no-list-style">
								<li>  
									<a link="">
									<span class="label label-sm label-icon label-warning disabled"><i class="fa fa-pencil"></i></span>
									Block selected lessons
									</a>
								</li>
								<li>  
									<a link="">
									<span class="label label-sm label-icon label-danger disabled"><i class="fa fa-ban"></i></span>
									Remove selected lessons
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
			<table class="table table-striped table-bordered table-hover">
				<thead>
				<tr>
					<th>
						<input type="checkbox" class="checkbox">
					</th>
					<th scope="col">
						ID
					</th>
					<th scope="col">
						Title
					</th>
					<th scope="col">
						Category
					</th>
					<th scope="col" style="width: 200px;">
						Abstract
					</th>
					<th scope="col">
						Author
					</th>
					<th scope="col">
						Created
					</th>
					<th scope="col">
						Liked
					</th>
					<th scope="col">
						Viewed
					</th>
					<th scope="col">
						Reported
					</th>
				</tr>
				</thead>
				<tbody>
					<?php if (isset($all_lessons) && $all_lessons['Total'] != 0) { ?>
						<?php foreach ($all_lessons['Data'] as $key => $lesson) { ?>
						<tr>
								<th>
								<input type="checkbox" class="checkbox">
							</th>
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
								NULL
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
								NULL
							</td>
						</tr>
						<?php } ?>
					<?php } ?>					
				</tbody>
			</table>
		</div>
	</div>
</div>