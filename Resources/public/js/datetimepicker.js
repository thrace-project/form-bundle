/**
 * Initialization of jquery datetime picker
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for datetimepicker elements
    jQuery('.thrace-datetimepicker').each(function(key, value){
        
        var options = evaluateOptions(jQuery(this).data('options')); 

        var lang = options.lang; 
        
        jQuery.datepicker
            .setDefaults(jQuery.datepicker.regional[(lang == 'en') ? 'en-GB' : lang]);

        jQuery('#' + options.id).datetimepicker(options);
    });
    
    // Searching for datetimerangepicker elements
    jQuery('.thrace-datetimerangepicker').each(function(key, value){
    	var options = evaluateOptions(jQuery(this).data('options')); 
    	
    	var firstEl = jQuery('#' + options.id + '_' + options.first_name);
    	var secondEl = jQuery('#' + options.id + '_' + options.second_name);
    	
    	firstEl.datetimepicker( "option", 'maxDate', new Date(firstEl.val()));
    	secondEl.datetimepicker( "option", 'minDate', new Date(secondEl.val()));
   
    	var onSelect = function(selectedDate) { 
            var date = new Date(selectedDate);
            
            if(this.id == options.id + '_' + options.first_name){
                secondEl.datetimepicker( "option", 'minDate', date );
            } else {
                firstEl.datetimepicker( "option", 'maxDate', date );
            }
        };
        
        firstEl.datetimepicker( "option", 'onSelect', onSelect);
        secondEl.datetimepicker( "option", 'onSelect', onSelect);      
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