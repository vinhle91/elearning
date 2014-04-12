<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
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
                        <a href="javascript:void(0)" class="selected t_lesson">
                            <span>トップ授業</span>
                        </a>                          
                    </li>
                    <li>
                       <a href="javascript:void(0)" class="t_teacher">
                            <span>トップ先生</span>
                       </a>                       
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="top" id="t_lesson">
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">番号</td>
                            <td width="25%" style="background-color: #eee;">タイトル</td>
                            <td width="7%" style="background-color: #eee;">カテゴリィ</td>
                            <td width="5%" style="background-color: #eee;"> いいねと言う</td>
                            <td width="5%" style="background-color: #eee;">ビュー</td>
                            <td width="13%" style="background-color: #eee;">パブリック時間</td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="5%" style="background-color: #eee;">購入</td>          
                        </tr>
                        <?php foreach ($topLessons as $lesson): ?>
                        <tr>
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']);?></a></td>
                            <td><?php echo $Category[$lesson['Lesson']['Category']];?></td>
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
                <div class="load_more">
                    <a href="javascrip:void(0)">もっと見る</a>
                </div>                       
            </div>
            <div class="top" id="t_teacher" style="display:none">
                 <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="5%" style="background-color: #eee;">番号</td>
                            <td width="10%" style="background-color: #eee;">アバター</td> 
                            <td width="25%" style="background-color: #eee;">先生</td>
                            <td width="10%" style="background-color: #eee;">授業</td>
                            <td width="10%" style="background-color: #eee;"> いいねと言う</td>
                            <td width="10%" style="background-color: #eee;">ビュー</td>
                            <td width="30%" style="background-color: #eee;">メール</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><?php echo $this->Html->image('icon/avatar_2.jpg', array('alt' => 'Avatar', 'width'=>'65','height'=>'70')); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>                                            
                <div class="load_more load_more_btn" >
                    <span class="normal_text">もっと見る</span>
                </div>                       
            </div>
        </div>
        <div class="title"><h3>勉強しているもの</h3></div>     
        <div class="box">
           <!--  <div class="order">
                順序を決める : 
                <?php echo $this->Html->link('時間', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'time'))); ?>
                <span>-</span>
                <?php echo $this->Html->link('Like', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'like'))); ?>
                <span>-</span>
                <?php echo $this->Html->link('見る事', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'view'))); ?>
            </div> -->
            <div class="top">
                <?php $paginator = $this->Paginator; ?>
                <table border = "1" align = "center" id = "mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width = "8%" style = "background-color: #eee;">番号</td>
                            <td width = "25%" style = "background-color: #eee;"><?php echo $paginator->sort('Lesson.Title', 'タイトル'); ?></td>
                            <td width = "8%" style = "background-color: #eee;"><?php echo $paginator->sort('User.Username', '先生'); ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo $paginator->sort('StudentHistory.StartDate', '始め時間'); ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo $paginator->sort('StudentHistory.ExpiryDate', '終わり時間'); ?></td>
                            <td colspan = "3" style = "background-color: #eee;">管理</td>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($histories as $item): 
                             $i++;
                         ?>
                        <tr style="text-align:center">
                            <td><?php echo $i;?></td>
                            <td><?php echo $this->Html->link($item['Lesson']['Title'], array('controller' => 'student', 'action' => 'view_lesson', $item['Lesson']['LessonId'],$item['FileId']));?></td>
                            <td><?php echo $item['User']['Username'];?></td>
                            <td><?php echo $item['StudentHistory']['StartDate'];?></td>
                            <td><?php echo $item['StudentHistory']['ExpiryDate'];?></td>
                            <td><?php echo $this->Html->link('勉強', array('controller' => 'student', 'action' => 'view_lesson', $item['Lesson']['LessonId'],$item['FileId']));?></td>
                            <td><?php echo $this->Html->link('テスト', array('controller' => 'student', 'action' => 'test', $item['Lesson']['LessonId'],$item['TestId']));?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
                
               <!--  <ul>
                   <a href="#">← Previous</a></li>
                    <li class="active"><a rel="start" href="#">1</a></li>
                    <li><a rel="next" href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="next next_page "><a rel="next" href="#">Next →</a></li>
                </ul>
            </div>  -->
            <div class="pager" style="text-align: center">
                <ul>
                    <li>
                        <?php echo $paginator->first('最初'); ?>
                    </li>
                    <?php
                    if ($paginator->hasPrev()): ?>
                    <li>
                        <?php echo $paginator->prev('前の');?>
                    </li>
                    <?php endif;?>
                    <?php
                        echo $paginator->numbers(array(
                            'separator' => ' | ',
                        ));
                    ?>
                    <?php
                    if ($paginator->hasNext()) : ?>
                    <li>
                         <?php echo $paginator->next('次の'); ?>
                    </li>
                    <?php endif;?>
                    <li>
                        <?php echo $paginator->last('最後'); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".buy_bt").click(function(){
        var r=confirm("Are you sure you want to buy this lesson?");
        if (r==true)
        {
            window.location.pathname($(this).attr("href"));
        }
    })
});
// $(document).ready(function() {
//     $(".load_more").click(function(){
//         $.ajax({
//         url: '<?php echo $this->Html->url(array('controller'=> 'student','action' => 'view_schedule1',$id, strtotime("-1 day", $weekMondayTime)))?>',
//         //data: form.serialize(),
//         success: function(response) {
//             $("#table_double").html(response);
//             $("#button-add3").attr("disabled", false);
//             $("#button-add2").attr("disabled", false);
//             $("#button-add1").attr("disabled", false);
//             $("#loading-3").hide();
//         },
//         error : function(){
//             alert("error");
//         }
//     })
// });
// }
</script>