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
                        <a href="#" class="selected"><h3><?php echo $cat['Category']['CatName']; ?></h3></a>
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
                            <td width="25%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.Title','タイトル');?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.LikeNumber', 'いいねと言う');?></td>
                            <td width="5%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.ViewNumber', 'ビュー');?></td>
                            <td width="13%" style="background-color: #eee;"><?php echo $paginator->sort('Lesson.modified','パブリック時間');?></td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="10%" style="background-color: #eee;">報告</td>
                            
                        </tr>
                        <?php   foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']);?></a></td>
                            <td><?php echo $lesson['Lesson']['LikeNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['ViewNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['modified'];?></td>
                            <td><?php echo $lesson['Lesson']['Abstract'];?></td>
                            <td> <?php if($lesson['Lesson']['UserId']!=$userId){echo $this->Html->link("報告",array('controller'=>'teacher','action'=>'report',$lesson['Lesson']['LessonId']),array('class'=>'report_btn')); }?></td>
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