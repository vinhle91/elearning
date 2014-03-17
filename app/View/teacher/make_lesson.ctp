<div id="contents" style="padding:0px 150px;">
    <div id="content">
        <div class="title"><h3>授業 アップロード</h3></div>
        <div class="box">
            <div class="top">
                <span class="title_text">授業を作る</span> 
                <div class="upload_page">                          
                    <?php echo $this->Form->create('Lesson', array('type' => 'file'));?>                        
                    <div class="input_error"></div>
                        <table class="sign_up_tb">
                            <tbody>
                                <tr>
                                    <td width="22%">
                                        <div class="td_text">タイトル<span style="color:red">*</span></div>
                                    </td>
                                    <td width="78%">
                                        <?php echo $this->Form->input('Title', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">カテゴリィ<span style="color:red">*</span></div></td>
                                    <td>
                                        <select class="picker" name="data[Lesson][Category]">
                                            <option value="" selected="selected">
                                                Chosse one
                                            </option>
                                        <?php foreach ($cat as $value):?>
                                            <option value="<?php echo $value['Category']['CatId']?>">
                                                <?php echo $value['Category']['CatName']; ?>
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td_text">記述<span style="color:red"></span></div>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('Abstract', array('class'=>'input','type'=>'textarea','label'=>false,'div'=>false));?>

                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">タグ</div></td>
                                    <td>
                                        <?php echo $this->Form->input('Tag', array('class'=>'input','type'=>'text','label'=>false,'div'=>false));?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td> <div class="td_text">ファイル アップロード</div></td>
                                    <td>
                                        <input type="hidden" value="0" id="n_file">
                                        <?php echo $this->Form->input('File.0.path', array('class'=>'input','type'=>'file','label'=>false,'div'=>false,'style'=>'margin-bottom:10px')); ?>
                                        <a href="javascript:void(0)" id="morefile">Add more files</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td> <div class="td_text">テスト ファイル アップロード</div></td>
                                    <td>
                                        <input type="hidden" value="0" id="n_testfile">
                                        <?php echo $this->Form->input('TestFile.0.path', array('class'=>'input','type'=>'file','label'=>false,'div'=>false,'style'=>'margin-bottom:10px')); ?>
                                        <a href="javascript:void(0)" id="moretestfile">Add more files</a>
                                    </td>
                                </tr> 
                                
                                <tr>
                                    <td></td>
                                    <td>
                                    <?php
                                    echo $this->Form->checkbox('TermsOfService', array('checked' => false));
                                    ?>
                                    アップロードする際に、 <a href="">システムの規約</a>　に合意する.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> <input class="flat_btn" data-act_as="submit" type="submit" value="授業を作る"></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php echo $this->Form->end(); ?>                           
                </div> 
            </div>
        </div>
    </div>
</div>