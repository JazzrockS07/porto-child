jQuery(document).ready(function($){
	
	$('.header-contact a').each(function(){
		$(this).attr('target', '_blank');
	});
	
	$('.products a').each(function() {
		$(this).attr('target', '_blank');
	});

	$('.wishlist-items-wrapper a').each(function() {
		$(this).attr('target', '_blank');
	});

	$('html[lang="en-US"] .rp_wcdpd_pricing_table_quantity').each(function() {
		var newtext = 'buy' + $(this).text();
		$(this).text(newtext);
	});

	$('html[lang="en-US"] .rp_wcdpd_pricing_table .woocommerce-Price-amount').each(function() {
		var newtext = 'pay ' + $(this).text();
		$(this).text(newtext);
	});

	$('html[lang="he-IL"] .rp_wcdpd_pricing_table_quantity').each(function() {
		var newtext = ' קנה' + $(this).text();
		$(this).text(newtext);
	});

	$('html[lang="he-IL"] .rp_wcdpd_pricing_table .woocommerce-Price-amount').each(function() {
		var newtext = ' שלם ' + $(this).text();
		$(this).text(newtext);
	});

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
		if (jQuery( ".jazz-single-product-description .price .jazz-price-from" ).length > 0) {
			jQuery( ".jazz-single-product-description .price .jazz-price-from" ).hide();
		}
		//console.log(jQuery( ".jazz-single-product-description .product-summary-wrap .single_variation_wrap .single_variation" ).html());
		setTimeout(function(){
			$('html[lang="en-US"] .rp_wcdpd_pricing_table_quantity').each(function() {
				var newtext = 'buy' + $(this).text();
				$(this).text(newtext);
			});

			$('html[lang="en-US"] .rp_wcdpd_pricing_table .woocommerce-Price-amount').each(function() {
				var newtext = 'pay ' + $(this).text();
				$(this).text(newtext);
			});

			$('html[lang="he-IL"] .rp_wcdpd_pricing_table_quantity').each(function() {
				var newtext = ' קנה' + $(this).text();
				$(this).text(newtext);
			});

			$('html[lang="he-IL"] .rp_wcdpd_pricing_table .woocommerce-Price-amount').each(function() {
				var newtext = ' שלם ' + $(this).text();
				$(this).text(newtext);
			});
		}, 7000);
	});

	$('.woocommerce-checkout .exin-button').click(function(){
		/* Get the text field */
		var copyText = $('#jazz-your-code').text();
		/* Copy the text inside the text field */
		navigator.clipboard.writeText(copyText);
		$(this).text('העתקת את הקוד, הדבק בעמודת הקופון');
	});
	$('.woocommerce-cart .exin-button').click(function(){
		/* Get the text field */
		var copyText = $('#jazz-your-code').text();
		/* Copy the text inside the text field */
		navigator.clipboard.writeText(copyText);
		$(this).text('העתקת את הקוד, הדבק בעמודת הקופון');
	});

	let header = $('#header');
	let hederHeight = header.height(); // вычисляем высоту шапки

	$(window).scroll(function() {

			if($(this).scrollTop() > 1) {
				header.addClass('header_fixed');
				$('body').css({
					'paddingTop': hederHeight+'px' // делаем отступ у body, равный высоте шапки
				});
				$('.jazz-custom-box-iw').addClass('header_2_remove');
				$('.jazz-banner-mobile').addClass('header-3-remove');
				$('.jazz-header-only-mini-1 .custom-logo').addClass('header-5-remove');
				$('.jazz-header-only-mini-1 .vc_custom_1645382450057').addClass('header-4-update');
				$('.jazz-custom-box-no-display').addClass('header-3-remove');
				$('.jazz-header-mini-1').addClass('header-3-remove');
				$('.jazz-mobile-header .jazz-header-mobile-logo').addClass('header-5-remove');
			} else {
				header.removeClass('header_fixed');
				$('.jazz-custom-box-iw').removeClass('header_2_remove');
				$('.jazz-banner-mobile').removeClass('header-3-remove');
				$('.jazz-header-only-mini-1 .custom-logo').removeClass('header-5-remove');
				$('.jazz-header-only-mini-1 .vc_custom_1645382450057').removeClass('header-4-update');
				$('.jazz-custom-box-no-display').removeClass('header-3-remove');
				$('.jazz-header-mini-1').removeClass('header-3-remove');
				$('.jazz-mobile-header .jazz-header-mobile-logo').removeClass('header-5-remove');
				$('body').css({
					'paddingTop': 0 // удаляю отступ у body, равный высоте шапки
				})
			}

	});

	$('.popup-test').click(function(){
		$('#pum-317199').popmake('close');
		$('#pum-353189').show();
	});
});

