<?php
add_filter('wp_sitemaps_enabled', '__return_false');
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) exit;
	
	// BEGIN ENQUEUE PARENT ACTION
	// AUTO GENERATED - Do not modify or remove comment markers above or below:
	
	if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
		$uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
		}
	endif;
	add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
	
	if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'porto-plugins','porto-theme','porto-shortcodes','porto-style','porto-style','porto_admin_bar' ) );
	}
	endif;
	add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 1000 );
	
	// END ENQUEUE PARENT ACTION
	
	function webzz_enqueue_styles() { 
		wp_enqueue_style( 'child-css', get_stylesheet_directory_uri(). '/style.css' );
		wp_enqueue_style( 'index-css', get_stylesheet_directory_uri(). '/css/index.css' );
		wp_enqueue_script( 'global-js', get_stylesheet_directory_uri() . '/js/global.js' );
		wp_enqueue_script( 'jquery-mask-js', get_stylesheet_directory_uri() . '/js/jquery.mask.js' );
		
	}
	add_action( 'wp_enqueue_scripts', 'webzz_enqueue_styles', PHP_INT_MAX  );
	
//	add_action ('wp_footer', 'tawkchat');
	function tawkchat(){
		echo '
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src="https://embed.tawk.to/5df50152d96992700fcc4bd0/default";
		s1.charset="UTF-8";
		s1.setAttribute("crossorigin","*");
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->
		';
		
	};
	
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page();
	}
	add_action( 'admin_init', 'my_remove_menu_pages' );
	function my_remove_menu_pages() {

		global $user_ID;
		$user_meta=get_userdata($user_ID);

		$user_roles=$user_meta->roles; //array of roles the user is part of.

		if ( in_array('shop_manager', $user_roles) )  {
			//echo '<style>.toplevel_page_woocommerce{display:none;}</style>';
			remove_menu_page( 'woocommerce' );

		}
	}

	add_filter( 'wpo_wcpdf_paper_format', 'wcpdf_a5_packing_slips', 10, 2 );
	function wcpdf_a5_packing_slips($paper_format, $template_type) {
		if ($template_type == 'packing-slip') {
			$paper_format = 'a5';
		}

		return $paper_format;
	}


	add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 9999 );

	function bbloomer_remove_product_tabs( $tabs ) {
		unset( $tabs['additional_information'] );
		return $tabs;
	}

	//remove_action ('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

	add_action('woocommerce_after_single_product_summary', 'my_bottom_content', 1);
	function my_bottom_content(){
		echo do_shortcode('[porto_block name="product-size-guide"]');

	}

	//add_action('woocommerce_after_single_product_summary', 'size_table');
	//add_action('woocommerce_share', 'size_table');
	add_action('woocommerce_after_add_to_cart_form', 'size_table', 20);
	function size_table(){
		$table = get_field( 'table_size' );

		if ( ! empty ( $table ) ) {

			echo '<div class="table-size_wrapper">';
			echo '<h3 class="sizeh3">' . __('Size Guide', 'porto-child') . '</h3>';
			echo '<table border="0">';

			if ( ! empty( $table['caption'] ) ) {

				echo '<caption>' . $table['caption'] . '</caption>';
			}

			if ( ! empty( $table['header'] ) ) {

				echo '<thead>';

                echo '<tr>';

				foreach ( $table['header'] as $th ) {

					echo '<th>';
					echo $th['c'];
					echo '</th>';
				}

                echo '</tr>';

				echo '</thead>';
			}

			echo '<tbody>';

            foreach ( $table['body'] as $tr ) {

                echo '<tr>';

				foreach ( $tr as $td ) {

					echo '<td>';
					echo $td['c'];
					echo '</td>';
				}

                echo '</tr>';
			}

			echo '</tbody>';

			echo '</table>';
			echo '</div>';
		}

	}


	add_action('woocommerce_after_add_to_cart_form', 'ship_dates', 35);
	function ship_dates(){
		$min=date("d M", strtotime("+25 Days"));
		$max=date("d M", strtotime("+35 Days"));
		$eng_months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );
		$heb_months   = array("ינואר", "פברואר", "מרץ", "אפריל", "מאי", "יוני", "יולי",  "אוגוסט", "ספטמבר", "אוקטובר", "נובמבר", "דצמבר");
		$min = str_ireplace($eng_months, $heb_months, $min);
		$max = str_ireplace($eng_months, $heb_months, $max);
		echo '<div class="ship-dates">';
		echo '<span class="redubnde">זמן משלוח:</span> 15 עד 20 ימי עבודה ';
		echo ' <a target="_blank" href="/shipping/">';
		echo 'לפרטים נוספים';
		echo '</a>';
		echo '<br/>';
		echo ' זמן משלוח משוער';
		echo '<span class="jazz-shipping-date">';
		echo ' מ - ';
		echo $min;
		echo ' ל - ';
		echo $max;
		echo '</span>';
		//	echo '<br/>';
		//	echo 'החל מ15 בינואר 2020, זמני האספקה יהיו כפולים מהרגיל עקב חופשת ראש השנה הסינית!';
		echo '</div>';
	}

	//add_action('wp_footer', 'side_coupon');
	//function side_coupon(){
	//	echo '<div class="coupon-banner"><a href="/coupons" class="pagelink test" target="_blank"></a><a href="#" class="open-coup"></a></div>';
	//
	//}

	add_action( 'woocommerce_after_add_to_cart_form', 'mx_parameter_of_prod_func', 15 );
	function mx_parameter_of_prod_func() {

		global $product;
		global $post;
		$product = wc_get_product(get_the_ID());
		//$shipclass = $product->get_shipping_class();
		echo "<div class='smallprint mx-prod-parameters'>";
		echo "<h2>More information:</h2>";
		//echo $shipclass;

		if( get_field('sizes') )
		echo "<p><b>Size: </b>". get_field('sizes'). "</p>";
		if( get_field('weight') )
		echo "<p><b>Weight: </b>". get_field('weight'). "</p>";
		if( get_field('color') )
		echo "<p><b>Color: </b>". get_field('color'). "</p>";
		if( get_field('material') )
		echo "<p><b>Material: </b>". get_field('material'). "</p>";
		if( get_field('general_notes') )
		echo "<p><b>Notes: </b>". get_field('general_notes'). "</p>";

		echo "</div>";
		$shiptext = "משלוח חינם מעל ₪165";
		$shiptext2 = "<br/>משלוח להזמנות מתחת ל165שח - בעלות של 17שח";
		//if( $product -> get_price() > 189.99 ){
		echo "<p class='freeship_label single-label'>" . $shiptext . $shiptext2  . " <i class='shipping-but fa fa-truck' aria-hidden='true'></i></p>";


		//	};
		//echo $product->id;
	}



	/**
		* Adds a new column to the "My Orders" table in the account.
		*
		* @param string[] $columns the columns in the orders table
		* @return string[] updated columns
	*/
	function sv_wc_add_my_account_orders_column( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $name ) {
			$new_columns[ $key ] = $name;
			// add ship-to after order status column
			if ( 'order-status' === $key ) {
				$new_columns['order-track'] = __( 'מספר המעקב', 'pojochild' );
			}
		}
		return $new_columns;
	}
	add_filter( 'woocommerce_my_account_my_orders_columns', 'sv_wc_add_my_account_orders_column' );
	/**
		* Adds data to the custom "ship to" column in "My Account > Orders".
		*
		* @param \WC_Order $order the order object for the row
	*/
	function sv_wc_my_orders_ship_to_column( $order ) {
		$invoice = wcpdf_get_invoice( $order, true ); // true makes sets 'init' which makes sure an invoice number is created;
		$invoice_number = $invoice->get_number();
		// invoice number is an object, but has a __toString magic method so if you use it as a string it will print the formatted number.
		// You can also explicitly get the formatted or plain number:
		$formatted_invoice_number = $invoice_number->get_formatted();
		if ($formatted_invoice_number == 1) $formatted_invoice_number = '';
		// $plain_invoice_number = $invoice_number->get_plain();
		$orddate = $order -> get_date_created();
		if ($orddate){
			//print_r ($orddate  -> getTimestamp());
			$days = (time() - $orddate  -> getTimestamp()) / (24*60*60);
			switch ($days){
				case($days > 20);
				echo '<a href="https://my.exelot.com/public/track/" target="_blank" rel="noopener">exelot.com</a><br/>';
				echo $formatted_invoice_number;
				break;
				case($days > 12);
				echo __('Product on flight', 'porto-child');
				break;
				case($days > 11);
				echo __('Product on custom control', 'porto-child');
				break;
				case($days > 7);
				echo __('Product on the way', 'porto-child');
				break;
				case($days > 3);
				echo __('Product arranged to ship', 'porto-child');
				break;
				case($days > 1);
				echo __('Paymant received', 'porto-child');
				break;
				case($days > 0.001);
				echo __('Order placed', 'porto-child');
				break;
			};
		}
		//echo  $formatted_invoice_number;
	}
	add_action( 'woocommerce_my_account_my_orders_column_order-track', 'sv_wc_my_orders_ship_to_column' );

	/**
		* @snippet       WooCommerce: Define Minimum Order Amount & Show Errors
		* @how-to        Get CustomizeWoo.com FREE
		* @author        Rodolfo Melogli
		* @compatible    WooCommerce 3.8
		* @donate $9     https://businessbloomer.com/bloomer-armada/
	*/

	add_action( 'woocommerce_checkout_process', 'bbloomer_wc_minimum_order_amount' );
	add_action( 'woocommerce_before_cart', 'bbloomer_wc_minimum_order_amount' );

	function bbloomer_wc_minimum_order_amount() {

		$minimum = 50.00; // change this to your minimum order amount
		//$minimum = 0.01;

		if ( WC()->cart->subtotal < $minimum ) {

			if ( is_cart() ) {

				wc_print_notice(
                sprintf( 'כרגע יש לך בסל %s מינימום הזמנה  %s.' , wc_price( WC()->cart->subtotal ), wc_price( $minimum ) ), 'error' );

				} else {

				wc_add_notice(
                sprintf( 'כרגע יש לך בסל %s מינימום הזמנה  %s.' ,wc_price( WC()->cart->subtotal ), wc_price( $minimum ) ), 'error' );

			}

		}

	}
	
	add_action( 'woocommerce_before_single_product', 'mx_discount_label' );

	function mx_discount_label() {
		//echo get_locale();
		if( wp_is_mobile() ) {
			echo "<p class='mx_discount_label discount_label_first'>קנה 2 מוצרים זהים, קבל 5% הנחה<span class='discount_label_coma'>, </span><span class='discount_label_first_to_block_switch'>קנו 3 מוצרים זהים וקבלו 8% הנחה</span></p>";
			echo "<p class='mx_discount_label discount_label_second'>מינימום הזמנה - ₪50</p>";
		} else {
			echo "<p class='mx_discount_label discount_label_second'>מינימום הזמנה - ₪50</p>";
		}
	};

	add_filter( 'get_terms', 'ts_get_subcategory_terms', 10, 3 );
	function ts_get_subcategory_terms( $terms, $taxonomies, $args ) {
		$new_terms = array();
		// if it is a product category and on the shop page
		if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {
			foreach( $terms as $key => $term ) {
				if ( !in_array( $term->slug, array( 'uncategorized' ) ) ) { //pass the slug name here
					$new_terms[] = $term;
				}}
				$terms = $new_terms;
		}
		return $terms;
	}

	add_shortcode( 'logout_link', 'logout_link_code');

