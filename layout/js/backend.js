$(function (){
    
    'use strict'

    // Dashboard

    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(200);

        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
    });

    // Trigger the selectBoxIt  
    // Calls the selectBoxIt method on your HTML select box and uses the default theme
    $("select").selectBoxIt({
        autoWidth : false
    });
    
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
    
    // Category View Option
    
    $('.cat h3').click(function(){
        $(this).next('.full-view').fadeToggle(200);
    });
    
    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
        
        if($(this).data('view') === 'full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);
        }
    });
    
})