<div style="background: #f0f0f0; height:100%">
    <div id="contents" style="padding:50px 0px 0px 0px;margin:0px auto;width:600px;height:500px;">
        <div id="content">
             <?php 
                $error = $this->Session->flash();
                if(!empty($error)):
            ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
            <?php endif;?>
            <div class="title"><h3>E-learningをログインする</h3></div>
            <div class="box" style="min-height:350px">
                <div class="login_box">
                    <div class="login_toggle">
                        <span class="arr_icon"><img src="../img/icon/icon_arrow_login.png" /></span>
                        <span class="toggle_text">E-learningアカウントを持っていますか?</span>
                        <?php echo $this->Form->create('User'); ?>
                        <label>
                            <div class="label_text">ユーザ名</div>
                             <?php echo $this->Form->input('Username', array('class'=>'input','type'=>'text','label'=>false));?>
                        </label>
                        <label>
                            <div class="label_text">パスワード</div>
                           <?php echo $this->Form->input('Password', array('class'=>'input','type'=>'password','label'=>false));?>
                        </label>
                        <label style="margin-top:10px;">
                            <input checked="checked" class="checkbox" id="remember" name="remember" type="checkbox" value="1"> ログイン状態を保つ
                        </label>       
                        <input class="flat_btn" style="margin-top:15px; height:40px; font-size:18px;" type="submit" value="Login">               
                        <?php echo $this->Form->end(); ?>
                        <span class="arr_icon"><img src="../img/icon/icon_arrow_login.png" /></span>
                        <span class="toggle_text">あなたは新人ですか? </a><?php echo $this->Html->link('アカウント登録して',array('controller' => 'users','action' => 'sign_up'), array('style'=>'color:blue'));?>  登録は無料です.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    

