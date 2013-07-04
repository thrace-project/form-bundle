/**
 * Initialization of jquery colorpicker
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for colorpicker elements
    jQuery('.thrace-colorpicker').each(function(key, value){  
    	var options = jQuery(this).data('options'); 

        var evaluateFn = function(options){
            jQuery.each(options, function(k,v){
                if(typeof(v) == 'string' && isNaN(v)){
                    if(v.match('^function')){
                        eval('options.'+ k +' = ' + v);
                    }
                } else if(jQuery.isPlainObject(v) || jQuery.isArray(v)){
                    evaluateFn(v);
                }
            });
        };
        
        evaluateFn(options);
        var el = jQuery('#' + options.id);
        var picker = jQuery('#thrace-colorpicker-widget-' + options.id);

        picker.find('div').css({
            backgroundColor: '#' + el.val()
        });

        options.color = el.val();

        options.onSubmit = function(hsb, hex, rgb, element) {
            el.val(hex); 
            picker.find('div').css({
                backgroundColor: '#' + hex
            });
            picker.ColorPickerHide();
        };

        picker.ColorPicker(options);
    });
});


