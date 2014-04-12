<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
    <div id="content">
       <!--  <div id="news">
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new1.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new2.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new3.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new4.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new5.jpg', array('alt' => 'New')); ?></a></span>
        </div> -->
        <div class="t_title">
            <div class="left">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="selected"><h3><?php echo $cat['Category']['CatName']; ?></h3></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="box">
            <?php $paginator = $this->Paginator; ?>
            <div class="top" id="t_lesson">
                <?php
                if(sizeof($lessons)==0):?>
                <h2>このカテゴリは授業がありません</h2>
                <?php else :?>
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">番号</td>
                            <td width="25%" style="background-color: #eee;">タイトル</td>
                            <td width="5%" style="background-color: #eee;"> いいねと言う</td>
                            <td width="5%" style="background-color: #eee;">ビュー</td>
                            <td width="13%" style="background-color: #eee;">パブリック時間</td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="5%" style="background-color: #eee;">購入</td>
                            
                        </tr>
                        <?php   foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']);?></a></td>
                            <td><?php echo $lesson['Lesson']['LikeNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['ViewNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['modified'];?></td>
                            <td><?php echo $lesson['Lesson']['Abstract'];?></td>
                            <td>
                             <?php if($lesson['Lesson']['isStudying']&&$lesson['Lesson']['isBlocked'] == 0){?>
                                <span class="bought_bt"><?php echo $this->Html->image('icon/yes.png'); ?> 既婚入</span>              
                            <?php }else if($lesson['Lesson']['isBlocked'] == 1){?>
                            <?php }else{?>
                            <?php echo $this->Html->link('購入',array('controller'=>'Student','action'=>'buy_lesson',$lesson['Lesson']['LessonId']),array('class'=>'buy_bt','id'=>$lesson['Lesson']['LessonId']));?>
                             <?php }?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php unset($lesson);?>   
                    </tbody>
                </table>
                <?php endif;?>          
            </div>
            <div class="paging" style="text-align: center">
                <ul>
                    <span>
                        <?php echo $paginator->first('最初'); ?>
                    </span>
                    <?php
                    if ($paginator->hasPrev()) {
                        echo "<span>";
                        echo $paginator->prev('前');
                        echo "</span>";
                    }
                    ?>
                    <?php
                    echo $paginator->numbers(array(
                        'separator' => ' | ',
                        'tag' => 'span',
                    ));
                    ?>
                    <?php
                    if ($paginator->hasNext()) {
                        echo "<span>";
                        echo $paginator->next('次');
                        echo "</span>";
                    }
                    ?>
                    <span>
                        <?php echo $paginator->last('最後'); ?>
                    </span>
                </ul>
            </div>
        </div>
    </div>
</div>