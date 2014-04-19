<?php echo $this->html->script(array('createTsv'))?>

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
?>

<div class="tabbable tabbable-custom tabbable-custom-profile col-md-9">
	<ul class="nav nav-tabs">
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1_11">

				<div class="nav portlet-title padding-top-8" style="padding:10px 10px 2px 10px;  height: 38px;">
					<div class="caption"><i class="fa fa-calendar margin-right-5"></i><span id="payment-date"><?php echo date("M Y")?></span></div>
					<div class="pull-right" id="date-picker">						
						<span>年: </span>
						<select class=" margin-right-3" id="payment-year">
							<option>2014</option>
							<option>2013</option>
						</select>

						<span class="margin-left-5">月: </span>
						<select class="margin-right-3" id="payment-month" onchange="getTransInMonth($('#payment-year').val(), this.value)">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
						</select>

						<a class="reload" href="javascript:;"></a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table margin-top-10" style="width: 400px">
							<tbody>
								<tr>
									<td class="">最初トランザクション</td>
									<td class="col-md-5" id="payment-first"><?php echo ($payment_summary['Start']) ? date_format(date_create($payment_summary['Start']), 'd M Y H:m:s') : null?></td>
								</tr>
								<tr>
									<td>最後トランザクション </td>
									<td id="payment-last"><?php echo $payment_summary['End'] ? date_format(date_create($payment_summary['End']), 'd M Y H:m:s') : null?></td>
								</tr>
								<tr>
									<td>総トランザクション</td>
									<td id="payment-total"><?php echo $payment_summary['Total'] ?></td>
								</tr>
								<tr>
									<td>すべての学生</td>
									<td id="payment-total-teacher"><?php echo $payment_summary['TotalStudent'] ?></td>
								</tr>
								<tr>
									<td>すべての先生</td>
									<td id="payment-total-student"><?php echo $payment_summary['TotalTeacher'] ?></td>
								</tr>
								<tr>
									<td>報酬％</td>
									<td id="payment-earn"><?php echo $payment_summary['Earn'] ?> VND</td>
								</tr>
							</tbody>
						</table>

						<a type="reset" class="btn btn-sm btn-info cancel pull-right" style="margin-top: -50px; margin-right: 0px" onclick="$('#payment-data').table2TSV({output: 'popup', year: $('#payment-year').val(), month: $('#payment-month').val()})"><i class="fa fa-save margin-right-5"></i>
							<span>ファイルに保存</span>
						</a>
						<div class="clear-fix"></div>
						<table class="table table-striped table-bordered table-advance table-hover" id = "payment-data">
							<thead>
								<tr>
									<th>#</th>
									<th>トランザクション時間</th>
									<th>授業</th>
									<th>学生</th>
									<th>先生</th>
									<th><i class="fa fa-bookmark margin-right-5"></i>課金 (VND)</th>
								</tr>
							</thead>
							<?php if (isset($payment_summary) && $payment_summary['Total'] != 0) { ?>
							<tbody>
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
							</tbody>
							<?php } else { ?>
							<tbody>
								<tr>
                                    トランザクションがない
								</tr>
							</tbody>
							<?php } ?>
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
							 報酬％
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
<script>
function getTransInMonth(year, month){
	months = new Array();
	months[0] = "January";
	months[1] = "February";
	months[2] = "March";
	months[3] = "April";
	months[4] = "May";
	months[5] = "June";
	months[6] = "July";
	months[7] = "August";
	months[8] = "September";
	months[9] = "October";
	months[10] = "November";
	months[11] = "December";
	$.ajax({
		type: "POST",
		url: "/elearning/admin/payment/getTransInMonth",
		data: {Year: year, Month: month},
		success: function(data) {
			console.log(data);
			window.abc = data;
			data = $.parseJSON(data);

			if (data.result == "Success") {
				$("#payment-date").html(months[month-1] + " " + year);	
				$("#payment-first").html(data.data.Start);
				$("#payment-last").html(data.data.End);
				$("#payment-total").html(data.data.Total);
				$("#payment-total-teacher").html(data.data.TotalTeacher);
				$("#payment-total-student").html(data.data.TotalStudent);
				$("#payment-earn").html(data.data.Earn);
				fillData(data.data);
			} else {
				alert("Fail");
			}

		}
	})
}

function fillData(data) {
	$("#payment-data tbody").html("");
	date = new Date();
	var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var label = new Array();
	$.each(data.Data, function(index, value){
		console.log(index);
		console.log(value);
		if (value.Transaction.ExpiryDate > firstDay) {
			label['style'] = "warning";
			label['text'] = "Not paid";
		} else {
			label['style'] = "success";
			label['text'] = "Paid";
		}
		$("#payment-data tbody").append(
		"<tr>" + 
			"<td>" + (index+1) + "</td>" + 
			"<td>" + value.Transaction.StartDate + "</td>" + 
			"<td>" + value.Lesson.Title + "</td>" + 
			"<td><a href='/elearning/admin/student/" + value.Student.Username + "'>" + value.Student.Username + "</a></td>" + 
			"<td><a href='/elearning/admin/teacher/" + value.Lesson.Author.Username + "'>" + value.Lesson.Author.Username + "</a></td>" + 
			"<td class='align-right'>" + value.Transaction.CourseFee + "<span class='margin-left-5 label label-" + label['style'] + " label-sm'>" + label['text'] + "</span></td>" + 
		"</tr>"

		);
	})


}

$(document).ready(function(){
	now = new Date();
	$("#payment-month").val((now.getMonth()+1).toString());
	$("#payment-year").val(now.getYear().toString());
});




</script>
