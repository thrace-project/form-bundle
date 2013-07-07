jQuery(document).ready(function(){
	jQuery('.thrace-collection').each(function(k,v){
		var options = jQuery(this).data('options'); 
        var prototype = jQuery(this).data('prototype');
        // fix mopa bundle
        if(prototype == ''){
        	prototype = jQuery(this).closest('div[data-prototype]').data('prototype');
        }
       
        var container = jQuery('#thrace-collection-container-' + options.id);
        var buttonAdd = jQuery('#thrace-collection-button-add-' + options.id);
        var elementIdx = jQuery('#thrace-collection-container-' + options.id + ' > fieldset').length; 
        var idx = elementIdx;
        
        jQuery.each(container.find('fieldset'),function(k,v){
            var currentIdx = jQuery(this).data('idx');
            if(currentIdx >= elementIdx){
                idx = currentIdx + 1;
            }
        });
        
        buttonAdd.click(function(){
        	var html = prototype.replace(/__name__/g, idx);
        	container.append('<fieldset data-idx="'+ idx +'" style="margin:20px">' + html + '<button class="'+ options.remove_button_class +' thrace-collection-button-remove">'+ options.remove_button_text + '</button></fieldset>');
        	idx++;
        	
        	var onAddEvent = jQuery.Event('thrace_form.collection.onAdd');
        	onAddEvent.options = options;
    		
            jQuery('#' + options.id).trigger(onAddEvent);
        	
        	if(jQuery('#thrace-collection-container-' + options.id + ' > fieldset').length > 0){
        		jQuery('#thrace-collection-empty-text-' + options.id).hide();
        	}
        	
        	return false;
        });
        
        jQuery(document).on('click', '.thrace-collection-button-remove', function(){ 
        	jQuery(this).parent().fadeOut(function(){
        		jQuery(this).remove();
        		
        		var onRemoveEvent = jQuery.Event('thrace_form.collection.onRemove');
            	onRemoveEvent.options = options;
        		
            	jQuery('#' + options.id).trigger(onRemoveEvent);
                
        		if(jQuery('#thrace-collection-container-' + options.id + ' > fieldset').length == 0){
            		jQuery('#thrace-collection-empty-text-' + options.id).fadeIn();
            	}
        	});

        	return false;
        });
	});
});