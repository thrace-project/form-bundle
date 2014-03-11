//Create namespace
window.ThraceForm = window.ThraceForm || {};

ThraceForm.collection = function(collection){
    var collection = (collection == undefined) ? jQuery('.thrace-collection') : collection;
    
    collection.each(function(k,v){
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
        
        jQuery(document).on('click', '#thrace-collection-button-add-' + options.id, function(event){
            event.preventDefault();
            var html = jQuery(prototype.replace(/__name__/g, idx));
            html.find('[data-collection-remove-btn]').parent().remove(); 
            container.append('<fieldset id="thrace_fieldset_'+ idx +'" data-idx="'+ idx +'" class="'+ options.fieldset_class +'" style="margin:20px">' + html.html() + '<button class="'+ options.remove_button_class +' thrace-collection-button-remove">'+ options.remove_button_text + '</button></fieldset>');
            
            var onAddEvent = jQuery.Event('thrace_form.collection.onAdd');
            onAddEvent.options = options;
            onAddEvent.idx = idx;
            jQuery(document).trigger(onAddEvent);

            idx++;
            if(jQuery('#thrace-collection-container-' + options.id + ' > fieldset').length > 0){
                jQuery('#thrace-collection-empty-text-' + options.id).hide();
            }
        });
        

        jQuery(document).on('click', '.thrace-collection-button-remove', function(event){ 
            event.preventDefault();    
            
            jQuery(this).parent().fadeOut(function(){
                jQuery(this).remove();

                var onRemoveEvent = jQuery.Event('thrace_form.collection.onRemove');
                onRemoveEvent.options = options;

                jQuery(document).trigger(onRemoveEvent);

                if(jQuery('#thrace-collection-container-' + options.id + ' > fieldset').length == 0){
                    jQuery('#thrace-collection-empty-text-' + options.id).fadeIn();
                }

            });
        });
    });
};

jQuery(document).ready(function(){
    ThraceForm.collection();
});

jQuery(document).on('thrace.form.collection.init', function(event, collection){
    ThraceForm.collection(collection);
});