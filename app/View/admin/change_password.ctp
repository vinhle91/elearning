<?php 
	// css file
	echo $this->Html->css(array(
		'font-awesome.min',
		'bootstrap/bootstrap',
		'uniform.default',
		'style-conquer',
		'style-responsive',
		'app',
		'jquery.fancybox'
	));
	// Js file
	echo $this->Html->script(array(
		'jquery-1.9.0.min',
		'jquery-migrate-1.2.1.min',
		'bootstrap',
		'jquery.blockui.min',
		'jquery.cookie.min',
		'jquery-ui.min.js',
		'jquery.metadata',
		'jquery.tablesorter',
		'jquery.tablesorter.min',
		'jquery.slimscroll.min',
		'bootstrap-typeahead',
		'jquery.validate.min',
		'jquery.fancybox',
		'jquery.fancybox.pack'
	)); 
?>
<div class="change-password">
	<form class="change-password-form">

		<table id="user" class="table table-striped">
			<tbody>
				<tr>
					<td>古いパスワード</td>
					<td><input type="password" name="password1" class="form-control placeholder-no-fix" placeholder="" id="password1"></input></td>
				</tr>
				<tr>
					<td>新しいパスワード</td>
					<td><input type="password" name="new_password" class="form-control placeholder-no-fix" placeholder="" id="new_password"></input></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="password" name="new_password2" class="form-control placeholder-no-fix" placeholder="" id="new_password2"></input></td>
				</tr>
			</tbody>
		</table>
		<div class="update-notif">
			<span></span>
			<label class="ajax-loader"></label>
		</div>
		<input type="submit" class="btn btn-info btn-sm button-save pull-right" value="保存"></input>
	</form>
</div>

<script>
$(".change-password-form").validate({
	rules: {
        password1: {
            required: true,
        },
        new_password: {
            required: true,
            maxlength: 16,
            minlength: 4,
        },
        new_password2: {
            required: true,
        },
    },
    messages: {
        password1: {
        	required: "古いパスワードを入力してください！",
        },
        new_password: {
            required: "新しいパスワードを入力してください！",
            minlength: "少なくとも4文字を入力してください。",
            maxlength: "これ以上16文字以内で入力してください。"
        },
        new_password2: {
            required: "新しいパスワードを入力してください！",
        },
    },
    errorPlacement: function (error, element) {
        error.appendTo(element.parent());
    },

});

$(".change-password-form").live("submit", function(e){
	if ($(".change-password-form").validate().checkForm() == false) {
		return false;
	} else {
		e.preventDefault();
		var url = "/elearning/admin/changePassword";
		var submit_data = {};

		submit_data.UserId = "<?php echo $userid?>";
		submit_data.old_password = $('#password1').val().trim();
		submit_data.new_password = $('#new_password').val().trim();

		if (submit_data.new_password != $('#new_password2').val().trim()) {
			$(".update-notif span").text("新しいパスワードが一致しない。");
           		setTimeout(function(){
       				$('.update-notif span').fadeTo(500, 0, function(){
					  	$('.update-notif span').css("visibility", "hidden");   
					});
       			}, 3000);
       		return false;
		}

		$(".update-notif span").css({"visibility": "visible", "opacity": 1});
		$(".update-notif span").text("情報が更新...");
		$(".ajax-loader").fadeIn(10);

	    $.ajax({
	           type: "POST",
	           url: url,
	           data: submit_data, 
	           success: function(data)
	           {
					$(".ajax-loader").fadeOut(10);
					data = $.parseJSON(data);
	               	if (data.result == "Success") {
               			$(".update-notif span").text("更新が成功した。");
               			setTimeout(function(){
               				$('.update-notif span').fadeTo(500, 0, function(){
							  	$('.update-notif span').css("visibility", "hidden");   
							});
                            parent.$.fancybox.close();
               			}, 3000);
	               	} else if (data.result == "Fail") {
               			$(".update-notif span").text("更新が失敗した！");
               			$(".update-notif span").append("<p>"+data.msg+"</p>");
	               		setTimeout(function(){
               				$('.update-notif span').fadeTo(500, 0, function(){
							  	$('.update-notif span').css("visibility", "hidden");   
							});
             3 			}, 2000);
	               	}
	           }
	         });
		return false;
	}
});

</script>