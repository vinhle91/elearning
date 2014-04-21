<div id="contents">
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
                <?php
                echo $this->Form->create('User', array(
                    'type' => 'POST',
                    'url' => array(
                        'controller' => 'Student',
                        'action' => 'transaction_history'
                    )
                ));
                ?>
                <table style="width:400px;padding:10px;">
                    <tbody>
                        <tr>
                            <td>
                                <h3>月</h3>
                            </td>
                            <td>
                                <?php
                                $today = getdate();
                                echo $this->Form->input('months', array(
                                    'options' => array(
                                        '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'
                                    ),
                                    'selected' => $selectMonth,
                                    'label' => false
                                ));
                                ?>

                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('year', array(
                                    'value' => $selectYear,
                                    'label' => false,
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->submit('OK');
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php echo $this->Form->end(); ?>
                <table  class="transaction_tb">
                    <thead>
                        <tr>
                            <th width="6%" align="center">番号</th>
                            <th width="38%">授業</th>
                            <th width="10%"> 始め時間</th>
                            <th width="10%"> 終わり時間</th>
                            <th width="12%">コスト</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo($i++); ?></td>
                                <td><?php echo($transaction['Lesson']['Title']); ?></td>
                                <td><?php echo($transaction['StudentHistory']['StartDate']); ?></td>
                                <td><?php echo($transaction['StudentHistory']['ExpiryDate']); ?></td>
                                <td><?php echo ($transaction['StudentHistory']['CourseFee']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($transaction);
                        unset($i); ?>                        
                        <tr> 
                            <td colspan="4"><h3>合計</h3></td>           
                            <td><h3 style="color:red"><?php echo $Total; ?></h3></td>
                        </tr>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>