function logout_link_code() {
    if (is_user_logged_in()) {
        $items = '<li><a  href="' . wp_logout_url(home_url()). '">' . __('Logout', 'woocommerce') . '</a></li>';
    }
    elseif (!is_user_logged_in()) {
        $items = '<li><a  href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">' . __('Log in', 'woocommerce') . '</a></li>';
    }
    return $items;
}

// Custom validation for Billing Phone checkout field
add_action('woocommerce_checkout_process', 'custom_validate_billing_phone');
function custom_validate_billing_phone() {
    $is_correct = preg_match('/(\()?([0-9]{3})(\))?([ .-]?)([0-9]{3})([ .-]?)([0-9]{4})/', $_POST['billing_phone']);
    if ( $_POST['billing_phone'] && !$is_correct) {
        wc_add_notice( __( 'בבקשה להזין טלפון בפורמט הזה <strong>(000) 000-0000 </strong>.' ), 'error' );
    }
}

/**
 * @snippet       [recently_viewed_products] Shortcode - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.6.2
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */



 function custom_track_product_view() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }

    global $post;

    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
        $viewed_products = array();
    else
        $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );

    if ( ! in_array( $post->ID, $viewed_products ) ) {
        $viewed_products[] = $post->ID;
    }

    if ( sizeof( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }

    // Store for session only
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}

