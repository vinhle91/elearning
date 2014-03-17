<div id="contents">
    <?php echo $this->Element('cat_menu'); ?>
    <div id="content">
        <div class="t_title">
            <div class="left">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="t_teacher selected">
                            <span>トランザクション履歴</span>
                        </a>                       
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="history">
                <table style="width:400px;padding:10px;">
                    <tbody>
                        <tr>
                            <td>
                                <h3>月</h3>
                            </td>
                            <td>
                                <select name="months">
                                    <option value="1">１月</option>
                                    <option value="2">２月</option>
                                    <option value="3">３月</option>
                                    <option value="4">４月</option>
                                    <option value="5">５月</option>
                                    <option value="6">６月</option>
                                    <option value="7">７月</option>
                                    <option value="8" >８月</option>
                                    <option value="9">９月</option>
                                    <option value="10">１０月</option>
                                    <option value="11">１１月</option>
                                    <option value="12" selected="selected">１２月</option>
                                </select>
                            </td>
                            <td>
                                <h3>年</h3>
                            </td>
                            <td>
                                <input class="input" name="year" style="width:92px" value="2013" type="text">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table  class="transaction_tb">
                    <thead>
                        <tr>
                            <th width="6%" align="center">番号</th>
                            <th width="58%">授業</th>
                            <th width="10%">買われる回数</th>
                            <th width="12%">課金</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo($i++); ?></td>
                                <td><?php echo ($transaction['Lesson']['Title']); ?></td>
                                <td><?php echo ($transaction['StudentHistory']['buys']); ?></td>
                                <td><?php echo ($transaction['StudentHistory']['fee']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($transaction);
                        unset($i); ?>          
                        <tr> 
                            <td colspan="3"><h3>合計</h3></td>           
                            <td><h3 style="color:red"><?php echo $total; ?></h3></td>
                        </tr>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>