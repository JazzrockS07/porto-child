<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>

<?php
//	function str_split_unicode($str, $l = 0) {
//	    if ($l > 0) {
//	        $ret = array();
//	        $len = mb_strlen($str, "UTF-8");
//	        for ($i = 0; $i < $len; $i += $l) {
//	            $ret[] = mb_substr($str, $i, $l, "UTF-8");
//	        }
//	        return $ret;
//	    }
//	    return array_reverse(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY));
//	}

//	function rtl($string) {
//		$rstr = strrev($string);
//		
//		$arr = preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
//		$r_arr = array_reverse($arr);
//		$r_str = implode($r_arr);
//
//		$r_str = preg_replace_callback(
//				"/(\d+)/" , function($matches) {
//					return strrev($matches[0]);
//				}, 
//			$r_str);
//		$r_str = preg_replace("/(\d+)([-])(\d+)/", '\\3\\2\\1', $r_str);
//		$r_str = preg_replace("/([)])(.*?)([(])/", '\\3\\2\\1', $r_str);
//		$r_str = preg_replace("/([}])(.*?)([{}])/", '\\3\\2\\1', $r_str);
//		$r_str = preg_replace("/([]])(.*?)([[]])/", '\\3\\2\\1', $r_str);
//
//		return $r_str;
//	}
	
	// echo "<pre>";
	// var_dump($this->get_shipping_notes());
	// echo "</pre>";
?>

<table class="head container">
	<tr>

		<td class="header shop-logo">
		<?php
		if( $this->has_header_logo() ) {
			//$this->header_logo();
					

		} else {
			echo apply_filters( 'wpo_wcpdf_invoice_title', __( 'Invoice', 'woocommerce-pdf-invoices-packing-slips' ) );
		}
		?>
		<img src="https://toyoya.store/wp-content/themes/porto-child/img/toyoyaLogo.png" width="220">
		</td>
				<td class="shop-info" style="text-align:left;">
			<div class="shop-name"><h3><?php $this->shop_name(); ?></h3></div>
			<div class="shop-address"><?php $this->shop_address(); ?>
			</div>
		</td>
	</tr>
</table>
<br/>
<br/>

