<div id="contents">
    <?php echo $this->Element('cat_menu');?>
    <div id="content">
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
                        <!-- <tr>
                            <td>
                                <h3>Month</h3>
                            </td>
                            <td>
                                <select name="months">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8" >August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12" selected="selected">December</option>
                                </select>
                            </td>
                            <td>
                                <h3>Year</h3>
                            </td>
                            <td>
                                 <input class="input" name="year" style="width:92px" value="2013" type="text">
                            </td>
                        </tr>
                    </tbody> -->
                </table>
                <table border="1" align="center" id="mylesson">
                    <tbody>
                        <tr>
                            <td width="8%" style="background-color: #eee;">ID</td>
                            <td width="30%" style="background-color: #eee;">学生</td>
                            <td width="9%" style="background-color: #eee;">テスト</td>
                            <td width="9%" style="background-color: #eee;">テスト結果</td>
                            <td width="19%" style="background-color: #eee;"> スタート時点</td>
                            <td width="19%" style="background-color: #eee;">終わる時点</td>
                            <td style="background-color: #eee;">終わる時点</td>
                        </tr>

                        <?php $i = 0; ?>
                        <?php foreach ($studentHistories as $studentHistory): ?>
                        <tr>                            
                            <td><?php echo(++$i);?></td>
                            <td><a href="#"><?php echo ($studentHistory['User']['FullName']);?></a></td>
                            <td>Test 1</td>
                            <td>4/5</td>
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