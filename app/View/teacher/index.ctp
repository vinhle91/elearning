<div id="contents">
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
                        <?php 
                        if(isset($topLessons)) {
                            echo $this->Html->link('授業', array('controller'=>'Teacher','action'=>'index','?'=>array('top'=>'lesson')),array('class'=>'selected'));
                        } else {
                            echo $this->Html->link('授業', array('controller'=>'Teacher','action'=>'index','?'=>array('top'=>'lesson')));
                        }
?>                        
                    </li>
                    <li>
                        <?php if(isset($topTeachers)){
                            echo $this->Html->link('先生', array('controller'=>'Teacher','action'=>'index','?'=>array('top'=>'teacher')),array('class'=>'selected'));
                        }else {
                            echo $this->Html->link('先生', array('controller'=>'Teacher','action'=>'index','?'=>array('top'=>'teacher')));
                        }
?>                     
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
            <?php if(isset($topLessons)) {?>
            <div class="top" id="t_lesson">
                <?php $paginator = $this->Paginator; ?>
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">番号</td>
                            <td width="20%" style="background-color: #eee;"><?php echo $paginator->sort('Title', 'タイトル'); ?></td>
                            <td width="7%" style="background-color: #eee;"><?php echo $paginator->sort('Category', 'カテゴリィ'); ?></td>
                            <td width="7%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.Author', '先生'); ?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('LikeNumber', 'いいねと言う'); ?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('ViewNumber', 'ビュー'); ?></td>
                            <td width="13%" style="background-color: #eee;"><?php echo $paginator->sort('created', 'パブリック時間'); ?></td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="10%" style="background-color: #eee;">報告</td>
                        </tr>
                        <?php foreach ($topLessons as $lesson): ?>
                            <tr>
                                <td><?php echo ($lesson['Lesson']['LessonId']); ?></td>
                                <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']); ?></a></td>
                                <td><?php echo $Category[$lesson['Lesson']['Category']]; ?></td>
                                <td><?php echo $lesson['Lesson']['Author']; ?></td>
                                <td><?php echo $lesson['Lesson']['LikeNumber']; ?></td>
                                <td><?php echo $lesson['Lesson']['ViewNumber']; ?></td>
                                <td><?php echo $lesson['Lesson']['modified']; ?></td>
                                <td><?php echo $lesson['Lesson']['Abstract']; ?></td>
                                <td> <?php if($lesson['Lesson']['UserId']!=$userId){echo $this->Html->link("報告",array('controller'=>'teacher','action'=>'report',$lesson['Lesson']['LessonId']),array('class'=>'report_btn')); }?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($lesson); ?>   
                    </tbody>
                </table>
                <div class="pager" style="text-align: center">
                    <ul>
                        <li>
                            <?php echo $paginator->first('最初'); ?>
                        </li>
                        <?php if ($paginator->hasPrev()): ?>
                            <li>
                                <?php echo $paginator->prev('前の'); ?>
                            </li>
                        <?php endif; ?>
                        <?php
                        echo $paginator->numbers(array(
                            'separator' => '',
                        ));
                        ?>
                        <?php if ($paginator->hasNext()) : ?>
                        <li>
                            <?php echo $paginator->next('次の'); ?>
                        </li>
                        <?php endif; ?>
                        <li>
                            <?php echo $paginator->last('最後'); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($topTeachers)) {?>
            <div class="top" id="t_teacher">
                <?php $paginator = $this->Paginator; ?>
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">番号</td>
                            <td width="10%" style="background-color: #eee;">アバター</td> 
                            <td width="25%" style="background-color: #eee;"><?php echo $paginator->sort('User.Username', '先生')?></td>
                            <td width="10%" style="background-color: #eee;"><?php echo $paginator->sort('User.totalLesson', '授業')?></td>
                            <td width="10%" style="background-color: #eee;"><?php echo $paginator->sort('User.totalLike', 'いいね')?></td>
                            <td width="10%" style="background-color: #eee;"><?php echo $paginator->sort('User.totalView', 'ビュー')?></td>
                            <td width="30%" style="background-color: #eee;"><?php echo $paginator->sort('User.Email', 'メール')?></td>
                        </tr>
                        <?php foreach($topTeachers as $t) { 
                            $i = 1; ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $this->Html->image('icon/avatar_2.jpg', array('alt' => 'Avatar', 'width' => '65', 'height' => '70')); ?></td>
                            <td><?php echo $t['User']['Username'];?></td>
                            <td><?php echo $t['User']['totalLesson'];?></td>
                            <td><?php echo $t['User']['totalLike'];?></td>
                            <td><?php echo $t['User']['totalView'];?></td>
                            <td><?php echo $t['User']['Email'];?></td>
                        </tr>
                        <?php }?>
                        <?php unset($t); ?> 
                    </tbody>
                </table>  
                <div class="pager" style="text-align: center">
                    <ul>
                        <li>
                            <?php echo $paginator->first('最初'); ?>
                        </li>
                        <?php if ($paginator->hasPrev()): ?>
                            <li>
                                <?php echo $paginator->prev('前の'); ?>
                            </li>
                        <?php endif; ?>
                        <?php
                        echo $paginator->numbers(array(
                            'separator' => '',
                        ));
                        ?>
                        <?php if ($paginator->hasNext()) : ?>
                        <li>
                            <?php echo $paginator->next('次の'); ?>
                        </li>
                        <?php endif; ?>
                        <li>
                            <?php echo $paginator->last('最後'); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="title"><h3>自分の授業</h3></div>                  
        <div class="box">
            <div class="top">
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">ID</td>
                            <td width="30%" style="background-color: #eee;">タイトル</td>
                            <td width="7%" style="background-color: #eee;">ビュー</td>
                            <td width="5%" style="background-color: #eee;">いいね</td>
                            <td width="7%" style="background-color: #eee;"> コメント</td>
                            <td width="19%" style="background-color: #eee;">更新時間</td>
                            <td colspan="3" style="background-color: #eee;">マネジメント</td>
                        </tr>

                        <?php foreach ($lessons as $lesson): ?>

                        <tr style="text-align:center">
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><?php echo $this->Html->link($lesson['Lesson']['Title'],array('controller'=>'Teacher','action'=>'view_lesson',$lesson['Lesson']['LessonId'],$lesson['FileId']));?>
                            </td>
                            <td><?php echo ($lesson['Lesson']['ViewNumber']);?></td>
                            <td><?php echo ($lesson['Lesson']['LikeNumber']);?></td>
                            <td><?php if(isset($lesson['Comment']['0']['Comment']['0']['count'])){echo $lesson['Comment']['0']['Comment']['0']['count'];}else{echo '0';}?></td>
                            <td><?php echo ($lesson['Lesson']['modified']);?></td>
                            <td width="10%"><?php echo $this->Html->link("学生のリスト",array('controller'=>'Teacher','action'=>'list_student',$lesson['Lesson']['LessonId']));?></td>

                            <td width="5%"><?php echo $this->Html->link("更新",array('controller'=>'Teacher','action'=>'edit_lesson',$lesson['Lesson']['LessonId']));?></td>
                            <td width="8%"><?php echo $this->Html->link("削除", array('controller'=>'Teacher','action'=>'delete_lesson',$lesson['Lesson']['LessonId']));?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php unset($lesson);?>  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>