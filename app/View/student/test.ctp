<div id="contents">
    <?php echo $this->Element('cat_menu');?>
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
                        <a href="javascript:void(0)" class="selected t_lesson">
                            <span>テスト 1</span>
                        </a>                          
                    </li>
                    <!-- <li>
                       <a href="javascript:void(0)" class="t_teacher">
                            <span>Test 2</span>
                       </a>                       
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="top">
                <?php echo $this->Form->create(null, array(
                    'url' => array('controller' => 'student', 'action' => 'test',$lesson_id))
                );?>  
                <table class="sign_up_tb" border="0px">
                      <tbody >
                         <tr>
                            <td colspan="3" style="border:1px solid #333; border-bottom:0"><h2><?php echo $data_test['Title']?></h2></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border:1px solid #333;border-bottom:0"><h4><?php echo $data_test['SubTitle']?></h4></td>
                        </tr>
                         <tr>
                            <td style="border:1px solid #333; width:18%;border-right:0"><h4>トータルの質問: <?php echo $data_test['Total']?></h4>
                            </td>
                            <td style="border:1px solid #333">
                                <?php  if(isset($point)&&isset($total_ans_correct)):?>
                                <h3 style="color:red;">トータル正解: <?php echo $total_ans_correct?> /  <?php echo $data_test['Total']?></h3>
                                <?php endif;?>
                            </td>
                            <td style="border:1px solid #333">
                                <?php  if(isset($point)&&isset($total_ans_correct)):?>    
                                <h2 style="color:red;"><?php echo $point?>点 </h2>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php foreach ($data_test['Question'] as $key1 => $value1): ?>
                        <tr>
                            <td width="10%" align="center" ><h3>質問 <?php echo $value1['QuesNum']?></h3></td>
                            <td width="65%"><h3><?php echo $value1['Content']?></h3></td>
                            <td width="25%" style="color:red"><h3><?php echo $value1['Point']?>ポイント</h3></td>
                        </tr>
                        <input name="data[<?php echo $value1['QuesNum']?>]"  value="0" type="hidden" />
                        <?php foreach ($value1['An'] as $key => $value): ?>
                        <tr>
                            <td align="right">
                            </td>
                            <td align="left">
                                <div class="td_text">
                                    <?php if(isset($test_result)):?>
                                        <label for="answer<?php echo $value1['QuesNum'].$value['Answer']['AnswerNumber']?>"><?php echo $value['Answer']['AnswerNumber']?>.<input name="data[<?php echo $value1['QuesNum']?>]" id="answer<?php echo $value1['QuesNum'].$value['Answer']['AnswerNumber']?>" value="<?php echo $value['Answer']['AnswerNumber']?>" type="radio"  <?php if($test_result[$value1['QuesNum']] == $value['Answer']['AnswerNumber'] ){echo 'checked';}else{echo 'disabled';}?> /> <?php echo $value['Answer']['AnswerContent']?></label>
                                    <?php else:?>
                                         <label for="answer<?php echo $value1['QuesNum'].$value['Answer']['AnswerNumber']?>"><?php echo $value['Answer']['AnswerNumber']?>.<input name="data[<?php echo $value1['QuesNum']?>]" id="answer<?php echo $value1['QuesNum'].$value['Answer']['AnswerNumber']?>" value="<?php echo $value['Answer']['AnswerNumber']?>" type="radio" /> <?php echo $value['Answer']['AnswerContent']?></label>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
                        <?php endforeach;?>                     
                        <tr>
                            <td></td>
                            <td>
                                <?php 
                                    if(isset($test_result[0])&&$test_result[0] ==1){
                                        echo $this->Html->link('もう一度やる',array('controller' => 'student','action' => 'test',$lesson_id),array('class'=>'flat_btn'));
                                        echo $this->Html->link('レビュー',array('controller' => 'student','action' => 'view_result',$lesson_id),array('class'=>'btn_search','style'=>'float:none'));
                                    }else{
                                      
                                        echo $this->Form->button('編集', array(
                                            'type' => 'submit',
                                            'class' => 'flat_btn',
                                        )); 
                                        echo $this->Form->button('リセット', array(
                                            'type' => 'reset',
                                            'class' => 'btn_search',
                                            'style' => 'float:none',
                                            ));
                                    }
                                ?>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <?php echo $this->Form->end(); ?>                  
            </div>
        </div>
    </div>
</div>
</div>