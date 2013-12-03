/**
 * Initialization of jquery multiselect
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    jQuery('.thrace-multi-select').each(function(key, value){ 
        var options = jQuery(this).data('options'); 
        var prototype = jQuery(this).data('prototype');

     // fix mopa bundle
        if(prototype == ''){
            prototype = jQuery(this).parent().closest('div[data-prototype]').data('prototype');
        }

        var container = jQuery('#thrace-multi-select-form-' + options.id);

        jQuery(this).bind('thrace_datagrid.gridComplete', function(data){
            jQuery.each(container.find(':hidden'), function(k,v){
                jQuery('#' + data.gridId).jqGrid('setSelection', jQuery(v).val());
            });
        });
         
        jQuery(this).bind('thrace_datagrid.beforeRowSelect', function(data){ 
       
            var html = prototype.replace(/__name__/g, data.id);
            var elm = jQuery(jQuery.parseHTML(html)).val(data.id);
            
            container.find(':hidden[value="'+ data.id +'"]').remove();

            if(data.isChecked){
               container.append(elm);
            }
        });
        
        jQuery(this).bind('thrace_datagrid.onSelectAll', function(data){
            container.find(':hidden').remove();
            jQuery.each(data.ids, function(k,v){              
                if(data.status === true){
                    var html = prototype.replace(/__name__/g, v);
                    var elm = jQuery(jQuery.parseHTML(html)).val(v);
                    container.append(elm);
                } 
            });
        });
    
    });
});



