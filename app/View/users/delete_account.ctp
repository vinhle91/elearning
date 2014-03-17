<script type="text/javascript">
    function validatePassword() {
        var question = document.myForm.質問.value;
        var answer = document.myForm.答え.value;
        if (question.toString() == "") {
            alert("秘密の質問は空けばいけない");
//            document.myForm.質問.focus();
            return false;
        }
        if (answer == "") {
            alert("秘密の答えは空けばいけない");
//            answer.focus();
            return false;
        }
//        if( document.myForm.Country.value == "-1" )
//        {
//            alert( "Please provide your country!" );
//            return false;
//        }
        return( true );
    }
</script>

<h3 style="color:red"><?php echo $this->Session->flash(); ?></h3>
<form action="" method="post" onsubmit="return validatePassword();" name="myForm">
    <div class="input_error"></div>
    <table id="change_pass" class="sign_up_tb">
        <tbody>
        <tr>
            <td colspan="2" align="left">
                <div class="td_text"><h3>退会する前にあなたは本物だか確認する</div>
                </h3></td>
        </tr>
        <tr>
            <td width="21%">
                <div class="td_text">秘密の質問</div>
            </td>
            <td width="79%"><input class="input" name="質問" size="20" type="text"></td>
        </tr>
        <tr>
            <td width="21%">
                <div class="td_text">秘密の質問に答え</div>
            </td>
            <td width="79%"><input class="input" name="答え" size="20" type="text"></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="flat_btn" data-act_as="submit" type="submit" value="退会する"></td>
        </tr>
        </tbody>
    </table>
</form>