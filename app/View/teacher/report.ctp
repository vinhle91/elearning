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
                        <a href="#" class="selected"><h3>報告内容</h3></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
        <?php echo $this->Form->create("Report"); ?>
            <table class="sign_up_tb">
                <tr>
                    <td><label for="radio1"><input name="data['Report']['Content']" id="radio1" value="Copyright 違反" type="radio" /> Copyright 違反</label>
                   </td>
                    <td></td>
                </tr>
                <tr>
                    <td><label for="radio2"><input name="data['Report']['Content']" id="radio2" value="運用規約等に違反" type="radio" /> 運用規約等に違反</label></td>
                    <td></td>
                </tr>
                <tr>
                    <td><label for="radio3"><input name="data['Report']['Content']" id="radio3" value="タイトルが不適です" type="radio" /> タイトルが不適です</label></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input class="flat_btn" data-act_as="submit" type="submit" value="報告"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <?php echo $this->Form->hidden('UserId', array('value' => $userId));
                        echo $this->Form->hidden('LessonId', array('value' => $lessonId));
                        echo $this->Form->hidden('IsDeleted', array('value' => 1)); ?>
                    </td>
                    <td></td>
                </tr>           
            </table>
            <?php echo $this->Form->end();?>
        </div>
    </div>
</div>