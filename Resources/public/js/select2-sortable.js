/**
 * Initialization of select2 sortable widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
	
    // Searching for select2 sortable elements
    jQuery('.thrace-select2-sortable').each(function(key, value){  
    	var options = jQuery(this).data('options'); 
        var id = options.id;
        delete options.id;

        jQuery('#' + id).select2(options);
  
        jQuery('#' + id).on("change", function() { 
        	var val = jQuery('#' + id).val();
        	jQuery('#' + id).html(val);
        });
    	 
    	jQuery('#' + id).select2("container").find("ul.select2-choices").sortable({
    	    containment: 'parent',
    	    start: function() { jQuery('#' + id).select2("onSortStart"); },
    	    update: function() { jQuery('#' + id).select2("onSortEnd"); }
    	});
    });
    
});