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

	
})