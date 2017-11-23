jQuery(function($) {

	$('.chosen').chosen({
		search_contains: true,
		placeholder_text_single: ' ',
		allow_single_deselect: true,
		placeholder_text_multiple: ' '
	});

	$(".number-input").on({
	    "focus": function (event) {
	        $(event.target).select();
	    },
	    "keyup": function (event) {
	        $(event.target).val(function (index, value ) {
	            return value.replace(/\D/g, "")
	                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
	                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
	        });
	    }
	});

	$('.link_imprimir').click(function(event) {
		event.preventDefault();
		window.print();
	});

	$('#forma_movimientos_caja,#forma_movimientos_proveedores,#forma_corte, .no_enter').on('keyup keypress', function(event) {
		var codigo_tecla = event.keyCode || event.which;
		if (codigo_tecla === 13) {
			event.preventDefault();
		}
	});

	$('form.disable').submit(function() {
		
		var boton = $(this).find("[type='submit']");
  		boton.prop('disabled',true);
		if ($(this).data('disable-with')) {
			boton.text($(this).data('disable-with'));
		}
	});

	$('.checkbox_cobranza').click(function() {

		var target=$(this).data("target");
		$("."+target).toggleClass("hidden");

		$("."+target).each(function(){

			if($(this).attr("disabled")){
				$(this).removeAttr("disabled");
			}
			else{
				$(this).attr("disabled",true);
			}
		})

	});

	$(".prueba").keyup(function(){

		var suma_cobranzas=0;
		var comisiones=0;
		var cobranza=0;
		var cobranza_entregado=0;
		var ingreso_caja=0;
		var extra=0;

		$(".prueba").each(function() {

			if (isNaN(parseFloat($(this).val())))
		    {
		      suma_cobranzas += 0 ;
		    } 
		    else 
		    {
		    	if($(this).attr("id")==5 || $(this).attr("id")==6)
		    	{
		      		comisiones+=Math.round(parseFloat($(this).val())*$(this).data("porcentaje"));
		    	}
		    	else
		    	{
		    		if($(this).attr("id")=='extra')
			    	{
			      		extra+=parseFloat($(this).val());
			    	}
			    	else
			    	{
			    		extra+=0;
			    		suma_cobranzas += parseFloat($(this).val());
			      		comisiones+=Math.round(parseFloat($(this).val())*$(this).data("porcentaje"));
			      	}
		    	}
		    }
		})

        if (isNaN(parseFloat($("#2").val())))
	    {
	     	cobranza_entregado+=0;
	    }
	    else
	    {
	    	cobranza_entregado+=parseFloat($("#2").val());
	    }

	    if (isNaN(parseFloat($("#4").val())))
	    {
	     	cobranza_entregado+=0;
	    }
	    else
	    {
	    	cobranza_entregado+=parseFloat($("#4").val());
	    }

	    ingreso_caja=Math.round(cobranza_entregado-comisiones-extra);

	    $(".cobranzas").val(suma_cobranzas);
        $(".comisiones").val(comisiones);
        $(".cobranza_entregado").val(cobranza_entregado);
        $(".extras").val(extra);
        $(".ingreso").val(ingreso_caja);

    });

})