$(document).ready(function() {
    $(".left>ul>li>a").click(function(){
        $(".left>ul>li>a").removeClass('selected');
        $(this).addClass('selected');   
        if($(this).hasClass('t_teacher')){      
            $("#t_teacher").show()
            $("#t_lesson").hide();
        }else{
            $("#t_lesson").show();
            $("#t_teacher").hide();
        }
    });
});
// top menu
$(document).ready(function() {
    $('#profile').click(function(e){
         $('.profilenav').toggle();
         e.stopPropagation();           
    });
    $(".left>ul>li>a").click(function(){
        $(".left>ul>li>a").removeClass('selected');
        $(this).addClass('selected');   
        if($(this).hasClass('t_teacher')){      
            $("#t_teacher").show()
            $("#t_lesson").hide();
        }else{
            $("#t_lesson").show();
            $("#t_teacher").hide();
        }
    });
});
$(document).click(function() {
    $('.profilenav').hide();
});
// select user type
$(document).ready(function() {

     $('#account_type').change(function(){
        if( $('#account_type').val()==1)
        {
            $('.student_info').show();
            $('.teacher_info').hide();
        }else{
            $('.teacher_info').show();
            $('.student_info').hide();
        }
    });
});
// change security
$(document).ready(function() {    
    $(".left>ul>li>a").click(function(){
        $(".left>ul>li>a").removeClass('selected');
        $(this).addClass('selected');   
        if($(this).hasClass('pass')){      
            $("#change_pass").show()
            $("#change_secu").hide();
        }else{
            $("#change_secu").show();
            $("#change_pass").hide();
        }
    });
});
// add more file
$(document).ready(function() { 
    $('#morefile').click(function(){
        var stt = $('#n_file').val();
        stt = parseFloat(stt);
        stt1 = stt + 1; 
        $('#n_file').val(stt1);
        var html = '<input type="file" name="data[File]['+stt1+'][path]" class="input" id="File'+stt1+'Path" style="margin-bottom:10px;">';
        $( html ).insertAfter( '#File'+stt+'Path' );     
    });
});
//add more file test
$(document).ready(function() { 
    $('#moretestfile').click(function(){
        var stt = $('#n_testfile').val();
        stt = parseFloat(stt);
        stt1 = stt + 1; 
        $('#n_testfile').val(stt1);
        var html = '<input type="file" name="data[TestFile]['+stt1+'][path]" class="input" id="TestFile'+stt1+'Path" style="margin-bottom:10px;">';
        $( html ).insertAfter( '#TestFile'+stt+'Path' );     
    });
});
// // show file
$(document).ready(function() { 
    $(".tabs>li>a").click(function(){
        $(".tabs>li>a").removeClass('active');
        $(this).addClass('active');   
        $('.file_l').hide();  
    });
});