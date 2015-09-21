jQuery(document).ready(function(){


/* слайдер цен */

jQuery("#begunok").slider({
	min: 0,
	max: $('#max').val(),
	values: [0,$('#max').val()],
	range: true,
	stop: function(event, ui) {
		jQuery("input#products-mincost").val(jQuery("#begunok").slider("values",0));
		jQuery("input#products-maxcost").val(jQuery("#begunok").slider("values",1));
		
    },
    slide: function(event, ui){
		jQuery("input#products-mincost").val(jQuery("#begunok").slider("values",0));
		jQuery("input#products-maxcost").val(jQuery("#begunok").slider("values",1));
    }
});

var min_cost = function(){
	var value1=jQuery("input#products-mincost").val();
	var value2=jQuery("input#products-maxcost").val();

    if(parseInt(value1) > parseInt(value2)){
		value1 = value2;
		jQuery("input#products-mincost").val(value1);
	}
	jQuery("#begunok").slider("values",0,value1);	
}

jQuery("input#minCost").change(function(){

	min_cost();
});
min_cost();

var max_cost = function(){
	var value1=jQuery("input#products-mincost").val();
	var value2=jQuery("input#products-maxcost").val();
	
	if (value2 > $('#max').val()) { value2 = $('#max').val(); jQuery("input#products-maxcost").val($('#max').val())}

	if(parseInt(value1) > parseInt(value2)){
		value2 = value1;
		jQuery("input#products-maxcost").val(value2);
	}
	jQuery("#begunok").slider("values",1,value2);	
}
	
jQuery("input#maxCost").change(function(){
	max_cost();	

});
max_cost();


// фильтрация ввода в поля
	jQuery('input').keypress(function(event){
		var key, keyChar;
		if(!event) var event = window.event;
		
		if (event.keyCode) key = event.keyCode;
		else if(event.which) key = event.which;
	
		if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
		keyChar=String.fromCharCode(key);
		
		if(!/\d/.test(keyChar))	return false;
	
	});


});



