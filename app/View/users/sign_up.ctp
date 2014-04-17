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
        <div class="title"><h3>アカウントを登録</h3></div>
        <div class="box">
            <div class="sign_up_box">                           
                <?php echo $this->Form->create('User');?>                               
                    <div class="input_error"></div>
                    <table class="sign_up_tb">
                        <tbody>
                            <tr>
                                <td align="left"><div class="td_text"><h3>アカウントについて情報</div></h3></td>
                                <td colspan="2" align="left"></td>
                            </tr>
                            <tr>
                                <td style="width:230px"> 
                                    <div class="td_text">ユーザ名<span style="color:red">*</span></div>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('Username', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr>
                                <td> 
                                    <div class="td_text">パスワード<span style="color:red">*</span></div>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('Password', array('class'=>'input','type'=>'password','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr>
                                <td> 
                                    <div class="td_text">パスワードを確認<span style="color:red">*</span></div>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('PasswordConfirm', array('class'=>'input','type'=>'password','label'=>false,'div'=>false));?>
                                </td>
                            </tr>

                            <tr>
                                <td> <div class="td_text">アカウントタイプ<span style="color:red">*</span></div></td>
                                <td>
                                    <select name="data[User][UserType]" id="account_type">
                                        <option value="1" selected="selected" >学生</option>
                                        <option value="2" >先生</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="student_info">                       
                                <td colspan="2" align="left"><div class="td_text"><h3>学生のプロファイル</div></h3></td>
                            </tr>
                            <tr class="teacher_info" style="display:none">                      
                                <td colspan="2" align="left"><div class="td_text"><h3>先生のプロファイル</div></h3></td>
                            </tr>

                            <tr>
                                <td > <div class="td_text">名前<span style="color:red">*</span></div></td>
                                <td>
                                    <?php echo $this->Form->input('FullName', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr class="teacher_info" style="display:none">
                            <td>
                                    <div class="td_text">セキュリティ質問<span style="color:red">*</span></div>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('VerifyCodeQuestion', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr class="teacher_info" style="display:none">
                            <td>
                                    <div class="td_text">答え<span style="color:red">*</span></div>
                                </td>
                                <td>
                                    <?php echo $this->Form->input('VerifyCodeAnswer', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr>
                                <td> <div class="td_text">誕生日</div></td>
                                <td>
                                    <?php
                                    echo $this->Form->input('Birthday', array(
                                        'label' => false,
                                        'class' =>'input',
                                        'dateFormat' => 'DMY',
                                        'minYear' => date('Y') - 70,
                                        'maxYear' => date('Y') - 18,
                                        'style'=>'width:96px',
                                    ));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td> <div class="td_text">性別</div></td>
                                <td>
                                    <?php
                                    echo $this->Form->select('Gender', array(
                                        '0' => '他',
                                        '1' => '男性',
                                        '2' => '女性',
                                    ));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td> <div class="td_text">電話番号</div></td>
                                <td><?php echo $this->Form->input('Phone', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?></td>
                            </tr>
                            <tr>
                                <td> <div class="td_text">メール<span style="color:red">*</span></div></td>
                                <td><?php echo $this->Form->input('Email', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?></td>
                            </tr>
                            <tr>
                                <td> <div class="td_text">住所</div></td>
                                <td><?php echo $this->Form->input('Address', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?></td>
                            </tr>
                            </tr>
                            <tr class="student_info">
                                <td> <div class="td_text"> クレジットカード</div></td>
                                <td>
                                    <?php echo $this->Form->input('CreditCard', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>      
                                </td>
                            </tr>
                            <tr class="teacher_info" style="display:none">
                                <td> <div class="td_text">銀行預金</div></td>
                                <td>
                                    <?php echo $this->Form->input('BankInfo', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                <?php
                                echo $this->Form->checkbox('TermsOfService', array('checked' => false));
                                ?>
                                E-learningの<a href="#">サービス条件</a>と<a href="#">プライバシー方針に</a>賛成する
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> <input class="flat_btn" data-act_as="submit" type="submit" value="Sign up"></td>
                            </tr>
                        </tbody>
                    </table>
                <?php echo $this->Form->end(); ?>                            
            </div>
        </div>
    </div>
</div>