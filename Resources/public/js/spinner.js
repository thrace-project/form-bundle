/**
 * Initialization of jquery spinner widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){

    //Searching for spinner widgets
    jQuery('.thrace-spinner').each(function(key, value){
        var options = evaluateOptions(jQuery(this).data('options'));
        var el = jQuery('#' + options.id);

        el.spinner(options);
    });
}); 

function evaluateOptions (options){
    jQuery.each(options, function(k,v){
        if(typeof(v) === 'string' && isNaN(v)){
            if(v.match('^function')){
                eval('options.'+ k +' = ' + v);
            }
        } else if(jQuery.isPlainObject(v) || jQuery.isArray(v)){
            evaluateOptions(v);
        }
    });
    
    return options;
}


