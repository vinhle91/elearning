<script type="text/javascript">
    function validatePassword() {
        var question = document.myForm.質問.value;
        if (question.toString() == "") {
            alert("使用中のパスワードは空けばいけない");
            return false;
        }
//        if (answer == "") {
//            alert("秘密の答えは空けばいけない");
//            return false;
//        }
        return( true );
    }
</script>
<div id="contents" style="padding:0px 150px;">
    <div id="content">
       <?php 
            $error = $this->Session->flash();
            if(!empty($error)):
        ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php endif;?>
        <div class="title" style="width:400px"><h3>退会する前にあなたは本物だか確認する</h3></div>    
        <div class="box" style="min-height:350px">
            <form action="" method="post" onsubmit="return validatePassword();" name="myForm">
                <div class="input_error"></div>
                <table id="change_pass" class="sign_up_tb">
                    <tbody>
                    <tr>
                        <td width="21%">
                            <div class="td_text">使用中のパスワード</div>
                        </td>
                        <td width="79%"><input class="input" name="質問" size="20" type="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input class="flat_btn" data-act_as="submit" type="submit" value="退会する"></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>