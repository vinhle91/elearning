<div id="contents" style="padding:0px 150px;">
    <div id="content">
        <?php 
            $error = $this->Session->flash();
            if(!empty($error)):
        ?>
        <div class="error">
            <?php echo $error; ?>
            <?php if(isset($error_msg)){
                    foreach ($error_msg as $key => $value) {
                        echo '<h4>'.$value.'</h4>';
                    }
            }?>
        </div>
        <?php endif;?>
        <div class="title"><h3>授業 アップロード</h3></div>
        <div class="box">
            <div class="top">
                <span class="title_text">授業を変更する </span> 
                <div class="upload_page">                          
                    <?php echo $this->Form->create('Lesson', array('type' => 'file'));?>
                        <table class="sign_up_tb">
                            <tbody>
                                <tr>
                                    <td width="25%">
                                        <div class="td_text">タイトル<span style="color:red">*</span></div>
                                    </td>
                                    <td width="75%">
                                        <?php echo $this->Form->input('Title', array('class'=>'input','type'=>'text','label'=>false,'div'=>false,'value'=>$lessons['Lesson']['Title']));?>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">カテゴリィ<span style="color:red">*</span></div></td>
                                    <td>
                                        <select  name="data[Lesson][Category]">
                                        <?php foreach ($cat as $value):?>
                                            <option <?php if($value['Category']['CatId']==$lessons['Lesson']['Category'])echo 'selected="selected"'; ?>value="<?php echo $value['Category']['CatId']?>">
                                                <?php echo $value['Category']['CatName']; ?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td_text">記述<span style="color:red">*</span></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('Abstract', array('class'=>'input','type'=>'textarea','label'=>false,'div'=>false,'value'=>$lessons['Lesson']['Abstract']));?>

                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">タグ<span style="color:red">*</span></div></td>
                                    <td>
                                        <?php echo $this->Form->input('Tag', array('class'=>'input','type'=>'text','label'=>false,'div'=>false,'value'=>$list_tag));?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td> <div class="td_text">ファイル アップロード</div></td>
                                    <td>
                                        <div class="td_text">承認されたタイプ：GIF、JPG、PNG、PDF、MP3、MP4、WAV、TSV</div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td> </td>
                                    <td>
                                        <input type="hidden" value="0" id="n_file">
                                        <?php echo $this->Form->input('File.0.path', array('class'=>'input','type'=>'file','label'=>false,'div'=>false,'style'=>'margin-bottom:10px')); ?>
                                        <a href="javascript:void(0)" id="morefile">さらにファイルを追加</a>
                                    </td>
                                </tr>      
                                <tr>
                                    <td></td>
                                    <td>
                                    <?php
                                    echo $this->Form->checkbox('TermsOfService', array('checked' => false));
                                    ?>
                                    アップロードする際に、 <a href="">コピーライト規約</a>　に合意する.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> <input class="flat_btn" data-act_as="submit" type="submit" value="授業を変更する"></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php echo $this->Form->end(); ?>                           
                </div> 
            </div>
        </div>
    </div>
</div>