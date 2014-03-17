<div id="contents">
    <?php echo $this->Element('cat_menu');?>
	<div id="content">
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
                        <tr>
                            <td width="4%" style="background-color: #eee;">ID</td>
                            <td width="25%" style="background-color: #eee;">タイトル</td>
                            <td width="10%" style="background-color: #eee;">カテゴリィ</td>
                            <td width="5%" style="background-color: #eee;"> いいねと言う</td>
                            <td width="5%" style="background-color: #eee;">ビュー</td>
                            <td width="7%" style="background-color: #eee;">パブリック時間</td>
                            <td width="30%" style="background-color: #eee;">記述</td>
                            
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
                <div class="row">
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Mac Hieu</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">11 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">10</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1000</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_1.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Ngo Thang</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">21 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">1042</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">10230</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_2.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">An Danh</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">8 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">102</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1230</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Mac Hieu</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">11 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">10</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1000</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_1.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Ngo Thang</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">21 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">1042</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">10230</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_2.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">An Danh</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">8 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">102</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1230</span>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Mac Hieu</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">11 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">10</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1000</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_1.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">Ngo Thang</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">21 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">1042</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">10230</span>
                        </div>
                    </div>
                    <div class="teacher">
                        <div class="imageThumbContainer">
                            <img width="96" height="96" id="preview" title="mrhieusd" alt="mrhieusd" src="images/icon/avatar_2.jpg" class="imageThumb">
                        </div>
                        <div class="ls_title">
                            <a href="#">An Danh</a>      
                        </div>
                        <div class="stat_row">
                            <span class="label">Uploads</span>
                            <span class="value">8 lessons</span>
                        </div>
                        <div>
                            <span class="label"><img src="images/icon/icon-like.png"/> Likes</span>
                            <span class="value">102</span>
                        </div>
                        <div>
                            <span class="label"> <img src="images/icon/icon-hits-12.png" /> Views</span>
                            <span class="value">1230</span>
                        </div>
                    </div>
                </div>                                     
                <div class="load_more load_more_btn" >
                    <span class="normal_text">LOAD MORE</span>
                </div>                       
            </div>
        </div>
        <div class="title"><h3>自分の授業</h3></div>                  
        <div class="box">
<!--             <div class="order">
                Sort by: 
                <a class="selected" href="javascript:;">Time</a>
                <span>-</span>
                <a href="#">Like</a>
                <span>-</span>
                <a href="#">Views</a>
            </div> -->
            <div class="top">
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr>
                            <td width="8%" style="background-color: #eee;">ID</td>
                            <td width="30%" style="background-color: #eee;">タイトル</td>
                            <td width="7%" style="background-color: #eee;">ビュー</td>
                            <td width="5%" style="background-color: #eee;">いいねと言う</td>
                            <td width="7%" style="background-color: #eee;"> コメント</td>
                            <td width="19%" style="background-color: #eee;">更新時間</td>
                            <td colspan="3" style="background-color: #eee;">マネジメント</td>
                        </tr>

                        <?php foreach ($lessons as $lesson): ?>

                        <tr>
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
<!--             <div class="pager">
                <ul>
                    <li class="prev previous_page disabled"><a href="#">← Previous</a></li>
                    <li class="active"><a rel="start" href="#">1</a></li>
                    <li><a rel="next" href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="next next_page "><a rel="next" href="#">Next →</a></li>
                </ul>
            </div> -->
        </div>
    </div>
</div>
</div>