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

	$('#forma_movimientos_caja, .no_enter').on('keyup keypress', function(event) {
		var codigo_tecla = event.keyCode || event.which;
		if (codigo_tecla === 13) {
			event.preventDefault();
		}
	});

/*
	$("#cargar").click(function () {

		var d = '';
		var cantidad=document.getElementById("cantidad").value;
		var sucursal=document.getElementById("sucursal");
		var joyero=document.getElementById("joyero");


		joyero = joyero.options[joyero.selectedIndex].text;
		sucursal = sucursal.options[sucursal.selectedIndex].text;

		 d+= '<tr>'+
		 '<td>'+joyero+'</td>'+
		 '<td>'+sucursal+'</td>'+
		 '<td>'+cantidad+'</td>'+
		 '</tr>';
		 
		 $("#tabla").append(d);
		
		var myArray = new Object(); // creamos un objeto

		myArray['joyero'] = joyero;
		myArray['sucursal'] = sucursal;
		myArray['cantidad'] = cantidad;

		var otroArray = jQuery.makeArray(myArray);

		var myJSON = JSON.stringify(otroArray);

		$('#forma_reparaciones').append('<input type="hidden" name="prueba[]" value='+ myJSON +'>');

		document.getElementById("cantidad").focus();
		document.getElementById("cantidad").value='';
 
	});

	$("#eliminar").click(function () {
		
		document.writeln(arre);

	});


	//parte que va en controlador
	$prueba = $this->request->getData('prueba'); debug($prueba); die;

            foreach($prueba as $id=>$p)
            {
                $pp=json_decode($p);
                if($id==2)
                {
                    debug($pp[0]->cantidad); die;
                }
            }
    //////
*/

})