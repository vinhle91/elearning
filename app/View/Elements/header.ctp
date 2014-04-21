<div id="header">
    <div id="t_header">
        <div id="logo"><h3> <?php echo $this->Html->link('E-learning',array('controller' => 'users','action' => 'index'),array('style'=>'color: #fff'));?></h3></div>
        <div id="search">
        <?php
        echo $this->Form->create('Lesson', array('controller'=>'Lesson','action'=>'search'));
        echo $this->Form->input("keyWords",array("label"=>false,"class"=>"frm_search"));
        $options=array('1'=>'全て','2'=>'先生','3'=>'授業','4'=>'タグ');
        echo $this->Form->input( '種類', array(
            'type' => 'select',
            'multiple'=> false,  // 複数選択を不可能にする場合
            'options' => $options,
            'class'=>'frm_search',
            'label'=>false,
            'style'=>'width:50px;height:30px;padding:0px'
        ));
        echo $this->Form->submit('検索',array("class"=>"btn_search"));
        echo $this->Form->end();
        ?>
        </div>
        <?php
        if($this->Session->check('Auth.User')): ?>
            <a href="javascript:void()" id="profile">
                <span class="full_name">
                  <?php echo $users_username['FullName'];?>
                </span>
                <span class="arr"></span>
            </a>
            <?php if($user_type == 2):?>
            <?php echo $this->Html->link('アップロード',array('controller' => 'Teacher','action' => 'make_lesson',$users_username['UserId']),array('class'=>'btn_upload'));?>
            <div class="profilenav">
                <ul>
                    <li class="icon">
                        <span style="background-position: -168px 0;"></span><?php echo $this->Html->link("プロフィールを見る",array('controller'=>'Users','action'=>'view_profile',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -240px 0;"></span><?php echo $this->Html->link("トランザクション履歴",array('controller'=>'Teacher','action'=>'transaction_history',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -432px 0;"></span>
                        <?php echo $this->Html->link("セキュリティ",array('controller'=>'Users','action'=>'update_security',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -72px 0;"></span>
                        <?php echo $this->Html->link("メッセージ",array('controller'=>'Teacher','action'=>'view_message'));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -383px 0;"></span><?php echo $this->Html->link( "ログアウト",   array('controller'=>'Users','action'=>'logout') ); ?>
                    </li>
                </ul>
            </div>
            <?php endif;?>
            <?php if($user_type == 1):?>
            <div class="profilenav">
                <ul>
                    <li class="icon">
                        <span style="background-position: -168px 0;"></span><?php echo $this->Html->link("プロフィールを見る",array('controller'=>'Users','action'=>'view_profile',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -240px 0;"></span><?php echo $this->Html->link("トランザクション履歴",array('controller'=>'Student','action'=>'transaction_history',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -432px 0;"></span>
                        <?php echo $this->Html->link("セキュリティ",array('controller'=>'Users','action'=>'update_security',$users_username['UserId']));?>
                    </li>
                    <li class="icon">
                        <span style="background-position: -383px 0;"></span><?php echo $this->Html->link( "ログアウト",   array('controller'=>'Users','action'=>'logout') ); ?>
                    </li>
                </ul>
            </div>
            <?php endif;?>
        <?php else:?>
            <div id="login">
                <span>
                    <?php echo $this->Html->link('ログイン',array('controller' => 'users','action' => 'login'));?>
                </span>
               <!--  <?php debug($this->params['action'])?>  -->
                <?php if ($this->params['action'] != 'sign_up'): ?>
                <span style="color:#fff">/</span>
                <span>
                    <?php echo $this->Html->link('サインアップ',array('controller' => 'users','action' => 'sign_up'));?>
                </span>
                <?php endif?>
            </div>
        <?php endif ?>
    </div>
</div>