add_action( 'template_redirect', 'custom_track_product_view', 20 );


add_shortcode( 'recently_viewed_products', 'bbloomer_recently_viewed_shortcode' );

function bbloomer_recently_viewed_shortcode() {

   $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
   $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

   if ( empty( $viewed_products ) ) return;

   $title = '<h3>מוצרים שנצפו לאחרונה</h3>';
   $product_ids = implode( ",", $viewed_products );

   return $title . do_shortcode("[products ids='$product_ids']");

}



	add_action('woocommerce_after_add_to_cart_button', 'buy_now_button');
	function buy_now_button(){
		global $product;
		global $post;
		echo '<button type="submit" name="add-to-cart" value="'. $product->get_id() .'" class="single_add_to_cart_button button alt" id="buy_now_button">קנה עכשיו</button><input type="hidden" name="is_buy_now" id="is_buy_now" value="0" />';
	}

	function buy_now_submit_form() {
	?>
	<script>
		jQuery(document).ready(function(){
			// listen if someone clicks 'Buy Now' button
			jQuery('#buy_now_button').click(function(){
				if (!jQuery(this).hasClass('disabled')){

					// set value to 1
					jQuery('#is_buy_now').val('1');
					//submit the form
					jQuery('form.cart').submit();
				}
			});
		});
	</script>
	<?php
	}
	add_action('woocommerce_after_add_to_cart_form', 'buy_now_submit_form');


	add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
	function redirect_to_checkout($redirect_url) {
		if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
			global $woocommerce;
			$redirect_url = wc_get_checkout_url();
		}
		return $redirect_url;
	}


