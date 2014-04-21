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
					<td></td>
					<td><input type="password" name="password2" class="form-control placeholder-no-fix" placeholder="" id="password2"></input></td>
				</tr>
				<tr>
					<td>新しいパスワード</td>
					<td><input type="password" name="new_password" class="form-control placeholder-no-fix" placeholder="" id="new_password"></input></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" class="btn btn-info btn-sm button-save pull-right" value="保存"></input>
	</form>
</div>

<script>
$(".change-password-form").validate({
	rules: {
        password1: {
            required: true,
        },
        password2: {
            required: true,
        },
        new_password: {
            required: true,
            maxlength: 16,
            minlength: 4,
        },
    },
    messages: {
        password1: {
        	required: "古いパスワードを入力してください！",
        },
        password2: {
            required: "もう一度古いパスワードを入力してください！",
        },
        new_password: {
            required: "新しいパスワードを入力してください！",
            minlength: "少なくとも4文字を入力してください。",
            maxlength: "これ以上16文字以内で入力してください。"
        },
    },
    errorPlacement: function (error, element) {
        error.appendTo(element.parent());
    },

});

$("#change-password-form").live("submit", function(e){
	if ($("#change-password-form").validate().checkForm() == false) {
		return;
	} else {
			var url = "/elearning/admin/updateUserInfo/update";
		var submit_data = {
			UserId: "<?php echo $moderatorInfo['UserId']?>",
		};
		// submit_data.Password = $('#Password').text();
		submit_data.Birthday = "'"+$("#BirthdayYear").val()+'-'+$("#BirthdayMonth").val()+'-'+$("#BirthdayDay").val()+"'";
		submit_data.FullName = "'"+$('#FullName').val().trim()+"'";
		submit_data.Gender = "'"+$('#Gender').val().trim()+"'";
		submit_data.Email = "'"+$('#Email').val().trim()+"'";
		submit_data.BankInfo = "'"+$('#BankInfo').val().trim()+"'";
		submit_data.Address = "'"+$('#Address').val().trim()+"'";
		console.log(submit_data);

		$(".update-notif span").css({"visibility": "visible", "opacity": 1});
		$(".user-info .update-notif span").text("情報が更新...");
		$(".ajax-loader").fadeIn(10);
		$(".button-save").addClass("disabled");

	    $.ajax({
	           type: "POST",
	           url: url,
	           data: submit_data, 
	           success: function(data)
	           {
					$(".ajax-loader").fadeOut(10);
					data = $.parseJSON(data);
	               	if (data.result == "Success") {
               			$(".user-info .update-notif span").text("更新が成功した。");
               			setTimeout(function(){
               				//$(".user-info .update-notif span").text("");
               				$('.user-info .update-notif span').fadeTo(500, 0, function(){
							  	$('.user-info .update-notif span').css("visibility", "hidden");   
							});
               			}, 2000);
	               	} else if (data.result == "Fail") {
               			$(".user-info .update-notif span").text("更新が失敗した。");
	               		setTimeout(function(){
               				//$(".user-info .update-notif span").text("");
               				$('.user-info .update-notif span').fadeTo(500, 0, function(){
							  	$('.user-info .update-notif span').css("visibility", "hidden");   
							});
               			}, 2000);
	               	}
	           }
	         });
		e.preventDefault();
	    return false;
	}
});

</script>