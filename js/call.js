(function($){

    $.fn.call = function(callerSettings) {

	var login_id = this;
	
	$(login_id).bind('click',function(){
		winW = document.body.offsetWidth;
		winH = document.body.offsetHeight
		$('.modal_box').remove();
		$('#data_box').remove();
		$('body').append('<div class="modal_box"></div>');
		$('body').append('<div id="data_box"></div>');
		$('#data_box').append('<div class="data_wrp"></div>');
		$('#data_box').css( "left", ((winW-350)/2)+'px' );
    
	var scrollTop = document.documentElement.scrollTop
    if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
		scrollTop = document.body.scrollTop;
    }		
		$('#data_box').css( {"top" : (scrollTop+200)+'px',"width":"350px"} );
		
		$('#data_box .data_wrp').append('<img src="/img/close_modal.jpg" id="modal_close" border="0" width="15" height="15" align="right" />');
		app = '<h1>Обратный звонок</h1>';
		app += '<hr class="hr" />';
		app += '<form name="form1" method="POST" action="/call"><input type="hidden" name="_csrf" value="'+callerSettings.token+'">';
		app += '<label>Ф.И.О.:</label>';
		app += '<input type="text" class="form-control" style="width:300px;" name="Call[name]" />';
		app += '<label>Телефон:</label>';
		app += '<input type="text" class="form-control" style="width:300px;" name="Call[phone]" />';
		app += '<label>Сообщение:</label>';
		app += '<textarea style="width:300px;" class="form-control" cols="32" rows="5" name="Call[body]" /></textarea>';
		app += '<hr class="hr" />';		
		app += '<center><input type="submit" class="submit4" value="Отправить" /></center>';
		app += '</form>';

		$('#data_box .data_wrp').append(app);
		
		$(".modal_box, #modal_close").click(function() {
			$('.modal_box').remove();
			$('#data_box').remove();
		});
		return false;
	})
	
	}	

})(jQuery);	