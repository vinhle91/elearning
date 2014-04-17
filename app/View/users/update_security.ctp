<script type="text/javascript">
    <!--
    // Form validation code will come here.
    //-->
    // Form validation code will come here.
    function validatePassword() {
        var currentPass = document.myForm.currentPassword.value;
        var newPass = document.myForm.newPassword.value;
        var confirmPass = document.myForm.confirmPassword.value;
        if (currentPass.toString() == "") {
            alert("使用中のパースワードは空かなければならない");
            document.myForm.currentPassword.focus();
            return false;
        }
       else if (newPass == "" || newPass.length <= 6) {
            alert("パースワードは6字以下いけません");
            newPass.focus();
            return false;
        }
        else if (confirmPass == "" || confirmPass.length <= 6) {
            alert("パースワードを確認してください");
            document.myForm.confirmPassword.focus();
            return false;
        }

       else if (newPass.toString() != confirmPass.toString()) {
            alert("新規のパースワードは合わせていません");
            document.myForm.confirmPassword.focus();
            return false;
        }
        //        if( document.myForm.Country.value == "-1" )
        //        {
        //            alert( "Please provide your country!" );
        //            return false;
        //        }
        return( true );
    }
    function validateQuestion() {
        var currentQuestion = document.questionForm.currentQuestion.value;
        var currentAns = document.questionForm.currentAnswer.value;
        var newQuestion = document.questionForm.newQuestion.value;
        var newAns = document.questionForm.newAnswer.value;
       if(currentQuestion==""||currentAns == ""||newQuestion==""||newAns==""){
           alert("必要な情報を入力してください");
           return false;
       }
        return true;
    }
</script>

<div id="contents" style="padding:0px 150px">
    <div id="content">
        <?php 
            $error = $this->Session->flash();
            if(!empty($error)):
        ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php endif;?>
        <div class="t_title">
            <div class="left">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="selected pass">
                            <span>パースワード</span>
                        </a>
                    </li>
                    <?php if(isset($UserType)&&$UserType ==2) : ?>
                    <li>
                        <a href="javascript:void(0)" class="secu">
                            <span>セキュリティ</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="box" style="min-height:350px">
            <div class="sign_up_box">
                <form action="" method="post" onsubmit="return validatePassword();" name="myForm">
                    <div class="input_error"></div>
                    <table id="change_pass" class="sign_up_tb">
                        <tbody>
                        <tr>
                            <td colspan="2" align="left">
                                <div class="td_text"><h3>パースワード変更</div>
                                </h3></td>
                        </tr>
                        <tr>
                            <td width="21%">
                                <div class="td_text">使用中パースワード</div>
                            </td>
                            <td width="79%"><input class="input" name="currentPassword" size="20" type="password"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">新規のパースワード</div>
                            </td>
                            <td><input class="input" name="newPassword" size="20" type="password"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">パースワード確認</div>
                            </td>
                            <td><input class="input" name="confirmPassword" size="20" type="password"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="flat_btn" data-act_as="submit" type="submit" value="変更"></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
                <form action="" method="post" onsubmit="return validateQuestion();" name="questionForm">
                    <table id="change_secu" class="sign_up_tb" style="display:none">
                        <tbody>
                        <tr>
                            <td colspan="2" align="left">
                                <div class="td_text"><h3>秘密の質問を変更</div>
                                </h3></td>
                        </tr>
                        <tr>
                            <td width="22%">
                                <div class="td_text">使用中の秘密の質問</div>
                            </td>
                            <td width="78%">
                                <!--                                <label for="firstname">First name:</label>-->
                                <input type="text" name="currentQuestion" id="CurrentQuestion" size="45"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">使用中の答え</div>
                            </td>
                            <td><input class="input" name="currentAnswer" size="50" type="text" value=""></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">新規の秘密の質問</div>
                            </td>
                            <td>
                                <input type="text" name="newQuestion" id="newQuestion" size="45"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">新規の答え</div>
                            </td>
                            <td><input class="input" name="newAnswer" size="50" type="text" value=""></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="flat_btn" data-act_as="submit" type="submit" value="変更"></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if(isset($isPassTab)&&!$isPassTab): ?>

    <script>
//        alert("Take care");
        $("#change_pass").hide();
        $("#change_secu").show();

    </script>
<?php endif; ?>
