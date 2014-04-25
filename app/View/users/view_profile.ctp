<div id="contents">
    <div id="content">
        <div class="title"><h3>個人的な情報</h3></div>
        <div class="box">
            <div class="sign_up_box">
                <table class="sign_up_tb">
                    <tbody>
                    <tr>
                        <td colspan="2"><?php echo $this->Html->link("プロフィール編集", array('controller' => 'Users', 'action' => 'edit_profile', $users_username['UserId']), array('class' => 'btn')); ?>
                            <?php echo $this->Html->link("脱退する", array('controller' => 'Users', 'action' => 'delete_account', $users_username['UserId']), array('class' => 'btn')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">名前</div>
                        </td>
                        <td>
                            <?php echo $profileInfo['FullName']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">誕生日</div>
                        </td>
                        <td>
                            <?php echo $profileInfo['Birthday']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">性別</div>
                        </td>
                        <td>
                            <?php echo $profileInfo['Gender']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">携帯電話番号</div>
                        </td>
                        <td><?php echo $profileInfo['Phone']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">メール
                        </td>
                        <td><?php echo $profileInfo['Email']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td_text">アドレス</div>
                        </td>
                        <td><?php echo $profileInfo['Address']; ?></td>
                    </tr>
                    </tr>
                    <tr class="student_info">
                        <td>
                            <div class="td_text"> クレジットカード</div>
                        </td>
                        <td>
                            <?php echo $profileInfo['CreditCard']; ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>