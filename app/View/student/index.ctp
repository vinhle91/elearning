<div id="contents" style="margin-left:220px">
<?php echo $this->Element('cat_menu');?>
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
                        <?php 
                        if(isset($topLessons)) {
                            echo $this->Html->link('授業', array('controller'=>'Student','action'=>'index','?'=>array('top'=>'lesson')),array('class'=>'selected'));
                        } else {
                            echo $this->Html->link('授業', array('controller'=>'Student','action'=>'index','?'=>array('top'=>'lesson')));
                        }
?>                        
                    </li>
                    <li>
                        <?php if(isset($topTeachers)){
                            echo $this->Html->link('先生', array('controller'=>'Student','action'=>'index','?'=>array('top'=>'teacher')),array('class'=>'selected'));
                        }else {
                            echo $this->Html->link('先生', array('controller'=>'Student','action'=>'index','?'=>array('top'=>'teacher')));
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
                            <td width="25%" style="background-color: #eee;"><?php echo $paginator->sort('Title', 'タイトル'); ?></td>
                            <!-- <td width="7%" style="background-color: #eee;"><?php echo $paginator->sort('Category', 'カテゴリィ'); ?></td> -->
                            <td width="7%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.Author', '先生'); ?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('LikeNumber', 'いいねと言う'); ?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('ViewNumber', 'ビュー'); ?></td>
                            <td width="13%" style="background-color: #eee;"><?php echo $paginator->sort('created', 'パブリック時間'); ?></td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="5%" style="background-color: #eee;">購入</td>          
                        </tr>
                        <?php foreach ($topLessons as $lesson): ?>
                            <tr>
                                <td><?php echo ($lesson['Lesson']['LessonId']); ?></td>
                                <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']); ?></a></td>
                                <!-- <td><?php echo $Category[$lesson['Lesson']['Category']]; ?></td> -->
                                <td><?php echo $lesson['Lesson']['Author']; ?></td>
                                <td><?php echo $lesson['Lesson']['LikeNumber']; ?></td>
                                <td><?php echo $lesson['Lesson']['ViewNumber']; ?></td>
                                <td><?php echo $lesson['Lesson']['modified']; ?></td>
                                <td><?php echo $lesson['Lesson']['Abstract']; ?></td>
                                <td>
                                    <?php if ($lesson['Lesson']['isStudying'] && $lesson['Lesson']['isBlocked'] == 0) { ?>
                                        <span class="bought_bt"><?php echo $this->Html->image('icon/yes.png'); ?> 既婚入</span>              
                                    <?php } else if ($lesson['Lesson']['isBlocked'] == 1) { ?>
                                    <?php } else { ?>
                                        <?php echo $this->Html->link('購入', array('controller' => 'Student', 'action' => 'buy_lesson', $lesson['Lesson']['LessonId']), array('class' => 'buy_bt', 'id' => $lesson['Lesson']['LessonId'])); ?>
                                    <?php } ?>
                                </td>
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
        <div class="title"><h3>勉強しているもの</h3></div>     
        <div class="box">
            <div class="order">
                順序を決める : 
                <?php echo $this->Html->link('時間', array('controller' => 'Student', 'action' => 'index', "?" => array('sortBy' => 'time', 'direction' => $direction))); ?>
                <span>-</span>
                <?php echo $this->Html->link('いいね数', array('controller' => 'Student', 'action' => 'index', "?" => array('sortBy' => 'like', 'direction' => $direction))); ?>
                <span>-</span>
                <?php echo $this->Html->link('見る事', array('controller' => 'Student', 'action' => 'index', "?" => array('sortBy' => 'view', 'direction' => $direction))); ?>
                <span>-</span>
                <?php echo $this->Html->link('タイトル', array('controller' => 'Student', 'action' => 'index', "?" => array('sortBy' => 'title', 'direction' => $direction))); ?>
            </div>
            <div class="top">
                <table border = "1" align = "center" id = "mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width = "5%" style = "background-color: #eee;">番号</td>
                            <td width = "25%" style = "background-color: #eee;"><?php echo 'タイトル'; ?></td>
                            <!-- <td width = "8%" style = "background-color: #eee;"><?php echo '先生'; ?></td> -->
                            <td width = "5%" style = "background-color: #eee;"><?php echo 'いいね'; ?></td>
                            <td width = "5%" style = "background-color: #eee;"><?php echo 'ビュー'; ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo '始め時間'; ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo '終わり時間'; ?></td>
                            <td colspan = "2" style = "background-color: #eee;">管理</td>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($histories as $item):
                            $i++;
                            ?>
                            <tr style="text-align:center">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $this->Html->link($item['Lesson']['Title'], array('controller' => 'student', 'action' => 'view_lesson', $item['Lesson']['LessonId'], $item['FileId'])); ?></td>
                                <!-- <td><?php echo $item['User']['Username']; ?></td> -->
                                <td><?php echo $item['Lesson']['LikeNumber']; ?></td>
                                <td><?php echo $item['Lesson']['ViewNumber']; ?></td>
                                <td><?php echo $item['StudentHistory']['StartDate']; ?></td>
                                <td><?php echo $item['StudentHistory']['ExpiryDate']; ?></td>
                                <td><?php echo $this->Html->link('勉強', array('controller' => 'student', 'action' => 'view_lesson', $item['Lesson']['LessonId'], $item['FileId'])); ?></td>
                                <td><?php echo $this->Html->link('テスト', array('controller' => 'student', 'action' => 'test', $item['Lesson']['LessonId'], $item['TestId'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!--            -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var fee = <?php echo $course_fee ?>;
        $(".buy_bt").click(function() {
            var r = confirm("このレッスンを購入してもよろしいですか"+fee+"VNDかかります");
            if (r == true)
            {
                window.location.pathname($(this).attr("href"));
            }
        })
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".load_more").click(function() {

        });
    });
</script>