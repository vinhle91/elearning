<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			<!-- <?php echo date('d/m/Y', time());?> -->
            <?php echo date('Y年 m月 d日', time());?>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="/elearning/admin/home">ホーム</a>
			</li>			
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>


<?php 
$paid = array('Unpaid', 'Paid');
$paid_label = array('warning', 'success');

$transactions = array(
	'total_student' => '1',
	'total_teacher' => '1',
	'total_profit' => '40000',
	'data' => array(
			array(
				'date' => date('d/m/Y', time()),
				'lesson' => 'ls001',
				'student' => 'lucilucency',
				'teacher' => 'gondai',
				'cost' => '20000',
				'paid' => 1
				),
			array(
				'date' => date('d/m/Y', time()),
				'lesson' => 'ls001',
				'student' => 'lucilucency',
				'teacher' => 'gondai',
				'cost' => '20000',
				'paid' => 0
				)
			)
		)

?>

<div class="tabbable tabbable-custom tabbable-custom-profile col-md-9">
	<ul class="nav nav-tabs">
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
	</div>			
</div>

<div class="col-md-3 pull-right no-padding-right">
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

	<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-user"></i>今日中新しい学生</div>
							<div class="tools">
								<a href="javascript:;" class="reload"></a>
							</div>
						</div>
						<?php if (isset($new_students) && $new_students['Total'] != 0) { ?>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>氏名</th>
											<th>ユーザー名</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($new_students['Data'] as $key => $new_student) { ?>
										<tr>
											<td><a href="/elearning/admin/student/<?php echo $new_student['User']['Username']?>"><?php echo $new_student['User']['FullName']?></a></td>
											<td><a href="/elearning/admin/student/<?php echo $new_student['User']['Username']?>"><?php echo $new_student['User']['Username']?></a></td>
											<td><span class="label label-sm label-<?php echo $status_label[$new_student['User']['Status']]?> line-6"><?php echo $status[$new_student['User']['Status']]?></span></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php }  else { ?>
						<div class="portlet-body">
							今日は新しい学生がいません。
						</div>
						<?php } ?>
					</div>
</div>