add_filter( 'woocommerce_rest_prepare_shop_order_object', 'my_wc_prepare_shop_order', 10, 3 );

function my_wc_prepare_shop_order( $response, $object, $request ) {
$order_data = $response->get_data();

foreach ( $order_data['line_items'] as $key => $item ) {
$order_data['line_items'][ $key ]['related_brand_product'] = get_post_meta( $item['product_id'], 'related_brand_product', true );
}

$response->data = $order_data;
return $response;
}

// Automatically Delete Woocommerce Images After Deleting a Product
add_action( 'before_delete_post', 'delete_product_images', 10, 1 );

function delete_product_images( $post_id )
{
    $product = wc_get_product( $post_id );

    if ( !$product ) {
        return;
    }

    $featured_image_id = $product->get_image_id();
    $image_galleries_id = $product->get_gallery_image_ids();

    if( !empty( $featured_image_id ) ) {
        wp_delete_post( $featured_image_id );
    }

    if( !empty( $image_galleries_id ) ) {
        foreach( $image_galleries_id as $single_image_id ) {
            wp_delete_post( $single_image_id );
        }
    }
}

// add shortcode recently_viewed_product

add_action( 'template_redirect', 'jazz_recently_viewed_product_cookie', 20 );

function jazz_recently_viewed_product_cookie() {

    // если находимся не на странице товара, ничего не делаем
    if ( ! is_product() ) {
        return;
    }


    if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
        $viewed_products = array();
    } else {
        $viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
    }

    // добавляем в массив текущий товар
    if ( ! in_array( get_the_ID(), $viewed_products ) ) {
        $viewed_products[] = get_the_ID();
    }

    // нет смысла хранить там бесконечное количество товаров
    if ( sizeof( $viewed_products ) > 4 ) {
        array_shift( $viewed_products ); // выкидываем первый элемент
    }

    // устанавливаем в куки
    wc_setcookie( 'woocommerce_recently_viewed_2', join( '|', $viewed_products ) );

}

