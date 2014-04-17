<?php define("LESSON", "Lesson", true) ?>
<?php define("TEACHER","User",true) ?>
<?php //if (isset($results)) { echo "<pre>";print_r($results); echo "</pre>";} ?>
<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
    <div id="content">
        <h3 style="color:red"><?php echo $this->Session->flash(); ?></h3>

        <?php if(isset($results)): ?>
        <div class="t_title">

            <div class="left">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="selected t_lesson">
                            <span>検索結果</span>
                        </a>
                    </li>
                    <!--            <li>-->
                    <!--                <a href="javascript:void(0)" class="t_teacher">-->
                    <!--                    <span>Top Teacher</span>-->
                    <!--                </a>-->
                    <!--            </li>-->
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="top" id="t_lesson">
                <div class="row">
                    <?php foreach ($results
                    as
                    $result): ?>
                    <?php echo '<div class="lesson">'; ?>
                    <?php echo ' <div class="imageThumbContainer">'; ?>
                    <img width="96" height="96" alt="mrhieusd"
                         src="img/icon/qnxpps-121211101606-phpapp01-thumbnail-2.jpg" class="imageThumb">
                </div>
                <div class="ls_title">
                    <a href="#"><?php echo $result[LESSON]["Title"]; ?></a>
                    <span style="float:right"><img src="img/icon/icon-like.png"/> <?php echo $result[LESSON]["LikeNumber"]; ?> </span>
<!--                    <span style="float:right"><img src="img/icon/icon-hits-12.png"/> 4500 </span>-->
                </div>
                <div class="creat_author">作家 <a href="#"><?php echo $result[TEACHER]["Username"]; ?></a> </div>
                <div class="description"><p><?php echo $result[LESSON]["Abstract"]; ?></p></div>

            </div>
            <!--            <div class="lesson">-->
            <!--                <div class="imageThumbContainer">-->
            <!--                    <img width="96" height="96" alt="mrhieusd" src="img/icon/qnxpps-121211101606-phpapp01-thumbnail-2.jpg" class="imageThumb">-->
            <!--                </div>-->
            <!--                <div class="ls_title">-->
            <!--                    <a href="#">The Dissident</a>-->
            <!--                    <span style="float:right"><img src="img/icon/icon-like.png"/> 10 </span>-->
            <!--                    <span style="float:right"><img src="img/icon/icon-hits-12.png" /> 4500 </span>-->
            <!--                </div>-->
            <!--                <div class="creat_author">Published by <a href="#">HarperCollins</a> 2 hours ago</div>-->
            <!--                <div class="description"><p>The story begins in 1962. On a rocky patch of the sun-drenched Italian coastline, a young innkeeper, chest-deep in daydreams, looks out over the incandescent waters...</p></div>-->
            <!--            </div>-->
            <?php endforeach; ?>
        </div>

<!--        <div class="load_more load_more_btn">-->
<!--            <span class="normal_text">LOAD MORE</span>-->
<!--        </div>-->
    </div>
</div>
<?php endif; ?>
</div>
</div>
</div>