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
        <div class="title"><h3>学生のリスト</h3></div>                  
        <div class="box">
            <div class="top">
                <table style="width:600px;padding:10px;">
                    <tbody>
                        <tr>
                            <td  style="padding-bottom:5px;">
                                <h2>タイトル</h2>
                            </td>
                            <td colspan="3" style="padding-bottom:5px;"><h2><a href="#">
                                <?php echo $lessonTitle ?></a></h2></td>
                        </tr>
                </table>
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
                            <td width="8%" style="background-color: #eee;">ID</td>
                            <td width="15%" style="background-color: #eee;">学生</td>
                            <td width="9%" style="background-color: #eee;">テスト</td>
                            <td width="19%" style="background-color: #eee;"> スタート時点</td>
                            <td width="19%" style="background-color: #eee;">終わる時点</td>
                            <td width="15%"style="background-color: #eee;">終わる時点</td>
                        </tr >
                        <?php $i = 0; ?>
                        <?php foreach ($studentHistories as $studentHistory): ?>
                        <tr style="text-align:center">                            
                            <td><?php echo(++$i);?></td>
                            <td><a href="#"><?php echo ($studentHistory['User']['FullName']);?></a></td>
                            <td>
                                <?php if(isset($studentHistory['Test'])):?>
                                    <?php foreach ($studentHistory['Test'] as $key => $value) {
                                        $i =$key +1;
                                        echo $this->Html->link('テスト'.$i, array('controller' => 'teacher', 'action' => 'view_result', $studentHistory['StudentHistory']['LessonId'], $value, $studentHistory['StudentHistory']['UserId']));
                                    }?>
                                <?php endif;?>
                            </td>
                            <td><?php echo ($studentHistory['StudentHistory']['StartDate']);?></td>
                            <td><?php echo ($studentHistory['StudentHistory']['ExpiryDate']);?></td>
                            <td width="6%">
                                <?php if ($studentHistory['StudentHistory']['Blocked'] == '1') {?>
                                ブロックされた
                                <?php } else {?>

                                <input type="button" value="ブロックする" onclick="confirm_alert(this, <?= ($studentHistory['StudentHistory']['UserId']);?>,<?= ($studentHistory['StudentHistory']['LessonId']);?>)">
                                <?php }?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php unset($lesson); unset($i);?>   

                    </tbody>
                </table>
            </div>
<!--             <div class="pager">
                <ul>
                    <li class="prev previous_page disabled"><a href="#">← Previous</a></li>
                    <li class="active"><a rel="start" href="#">1</a></li>
                    <li><a rel="next" href="#">2</a></li>
                    <li class="next next_page "><a rel="next" href="#">Next →</a></li>
                </ul>
            </div> -->
        </div>
    </div>
</div>
</div>

<script type="text/javascript">

function confirm_alert(node, a, b) {
    if (confirm('Are you sure you want to block this student?')) {
        var url = ".././block_student/"+a+"/"+b;    
        $(location).attr('href',url);    
    } else {
        // Do nothing!
    }
}

</script>