add_shortcode( 'recently_viewed_products', 'jazz_recently_viewed_products' );

function jazz_recently_viewed_products() {

    if( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
        $viewed_products = array();
    } else {
        $viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
    }

    if ( empty( $viewed_products ) ) {
        return;
    }

    // надо ведь сначала отображать последние просмотренные
    $viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
	$title = '<h2>מוצרים אחרונים שצפית</h2>';

    $product_ids = join( ",", $viewed_products );

    return $title.do_shortcode( "[products ids='$product_ids']" );

}

// add button add to wishlist on single product page

add_action( 'woocommerce_after_add_to_cart_button', 'jazz_add_to_wishlist', 15 );

function jazz_add_to_wishlist() {
    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
}

// add something to mini-cart

add_action( 'woocommerce_after_mini_cart', 'jazz_add_to_minicart', 12 );

function jazz_add_to_minicart() {
  echo do_shortcode( '[woocommerce_my_account]');
}

// add attributes to product page

/*
add_action( 'woocommerce_before_add_to_cart_form', 'jazz_add_attributes', 15 );

function jazz_add_attributes() {
    global $product;
    ?>
	<table class="variations attributes" cellspacing="0">
		<tbody>
		<tr>
			<td class="label"><label>Age</label></td>
			<td class="value"><?php echo $product->get_attribute('age'); ?></td>
		</tr>
		</tbody>
	</table>
	<?php
}
*/

// add specification on single product page

add_action( 'woocommerce_after_add_to_cart_form', 'jazz_add_specification', 5 );

function jazz_add_specification() {
    global $product;
    $attributes = $product->get_attributes();
    ?>
	<div class="row table-attributes-wrapper">
        <?php foreach ( $attributes as $attribute ) :
            if (wc_attribute_label( $attribute->get_name() ) != 'Select' && wc_attribute_label( $attribute->get_name() ) != 'Weight') { ?>
				<div class="col-md-12 table-attributes">
					<span class="label-table-attributes"><?php echo wc_attribute_label( $attribute->get_name() ); ?>:</span>
                    <?php
                    $values = array();

                    if ( $attribute->is_taxonomy() ) {
                        $attribute_taxonomy = $attribute->get_taxonomy_object();
                        $attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                        foreach ( $attribute_values as $attribute_value ) {
                            $value_name = esc_html( $attribute_value->name );

                            if ( $attribute_taxonomy->attribute_public ) {
                                $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                            } else {
                                $values[] = $value_name;
                            }
                        }
                    } else {
                        $values = $attribute->get_options();

                        foreach ( $values as &$value ) {
                            $value = make_clickable( esc_html( $value ) );
                        }
                    }

                    echo apply_filters( 'woocommerce_attribute', function_exists( 'porto_shortcode_format_content' ) ? porto_shortcode_format_content( implode( ', ', $values ) ) : implode( ', ', $values ), $attribute, $values );
                    ?>
				</div>
            <?php } endforeach; ?>
	</div>
    <?php
}

// change slider thumbnales on single product page

add_filter( 'woocommerce_single_product_carousel_options', 'jazz_product_gallery_arrows' );

function jazz_product_gallery_arrows( $options ) {

    $options[ 'direction' ] = "vertical";
    return $options;

}
/*
add_shortcode( 'jazz_add_video_to_product_page', 'jazz_add_video_to_product' );

function jazz_add_video_to_product() {
	?>
	<div class="mx-video">
        <?php
        if( get_field('video_url')){
            //the_field('video_url');
            ?>
			<br/>
			<video  controls>
				<source src="<?php the_field('video_url'); ?>" type="video/mp4">
			</video>
            <?php
        };
        ?>
	</div>
    <?php
}
*/

