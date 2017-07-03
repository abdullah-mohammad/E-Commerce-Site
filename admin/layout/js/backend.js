$(function (){
    
    'use strict'
    
    // Hide Placeholder On Form Focus
    
    $('[placeholder]').focus(function () {
        
        $(this).attr('data-text',$(this).attr('placeholder'));
        
        $(this).attr('placeholder','');
        
    }).blur(function (){
        
        $(this).attr('placeholder',$(this).attr('data-text'));
        
    });
    
    // add asterisk on required field
    
    $('input').each(function(){
                    
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    });
    
    // convert password field to text field
    
    var passField = $('.password');
    
    $('.show-pass').hover(function(){
        
        passField.attr('type','text');
        $(this).attr('class','show-pass fa fa-eye-slash fa-2x');
        
    },function(){
        
        passField.attr('type','password');
        $(this).attr('class','show-pass fa fa-eye fa-2x');
    });
    
    // confirmation message on button
    
    $('.confirm').click(function(){
       
        return confirm('Are you sure ?');
    });
})