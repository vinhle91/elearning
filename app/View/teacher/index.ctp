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
                            <td width="4%" style="background-color: #eee;">番号</td>
                            <td width="20%" style="background-color: #eee;">タイトル</td>
                            <td width="7%" style="background-color: #eee;">カテゴリィ</td>
                            <td width="5%" style="background-color: #eee;"> いいねと言う</td>
                            <td width="5%" style="background-color: #eee;">ビュー</td>
                            <td width="10%" style="background-color: #eee;">パブリック時間</td>
                            <td width="27%" style="background-color: #eee;">記述</td>
                            <td width="8%" style="background-color: #eee;">報告</td>    
                        </tr>
                        <?php foreach ($allLessons as $lesson): ?>
                        <tr style="text-align:center">
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']);?></a></td>
                            <td><?php echo $Category[$lesson['Lesson']['Category']];?></td>
                            <td><?php echo $lesson['Lesson']['LikeNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['ViewNumber'];?></td>
                            <td><?php echo $lesson['Lesson']['modified'];?></td>
                            <td style="text-align:left"><?php echo $lesson['Lesson']['Abstract'];?></td>
                            <td> <div class="report_btn"> 報告</div> </td>
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
                                 
                <div class="load_more load_more_btn" >
                    <span class="normal_text">LOAD MORE</span>
                </div>                       
            </div>
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
                            <td width="5%" style="background-color: #eee;">いいねと言う</td>
                            <td width="7%" style="background-color: #eee;"> コメント</td>
                            <td width="19%" style="background-color: #eee;">更新時間</td>
                            <td colspan="3" style="background-color: #eee;">マネジメント</td>
                        </tr>

                        <?php foreach ($lessons as $lesson): ?>

                        <tr style="text-align:center">
                            <td><?php echo ($lesson['Lesson']['LessonId']);?></td>
                            <td><?php echo $this->Html->link($lesson['Lesson']['Title'],array('controller'=>'Teacher','action'=>'view_lesson',$lesson['Lesson']['LessonId']));?>
                            </td>
                            <td><?php echo ($lesson['Lesson']['ViewNumber']);?></td>
                            <td><?php echo ($lesson['Lesson']['LikeNumber']);?></td>
                            <td><?php if(isset($lesson['Comment']['0']['Comment']['0']['count'])){echo $lesson['Comment']['0']['Comment']['0']['count'];}else{echo '0';}?></td>
                            <td><?php echo ($lesson['Lesson']['modified']);?></td>
                            <td width="10%"><?php echo $this->Html->link("学生のリスト",array('controller'=>'Teacher','action'=>'list_student',$lesson['Lesson']['LessonId']));?></td>

                            <td width="5%"><a href="#">更新</a></td>
                            <td width="8%"><a href="#">削除</a></td>
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