<h1 class="document-type-label">
<?php if( $this->has_header_logo() ) //echo rtl('פרוט הזמנה'); 
echo ( 'Order Invoice'); ?>
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<table class="order-data-addresses">
	<tr>
		<td class="order-data">
			<table>
				<?php do_action( 'wpo_wcpdf_before_order_data', $this->type, $this->order ); ?>
				<?php if ( isset($this->settings['display_number']) ) { ?>
				<tr class="invoice-number">

					<th><?php _e( 'Invoice Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
					<td><?php $this->invoice_number(); ?></td>
				</tr>
				<?php } ?>
				<?php if ( isset($this->settings['display_date']) ) { ?>
				<tr class="invoice-date">

					<th><?php _e( 'Invoice Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
					<td><?php $this->invoice_date(); ?></td>
				</tr>
				<?php } ?>
				<tr class="order-number">

					<th><?php _e( 'Order Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
					<td><?php $this->order_number(); ?></td>
				</tr>
				<tr class="order-date">
					<th><?php _e( 'Order Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
					<td><?php $this->order_date(); ?></td>
				</tr>
				<tr class="payment-method">
					<th><?php _e( 'Payment Method:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
					<td><?php echo ($this->order->payment_method_title); ?></td>
				</tr>
				<?php do_action( 'wpo_wcpdf_after_order_data', $this->type, $this->order ); ?>
			</table>			
		</td>
		<!--<td class="address shipping-address">
			<?php if ( isset($this->settings['display_shipping_address']) && $this->ships_to_different_address()) { ?>
			<h3><?php _e( 'Ship To:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
			<div dir="rtl">
			<?php $this->shipping_address(); ?>
			</div>
			<?php }  ?>
		</td> -->
		<td></td>
		<td class="address billing-address" style="unicode-bidi: normal;">
			<!-- <h3><?php _e( 'Billing Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3> -->
			<?php
				//echo ($this->order->get_data()['billing']["first_name"]) . " " . ($this->order->get_data()['billing']["last_name"]) . "<br>";
				//echo ($this->order->get_data()['billing']["address_1"]) . "<br>";
				//echo ($this->order->get_data()['billing']["address_2"]) . "<br>";
				//echo ($this->order->get_data()['billing']["city"]) . "<br>";
				//echo ($this->order->get_data()['billing']["postcode"]);
			?>
			<?php $this->shipping_address(); ?>
			<?php //$this->billing_address(); ?>
			<?php if ( isset($this->settings['display_email']) ) { ?>
			<!--<div class="billing-email"><?php //$this->billing_email(); ?></div> -->
			<?php } ?>
			<?php if ( isset($this->settings['display_phone']) ) { ?>
			<div class="shipping-phone" ><bdo dir="ltr">+972 <?php $this->billing_phone(); ?></bdo></div>
			<?php } ?>
			<div class="country">ISRAEL</div>
		</td>
	</tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<table class="order-details">
	<thead>
		<tr>
			<th class="image">Image</th>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="price"><?php _e('Price', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
	
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items(); if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) :?>
		<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
			<td class="image">
				<?php 
				if(isset($item["thumbnail"]))
					echo $item["thumbnail"]; 
				?>
			</td>
			
			<td class="product">
				<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation 
				$engname = get_field ('name_of_product_in_english',  $item['product_id']);
					if($engname)		{?>
						<span class="item-name"> <?php echo  $engname ; ?></span>
					<?php } else {?>
						<span class="item-name"> <?php echo ($item['name']);  ?></span>
					<?php };?>
				<?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
				<span class="item-meta"><?php echo $item['meta']; ?></span>
				<dl class="meta">
					<?php $description_label = __( 'SKU', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
					<?php if( !empty( $item['sku'] ) ) : ?><dt class="sku"><?php _e( 'SKU:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="sku"><?php echo $item['sku']; ?></dd><?php endif; ?>
				</dl>
				<?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
			</td>
			
			<td class="quantity"><?php echo $item['quantity']; ?></td>
			
			<td class="price">
			<?php
			//echo $item['order_price'].'<br/>';
			//echo $item['price'].'<br/>';
			$item_data     = $item['item']->get_data();
			//$quantity      = $item_data['quantity'];
			//$line_subtotal = $item_data['sub_total'];
			$line_total    = $item_data['total'];
			//echo $line_total.'<br/>';
			//echo $line_subtotal.'<br/>';
			//echo $quantity.'<br/>';
			//var_dump ($item);
			//$usdprice = substr($item['order_price'], 100);
			
			//$usdprice = str_replace('</span>', '', $usdprice) ;
			
			//$usdprice = floatval($usdprice);
			$usdprice = $line_total;
			
			$usdprice =round($usdprice/get_field('exchange_rate', 'option'), 2 );
			echo $usdprice; ?> USD 
					<?php
			if( get_field('shipping_price', $item['product_id'])){
				$shipinusd = round (get_field('shipping_price', $item['product_id'])/get_field('exchange_rate', 'option'), 2);
				
				echo "<p>Shipping:". $shipinusd . " </b> USD </p>";
				//echo get_field('exchange_rate', 'option');
			}
		?>
			</td>



		</tr>
		<?php endforeach; endif; ?>
	</tbody>

</table>
	<table style="    width: 100%;"> 
		<tr class="no-borders">
			<td class="no-borders">
				<table class="totals">
					<tfoot>
					
						<?php
						foreach( $this->get_woocommerce_totals() as $key => $total ) : 
						if  ($key != 'payment_method'){
						?>
						
						<tr class="<?php echo $key; ?>">
							<td class="no-borders"></td>
							
							<th class="description"><?php echo $total['label']; ?></th>
							<td class="price" style="text-align: right;"><span class="totals-price"><?php 
							//echo $total['value']; 
							
			//$total_data     = $total['item']->get_data();
			//$line_total    = $total_data['total'];
			//echo $line_total;
			//print_r ($total);
			//echo $total['value'].'<br>';
			$test = preg_match('([0-9,]*[.][0-9][0-9])', $total['value'],  $matches);
			$usdprice =  $matches[0];
			//echo $usdprice.'<br>';
			//$usdprice = substr($total['value'], 100);
			//$usdprice = str_replace('</span>', '', $usdprice) ;
			//$usdprice = floatval($usdprice);
			//$usdprice = floatval($usdprice);
			$usdprice = str_replace(',', '', $usdprice);
			$usdprice =round($usdprice/get_field('exchange_rate', 'option'), 2 );
			echo $usdprice; ?> USD </span></td>
						</tr>
						<?php }
						endforeach; ?>
						

					</tfoot>
				</table>
			</td>

		</tr>
		<tr>			 <td class="no-borders" >
				
										<div>
						<?php
							    foreach( $order->get_items('coupon') as $coupon ){
									$coupon_codes[] = $coupon->get_code();
    }
    // For one coupon
    if($coupon_codes && count($coupon_codes) == 1 ){
        $coupon_code = reset($coupon_codes);
        echo '<p>'.__( 'Coupon Used: ').$coupon_code.'<p>';
    } 
    // For multiple coupons
    else if ($coupon_codes && count($coupon_codes) > 1 ){
        $coupon_codes = implode( ', ', $coupon_codes);
        echo '<p>'.__( 'Coupons Used: ').$coupon_codes.'<p>';
    }; ?>

							
						</div>
				
				
				<div class="customer-notes">
					<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->type, $this->order ); ?>
					<?php if ( $this->get_shipping_notes() ) : ?>
						<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
						<?php $this->shipping_notes(); ?>
					<?php endif; ?>
					<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->type, $this->order ); ?>
				</div>		
				
				
			</td></tr>
	</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); 
	$to = 'hadashaha@gmail.com';
			$headers = array(
					'From: kaniti.online<service@kaniti.online>',
					'content-type: text/html'
				);
	if($this->get_invoice_number() > 996909900){

				

				$message =  ('numbers for XLT invoices will finished soon');
				
				wp_mail( $to, 'numbers for XLT invoices will finished soon', $message, $headers );
	}
	//wp_mail( $to, 'numbers for XLT invoices will finished sent', $this->get_invoice_number(), $headers );
	
?>
