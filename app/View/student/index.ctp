<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
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
        <div class="title"><h3>勉強しているもの</h3></div>     
        <div class="box">
            <div class="order">
                順序を決める : 
                <?php echo $this->Html->link('時間', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'time'))); ?>
                <span>-</span>
                <?php echo $this->Html->link('Like', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'like'))); ?>
                <span>-</span>
                <?php echo $this->Html->link('見る事', array('controller'=>'Student', 'action' => 'index', "?"=>array('sortBy'=>'view'))); ?>
            </div>
            <div class="top">
                <?php $paginator = $this->Paginator; ?>
                <table border = "1" align = "center" id = "mylesson">
                    <tbody>
                        <tr>
                            <td width = "8%" style = "background-color: #eee;">番号</td>
                            <td width = "25%" style = "background-color: #eee;"><?php echo $paginator->sort('Lesson.Title', 'タイトル'); ?></td>
                            <td width = "8%" style = "background-color: #eee;"><?php echo $paginator->sort('User.Username', '先生'); ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo $paginator->sort('StudentHistory.StartDate', '始め時間'); ?></td>
                            <td width = "19%" style = "background-color: #eee;"><?php echo $paginator->sort('StudentHistory.ExpiryDate', '終わり時間'); ?></td>
                            <td colspan = "3" style = "background-color: #eee;">管理</td>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($histories as $item) {
                            echo "<tr>";
                            $i++;
                            echo "<td>{$i}</td>";
                            echo "<td>{$item['Lesson']['Title']}</td>";
                            echo "<td>{$item['User']['Username']}</td>";
                            echo "<td>{$item['StudentHistory']['StartDate']}</td>";
                            echo "<td>{$item['StudentHistory']['ExpiryDate']}</td>";
                            echo "<td>" . $this->Html->link('勉強', array('controller' => 'student', 'action' => 'view_lesson', $item['Lesson']['LessonId'])) . "</td>";
                            echo "<td>" . $this->Html->link('テスト', array('controller' => 'student', 'action' => 'test', $item['Lesson']['LessonId'])) . "</td>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="paging" style="text-align: center">
                <ul>
                    <?php echo $paginator->first('最初'); ?>
                    <?php
                    if ($paginator->hasPrev()) {
                        echo $paginator->prev('前の');
                    }
                    ?>
                    <?php
                    echo $paginator->numbers(array(
                        'separator' => ' | ',
                    ));
                    ?>

                    <?php
                    if ($paginator->hasNext()) {
                        echo $paginator->next('次の');
                    }
                    ?>
                    <?php echo $paginator->last('最後'); ?>
                </ul>
            </div>
        </div>
    </div>
</div>