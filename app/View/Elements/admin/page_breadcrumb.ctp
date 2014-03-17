<?php
$page_breadcrumb_title = isset($page_breadcrumb['title']) ? $page_breadcrumb['title'] : "page_breadcrumb_title is not set";
$page_breadcrumb_direct = isset($page_breadcrumb['direct']) ? $page_breadcrumb['direct'] : array('Home', 'Your_Page_Here');
?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			<?php echo $page_breadcrumb_title ?><span class="margin-left-20"><small><?php echo date('d/m/Y h:i:s a', time());?></small></span>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="/elearning/admin/home"><?php echo $page_breadcrumb_direct[0]?></a> 
			</li>
			<?php 
				$page_breadcrumb_direct = array_slice($page_breadcrumb_direct, 1);
				foreach ($page_breadcrumb_direct as $buff) {
			?>
			<li>
				<i class="fa fa-angle-right"></i>
				<a href="/elearning/admin/<?php echo $buff == 'Your_Page_Here' ? 'home' : $buff?>"><?php echo $buff?></a>				
			</li>
			<?php
				}
			?>			
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>