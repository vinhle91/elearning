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
                    <?php foreach ($list_test as $k => $v):?>
                    <li>                             
                        <a href="/elearning/teacher/view_test/<?php echo $lesson_id?>/<?php echo $v['Test']['TestId']?>" <?php if($test_id == $v['Test']['TestId']){echo 'class="selected"';} ?>>
                            <span>テスト <?php echo $k+1;?></span>
                        </a>                          
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="box">
            <div class="top">  
                <table class="sign_up_tb" border="0px">
                      <tbody >
                         <tr>
                            <td colspan="3" style="border:1px solid #333; border-bottom:0"><h2><?php echo $data_test['Title']?></h2></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border:1px solid #333;border-bottom:0"><h4><?php echo $data_test['SubTitle']?></h4></td>
                        </tr>
                         <tr>
                            <td style="border:1px solid #333; width:18%;border-right:0"><h4>トータルの質問: <?php echo $data_test['Total']?></h4></td>
                            <td colspan="2" style="border:1px solid #333"><h3 style="color:red;">トータルの点: <?php echo $data_test['TotalPoint']?></h3></td>
                        </tr>
                        <?php foreach ($data_test['Question'] as $key1 => $value1): ?>
                        <tr>
                            <td width="10%" align="center" ><h3>質問 <?php echo $value1['QuesNum']?></h3></td>
                            <td width="65%"><h3><?php echo $value1['Content']?></h3></td>
                            <td width="25%" style="color:red"><h3><?php echo $value1['Point']?>ポイント</h3></td>
                        </tr>
                        <?php foreach ($value1['An'] as $key => $value): ?>
                        <tr <?php 
                            if($value['Answer']['AnswerNumber'] == $value1['Answer']){
                                echo 'style="background-color: #e8f8d2;"';
                            }?>>
                            <td align="right">
                                <?php if($value['Answer']['AnswerNumber'] == $value1['Answer']):?>
                                    <?php echo $this->Html->image('icon/yes.png'); ?>
                                <?php endif;?>
                            </td>
                            <td align="left">
                              <div class="td_text">
                                <label class="privacy-label" for="answer"><?php echo $value['Answer']['AnswerNumber']?>. <?php echo $value['Answer']['AnswerContent']?>
                                </label>
                            </div>
                            </td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
                        <?php endforeach;?>                     
                        <tr>
                            <td></td>
                            <td>
                                <?php echo $this->Html->link('編集',array('controller' => 'Teacher','action' => 'edit_lesson',$lesson_id),array('class'=>'flat_btn'));?>
                                <?php echo $this->Html->link('戻る',array('controller' => 'Teacher','action' => 'index'),array('class'=>'btn_search','style'=>'float:none'));?>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>                  
            </div>
        </div>
    </div>
</div>
