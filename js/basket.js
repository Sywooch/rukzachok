(function($){

    $.fn.basket = function(callerSettings) {
	
	var basket_id = this;

		var find_products = function(){ 
         $("a[rel~='product']").each(function (i) { 
                $(this).bind('click',function(){ 
                var rel = $(this).attr('rel');
                var id = $('#product_id').val();
                var count = 1;
                go_product({mod_id : id,count:count});
                return false;
                })
         })
        }
        
		var go_product = function(data){
		    var product_id = data.product_id;
			$.get("/basket/add/",  data ,
			function(data){ 
				//alert_msg("Товар добавлен<br /> в корзину",product_id);
				popup(0,'.black');
				start_basket();
			});		
		}

		var popup = function(w,form){
			$.get("/basket/items/", {} ,function(data){
				$('.basket_items').html(data);
				$('.basket_items .delete_button').click(function(){
					var id =$(this).data('id');
					$.get("/basket/items/",  {deleteID : id},function(data){
						popup(w,form);
						start_basket(w,form);
					});
					return false;
				});
				$(".item_num").bind('input',function(){
					sendformitems(w,form);
				});
				$(".minus").click(function(){
					var a = $(this).parent().find(".item_num").attr("value");
					if (a == 1) {
						/* минимум 1 элемент */
					}
					else{
						a--;
						$(this).parent().find('.item_num').val(a);
						sendformitems(w,form);
					}
				});
				$(".plus").click(function(){
					var a = $(this).parent().find(".item_num").attr("value");
					if (a == 10) {
						/* минимум 1 элемент */
					}
					else{
						a++;
						$(this).parent().find('.item_num').val(a);
						sendformitems(w,form);
					}
				});
			});
			if(w==0) {
				$(".black").removeClass("hidden");
				$(".black_close").click(function () {
					$(this).parent().parent().addClass("hidden");
				});
				$(".cont_shop").click(function () {
					$(".black").addClass("hidden");
				});
			}
		}

		var sendformitems = function(w,form){
			data_form = $(form+' #basket_form2').serialize();
			$.ajax({
				type: 'POST',
				url: "/basket/items/",
				data: data_form,
				success: function(data) {
					popup(w,form);
					start_basket();
				},
			});
		}
	
        var start_basket = function(){ 
			$.get("/basket/info/",
			function(data){
				$(basket_id).html(data);
			});

        }

		var alert_msg = function(msg,product_id){ 
		winW = document.body.offsetWidth;
		winH = document.body.offsetHeight
		$('.modal_box').remove();
		$('#data_box').remove();
		$('body').append('<div class="modal_box"></div>');
		$('body').append('<div id="data_box"></div>');
		$('#data_box').append('<div class="data_wrp"></div>');
                $('#data_box').css( "left", ((winW-400)/2)+'px' );
    
	var scrollTop = document.documentElement.scrollTop
    if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1 || navigator.userAgent.toLowerCase().indexOf('safari') > -1) {
		scrollTop = document.body.scrollTop;
    }		
		$('#data_box').css( "top", (scrollTop+150)+'px' );
		
		app = '<center>';
		app +='<h1>'+msg+'</h1>';
		app += '<br /><input type="submit" class="submit4" style="text-transform:none;" value="Перейти в корзину" onClick="document.location=\'/basket/\'" />&nbsp;';
		app += '<input type="submit" class="submit4" style="text-transform:none;" id="p_close" value="Продолжить покупки" />';
		app += '</center>';
		$('#data_box .data_wrp').append(app);
		
		
		$(".modal_box, #modal_close, #p_close").click(function() {
			$('.modal_box').remove();
			$('#data_box').remove();
		});		
		}		
		
		find_products();
		start_basket();



		$(".more").click(function(){
			if($(this).hasClass("hideico")){
				$(this).removeClass("hideico");
				$(this).parent().addClass("open");
				$(this).parent().removeClass("open");
			}
			else{
				$(this).addClass("hideico");
				$(this).parent().addClass("open");
				popup(1,'.basket_hovered');
			}
		})


		
	}	

})(jQuery);