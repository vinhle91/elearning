<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<script type="text/javascript">
    $(function() {
        $("table").tablesorter({debug: true});
    });
</script>
<?php if (!isset($moderatorInfo)) { ?>
<div class="moderator">
	<form id="all-moderator">
		<div class="col-md-7">
			<div class="portlet">
				<div class="nav portlet-title padding-top-8">
					<div class="caption">すべての管理者</div>
					<div class="pull-right">
						<li class="dropdown" id="header_notification_bar">
							<a href="#" class="btn btn-info btn-xs" id="add-mod" onclick="addModerator(event)"><i class="fa fa-plus"></i>追加</a>
						</li>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
					<?php if (isset($all_moderators) && $all_moderators['Total'] != 0) { ?>

						<table class="table table-hover" id="mod-tbl">
							<thead>
								<tr>
									<th class="col-md-1">#</th>
									<th class="col-md-3">ユーザー名</th>
									<th class="col-md-3">登録日時</th>
									<!-- <th class="col-md-3">状態</th> -->
									<th class="col-md-3"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($all_moderators['Data'] as $key => $moderator) { ?>
								<tr>
									<td class="col-md-1"><?php echo $key + 1?></td>
									<td class="col-md-3"><a href="/elearning/admin/moderator/<?php echo $moderator['User']['Username']?>"><?php echo $moderator['User']['Username']?></a></td>
									<td class="col-md-3"><?php echo $moderator['User']['created']?></td>
									<!-- <td><label class="line-8 label label-sm label-<?php echo $moderator['User']['IsOnline'] == 1 ? "success" : "default disabled"?>"><?php echo $moderator['User']['IsOnline'] == 1 ? "Online" : "Offline"?></label></td> -->
									<td class="col-md-3"><a type="reset" class="btn btn-xs btn-warning cancel pull-right <?php if ($moderator['User']['Username'] == $this->Session->read('User.Username')) echo "disabled"?>" onclick="removeUser(event)"><span>削除</span></a></td>
								</tr>	
								<?php } ?>
							</tbody>
						</table>
						<div class="update-notif">
							<span></span>
							<label class="ajax-loader"></label>
						</div>
					<?php } else {?>
					<div>
						NO ADMIN!
					</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('#all-moderator').validate({
	    rules: {
	        username: {
	            required: true,
	        },
	        password1: {
	            required: true,
	            minlength: 4,
	            maxlength: 16,
	        },
	        password2: {
	        	required: true,
	        }
	    },
	    messages: {
	        username: {
	        	required: "ユーザー名を入力してください。"
	        },
	        password1: {
	            required: "パスワードを入力してください。",
	            minlength: "少なくとも4文字を入力してください。",
	            maxlength: "これ以上16文字以内で入力してください。"
	        },
	        password2: {
	        	required: true,
	        }
	    },
	    errorPlacement: function (error, element) {
	        error.appendTo(element.parent());
	    },
	});


	function addModerator(e) {
		e = $.event.fix(e);
		e.preventDefault();
		var next = parseInt($("#mod-tbl tr:last td:first").html()) + 1;
		var buff = 		'<tr>'
						+ '<td class="col-md-1">' + next + '</td>'
						+ '<td class="col-md-3"><input type="text" name="username" rows="1" class="no-border mod-info name padding-3" style="resize: none; width: 150px; margin-top: 3px;" id="username" placeholder="ユーザー"></input></td>'
						+ '<td class="col-md-3"><input type="password" name="password1" id="password1" rows="1" class="no-border mod-info password padding-3" style="resize: none; width: 150px; margin-top: 3px;" id="password" placeholder="パスワード"></input><input type="password" name="passwor2" id="password2" rows="1" class="no-border mod-info password padding-3" style="resize: none; width: 150px; margin-top: 3px;" id="password" placeholder="パスワード"></input></td>'
						+ '<td class="col-md-3"><a href="#" class="btn btn-xs btn-warning margin-left-5 pull-right" onclick="cancel(event)"><?php echo __("キャンセル")?></a><input type="submit" class="pull-right btn btn-xs btn-success" value="<?php echo __("保存") ?>"></input></td>'
						+ '</tr>';
		$("#add-new-mod").addClass("disabled");
		$("#mod-tbl tr:last").after(buff);
		$("#mod-tbl tr:last td:eq(1) input").focus();
	}

	function removeUser(event) {
		parent = $(event.target).closest("tr");
		submit_data = parent.find("td:eq(1) a").html();
		r = confirm("このユーザーを削除しますか?");		
		if (r == true) {
			$("#moderator .update-notif span").css({"visibility": "visible", "opacity": 1});
			$("#moderator .update-notif span").text("削除している...");
			$("#moderator .ajax-loader").fadeIn(10);
			$("#moderator .button-save").addClass("disabled");
			$.ajax({
	           type: "POST",
	           url: "/elearning/admin/updateUserInfo/remove",
	           data: {Username: submit_data}, 
	           success: function(data)
	           {
					$(".ajax-loader").fadeOut(10);
					data = $.parseJSON(data);
	               	if (data.result == "Success") {
	               		$("#user-info .update-notif span").text("最新化が成功です。");
						parent.remove();
	               	} else if (data.result == "Fail") {
	               		$("#user-info .update-notif span").text("最新化が失敗しました。");
	               		
	               	}
	               	setTimeout(function(){
           				$('#user-info .update-notif span').fadeTo(500, 0, function(){
						  	$('#user-info .update-notif span').css("visibility", "hidden");   
						});
           			}, 2000);
	           }
	        });
		} 
	}

	$("#all-moderator").live("submit", function(e) {
		if ($("#all-moderator").validate().checkForm() == false) {
			return;
		} else {
			if ($("input#password1").val() != $("input#password2").val()) {
				$(".moderator .update-notif span").text("パスワードが一致しない。");
           		setTimeout(function(){
       				$(".moderator .update-notif span").text("");
       				$(".moderator .update-notif p").text("");
       			}, 4000);
       			return false;
			} else {
				console.log($("input#password1").val());
				console.log($("input#password2").val());
				$(".moderator .update-notif span").css("visibility", "visible");
				$(".moderator .update-notif").html("<span>情報が更新...</span>");
				$(".ajax-loader").fadeIn(10);
				
				var url = "/elearning/admin/updateUserInfo/insert";
				var submit_data = {
					Username: $("input.name").val(), 
					Password: $("input#password1").val(), 
					InitialPassword: $("input#password1").val(), 
					UserType: 3,
		            VerifyCodeQuestion: "Default Question",
		            InitialCodeQuestion: "12345678",
		            VerifyCodeAnswer: "Default Answer",
		            InitialCodeAnswer: "12345678",
		            Status: 1,
				};

				$.ajax({
			           type: "POST",
			           url: url,
			           data: submit_data, 
			           success: function(data)
			           {
							$(".ajax-loader").fadeOut(10);
							console.log(data);
							data = $.parseJSON(data);
							console.log(data);
			               	if (data.result == "Success") {
		               			$(".moderator .update-notif span").text("更新することは成功した");
		               			$("#mod-tbl tr:last td:eq(1)").html('<a href="/elearning/admin/moderator/'+$("#mod-tbl tr:last td:eq(1) input").val()+'">' + $("#mod-tbl tr:last td:eq(1) input").val() + '</a>');
								$("#mod-tbl tr:last td:eq(2)").html("<?php echo date('Y-m-d H:i:s', time())?>");
								$("#mod-tbl tr:last td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right" onclick="removeUser(event)"><span>削除</span></a>');
								$("#add-mod").removeClass("disabled");
		               			setTimeout(function(){
		               				$(".moderator .update-notif span").text("");
		               			}, 2000);
			               	} else if (data.result == "Fail") {
		               			$(".moderator .update-notif span").text("更新することは失敗した");
		               			$(".moderator .update-notif").append("<p><span>"+data.msg+"</span><p>");
			               		setTimeout(function(){
		               				$(".moderator .update-notif span").text("");
		               				$(".moderator .update-notif p").text("");
		               			}, 4000);
			               	}
			           }
			         });
			         
				e.preventDefault();
			    return false;
			}
		}
	});

	function cancel(e) {
		e = $.event.fix(e);
		e.preventDefault();
		$("#mod-tbl tr:last").remove();		
		$("#add-new-mod").removeClass("disabled");
	}

	$(document).ready(function(){
		$("input.mod-info").live("keypress", function(event) {
		    if (event.which == 13) {
		        event.preventDefault();
		        submitNewMod();
		    }
		});	
	});
</script>

<?php } else { //end if !isset($moderatorInfo) ?>
    <?php //have $moderatorInfo?>
    <div class="row">
        <div class="col-md-12">			
            <div class="row">
                <div class="note note-success user-info" style="margin-top:  20px;">
                    <div class="pull-left" style="padding: 10px">
                        <img class="imageThumb" src="<?php echo $moderatorInfo['ImageProfile'] ? $moderatorInfo['ImageProfile'] : '/elearning/img/photo/no-avatar.jpg' ?>" id="preview" width="96" height="96" style="margin-top: -50px;">
                    </div>
                    <h4 class="block" style="margin-bottom: 0; margin-top: -10px;"><?php echo $moderatorInfo['FullName'] ?></h4> 
                    <span class="gender male"></span><?php echo $moderatorInfo['Gender'] == 1 ? "男" : ($moderatorInfo['Gender'] == 2 ? "女":"他") ?>
                    <span class="bday"></span><?php echo $moderatorInfo['Birthday'] ?>
                    <span class="addr"></span><?php echo $moderatorInfo['Address'] ? $moderatorInfo['Address'] : "住所  <i class='margin-left-5'> </i>" ?>
                    <span class="phone"><label class="fa fa-phone"></label><?php echo $moderatorInfo['Phone'] ? $moderatorInfo['Phone'] : "<i class=''> </i>" ?></span>
                </div>
            </div>
            <?php if ($moderatorInfo['Status'] == 2) { ?>
                <div class = "handle-user pull-right">
                    <button class="btn btn-sm btn-info disabled pull-right" id = "notif-pending">
                        <i class='fa fa-exclamation-triangle margin-right-5'></i>
                        <span>
                            未確定
                        </span>
                    </button>
                    <button class="btn btn-sm btn-success margin-right-5 pull-right" id = "first-active">
                        <span>
                            アクティブ
                        </span>
                    </button>
                </div>			
            <?php } ?>
            <?php if ($moderatorInfo['Status'] == 0) { ?>
                <label class="label label-xl label-default pull-right">
                    <i class="fa fa-exclamation-triangle"></i>
                    <span>
                        削除
                    </span>
                </label>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <form id="user-info-form">
            <div class="col-md-6">
                <div class="portlet">
                    <div class="nav portlet-title padding-top-8">
                        <div class="caption"><i class="fa fa-reorder"></i><?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>'s 情報</div>
                        <?php if ($moderatorInfo['Status'] != 2 && $moderatorInfo['Status'] != 0) { ?>
                            <div class="pull-right no-list-style">
                                <li class="dropdown menu-left" id="options">
                                    <span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
                                    <ul class="dropdown-menu extended" style="width: auto !important; margin-left: 77px; margin-top: -50px;">
                                        <li>
                                            <ul class="dropdown-menu-list no-space no-list-style">
                                                <!-- <li>  
                                                        <a class="reset-pw" href="">
                                                        <span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-refresh"></i></span>
                <span class="inline-block">パスワードをリセット</span>
                                                        </a>
                                                </li>
                                                <li>  
                                                        <a class="reset-ver-cod" href="">
                                                        <span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-refresh"></i></span>
                <span class="inline-block">verifycodeをリセット<span>
                                                        </a>
                                                </li> -->
                                                <li>  
                                                    <a class="change-password-btn">
                                                        <span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-key"></i></span>
                                                        <span class="inline-block">パスワードを変更する</span>
                                                    </a>
                                                </li>
                                                <?php if ($moderatorInfo['Username'] != $this->Session->read('User.Username')) { ?>
                                                    <?php if ($moderatorInfo['Status'] == 1) { ?>
                                                        <li>  
                                                            <a class="update-block" href="">
                                                                <span class="label label-sm label-icon label-danger inline-block pull-left margin-right-3"><i class="fa fa-warning"></i></span>
                                                                <span class="inline-block">ユーザーを拒否</span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($moderatorInfo['Status'] != 1) { ?>
                                                        <li>  
                                                            <a class="update-active" href="">
                                                                <span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-check"></i></span>
                                                                <span class="inline-block">ユーザーをアクティブ</span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <li>  
                                                        <a class="update-delete" href="">
                                                            <span class="label label-sm label-icon label-default inline-block pull-left margin-right-3"><i class="fa fa-ban"></i></span>
                                                            <span class="inline-block">ユーザーを削除</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="portlet-body user-info">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="user" class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>ユーザー名</td>
                                            <td><section class="pull-left padding-5" id="Username"><?php echo $moderatorInfo['Username'] ?></section></td>
                                        </tr>
                                        <?php if ($moderatorInfo['Status'] != 2 && $moderatorInfo['Status'] != 0) { ?>
                                            <tr>
                                                <td>状態</td>
                                                <td><section class="pull-left padding-5" id="Status"><span class="label label-<?php echo $status_label[$moderatorInfo['Status']] ?> line-6"><?php echo $status[$moderatorInfo['Status']] ?></span></section></td>
                                            </tr>		
                                        <?php } ?>
                                        <tr>
                                            <td>名前</td>
                                            <td><input type="text" id="FullName" name="FullName" value="<?php echo $moderatorInfo['FullName'] ?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
                                        </tr>
                                        <tr>
                                            <td>性</td>
                                            <td>
                                                <select name="Gender" id="Gender">
                                                    <option value="0" <?php if ($moderatorInfo['Gender'] == "" || $moderatorInfo['Gender'] == "0") echo "selected" ?>>他</option>
                                                    <option value="1" <?php if ($moderatorInfo['Gender'] == "1") echo "selected" ?>>男</option>
                                                    <option value="2" <?php if ($moderatorInfo['Gender'] == "2") echo "selected" ?>>女</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>生年月日</td>
                                            <td>
                                                <select name="BirthdayYear" class="birth-year" id="BirthdayYear">
                                                    <option value="0000">年</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2000">2000</option>
                                                    <option value="1999">1999</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1900">1900</option>
                                                </select>年
                                                <select name="BirthdayMonth" class="birth-month" id="BirthdayMonth">
                                                    <option value="00">月</option>
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                    <option value="4">04</option>
                                                    <option value="5">05</option>
                                                    <option value="6">06</option>
                                                    <option value="7">07</option>
                                                    <option value="8">08</option>
                                                    <option value="9">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>月
                                                <select name="BirthdayDay" class="birth-day" id="BirthdayDay">
                                                    <option value="00">日</option>
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                    <option value="4">04</option>
                                                    <option value="5">05</option>
                                                    <option value="6">06</option>
                                                    <option value="7">07</option>
                                                    <option value="8">08</option>
                                                    <option value="9">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>日
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>メール</td>
                                            <td><input type="text" id="Email" name="Email" value="<?php echo $moderatorInfo['Email'] ?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
                                        </tr>
                                        <tr>
                                            <td>クレジットカード情報</td>
                                            <td><input type="text" id="BankInfo" name="BankInfo" value="<?php echo $moderatorInfo['BankInfo'] ?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
                                        </tr>
                                        <tr>
                                            <td>住所</td>
                                            <td><input type="text" id="Address" name="Address" value="<?php echo $moderatorInfo['Address'] ?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="update-notif">
                                    <span></span>
                                    <label class="ajax-loader"></label>
                                </div>
                                <div class="padding-5 align-right">
                                    <input type="submit" class="btn btn-info btn-xs button-save disabled" value="保存"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $('#user-info-form').validate({
            rules: {
                FullName: {
                    // required: true,
                },
                Email: {
                    // required: true,
                    email: true,
                },
                BankInfo: {
                    number: true,
                    maxlength: 16,
                    minlength: 12,
                },
                Address: {
                },
                BirthdayYear: {
                    required: true,
                },
                BirthdayMonth: {
                    required: true,
                },
                BirthdayDay: {
                    required: true,
                }
            },
            messages: {
                FullName: {
                    required: "名前は必須です",
                },
                Email: {
                    email: "有効なメールアドレスを入力してください！",
                    required: "メールは必須です",
                },
                BankInfo: {
                    number: "有効なクレジットカード情報を入力してください！",
                    minlength: "少なくとも12文字を入力してください。",
                    maxlength: "これ以上16文字以内で入力してください。"
                },
                Address: {
                },
                BirthdayYear: {
                    required: "",
                },
                BirthdayMonth: {
                    required: "",
                },
                BirthdayDay: {
                    required: "",
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
        });

        $("#user-info-form").live("submit", function(e) {
            if ($("#user-info-form").validate().checkForm() == false) {
                return;
            } else {
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                var url = "/elearning/admin/updateUserInfo/update";
                var submit_data = {
                    UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                };
                // submit_data.Password = $('#Password').text();
                submit_data.Birthday = "'" + $("#BirthdayYear").val() + '-' + $("#BirthdayMonth").val() + '-' + $("#BirthdayDay").val() + "'";
                submit_data.FullName = "'" + $('#FullName').val().trim() + "'";
                submit_data.Gender = "'" + $('#Gender').val().trim() + "'";
                submit_data.Email = "'" + $('#Email').val().trim() + "'";
                submit_data.BankInfo = "'" + $('#BankInfo').val().trim() + "'";
                submit_data.Address = "'" + $('#Address').val().trim() + "'";
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
                            setTimeout(function() {
                                //$(".user-info .update-notif span").text("");
                                $('.user-info .update-notif span').fadeTo(500, 0, function() {
                                    $('.user-info .update-notif span').css("visibility", "hidden");
                                });
                            }, 2000);
                        } else if (data.result == "Fail") {
                            $(".user-info .update-notif span").text("更新が失敗した。");
                            setTimeout(function() {
                                //$(".user-info .update-notif span").text("");
                                $('.user-info .update-notif span').fadeTo(500, 0, function() {
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

        $("a.change-password-btn").fancybox({
            'width': 400,
            'height': 250,
            'enableEscapeButton': false,
            'overlayShow': true,
            'overlayOpacity': 0,
            'hideOnOverlayClick': false,
            'type': 'iframe',
            'href': '/elearning/admin/changePassword/<?php echo $this->Session->read('User.UserId')?>',
            'fitToView': false,
            'autoSize': false
        });

        $(document).ready(function() {
            var origin = {};
            birthday = new Date("<?php echo $moderatorInfo['Birthday'] ?>");
            $("#BirthdayYear").val(birthday.getFullYear());
            $("#BirthdayMonth").val(birthday.getMonth());
            $("#BirthdayDay").val(birthday.getDay());

            $(".edit-btn").on("click", function() {
                editElm = $(this).closest("td").find("input");
                $(".button-save").removeClass("disabled");
                editElm.focus();
            });

            $(".user-info input[type='text'], .user-info select").live("focusin", function() {
                $(".button-save").removeClass("disabled");
            });

            $(".reset-pw").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                if (confirm("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントのパスワードをリセットしますか？") == true) {
                    var url = "/elearning/admin/resetPassword";
                    var submit_data = {
                        UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                        Username: "<?php echo $moderatorInfo['Username'] ?>",
                    };
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: submit_data,
                        success: function(data)
                        {
                            data = $.parseJSON(data);
                            if (data.result == "Success") {
                                alert("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントのパスワードがリセットさせられました");
                            } else if (data.result == "Fail") {
                                alert("パスワードリセットさせられません");
                            }
                        }
                    });
                    return false;

                }
            });

            $(".reset-ver-cod").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                if (confirm("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントのVerifyCodeをリセットしますか？") == true) {
                    var url = "/elearning/admin/resetVerifyCode";
                    var submit_data = {
                        UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                        Username: "<?php echo $moderatorInfo['Username'] ?>",
                    };
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: submit_data,
                        success: function(data)
                        {
                            data = $.parseJSON(data);
                            if (data.result == "Success") {
                                alert("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントのVerifyCodeがリセットさせられました。");
                            } else if (data.result == "Fail") {
                                alert("VerifyCode　リセットさせられませんでした");
                            }
                        }
                    });
                    return false;

                }
            });

            $(".update-block").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                if (confirm("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントを拒否させますか") == true) {
                    var url = "/elearning/admin/updateUserInfo/block";
                    var submit_data = {
                        UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                        Username: "<?php echo $moderatorInfo['Username'] ?>",
                    };
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: submit_data,
                        success: function(data)
                        {
                            data = $.parseJSON(data);
                            if (data.result == "Success") {
                                alert("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウント拒否されました。");
                                location.reload();
                            } else if (data.result == "Fail") {

                            }
                        }
                    });
                    return false;

                }
            });

            $(".update-delete").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                $("li.dropdown#options").removeClass("open");
                if (confirm("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントを削除しますか？") == true) {
                    var url = "/elearning/admin/updateUserInfo/delete";
                    var submit_data = {
                        UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                        Username: "<?php echo $moderatorInfo['Username'] ?>",
                    };
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: submit_data,
                        success: function(data)
                        {
                            data = $.parseJSON(data);
                            if (data.result == "Success") {
                                alert("<?php echo!empty($moderatorInfo['FullName']) ? $moderatorInfo['FullName'] : $moderatorInfo['Username'] ?>アカウントが削除されました。");
                                location.reload();
                            } else if (data.result == "Fail") {

                            }
                        }
                    });
                    return false;

                }
            });

            $(".update-active").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                var url = "/elearning/admin/updateUserInfo/active";
                var submit_data = {
                    UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                    Username: "<?php echo $moderatorInfo['Username'] ?>",
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {

                            location.reload();
                        } else if (data.result == "Fail") {
                            alert("活動させられません");
                        }
                    }
                });
                return false;
            });

            $("#first-active").on("click", function(e) {
                e = $.event.fix(e);
                e.preventDefault();
                $("li.dropdown#options").removeClass("open");
                var url = "/elearning/admin/updateUserInfo/active";
                var submit_data = {
                    UserId: "<?php echo $moderatorInfo['UserId'] ?>",
                    Username: "<?php echo $moderatorInfo['Username'] ?>",
                };

                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            $(".handle-user #notif-pending").hide("slide", {direction: "right"}, 1000);
                            $(".handle-user #first-active").delay(1000).prepend('<i class="fa fa-check margin-right-5"></i>');
                        } else if (data.result == "Fail") {
                            alert("活動させられません");
                        }
                    }
                });

                return false;
            });

        });
    </script>

<?php
} //end else-if !isset($moderatorInfo)?>
