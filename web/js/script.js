$(document).ready(function(){
   
    var navigation_items = {
        'login': $('#menu_login'),
        'register': $('#menu_register'),
        'login_form': $('#login_form'),
        'register_form': $('#register_form'),
        'emergent': $('.emergent'),
        'show_login': function(){
            this.login_form.fadeIn();
        },
        'show_register': function(){
            this.register_form.fadeIn();
        },
        'hide_emergent': function(){
            this.emergent.fadeOut();
        }
    };
   
    var init = function()
    {
        
        
        setTimeout(function()
        {
            $(".alert").fadeOut();
        }, 5000);

        $('.alert').on('click', function()
        {
            $(this).fadeOut();
        });
        
         navigation_items.login.on('click', function(){
            navigation_items.show_login();
        });

        navigation_items.register.on('click', function(){
            navigation_items.show_register();
        });

        navigation_items.emergent.on('click', function(){
            navigation_items.hide_emergent();
        });
    };
   

   
   init(); 
    
});