function rf_product_thumbnail_size( $size ) {
    global $product;

    $size = 'full';
    return $size;
}
add_filter( 'subcategory_archive_thumbnail_size', 'rf_product_thumbnail_size' );

/**
 * Format price range.
 *
 * @param string $price
 * @param $from
 * @param $to
 *
 * @return string
 */
function iconic_format_price_range( $price, $from, $to ) {
	//return str_replace( '&ndash;', '/', $price );
	return '<span class="jazz-price-from">מ ' . wc_price($from).'</span>';
}

add_filter( 'woocommerce_format_price_range', 'iconic_format_price_range', 10, 3 );

/*
 * set cookie - no cache for gtranslate
 */
/*
add_action('init', 'jazz_setcookie_gtranslate');
function jazz_setcookie_gtranslate() {
    setcookie("gt-no-cache", "yes", 7*24*3600);
}
*/
	
/*
 * check email
 *
add_action('init', 'jazz_mail');
function jazz_mail() {
	$to = 'sjnexus18@gmail.com';
	$subject = 'The subject';
	$body = 'The email body content';
	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail( $to, $subject, $body, $headers );
}
*/

add_action('wp_head', 'add_verification_code');
function add_verification_code(){
echo '<meta name="google-site-verification" content="JBfPJ-f7mJrHU_UHqeojFdGd3WJJs3JBC4s2X4uaFvw" />';
}


/*
 * add invoice number to email
 */

add_action( 'woocommerce_email_before_order_table', 'woocommerce_email_print_invoice_number', 10, 4 );
function woocommerce_email_print_invoice_number( $order, $sent_to_admin, $plain_text, $email ) {
	// limit to specific order statuses
	$allowed_statuses = array( 'processing', 'completed' );
	if (!in_array($order->get_status(), $allowed_statuses)) {
		return;
	}

	// create/initialize invoice
	$invoice = wcpdf_get_invoice( (array) $order->get_id(), true ); // true makes sets 'init' which makes sure an invoice number is created;
	$invoice_number = $invoice->get_number();
	// invoice number is an object, but has a __toString magic method so if you use it as a string it will print the formatted number.
	// You can also explicitly get the formatted or plain number:
	$formatted_invoice_number = $invoice_number->get_formatted();
	$plain_invoice_number = $invoice_number->get_plain();

	echo "<p>זה מספר המעקב שלך: <span style='color:#f9637d'>{$formatted_invoice_number}</span>,<br>הנה קישור למעקב אחריו: <a href='https://www.exelot.com/'>https://www.exelot.com/</a></p>";
}

/*
 *  add icon for checkout credit card method
 */

add_filter( 'woocommerce_gateway_icon', 'add_credit_card_gateway_icons', 10, 2 );

function add_credit_card_gateway_icons( $icon_string, $gateway_id ) {

	if ( 'cardcom' === $gateway_id ) {

		$icon_string  = '<img class="jazz-visa-icon" src="https://sw-themes.com/porto_dummy/wp-content/uploads/images/payments/payment-visa.svg" alt="Visa" />';
		$icon_string .= '<img class="mastercard-icon" src="'.get_stylesheet_directory_uri().'/img/mastercard.png" alt="mastercard" />';


	}
	return $icon_string;
}

add_filter( 'woocommerce_gateway_icon', 'add_credit_card_gateway_icons', 10, 2 );




/**
 * @snippet       Change "Place Order" Button text @ WooCommerce Checkout
 */

add_filter( 'woocommerce_order_button_text', 'misha_custom_button_text' );

function misha_custom_button_text( $button_text ) {
	return 'שלח הזמנה לתשלום'; // new text is here
}

function w3speedup_before_start_optimization($html){
	$html = str_replace(array('color:  !important;'),array(''),$html);
    return $html;
}

function w3speedup_customize_critical_css($critical_css){
	$critical_css = str_replace(array('@font-face{font-family:"porto";','@font-face{font-family:"Font Awesome 5 Free";','@font-face{font-family:"Font Awesome 5 Brands";'),array('','',''),$critical_css);
	return $critical_css;
}