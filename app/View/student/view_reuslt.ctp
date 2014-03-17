<div class="contents">
	<?php if ($this->Session->check('Message.flash')){ ?> 
		<div class="message_box"><?php echo $this->Session->flash(); ?></div>
	<?php } ?>
	<div class="btnlst_small">
		<a class="btn" href="/qlbh/qlnv/add">Thêm nhân viên</a>		
	</div>
	<div class="tit_blck1"><h3 class="tit"> Danh sách nhân viên </h3>
		<div class="onTit"></div>
	</div>	
	<div class="bd_cmm1 clearfix">														
		<div class="dataTable">
			<table id="qlkhTable">
				<thead>
					<th>Mã nv</th>
					<th>Tên nhân viên</th>
					<th>Điện thoại</th>
					<th>Địa chỉ</th>
					<th>Phân quyền</th>
					<th>Ghi chú</th>
					<th>Quản lý</th>
				</thead>
				<tbody>
					<?php foreach ($list_user as $key => $value):?>					
					<tr>
						<td><?php echo $value['Nhanvien']['nv_ms']?></td>
						<td>
							<?php  echo $this->Html->link($value['Nhanvien']['nv_ten'], 
							array('controller'=>'qlnv','action' => 'detail',$value['Nhanvien']['nv_ms']));
							?>
						</td>
						<td><?php echo $value['Nhanvien']['nv_phone']?></td>
						<td><?php echo $value['Nhanvien']['nv_diaChi']?></td>
						<td>
							<?php if($value['Nhanvien']['nv_role'] == 1){
								echo 'Admin';
							}else if($value['Nhanvien']['nv_role'] == 2){
								echo 'Quản lý kho';
							}else{
								echo 'Quản lý bán hàng';
							}
							?>
						</td>
						<td><?php echo $value['Nhanvien']['nv_ghiChu']?></td>
						<td align="center">
							<div class="managebtn_box">
								<ul class="clearfix">
									<li><a href="/qlbh/qlnv/detail/<?php echo $value['Nhanvien']['nv_ms']; ?>" title="<?php echo __('Detail'); ?>" ><?php echo $this->Html->image("btn_detail.gif", array("alt" => "Chi tiết"));?></a></li>
									<li><a href="/qlbh/qlnv/edit/<?php echo $value['Nhanvien']['nv_ms']; ?>" title="<?php echo __('Edit'); ?>" ><?php echo $this->Html->image("btn_edit.gif", array("alt" => "Sửa"));?></a></li>
									<li><a href="/qlbh/qlnv/delete/<?php echo $value['Nhanvien']['nv_ms']; ?>"  title="<?php echo __('Delete'); ?>" ><?php echo $this->Html->image("btn_del.gif", array("alt" => "Xóa"));?></a></li>
								</ul>
							</div>
						</td>
					</tr>
					<?php endforeach;?>		
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
 $('#qlkhTable').fixheadertable({ 
		height : 400,  
		colratio : [50, 150, 100, 250,150,450,100], 
		zebra : true, 
		sortable : true,
		showhide	 : true,
		sortedColId : 1, 
		resizeCol : true,
		pager : true,
		rowsPerPage	 : 10,
		sortType : ['integer', 'string'],
		dateFormat : 'm/d/Y'
	});
</script>