
    <div class="col-md-6" id="ip-info">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>カテゴリ</div>
                <div class="actions">
                    <a href="#" class="btn btn-info btn-xs" id="add-ip" onclick="addNewIp(event)"><i class="fa fa-plus"></i> 追加</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="ip-table">
                        <thead>
                            <tr>
                                <th class="col-md-1">番号</th>
                                <th class="col-md-3">カテゴリ名</th>
                                <th class="col-md-3"></th>
                            </tr>
                        </thead>
                        <?php  if (isset($all_category)) { ?>
                        <tbody>
                            <?php foreach ($all_category['Data'] as $key => $category) { ?>
                            <tr>
                                <td><?php echo $key + 1?></td>
                                <td class="ipaddr">
                                    <input name="" id="<?php echo $category['Category']['CatId']?>" value="<?php echo $category['Category']['CatName']?>" class="no-border transparent width-100" disabled></input>
                                        <a class="btn btn-xxs btn-default pull-right display-none editIp" onclick="editIp(event)"><span>エディット</span></a>
                                    </td>
                                <td></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } else { ?>
                        <div class="portlet-body">
                            登録がIPアドレスがありません。
                        </div>
                        <?php } ?>
                    </table>
                    <div class="update-notif">
                        <span></span>
                        <label class="ajax-loader"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function addNewIp(e) {
        e = $.event.fix(e);
        e.preventDefault();

        var next = parseInt($("#ip-table tr:last td:first").html()) + 1;
        var buff =      '<tr>'
                        + '<td class="col-md-1">' + next + '</td>'
                        + '<td class="col-md-3"><input type="text" name="" rows="1" class="no-border padding-5" style="resize: none; width: 130px;" id="new-user" placeholder="ユーザー"></input></td>'
                        + '<td class="col-md-3"><a class="pull-right btn btn-xs btn-warning margin-left-5" onclick="cancel(event)"><?php echo __("キャンセル")?></a><a class="pull-right btn btn-xs btn-success" onclick="submitNewIp()"><?php echo __("保存") ?></a></td>'
                        + '</tr>';
        $("#add-ip").addClass("disabled");
        $("#ip-table tr:last").after(buff);
        $("#ip-table tr:last td:eq(1) input").focus();
    }   

    $("#new-user").live("focusin focusout", function(){
        var availableTags = [];
        <?php foreach ($list_tag as $key => $tag) { ?>
            availableTags.push("<?php echo $tag['Tag']['TagContent']?>");
        <?php } ?>
        $(this).autocomplete({
            source: availableTags,
            minLength:0
        }).bind('focus', function(){ $(this).autocomplete("search"); } );
    });

    var availableTags2 = [];
    <?php foreach ($all_category['Data'] as $key => $category) { ?>
        availableTags2.push("<?php echo $category['Category']['CatName']?>");
    <?php } ?>

    function submitNewIp() {
        var time = "<?php echo date("Y-m-d h:i:s"); ?>";
        var submit_data = $("#ip-table tr:last td:eq(1) input").val();
            if (submit_data != '') {
                if (availableTags2.indexOf(submit_data) == -1) {
                    $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
                    $("#ip-info .update-notif span").text("IPアドレスを変更している...");
                    $("#ip-info .ajax-loader").fadeIn(10);
                    $("#ip-info .button-save").addClass("disabled");
                    $.ajax({
                           type: "POST",
                           url: "/elearning/admin/updateConfig/category",
                           data: {Category: submit_data}, 
                           success: function(data)
                           {
                                $(".ajax-loader").fadeOut(10);
                                data = $.parseJSON(data);
                                if (data.result == "Success") {
                                    $("#ip-table tr:last td:eq(1)").html('<input name="" id="" value="'+submit_data+'" class="no-border transparent width-100" disabled></input><a class="btn btn-xxs btn-default pull-right display-none editIp" onclick="editIp(event)"><span>エディット</span></a>');
                                    $("#ip-table tr:last td:eq(1)").addClass("ipaddr");
                                    $("#ip-info #add-ip").removeClass("disabled");
                                    $("#ip-info .update-notif span").text("変更が成功");
                                    $("#ip-table tr:last td:eq(2)").html("")
                                    availableTags2.push(submit_data);
                                } else if (data.result == "Fail") {
                                    $("#ip-info .update-notif span").text("変更が失敗");
                                    
                                }
                                setTimeout(function(){
                                    $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                                        $('#ip-info .update-notif span').css("visibility", "hidden");   
                                    });
                                }, 2000);
                           }
                         });
                } else {
                    $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
                    $("#ip-info .update-notif span").text("カテゴリがいます!");
                    setTimeout(function(){
                        $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                            $('#ip-info .update-notif span').css("visibility", "hidden");   
                        });
                    }, 2000);
                }
                
            } else {
                $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
                $("#ip-info .update-notif span").text("カテゴリがなければならない!");
                setTimeout(function(){
                    $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                        $('#ip-info .update-notif span').css("visibility", "hidden");   
                    });
                }, 2000);
            }
    }

    function cancel(e) {
        e = $.event.fix(e);
        e.preventDefault();
        $(e.target).closest("tr").remove();     
        $("#add-ip").removeClass("disabled");
    }

    function removeIp(event) {
        parent = $(event.target).closest("tr");
        window.abc = parent;
        submit_data = parent.find("td:eq(1) input").val().trim();
        r = confirm("あなたは、このIPアドレスを削除しますか?");
        if (r == true) {
            $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
            $("#ip-info .update-notif span").text("IPアドレスを削除している...");
            $("#ip-info .ajax-loader").fadeIn(10);
            $("#ip-info .button-save").addClass("disabled");
            $.ajax({
               type: "POST",
               url: "/elearning/admin/updateConfig/removeIp",
               data: {IpAddress: submit_data}, 
               success: function(data)
               {
                    console.log(data);
                    $(".ajax-loader").fadeOut(10);
                    data = $.parseJSON(data);
                    if (data.result == "Success") {
                        $("#ip-info .update-notif span").text("変更が成功");
                        parent.remove();
                    } else if (data.result == "Fail") {
                        $("#ip-info .update-notif span").text("変更が失敗");
                        
                    }
                    setTimeout(function(){
                        $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                            $('#ip-info .update-notif span').css("visibility", "hidden");   
                        });
                    }, 2000);
               }
            });
        } 
    }

    $(".ipaddr").live("mouseover", function(e){
        $(this).find(".editIp").removeClass("display-none");
    });

    $(".ipaddr").live("mouseout", function(e){
        $(this).find(".editIp").addClass("display-none");
    });

    function editIp(e) {
        e = $.event.fix(e);
        e.preventDefault();
        window.abc = $(e.target);
        $(e.target).closest("td").find("input").removeAttr("disabled");
        $(e.target).closest("td").find("input").focus();
        $(e.target).closest("tr").find("td:eq(3)").html('<a class="pull-right btn btn-xs btn-warning margin-left-5" onclick="cancelEdit(event)"><?php echo __("キャンセル")?></a><a class="pull-right btn btn-xs btn-success" onclick="submitEdit(event)"><?php echo __("保存") ?></a>')
        $("#ip-info #add-ip").addClass("disabled");
    }

    function cancelEdit(e) {
        e = $.event.fix(e);
        e.preventDefault();
        $(e.target).closest("td").find("input").attr("disabled", "disabled");
        $(e.target).closest("tr").find("td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right onclick="removeIp(event)"><span>削除</span></a>')
        $("#ip-info #add-ip").removeClass("disabled");
    }

    function submitEdit(e) {
        e = $.event.fix(e);
        e.preventDefault();
        target = $(e.target);
        var submit_data = target.closest("tr").find("td:eq(1) input").val();
        var ipid = target.closest("tr").find("td:eq(1) input").attr("id");
        var submit_data2 = target.closest("tr").find("td:eq(2) a").val();
        if (checkIpValidate(submit_data)) {
            $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
            $("#ip-info .update-notif span").text("IPアドレスを変更している...");
            $("#ip-info .ajax-loader").fadeIn(10);
            $.ajax({
                   type: "POST",
                   url: "/elearning/admin/updateConfig/changeIp",
                   data: {IpAddress: "'"+submit_data+"'", IpId: ipid}, 
                   success: function(data)
                   {
                        $(".ajax-loader").fadeOut(10);
                        data = $.parseJSON(data);
                        if (data.result == "Success") {
                            $(e.target).closest("tr").find("td:eq(1)").html('<input name="" id="'+ipid+'" value="'+submit_data+'" class="no-border transparent width-100" disabled></input><a class="btn btn-xxs btn-default pull-right display-none editIp" onclick="editIp(event)"><span>エディット</span></a>');
                            $(e.target).closest("tr").find("td:eq(1)").addClass("ipaddr");
                            $(e.target).closest("tr").find("td:eq(3)").html('<a type="reset" class="btn btn-xs btn-warning cancel pull-right onclick="removeIp(event)"><span>削除</span></a>')
                            $("#ip-info .update-notif span").text("変更が成功");
                            $("#ip-info #add-ip").removeClass("disabled");
                            
                        } else if (data.result == "Fail") {
                            $("#ip-info .update-notif span").text("変更が失敗");
                            
                        }
                        setTimeout(function(){
                            $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                                $('#ip-info .update-notif span').css("visibility", "hidden");   
                            });
                        }, 2000);
                   }
                 });
                
        } else {
            $("#ip-info .update-notif span").css({"visibility": "visible", "opacity": 1});
            $("#ip-info .update-notif span").text("IPアドレスが一致しない!");
            setTimeout(function(){
                $('#ip-info .update-notif span').fadeTo(500, 0, function(){
                    $('#ip-info .update-notif span').css("visibility", "hidden");   
                });
            }, 2000);
        }
    }

    function submitKey(key) {
        if (key == 13) {
            event.preventDefault();
            submitNewIp();
        }
    }

    $("#form1 input[type='text']").on("click", function(){
        $("#config-info .button-save").removeClass("disabled");         
    });


    $('#form1').validate({
        rules: {
            session_timeout: {
                required: true,
                number: true
            },
            auto_backup: {
                required: true,
                number: true
            },
            login_fail: {
                required: true,
                number: true
            },
            lock_time: {
                required: true,
                number: true
            },
            lesson_cost: {
                required: true,
                number: true
            },
            test_time: {
                required: true,
                number: true
            },
            share_rate: {
                required: true,
                number: true,
                range: [1, 100],
            },

        },
        messages: {
            session_timeout: {
                number: "番号を入力してください。",
                required: "自動セッション終了時間 は必須です",
            },
            auto_backup: {
                number: "番号を入力してください。",
                required: "自動バックアップ時刻 は必須です",
            },
            login_fail: {
                number: "番号を入力してください。",
                required: "ログイン誤り回数 は必須です",
            },
            lock_time: {
                number: "番号を入力してください。",
                required: "ロッグ時間 は必須です",
            },
            lesson_cost: {
                number: "番号を入力してください。",
                required: "一回受講料 は必須です",
            },
            test_time: {
                number: "番号を入力してください。",
                required: "受講可能時間 は必須です",
            },
            share_rate: {
                number: "番号を入力してください。",
                required: "報酬% は必須です",
                range: "1から100までを入力してください。"
            },
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent());
        },
        submitHandler: function (form) {
            $.mobile.changePage('#success', {
                transition: "slide"
            });
            return false;
        },
    });

    $("#form1").live("submit", function(e){
        if ($("#form1").validate().checkForm() == false) {
            return;
        } else {
            var url = "/elearning/admin/updateConfig/config";
            var submit_data = {
                1 : $("#session_timeout").val().trim(),
                2 : $("#auto_backup").val().trim(),
                3 : $("#login_fail").val().trim(),
                4 : $("#lock_time").val().trim(),
                5 : $("#lesson_cost").val().trim(),
                6 : $("#test_time").val().trim(),
                7 : $("#share_rate").val().trim(),
            };
            console.log(submit_data);
            
            $("#config-info .update-notif span").css({"visibility": "visible", "opacity": 1});
            $("#config-info .update-notif span").text("情報を更新している...");
            $("#config-info .ajax-loader").fadeIn(10);
            // $("#config-info .button-save").addClass("disabled");

            $.ajax({
                   type: "POST",
                   url: url,
                   data: submit_data, 
                   success: function(data)
                   {
                        $(".ajax-loader").fadeOut(10);
                        data = $.parseJSON(data);
                        console.log(data);
                        if (data.result == "Success") {
                            $("#config-info .update-notif span").text("更新が成功した");
                            setTimeout(function(){
                                $('#config-info .update-notif span').fadeTo(500, 0, function(){
                                    $('#config-info .update-notif span').css("visibility", "hidden");   
                                });
                            }, 2000);
                        } else if (data.result == "Fail") {
                            $("#config-info .update-notif span").text("更新が失敗した");
                            setTimeout(function(){
                                $('#config-info .update-notif span').fadeTo(500, 0, function(){
                                    $('#config-info .update-notif span').css("visibility", "hidden");   
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