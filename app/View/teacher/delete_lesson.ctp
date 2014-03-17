<div id="contents" style="padding:0px 150px;">
	<div id="content">
        <div class="title"><h3>Upload lesson</h3></div>
        <div class="box">
        	<div class="top">
                <span class="title_text">Make Lesson</span> 
                <div class="upload_page">                          
                    <form>                                
                        <div class="input_error"></div>
                        <table class="sign_up_tb">
                            <tbody>
                                <tr>
                                    <td width="22%">
                                        <div class="td_text">Title<span style="color:red">*</span></div>
                                    </td>
                                    <td width="78%"><input class="input" name="name" size="20" type="text"></td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">Category<span style="color:red">*</span></div></td>
                                    <td>
                                        <select class="picker" data-auto="tag" name="word_document[category_id]">
                                            <option value="5185">
                                                Articles &amp; News Stories
                                            </option>
                                            <option value="5218">
                                                Book Excerpts
                                            </option>
                                            <option value="148">
                                                Books - Non-fiction
                                            </option>
                                            <option value="115">
                                                Business/Law
                                            </option>
                                            <option value="242">
                                                Comics
                                            </option>
                                            <option value="5181">
                                                Food &amp; Wine
                                            </option>
                                            <option value="207">
                                                Government &amp; Politics
                                            </option>
                                            <option value="4751">
                                                Japanese
                                            </option>
                                            <option value="79">
                                                Magazines/Newspapers
                                            </option>
                                            <option value="252">
                                                Presentations
                                            </option>
                                            <option value="170">
                                                Religious &amp; Bible Study
                                            </option>
                                            <option value="5203">
                                                Topics
                                            </option>
                                            <option value="5182">
                                                Types
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td_text">Description<span style="color:red">*</span></div>
                                    </td>
                                    <td>
                                        <textarea class="text_border" cols="60" name="description" rows="10"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">Tag</div></td>
                                    <td><input class="input" name="login_or_email" size="20" type="text"></td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">Upload File</div></td>
                                    <td>Upload one or more file</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                       <h3 style="display:inline-block;"> <?php echo $this->Html->image('icon/yes.png', array('alt' => 'Yes')); ?>File <a href="#">10 w 02-議事録、報告書について.pdf</a> uploaded successfully!</h3>
                                       <span style="display:inline-block;margin-left:10px;"class="btn" id="editPhoto"> Delete File</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                       <h3 style="display:inline-block;"> <?php echo $this->Html->image('icon/yes.png', array('alt' => 'Yes')); ?>File <a href="#">画面設計_1.0.1.docx</a> uploaded successfully!</h3>
                                       <span style="display:inline-block;margin-left:10px;"class="btn" id="editPhoto"> Delete File</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                    	<div class="upload_button_border">
                                        	<div class="home_btn lightblue upload_button">
                                            	<div class="btn_inner ">
                                                	<div class="huge_icon"></div>Select files to upload
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <div class="td_text">Upload File Test</div></td>
                                    <td>Upload one or more file</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                       <h3 style="display:inline-block;"> <?php echo $this->Html->image('icon/yes.png', array('alt' => 'Yes')); ?>File <a href="#">Test1.tsv</a> uploaded successfully!</h3>
                                       <span style="display:inline-block;margin-left:10px;"class="btn" id="editPhoto"> Delete File</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                       <h3 style="display:inline-block;"> <?php echo $this->Html->image('icon/yes.png', array('alt' => 'Yes')); ?>File <a href="#">test2.tsv</a> uploaded successfully!</h3>
                                       <span style="display:inline-block;margin-left:10px;"class="btn" id="editPhoto"> Delete File</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="upload_button_border">
                                            <div class="home_btn lightblue upload_button">
                                                <div class="btn_inner ">
                                                    <div class="huge_icon"></div>Select files to upload
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                    <input type="checkbox" value="yes" name="TermsOfService">
                                    By uploading, you agree to the E-learning <a href="">Uploader Agreement</a>.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> <input class="flat_btn" data-act_as="submit" type="submit" value="Upload"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>