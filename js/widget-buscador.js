//iniciar Select2 Woocomerce
	var gatilles = function (){
            var selectables = jQuery('.dropdown_product_wooSelect');
			if ( jQuery().selectWoo && selectables) {
					for(var count = 0; selectables.length > count; count++){
                         jQuery(selectables[count]).select2 ( {
                                        placeholder: 'Select a category',
                                        minimumResultsForSearch: 5,
                                        width: '100%',
                                        allowClear: true,
                                        language: {
                                            noResults: function() {
                                                return 'No existe coincidencia';
                                            }
                                        }
						            }); 
                    }
                    
				}
        };
        jQuery(".buscador_select2").on("select2:select", function (e) { 
            var select_val = $(e.currentTarget).val();
            console.log(select_val) 
          });

        var buscadores = jQuery('.buscador-class-general');
        var BuscadoresApp = [];
        Vue.component('input-atributo', {
            props: ['input_mensaje'],
            template: `
        <div class="my-column">
            <label>Filtrar por $attributes_name {{input_mensaje}} </label>
            <select name="product_$attributes_name" id="select_$attributes_name" class="dropdown_product_wooSelect select2-hidden-accessible"  tabindex="-1" aria-hidden="true">
                <option value="" selected="selected">Seleccione  $attributes_name</option>
 
                <option class="level-0" value="$attributo_terms_aux->slug">$attributo_terms_aux->name</option>
            </select>
         </div>`
          });
        for(var count = 0; buscadores.length > count; count++){
             ID_actual = jQuery(buscadores[count]).attr('id');
             BuscadoresApp[count] = new Vue({
                                        el:"#"+ID_actual,
                                        data:{
                                                mensaje: 'hola mundo Vue '+ID_actual,
                                        }                
                                        });
        }   
    jQuery(function($) {
       // console.log(jQuery('.dropdown_product_wooSelect'));
       // console.log(jQuery('.dropdown_product_wooSelect').length);
        gatilles();
       
    });