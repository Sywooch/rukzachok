/* more_hide */

$(function(){
	$(".more").click(function(){
		if($(this).hasClass("hideico")){
			$(this).removeClass("hideico");
			$(this).parent().addClass("open");
		$(this).parent().removeClass("open");
		}
		else{
		$(this).addClass("hideico");
			$(this).parent().addClass("open");
		}
	})
});

$(function(){
	$(".minus").click(function(){
		var a = $(this).parent().find(".item_num").attr("value");
		if (a == 1) {
		/* минимум 1 элемент */
		}
		else{
		a--;
		$(this).parent().find('.item_num').val(a);
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
		}
	});
})

$(function(){
	$(".black_close").click(function(){
		$(this).parent().parent().addClass("hidden");
	})
	$(".tobasket").click(function(){
		$(".black").removeClass("hidden");
	});
	$(".cont_shop").click(function(){
		$(".black").addClass("hidden");
	})
})

$(function(){
	$(".variant").click(function(){
		$(this).parent().find(".active").removeClass("active");
		$(this).addClass("active");
	})
})


$(function(){
	$(".title_spoiler").click(function(){
		if($(this).hasClass("closed")){
		$(this).parent().find(".spoiler_content").removeClass("hidden");
		$(this).removeClass("closed");
		}
		else{
		$(this).parent().find(".spoiler_content").addClass("hidden");
		$(this).addClass("closed");
		}
	});
})