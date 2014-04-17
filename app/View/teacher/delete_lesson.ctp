<div id="contents" style="padding:0px 150px;">
    <div id="content">
        <h3 style="">この授業を削除しますか？</h3>
        <?php
        echo $this->Form->create('Teacher');
        echo $this->Form->hidden('lesson_id', array('value' => $lesson_id));
        ?>
        <div class="submit">
            <?php echo $this->Form->submit('はい', array('name' => 'submit', 'div' => false)); ?>
            <?php echo $this->Form->submit('いいえ', array('name' => 'submit', 'div' => false)); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>