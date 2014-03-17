<script>
    function checkDate(str) {
        var matches = str.match(/(\d{1,2})[- \/](\d{1,2})[- \/](\d{4})/);
        if (!matches) return false;

        // parse each piece and see if it makes a valid date object
        var month = parseInt(matches[1], 10);
        var day = parseInt(matches[2], 10);
        var year = parseInt(matches[3], 10);
        var date = new Date(year, month - 1, day);
        if (!date || !date.getTime()) return false;

        // make sure we have no funny rollovers that the date object sometimes accepts
        // month > 12, day > what's allowed for the month
        if (date.getMonth() + 1 != month ||
            date.getFullYear() != year ||
            date.getDate() != day) {
            return false;
        }
        return true;
    }


    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


    function validateInput() {
        var name = document.profileForm.name.value;
        var dayOfBirth = document.profileForm.day.value;
        var monthOfBirth = document.profileForm.months.value;
        var yearOfBirth = document.profileForm.year.value;
        var gender = document.profileForm.gender.value;
        var phone = document.profileForm.phone.value;
        var paymentInfo = document.profileForm.paymentInfo.value;
        var birthDay = monthOfBirth.concat("-", dayOfBirth, "-", yearOfBirth);
        var email = document.profileForm.mail.value;
        if (name == "") {
            alert("名前は空けばいけない");
            return false;
        }
        else if (!checkDate(birthDay)) {
            alert("誕生日は正しくない");
            return false;
        } else if (!(/^\d{10,11}$/.test(phone))) {
//            alert(phone);
            alert("電話番号は正しくない");
//            phone.focus();
            return false;
        }
        else if (/^\d{10,11}$/.test(paymentInfo) == false) {
            alert("クレジットカードまたは銀行口座番号は正しくない");
//            paymentInfo.focus();
            return false;
        }
        else if (validateEmail(email) == false) {
            alert('メールアドレスは正しくない');
//            email.focus();
            return false;
        }
        else {
            return true;
        }
    }
</script>
<div id="contents">
    <div id="content">
        <div class="title"><h3>個人情報</h3></div>
        <h3 style="color:red"><?php echo $this->Session->flash(); ?></h3>

        <div class="box">
            <div class="sign_up_box">
                <form action="" method="post" onsubmit="return validateInput();" name="profileForm">
                    <div class="input_error"></div>
                    <table class="sign_up_tb">
                        <tbody>
                        <tr>
                            <td width="21%">
                                <div class="td_text">名前<span style="color:red">*</span></div>
                            </td>
                            <td width="79%"><input class="input" name="name" size="20" type="text"
                                                   value=<?php echo '"' . $profileInfo['FullName'] . '"'; ?>></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">誕生日</div>
                            </td>
                            <td>
                                <input class="input" name="day" style="width:72px"
                                       value=<?php echo(date("d", strtotime($profileInfo['Birthday']))); ?> type="text">
                                <?php $month = date("n", strtotime($profileInfo['Birthday'])); ?>
                                <input class="input" name="year" style="width:92px"
                                       value=<?php echo(date("Y", strtotime($profileInfo['Birthday']))); ?> type="text">
                                <select name="months">
                                    <option value="1" <?php if ($month == 1) echo 'selected="selected"'; ?> >1月
                                    </option>
                                    <option value="2" <?php if ($month == 2) echo 'selected="selected"'; ?>>2月
                                    </option>
                                    <option value="3" <?php if ($month == 3) echo 'selected="selected"'; ?>>3月
                                    </option>
                                    <option value="4" <?php if ($month == 4) echo 'selected="selected"'; ?>>4月
                                    </option>
                                    <option value="5" <?php if ($month == 5) echo 'selected="selected"'; ?>>5月</option>
                                    <option value="6" <?php if ($month == 6) echo 'selected="selected"'; ?>>6月
                                    </option>
                                    <option value="7" <?php if ($month == 7) echo 'selected="selected"'; ?>>7月

                                    </option>
                                    <option value="8" <?php if ($month == 8) echo 'selected="selected"'; ?>>8月
                                    </option>
                                    <option value="9" <?php if ($month == 9) echo 'selected="selected"'; ?>>9月

                                    </option>
                                    <option value="10" <?php if ($month == 10) echo 'selected="selected"'; ?>>10月
                                    </option>
                                    <option value="11" <?php if ($month == 11) echo 'selected="selected"'; ?>>11月

                                    </option>
                                    <option value="12" <?php if ($month == 12) echo 'selected="selected"'; ?>>12月
                                    </option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">性別<span style="color:red">*</span></div>
                            </td>
                            <td>
                                <select name="gender">
                                    <option
                                        value="0" <?php if ($profileInfo['Gender'] == 0) echo 'selected="selected"'; ?>>
                                        答えなし
                                    </option>
                                    <option
                                        value="1" <?php if ($profileInfo['Gender'] == 1) echo 'selected="selected"'; ?>>
                                        男性
                                    </option>
                                    <option
                                        value="2" <?php if ($profileInfo['Gender'] == 2) echo 'selected="selected"'; ?>>
                                        女性
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">携帯番号</div>
                            </td>
                            <td><input class="input" name="phone" size="20"
                                       value=<?php echo '"' . $profileInfo['Phone'] . '"'; ?> type="text"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">アドレス</div>
                            </td>
                            <td>
                                <input class="input" name="address" size="20" type="text"
                                       value=<?php echo '"' . $profileInfo['Address'] . '"'; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="td_text">メールアドレス<span style="color:red">*</span></div>
                            </td>
                            <td>
                                <input class="input" name="mail" size="20" type="text"
                                       value=<?php echo '"' . $profileInfo['Email'] . '"'; ?>>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div class="td_text"> <?php if ($profileInfo['UserType'] == 1) {
                                        echo "クレジットカード";
                                    } else echo "銀行口座" ?><span style="color:red">*</span></div>
                            </td>
                            <td>
                                <input class="input" name="paymentInfo" size="20" type="text"
                                       value="<?php if ($profileInfo['UserType'] == 1) {
                                           echo $profileInfo['CreditCard'];
                                       } else {
                                           echo $profileInfo['BankInfo'];
                                       } ?>" style="float: left;"> <span
                                    class="cclogo master"></span>
                                <span class="cclogo visa"></span>
                                <span class="cclogo american_express h-american_express"></span>
                            </td>

                        </tr>


                        <tr>
                            <td></td>
                            <td>
                                <input class="flat_btn" data-act_as="submit" type="submit" value="変更">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>