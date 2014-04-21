<?php define("LESSON", "Lesson", true) ?>
<?php define("TEACHER","User",true) ?>
<?php //if (isset($results)) { echo "<pre>";print_r($results); echo "</pre>";} ?>
<div id="contents">
<!--     <?php echo $this->Element('cat_menu'); ?> -->
    <div id="content">
        <?php
        $error = $this->Session->flash();
        if (!empty($error)):
            ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="t_title">
            <div class="left">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="selected t_lesson">
                            <span>検索結果</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="top" id="t_lesson">
                <?php if(isset($results)): ?>
                    <?php
                    if(sizeof($results)==0):?>
                        <h2><?php echo $keyWord?>での検索も結果は得られなかった。</h2>
                    <?php else :?>
                    <table border="1" align="center" id="mylesson">
                        <tbody>
                            <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                                <td width="5%" style="background-color: #eee;">ID</td>
                                <td width="23%" style="background-color: #eee;"> タイトル</td>
                                <td width="7%" style="background-color: #eee;">カテゴリィ</td>
                                <td width="7%" style="background-color: #eee;">先生</td>
                                <td width="5%" style="background-color: #eee;">いいねと</td>
                                <td width="5%" style="background-color: #eee;">ビュー</td>
                                <td width="13%" style="background-color: #eee;">パブリック時間</td>
                                <td width="25%" style="background-color: #eee;">記述</td>
                                <?php if($UserType ==1):?>
                                <td width="10%" style="background-color: #eee;">購入</td>
                                <?php else:?>
                                <td width="10%" style="background-color: #eee;">報告</td>
                                <?php endif;?>           
                            </tr>
                            <?php foreach ($results as $reuslt): ?>
                                <tr>
                                    <td><?php echo ($reuslt['Lesson']['LessonId']); ?></td>
                                    <td><a href="javascript:void(0)"><?php echo ($reuslt['Lesson']['Title']); ?></a></td>
                                    <td><?php echo $Category[$reuslt['Lesson']['Category']]; ?></td>
                                    <td><?php echo $reuslt['User']['FullName']; ?></td>
                                    <td><?php echo $reuslt['Lesson']['LikeNumber']; ?></td>
                                    <td><?php echo $reuslt['Lesson']['ViewNumber']; ?></td>
                                    <td><?php echo $reuslt['Lesson']['modified']; ?></td>
                                    <td><?php echo $reuslt['Lesson']['Abstract']; ?></td>
                                    <td>
                                    <?php if($UserType ==1):?>
                                       <?php if ($reuslt['Lesson']['isStudying'] && $reuslt['Lesson']['isBlocked'] == 0) { ?>
                                            <span class="bought_bt"><?php echo $this->Html->image('icon/yes.png'); ?> 既婚入</span>              
                                        <?php } else if ($reuslt['Lesson']['isBlocked'] == 1) { ?>
                                        <?php } else { ?>
                                            <?php echo $this->Html->link('購入', array('controller' => 'Student', 'action' => 'buy_lesson', $reuslt['Lesson']['LessonId']), array('class' => 'buy_bt')); ?>
                                        <?php } ?>
                                    <?php else:?>
                                        <?php if($reuslt['User']['UserId']!=$userId){echo $this->Html->link("報告",array('controller'=>'teacher','action'=>'report',$reuslt['Lesson']['LessonId']),array('class'=>'report_btn')); }?>
                                    <?php endif;?>    
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($reuslt); ?> 
                            </tbody>
                        </table>  
                    <?php endif;?>
                <?php endif;?>           
            </div>
        </div>
    </div>
</div>