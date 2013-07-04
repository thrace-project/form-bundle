/**
 * Initialization of jquery toggle button
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for toggle button elements
    jQuery('.thrace-toggle-button').each(function(key, value){
        var options = jQuery(this).data('options');
        var el = jQuery('#' + options.id);
        var toggle = function(event){
            var label;
            event.target.checked ? 
                label = options.checked_label : label = options.unchecked_label;

            el.button( "option" , 'label' , label );
        };

        options.create = function(event, ui){ 
            toggle(event);
        };

        el.click(function(event){
            toggle(event);
        });

        el.button(options);
    });
});


