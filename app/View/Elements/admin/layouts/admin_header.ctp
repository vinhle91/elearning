<?php 
function time_elapsed_string($ptime)
{
    $etime = time() - strtotime($ptime);

    if ($etime < 1)
    {
        return 'Just now';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}
?>

	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<a class="navbar-brand" href="">
		<p>E-learning システム</p>
		</a>

		<!-- Search Form -->
		<!-- <form class="search-form search-form-header" role="form" action="">
			<div class="input-icon right">
				<i class="fa fa-search"></i>
				<input type="text" class="form-control input-medium input-sm" name="query" placeholder="検索 ...">
			</div>
		</form> -->

		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
			<!-- BEGIN NOTIFICATION DROPDOWN -->
			<li class="dropdown" id="header_notification_bar">
				<a href="//elearning/admin/student" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<i class="fa fa-envelope-o"></i>
				<span class="badge"><?php echo isset ($nmsg) ? $nmsg : '0' ?></span>
				</a>
				<ul class="dropdown-menu extended notification">
				<?php if (isset($notifs) && count($notifs) > 0) { ?>
					<li>
						<p class="notification-header"><?php echo $nmsg?> 新しいお知らせ</p>
					</li>
					<li>
						<ul class="dropdown-menu-list scroller" style="height: 165px; overflow: hidden; width: auto;">
							<?php foreach ($notifs as $notif) : ?>
							<li>
								<a href="<?php echo $msg_link[$notif['Msg']['MsgType']]?>" class='<?php if ($notif['Msg']['IsReaded']  == 0) echo "not-read"?>' msgId = "<?php echo $notif['Msg']['MsgId']?>" onclick="confirmReaded(this, event)">
									<span class="label label-sm label-icon label-<?php echo $status_label[$notif['Msg']['MsgType']]?>"><i class="fa fa-<?php echo $fa_label[$notif['Msg']['MsgType']]?>"></i></span>
										<?php echo $notif['Msg']['Content'] ?>
									<span class="time pull-right"><?php echo time_elapsed_string($notif['Msg']['created'])?></span>
								</a>
							</li>		
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="external">   
						<a href="//elearning/admin/student" class="no-padding-left" style="font-size: 12px">すべて知らせを表示<i class="fa fa-angle-right"></i></a>
					</li>
				<?php } else { ?>
					<li>
						<p><?php echo __("You don't have any notification") ?></p>
					</li>
					<li class="external">   
						<a href="//elearning/admin/student">　近く知らせを表示　<i class="fa fa-angle-right"></i></a>
					</li>
				<?php } ?>
				</ul>
			</li>
			<!-- END NOTIFICATION DROPDOWN -->
		
			<li class="devider">&nbsp;</li>
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="//elearning/admin/student" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<?php echo $this->Session->read('User.ImageProfile') && $this->Session->read('User.ImageProfile')!="" ? $this->Session->read('User.ImageProfile') : $this->html->image('photo/no-avatar.jpg', array('class' => 'avatar'))?>

				<span class="username"><?php echo $this->Session->read('User.Username') ? $this->Session->read('User.Username') : null ?></span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="/elearning/admin/moderator/<?php echo $this->Session->read('User.Username') ? $this->Session->read('User.Username') : null?>"><i class="fa fa-user"></i> プロフィール</a>
					</li>
					<li class="divider"></li>
					<li><a href="/elearning/admin/logout"><i class="fa fa-key"></i>　ログアウト </a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>

<script>
	$(".dropdown-menu-list").slimScroll({
        height: '250px'
    });
	function confirmReaded(target, e) {
		submit_data = {msgId: $(target).attr("msgId")};
		$.ajax({
           type: "POST",
           url: '/elearning/admin/updateUserInfo/msg',
           data: submit_data, 
           success: function(data)
           {
				data = $.parseJSON(data);
				alert(data);
               	if (data.result == "Success") {

               	} else if (data.result == "Fail") {

               	}
           }
        });
	}


</script>