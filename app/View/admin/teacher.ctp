<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<script type="text/javascript">
    $(function() {
        $("table").tablesorter({debug: true});
    });
</script>

<?php if (!isset($teacherInfo)) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="row" id="new-teachers">
				<div class="col-md-6">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-user"></i>新しい先生</div>
						</div>
						<?php if (isset($new_teachers) && $new_teachers['Total'] != 0) { ?>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-hover tablesorter">
									<thead>
										<tr>
											<th>#</th>
											<th><a link>氏名</a></th>
											<th><a link>ユーザー名</a></th>
											<th><a link>登録日時</a></th>
											<th><a link></a></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($new_teachers['Data'] as $key => $new_teacher) { ?>
										<tr>
											<td><?php echo ($key + 1)?></td>
											<td><a href="/elearning/admin/teacher/<?php echo $new_teacher['User']['Username']?>"><?php echo $new_teacher['User']['FullName']?></a></td>
											<td><a href="/elearning/admin/teacher/<?php echo $new_teacher['User']['Username']?>"><?php echo $new_teacher['User']['Username']?></a></td>
											<td><?php echo $new_teacher['User']['created']?></td>
											<td><span class="label label-sm label-<?php echo $status_label[$new_teacher['User']['Status']]?> line-6"><?php echo $status[$new_teacher['User']['Status']]?></span></td>
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
			</div>

			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">すべてのユ学生</div>


				</div>
				<div class="portlet-body flip-scroll" style="display: block; overflow: auto">
					<?php if (isset($all_teachers) && $all_teachers['Total'] != 0) { ?>
					<table class="table table-hover table-striped table-condensed tablesorter">
						<thead class="flip-content">
							<tr>
								<th><a link>ID</a></th>
								<th><a link>ユーザー名</a></th>
								<th><a link>メール</a></th>
								<th class="numeric"><a link>氏名</a></th>
								<th class="numeric"><a link>生年月日</a></th>
								<th class="numeric"><a link>性</a></th>
								<th class="numeric"><a link>電話番号</a></th>
								<th class="numeric"><a link>登録日時</a></th>
								<th class="numeric"><a link>変更</a></th>
								<th class="numeric"><a link>レポート</a></th>
								<th class="numeric"><a link>状態</a></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_teachers['Data'] as $key => $teacher) { ?>
							<tr>
								<td><?php echo $key + 1?></td>
								<td><a href="/elearning/admin/teacher/<?php echo $teacher['User']['Username']?>"><?php echo $teacher['User']['Username']?></a></td>
								<td><?php echo $teacher['User']['Email']?></td>
								<td><?php echo $teacher['User']['FullName']?></td>
								<td><?php echo $teacher['User']['Birthday'] ? date_format(date_create($teacher['User']['Birthday']), 'Y年m月d日') : null?></td>
								<td><?php echo $teacher['User']['Gender'] == 0 ? __("他"): ($teacher['User']['Gender'] == 1 ? __("男") : __("女"))?></td>
								<td><?php echo $teacher['User']['Phone']?></td>
								<td><?php echo $teacher['User']['created']?></td>
								<td><?php echo $teacher['User']['modified']?></td>
								<td class="text-align-right"><?php echo $teacher['User']['Violated'] == 0 ? null : $teacher['User']['Violated']; ?></td>
								<td><label class="label label-sm label-<?php echo $status_label[$teacher['User']['Status']]?> line-8" ><?php echo $status[$teacher['User']['Status']]?></label></td>
							</tr>
							<?php } ?>							
						</tbody>
					</table>
					<?php }  else { ?>
					<div class="portlet-body">
                        今日登録が新入生はありません。
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>


<?php } else { //end if !isset($teacherInfo) ?>
<?php //have $teacherInfo?>
	<div class="row">
		<div class="col-md-12">			
			<div class="row">
				<div class="note note-success user-info" style="margin-top:  20px;">
						<div class="pull-left" style="padding: 10px">
                    		<img class="imageThumb" src="<?php echo $teacherInfo['ImageProfile'] ? $teacherInfo['ImageProfile'] : '/elearning/img/photo/no-avatar.jpg'?>" id="preview" width="96" height="96" style="margin-top: -50px;">
                		</div>
						<h4 class="block" style="margin-bottom: 0; margin-top: -10px;"><?php echo $teacherInfo['FullName'] ?></h4> 
						<span class="gender male"></span><?php echo $teacherInfo['Gender'] == 1 ? "男" : ($teacherInfo['Gender'] == 2 ? "女" : "他") ?>
						<span class="bday"></span><?php echo $teacherInfo['Birthday'] ?>
						<span class="addr"></span><?php echo $teacherInfo['Address'] ? $teacherInfo['Address'] : "住所  <i class='margin-left-5'> </i>" ?>
						<span class="phone"><label class="fa fa-phone"></label><?php echo $teacherInfo['Phone'] ? $teacherInfo['Phone'] : "<i class=''> </i>" ?></span>
				</div>
			</div>
			<?php if ($teacherInfo['Status'] == 2) { ?>
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
				<button class="btn btn-sm btn-danger margin-right-5 pull-right" id = "first-deny">
					<span>
						 拒否
					</span>
				</button>
			</div>			
			<?php } ?>
			<?php if ($teacherInfo['Status'] == 0) { ?>
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
					<div class="caption"><i class="fa fa-reorder"></i><?php echo !empty($teacherInfo['FullName'])?$teacherInfo['FullName']:$teacherInfo['Username'] ?>'s 情報</div>
					<?php if ($teacherInfo['Status'] != 2 && $teacherInfo['Status']!=0) {?>
					<div class="pull-right no-list-style">
						<li class="dropdown menu-left" id="options">
							<span href="#" class="btn btn-info btn-xs" id="edit" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog"></i>オプション</span>
							<ul class="dropdown-menu extended" style="width: auto !important; margin-left: 77px; margin-top: -50px;">
								<li>
									<ul class="dropdown-menu-list no-space no-list-style">
										<li>  
											<a class="reset-pw" href="">
											<span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-refresh"></i></span>
                                                <span class="inline-block">パスワードをリセット</span>
											</a>
										</li>
										<li>  
											<a class="reset-ver-cod" href="">
											<span class="label label-sm label-icon label-success inline-block pull-left margin-right-3"><i class="fa fa-refresh"></i></span>
                                                <span class="inline-block">Verifycodeをリセット<span>
											</a>
										</li>
										<?php if ($teacherInfo['Username'] != $this->Session->read('User.Username')) { ?>
											<?php if ($teacherInfo['Status'] == 1) { ?>
											<li>  
												<a class="update-block" href="">
												<span class="label label-sm label-icon label-danger inline-block pull-left margin-right-3"><i class="fa fa-warning"></i></span>
	                                            <span class="inline-block">ユーザーを拒否</span>
												</a>
											</li>
											<?php } ?>
											<?php if ($teacherInfo['Status'] != 1) { ?>
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
										<td><section class="pull-left padding-5" id="Username"><?php echo $teacherInfo['Username'] ?></section></td>
									</tr>
									<?php if ($teacherInfo['Status'] != 2 && $teacherInfo['Status'] != 0) { ?>
									<tr>
										<td>状態</td>
										<td><section class="pull-left padding-5" id="Status"><span class="label label-<?php echo $status_label[$teacherInfo['Status']] ?> line-6"><?php echo $status[$teacherInfo['Status']] ?></span></section></td>
									</tr>		
									<?php } ?>
									<tr>
										<td>名前</td>
										<td><input type="text" id="FullName" name="FullName" value="<?php echo $teacherInfo['FullName']?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>性</td>
										<td>
											<select name="Gender" id="Gender">
												<option value="0" <?php if ($teacherInfo['Gender'] == "" || $teacherInfo['Gender'] == "0") echo "selected"?>>他</option>
												<option value="1" <?php if ($teacherInfo['Gender'] == "1") echo "selected"?>>男</option>
												<option value="2" <?php if ($teacherInfo['Gender'] == "2") echo "selected"?>>女</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>生年月日</td>
										<td>
                                        	<span class="align-top">
                                                <select name="BirthdayYear" class="birth-year" id="BirthdayYear">
                                                    <option value="0">--</option>
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
                                                </select>
                                                <span class="margin-right-5">年</span>
                                                <div class="clear-fix"></div>
                                            </span>
                                            <span class="inline-block">
                                                <select name="BirthdayMonth" class="birth-month" id="BirthdayMonth">
                                                    <option value="0">--</option>
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
                                                </select>
                                                <span class="margin-right-5">月</span>
                                                <div class="clear-fix"></div>
											</span>
                                            <span class="inline-block">
                                                <select name="BirthdayDay" class="birth-day" id="BirthdayDay">
                                                    <option value="0">--</option>
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
                                                </select>
                                                <span class="margin-right-5">日</span>
                                                <div class="clear-fix"></div>
                                            </span>
                                        </td>
									</tr>
									<tr>
										<td>メール</td>
										<td><input type="text" id="Email" name="Email" value="<?php echo $teacherInfo['Email']?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>クレジットカード情報</td>
										<td><input type="text" id="BankInfo" name="BankInfo" value="<?php echo $teacherInfo['BankInfo']?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
									<tr>
										<td>住所</td>
										<td><input type="text" id="Address" name="Address" value="<?php echo $teacherInfo['Address']?>"></input><span class="edit-btn pull-right fa fa-edit pointer" data-toggle="modal" href="#portlet-config"></span></td>
									</tr>
								</tbody>
							</table>
							<div class="update-notif">
								<span></span>
								<label class="ajax-loader"></label>
							</div>
							<div class="padding-5 text-align-right">
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
                selectcheck: true,
            },
            BirthdayMonth: {
                selectcheck: true,
            },
            BirthdayDay: {
                selectcheck: true,
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
                selectcheck: "年は必須です",
            },
            BirthdayMonth: {
                selectcheck: "月は必須です",
            },
            BirthdayDay: {
                selectcheck: "日は必須です",
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        },
        
    });

    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "");

    $("#user-info-form").live("submit", function(e) {
        if ($("#user-info-form").validate().checkForm() == false) {
            return;
        } else {
            e.preventDefault();
            $("li.dropdown#options").removeClass("open");
            var url = "/elearning/admin/updateUserInfo/update";
            var submit_data = {
                UserId: "<?php echo $teacherInfo['UserId'] ?>",
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

    $(document).ready(function() {
        var origin = {};
        birthday = new Date("<?php echo $teacherInfo['Birthday'] ?>");
        $("#BirthdayYear").val(birthday.getFullYear());
        $("#BirthdayMonth").val(birthday.getMonth()+1);
        $("#BirthdayDay").val(birthday.getDate());

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
            if (confirm("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントのパスワードをリセットしますか？") == true) {
                var url = "/elearning/admin/resetPassword";
                var submit_data = {
                    UserId: "<?php echo $teacherInfo['UserId'] ?>",
                    Username: "<?php echo $teacherInfo['Username'] ?>",
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            alert("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントのパスワードが初期パスワードにリセットされました。");
                        } else if (data.result == "Fail") {
                            alert("Reset password failed!");
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
            if (confirm("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントのVerifyCodeをリセットしますか？") == true) {
                var url = "/elearning/admin/resetVerifyCode";
                var submit_data = {
                    UserId: "<?php echo $teacherInfo['UserId'] ?>",
                    Username: "<?php echo $teacherInfo['Username'] ?>",
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            alert("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントのVerifyCodeがリセットされました");
                        } else if (data.result == "Fail") {
                            alert("Reset password failed!");
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
            if (confirm("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントを拒否しますか？") == true) {
                var url = "/elearning/admin/updateUserInfo/block";
                var submit_data = {
                    UserId: "<?php echo $teacherInfo['UserId'] ?>",
                    Username: "<?php echo $teacherInfo['Username'] ?>",
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            alert("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントが拒否されました。");
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
            if (confirm("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントを削除しますか？") == true) {
                var url = "/elearning/admin/updateUserInfo/delete";
                var submit_data = {
                    UserId: "<?php echo $teacherInfo['UserId'] ?>",
                    Username: "<?php echo $teacherInfo['Username'] ?>",
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: submit_data,
                    success: function(data)
                    {
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            alert("<?php echo!empty($teacherInfo['FullName']) ? $teacherInfo['FullName'] : $teacherInfo['Username'] ?>アカウントが削除されました。");
                            location.assign("/elearning/admin/teacher");
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
                UserId: "<?php echo $teacherInfo['UserId'] ?>",
                Username: "<?php echo $teacherInfo['Username'] ?>",
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
                        alert("再活動させられません");
                    }
                }
            });
            return false;
        });

		$("#first-active").on("click", function(e) {
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/active";
			var submit_data = {
				UserId: "<?php echo $teacherInfo['UserId']?>",
				Username: "<?php echo $teacherInfo['Username']?>",
			};
			$(".handle-user #notif-pending").hide("slide", { direction: "right" }, 1000);
			$(".handle-user #first-deny").hide("slide", { direction: "right" }, 1000);
			setTimeout(function(){
				$(".handle-user #first-active").prepend('<i class="fa fa-check margin-right-5"></i>');
			}, 1000);
			$("#first-active").unbind();
			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		
		               	} else if (data.result == "Fail") {

		               	}
                                location.reload();
		           }
		         });

		    return false;
		});

		$("#first-deny").on("click", function(e) {
			e = $.event.fix(e);
			e.preventDefault();
			var url = "/elearning/admin/updateUserInfo/deny";
			var submit_data = {
				UserId: "<?php echo $teacherInfo['UserId']?>",
				Username: "<?php echo $teacherInfo['Username']?>",
			};
			$(".handle-user #notif-pending").hide("slide", { direction: "right" }, 1000);
			$(".handle-user #first-active").hide("slide", { direction: "right" }, 1000);
			setTimeout(function(){
				$(".handle-user #first-deny").prepend('<i class="fa fa-check margin-right-5"></i>');
			}, 1000);
			$("#first-deny").unbind();
			$.ajax({
		           type: "POST",
		           url: url,
		           data: submit_data, 
		           success: function(data)
		           {
						data = $.parseJSON(data);
		               	if (data.result == "Success") {
		               		
		               	} else if (data.result == "Fail") {

		               	}
		           }
		         });

                return false;
            });

        });
    </script>

    <?php
} //end else-if !isset($teacherInfo)?>
