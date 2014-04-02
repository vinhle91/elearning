<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>

<div class="row padding-20">
	<div class="tabbable tabbable-custom tabbable-custom-profile col-md-9">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_11" data-toggle="tab">Payment Summary</a>
			</li>
			<li class="">
				<a href="#tab_1_22" data-toggle="tab">今日</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_11">

				<div class="nav portlet-title padding-top-8" style="padding:10px 10px 2px 10px;  height: 38px;">
					<div class="caption"><i class="fa fa-calendar margin-right-5"></i><?php echo date("M Y")?></div>
					<div class="pull-right">
						
						<span>年: </span>
						<select class=" margin-right-3">
							<option>2014</option>
							<option>2013</option>
						</select>

						<span>月: </span>
						<select class=" margin-right-3">
							<option>01</option>
							<option>02</option>
							<option>03</option>
							<option>04</option>
							<option>05</option>
							<option>06</option>
							<option>07</option>
							<option>08</option>
							<option>09</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
						</select>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table margin-top-10" style="width: 300px">
							<tbody>
								<tr>
									<td class="">から </td>
									<td class="col-md-5">01 Jan 2014</td>
								</tr>
								<tr>
									<td>まで </td>
									<td>31 Jan 2014</td>
								</tr>
								<tr>
									<td>Total transactions</td>
									<td><?php echo $payment_summary['Total'] ?></td>
								</tr>
								<tr>
									<td>すべての学生</td>
									<td>4</td>
								</tr>
								<tr>
									<td>すべての先生</td>
									<td>3</td>
								</tr>
								<tr>
									<td>Profits</td>
									<td><?php echo $payment_summary['Earn'] ?> VND</td>
								</tr>
							</tbody>
						</table>

						<a type="reset" class="btn btn-sm btn-info cancel pull-right" style="margin-top: -50px; margin-right: 0px"><i class="fa fa-save margin-right-5"></i><span>ファイルに保存</span></a>

						<table class="table table-striped table-bordered table-advance table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Transaction time</th>
									<th>授業</th>
									<th>学生</th>
									<th>先生</th>
									<th><i class="fa fa-bookmark margin-right-5"></i>課金 (VND)</th>
								</tr>
							</thead>
							<tbody>
							<?php $this->log($payment_summary) ?>
							<?php if (isset($payment_summary)) { ?>
								<?php foreach ($payment_summary['Data'] as $key => $buff) { ?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td><?php echo $buff['Transaction']['StartDate'] ?></td>
									<td><?php echo $buff['Lesson']['Title'] ?></td>
									<td><a href="/elearning/admin/student/<?php echo $buff['Student']['Username'] ?>"><?php echo $buff['Student']['Username'] ?></a></td>
									<td><a href="/elearning/admin/teacher/<?php echo $buff['Lesson']['Author']['Username'] ?>"><?php echo $buff['Lesson']['Author']['Username'] ?></a></td>
									<td class="align-right"><?php echo $buff['Transaction']['CourseFee'] ?><span class="margin-left-5 label label-<?php echo date($buff['Transaction']['ExpiryDate']) > date('Y-m-01') ? "warning" : "success"  ?> label-sm"><?php echo date($buff['Transaction']['ExpiryDate']) > date('Y-m-01') ? "Not paid" : "Paid"  ?></span></td>
								</tr>
								<?php } ?>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
					
			</div>
			<div class="tab-pane" id="tab_1_22">
				<div class="nav portlet-title padding-top-8" style="padding:10px 10px 2px 10px;  height: 38px;">
					<div class="caption"><i class="fa fa-calendar margin-right-5"></i><?php echo date("d M Y")?></div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-advance table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th class="col-md-4">Transaction date</th>
									<th>Lesson</th>
									<th>Student</th>
									<th>Teacher</th>
									<th><i class="fa fa-bookmark margin-right-5"></i>Amount (VND)</th>
								</tr>
							</thead>
							<tbody>
							<?php if (isset($today)) { ?>
								<?php foreach ($today['Data'] as $key => $buff) { ?>
								<tr>
									<td><?php echo $key + 1 ?></td>
									<td><?php echo $buff['Transaction']['StartDate'] ?></td>
									<td><?php echo $buff['Lesson']['Title'] ?></td>
									<td><a href="/elearning/admin/student/<?php echo $buff['Student']['Username'] ?>"><?php echo $buff['Student']['Username'] ?></a></td>
									<td><a href="/elearning/admin/teacher/<?php echo $buff['Lesson']['Author']['Username'] ?>"><?php echo $buff['Lesson']['Author']['Username'] ?></a></td>
									<td class="align-right"><?php echo $buff['Transaction']['CourseFee'] ?><span class="margin-left-5 label label-<?php echo date($buff['Transaction']['ExpiryDate']) > date('Y-m-01') ? "warning" : "success"  ?> label-sm"><?php echo date($buff['Transaction']['ExpiryDate']) > date('Y-m-01') ? "Not paid" : "Paid"  ?></span></td>
								</tr>
								<?php } ?>
							<?php } else { ?>

							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>			
	</div>
	
	<!-- END TABTABLE-->

	<div class="col-md-3 pull-right margin-top-20">
	<?php if (isset($overview)) { ?>
		<div class="portlet payment-summary">
			<div class="portlet-title">
				<div class="caption">
					 <i class="fa fa-bookmark"></i> 概要
				</div>
				<div class="tools">
					<a class="reload" href="javascript:;"></a>
				</div>
			</div>
			<div class="portlet-body">
				<ul class="list-unstyled">
					<li>
						<span class="sale-info">
							今日  <i class="fa fa-img-up"></i>
						</span>
						<span class="sale-num">
							 <?php echo number_format($overview['Today'])?>
						</span>
					</li>
					<li>
						<span class="sale-info">
							週間 <i class="fa fa-img-down"></i>
						</span>
						<span class="sale-num">
							 <?php echo number_format($overview['Lastweek'])?>
						</span>
					</li>
					<li>
						<span class="sale-info">
							 合計
						</span>
						<span class="sale-num">
							 <?php echo number_format($overview['Total'])?>
						</span>
					</li>
					<li>
						<span class="sale-info">
							 課金
						</span>
						<span class="sale-num">
							 <?php echo number_format($overview['Earn'])?>
						</span>
					</li>
					<li>
						<span class="sale-caption" style = "width: 100px;">
							 Sharing rate
						</span>
						<span class="sale-num" style="font-size: 14px;">
							 <?php echo $CONFIG_SHARING_RATE?> %
						</span>
					</li>
				</ul>
			</div>
		</div>
	<?php } ?>
	</div>	
</div>