<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
    <div id="content">
        <div id="news">
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new1.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new2.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new3.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new4.jpg', array('alt' => 'New')); ?></a></span>
            <span><a href="javascript:void(0)"><?php echo $this->Html->image('new5.jpg', array('alt' => 'New')); ?></a></span>
        </div>
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
                $i = 0;
                if(sizeof($lessons)==0) {echo "このカテゴリは授業がありません";}
                foreach ($lessons as $lesson) {
                    ?>
                    <?php
                    if ($i % 2 == 0) {
                        echo "<div class='row'>";
                    }
                    echo "<div class='lesson'>";
                    echo "<div class='ls_title'>";
                    echo "<a href='#'>{$lesson['Lesson']['Title']}</a>";
                    echo "<span >";
                    echo $this->Html->image('icon/icon-like.png',array('alt' =>'views'));
                    echo  $lesson['Lesson']['LikeNumber'];
                    echo "</span>";
                    echo "<span >";
                    echo $this->Html->image('icon/icon-hits-12.png',array('alt' =>'views'));
                    echo  $lesson['Lesson']['ViewNumber'];
                    echo "</span>";
                    echo "</div>";
                    ?>
                    <div class="creat_author"><a href="#"> <?php echo $lesson['User']['Username']; ?></a>から作られた</div>
                    <div class="description"><p><?php echo $lesson['Lesson']['Abstract']; ?></p></div>
                    <?php echo "</div>"; //class=lesson ?>
                    <?php
                    if ($i % 2 == 1) {
                        echo "</div>";
                    }
                    ?>
                    <?php
                    $i++;
                }
                ?>

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