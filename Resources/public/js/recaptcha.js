/**
 * Initialization of recaptcha widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for recaptcha elements
    jQuery('.thrace-recaptcha').each(function(key, value){ 
        var options = jQuery(this).data('options');
        
        Recaptcha.create(options.public_key,
            options.id, 
            {
              theme: options.theme,
              lang: options.lang
            }
        );    
    });
    
});