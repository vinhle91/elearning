<div id="contents">
    <?php echo $this->Element('cat_menu');?>
	<div id="content">
        <?php 
            $error = $this->Session->flash();
            if(!empty($error)):
        ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php endif;?>
        <div id="news">
            <span><a href="javascript:void(0)"><img src="img/new1.jpg"  /></a></span>
            <span><a href="javascript:void(0)"><img src="img/new2.jpg"  /></a></span>
            <span><a href="javascript:void(0)"><img src="img/new3.jpg"  /></a></span>
            <span><a href="javascript:void(0)"><img src="img/new4.jpg"  /></a></span>
            <span><a href="javascript:void(0)"><img src="img/new5.jpg"  /></a></span>
        </div>
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
                        <?php foreach ($allLessons as $lesson): ?>
                        <tr>
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']);?></a></td>
                            <td><?php echo $Category[$lesson['Lesson']['Category']];?></td>
                            <td><?php echo $lesson['Lesson']['LikeNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['ViewNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['modified'];?></td>
                            <td><?php echo $lesson['Lesson']['Abstract'];?></td>
                            <td><?php echo $this->Html->link('購入',array('controller'=>'Student','action'=>'buy_lesson',$lesson['Lesson']['LessonId']),array('class'=>'buy_bt'));?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php unset($lesson);?>   
                    </tbody>
                </table>                                              
                <div class="load_more load_more_btn" >
                    <span class="normal_text">もっと見る</span>
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
    </div>
</div>