jQuery(document).ready(function($){
	
	$('.header-contact a').each(function(){
		$(this).attr('target', '_blank');
	});
	
	$('.products a').each(function() {
		$(this).attr('target', '_blank');
	})  
  
	$(window).load(function(){
		
		//$('#follow-us-widget-2 .share-links [data-original-title="WhatsApp"]').attr('href', 'https://api.whatsapp.com/send?phone=85251351196').show().attr('target', '_blank');
		
		$('.share-links a').attr('target', '_blank');
	})
	$('#menu-top-navigation').append('<li class="menu-item"><a>מינימום הזמנה 99.99ש"ח | משלוחים חינם מעל 159.99ש"ח</a></li>')
	
	$('.summary.entry-summary .product_meta').insertAfter('.ship-dates');
	$('.coupon-banner .pagelink').attr('target', '_blank');
	$('.open-coup').click(function(e){
		e.preventDefault();
		$('.coupon-banner').toggleClass('copened');
	});
	setTimeout(function(){
		jQuery('.star-rating').each(function(){
			if (jQuery(this).data('original-title') == '0') {
				jQuery(this).attr('data-original-title', (Math.round( (Math.random()/2 + 4.5) * 10 )/10 ).toString());
				jQuery(this).find('span').css('width', '96%');	
			};
			
		})
	}, 1000);
	
	$('#menu-main-menu a').attr('target', '_blank');
	
	jQuery('#billing_phone').mask("(YS9) 999-9999", {'translation': {
		S: {pattern: /[5-7]/},
		Y: {pattern: /[0]/}
	}
	});
	setTimeout(function(){
	if ($('.review-widget .r-wapper-widget').is(":visible")){
		$('.entry-summary .woocommerce-product-rating').hide();
	}
	}, 7000);
	
				$(document).on('click','.product-widget__ryviu',function(){
				$('html, body').animate({
			      scrollTop: $('.resp-accordion[aria-controls="tab_item-1"]').offset().top
			    },500)
			    $('.resp-accordion[aria-controls="tab_item-1"]').trigger('click');
			});

	jQuery(".product-summary-wrap .variations_form #select").change(function(){
		if (jQuery( ".jazz-single-product-description .price" ).html().substr(0, 4) == 'From') {
			jQuery( ".jazz-single-product-description .price" ).hide();
		}

	});

	console.log(jQuery( ".jazz-single-product-description .price" ).html().substr(0, 4));

});

