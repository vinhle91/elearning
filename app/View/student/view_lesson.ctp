<div id="contents">
    <div id="content">
        <?php
        $error = $this->Session->flash();
        if (!empty($error)):
            ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="box1">
            <div class="view_lesson"> 
                <div class="actions">
                    <div class="left">
                        <ul class="tabs">
                            <?php foreach ($list_file as $k => $v): ?>
                                <li <?php
                                if ($file_id == $v['File']['FileId']) {
                                    echo 'class="active"';
                                }
                                ?> >                             
                                    <a href="/elearning/student/view_lesson/<?php echo $lesson_id ?>/<?php echo $v['File']['FileId'] ?>">
                                        <span>ファイル <?php echo $k + 1; ?></span>
                                    </a>                          
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>         
                </div>
                <div class="light_player">                       
                    <div style="width: 100%;">
                        <?php if (!empty($lesson['File'])): ?>
                            <?php foreach ($lesson['File'] as $key => $value): ?>
                                <?php if ($value['Extension'] == 'pdf'): ?>
                                    <div class="<?php echo 'file' . $key ?> file_l">
                                        <object data="<?php echo '/elearning' . $value['FileLink'] ?>" type="application/pdf" width='945' height='704'></object>

                                    </div>
                                <?php endif; ?>
                                <?php if ($value['Extension'] == 'gif'|| $value['Extension'] == 'jpg'||$value['Extension'] == 'png'): ?>
                                    <div class="<?php echo 'file' . $key ?> file_l">
                                        <?php echo $this->Html->image($value['FileLink']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($value['Extension'] == 'mp4'): ?>
                                    <div class="<?php echo 'file' . $key ?> file_l" >
                                        <video width="945" height="535" controls>
                                            <source src="<?php echo '/elearning' . $value['FileLink'] ?>" type="video/mp4">
                                            お使いのブラウザはvideoタグをサポートしていません。
                                        </video>
                                    </div>
                                <?php endif; ?>
                                <?php if ($value['Extension'] == 'mp3' || $value['Extension'] == 'wav'): ?>
                                    <div class="<?php echo 'file' . $key ?> file_l"style="margin:50px" > 
                                        <audio controls>
                                            <source src="<?php echo '/elearning' . $value['FileLink'] ?>" type="audio/mpeg">
                                            お使いのブラウザはaudioタグをサポートしていません。
                                        </audio>
                                    </div>
                                <?php endif; ?>                                
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>                     
                </div>
                <div>
                    <div class="lesson_nav">                                
                        <?php echo $this->Html->link('テストをする', array('controller' => 'student', 'action' => 'test', $lesson['Lesson']['LessonId'], $test_id)); ?>          
                    </div>
                    <div class="lesson_nav">        
                        <?php echo $this->Html->link('テストした結果をみる', array('controller' => 'student', 'action' => 'view_result', $lesson['Lesson']['LessonId'], $test_id)); ?>
                    </div>
                     <div class = "lesson_nav" style="background: linear-gradient(#28a8e5,#28a811);color:#000;">
                     <?php echo $this->Html->link("違反報告",array('controller'=>'student','action'=>'report',$lesson['Lesson']['LessonId'])); ?>
                     </div>
                    <div style="float:right" >
                        <?php
                        if (isset($study_history)) {
                            if ($study_history['StudentHistory']['IsLike'] == 0) {
                                $text = 'いいね';
                            } else {
                                $text = '嫌い';
                            }
                        }
                        ?>
                        <a href="javascript:void(0)" id="like_lesson">
                            <?php echo $this->Html->image('like.png', array('alt' => 'like', 'width' => '32', 'height' => '32', 'class' => 'like')); ?>
                            <h3 style="line-height:32px;display:block;float:right;height:32px;color:black;margin-top:5px"><?php echo $text; ?></h3>
                        </a>
                        <?php
                        $this->Js->get('#like_lesson')->event(
                                'click', $this->Js->request(
                                        array(
                                    'controller' => 'Student',
                                    'action' => 'like_lesson',
                                    $lesson_id
                                        ), array(
                                    'update' => '#like_lesson h3',
                                    'method' => 'POST',
                                            'complete' => 'location.reload();'
                                        )
                                )
                        );
                        echo $this->Js->writeBuffer();
                        ?>
                    </div>
                </div>
                <div class="articleCore ">
                    <div class="ls_title">
                        <h1><?php echo $this->Html->link($lesson['Lesson']['Title'], array('controller' => 'Teacher', 'action' => 'view_lesson', $lesson['Lesson']['LessonId'])); ?></h1>
                    </div>
                    <div class="type"><h3><?php
                            if (isset($cat)) {
                                echo $cat['Category']['CatName'];
                            }
                            ?></h3></div>
                    <div class="ls_rate" style=" font-size:16px;">
                        <span><?php echo $this->Html->image('icon/icon-hits-12.png', array('alt' => 'views')); ?> <?php echo $lesson['Lesson']['ViewNumber']; ?></span>
                        <span><?php echo $this->Html->image('icon/icon-like.png', array('alt' => 'views')); ?><?php echo $lesson['Lesson']['LikeNumber']; ?> </span>
                    </div>
                    <div class="creat_author"><h3>発行 <a href="#"><?php echo $lesson['User']['FullName'] ?></a></h3></div>
                    <div class="description" style="width:600px"><?php echo $lesson['Lesson']['Abstract']; ?></div>
                </div>
                <div class="articleCore " style="margin-top:5px">
                    <?php foreach ($lesson['Tag'] as $key => $value): ?>
                        <a href="javascript:void(0)" class="tag"><?php echo $value['TagContent']; ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="commentsNotes">
                    <ul class="tabs">
                        <li class="active h-comments-tab j-comments">

                            <?php
                            $i = 0;
                            if (isset($com)):
                                ?>
                                <?php foreach ($com as $key => $value): ?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>                   
                            <a class="j-comments-tab" href="#"><em class="h-comments-count"><?php echo $i; ?> コメント</em></a>
                        </li>                                    
                    </ul>
                    <div class="commentsWrapper">
                        <ul class="commentWrapper h-comment-list" id="commentsList" style="">
                            <?php if (isset($com)): ?>
                                <?php foreach ($com as $key => $value): ?>
                                    <li cass="comment"  style="display: list-item;">
                                        <a href="#" title="Dahiibrahim" class="commenter" >
                                            <img class="nickname" src="images/icon/user-48x48.png" height="48" alt="Dahiibrahim" width="48" style="display: block;">
                                            <?php echo $this->Html->image('icon/user-48x48.png', array('alt' => 'views', 'height' => '48px')); ?>
                                            <strong class=""><?php echo $value['User']['FullName'] ?></strong>
                                        </a>
                                        <span class="commentText"><?php echo $value['Comment']['Content'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>                                
                        </ul>    
                        <form action="" method="post"  style="display: block;" class="postComment">
                            <fieldset>
                                <div class="">
                                    <a href="/mrhieusd/newsfeed" title="mrhieusd" class="commenter">
                                        <?php echo $this->Html->image('icon/user-48x48.png', array('alt' => 'views', 'height' => '48px')); ?>
                                        <strong><?php echo $users_username['FullName']; ?></strong>
                                    </a>
                                </div>
                                <textarea cols="100" rows="4" name="comment"></textarea>
                                <div class="postCommentSubmit sign_up_tb">
                                    <input class="flat_btn" value="コメント" type="submit" style="">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>          
            </div>
            <div class="relate_more_tab">
                <div class="t_title" style="margin-right:0px">
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
                <ul>
                    <?php foreach ($allLessons as $lesson): ?>
                        <li>
                            <div class="lesson">
                                <div class="ls_title"><a href="javascript:void(0)"><?php echo ($lesson['Lesson']['Title']); ?></a></div>
                                <div class="ls_rate">
                                    <div><?php echo $lesson['Lesson']['LikeNumber']; ?>いいねと言う / <?php echo $lesson['Lesson']['ViewNumber']; ?> ビュー </div>
                                    <div><?php echo $lesson['Lesson']['Abstract']; ?></div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <?php unset($lesson); ?> 
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
      $(document).bind("contextmenu",function(e){
        e.preventDefault();
        alert("右クリックは許可されていません");
      });

      /*$('.dvOne').bind("contextmenu",function(e){
        e.preventDefault();
        alert("Right Click is not allowed on div");
      });*/
    });
</script>
// <script language='JavaScript' type='text/JavaScript'> 
//     // http://htmlgenerator.weebly.com 
//     var tenth = ''; 
 
//     function ninth() { 
//         if (document.all) { 
//             (tenth); 
//             alert("Right Click Disable"); 
//             return false; 
//         } 
//     } 
 
//     function twelfth(e) { 
//         if (document.layers || (document.getElementById && !document.all)) { 
//             if (e.which == 2 || e.which == 3) { 
//                 (tenth); 
//                 return false; 
//             } 
//         } 
//     } 
//     if (document.layers) { 
//         document.captureEvents(Event.MOUSEDOWN); 
//         document.onmousedown = twelfth; 
//     } else { 
//         document.onmouseup = twelfth; 
//         document.oncontextmenu = ninth; 
//     } 
//     document.oncontextmenu = new Function('alert("右クリックは許可されていません"); return false') 
// </script> 
