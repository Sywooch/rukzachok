$(document).ready(function(){

	var iii = true;
	
	// console.log(ddd);
	// if (ddd) {console.log('hello var ddd is correnct')
	// }else {
	// 	console.log('var ddd is not exist');
	// };

	console.log($('button'));
	$('button').click(function(){

		var testt = $(this);

		var id = $(this).attr('id');

		var ddd = document.getElementById('test_tr_class');

		// $.post( "index.php?r=order%2Fupdate&id=1", function( data ) {

		if (!ddd) {

		$.post( "/admin/orders/show?id=" + id + '"', function( data ) {

				testt.closest('tr').after(
					'<tr id="test_tr_class">' + 
						'<td colspan="12">' +
							data +
						'</td>' +
					'</tr>' 
					);

				});
		
		}else{
			document.getElementById('test_tr_class').remove();
		};

		iii = false;
		console.log(iii);




	});





});