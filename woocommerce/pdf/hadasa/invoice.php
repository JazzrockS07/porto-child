<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>

<?php
	function rev($str)
	{
		$string = $str;
		$length = strlen($str);
		$rstr = '';

		for ($i = $length; $i > 0; $i--){
			$rstr .= $string[$i-1];
		}

		return $rstr;
	}

	function str_split_unicode($str, $l = 0) {
	    if ($l > 0) {
	        $ret = array();
	        $len = mb_strlen($str, "UTF-8");
	        for ($i = 0; $i < $len; $i += $l) {
	            $ret[] = mb_substr($str, $i, $l, "UTF-8");
	        }
	        return $ret;
	    }
	    return array_reverse(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY));
	}

	function rtl($string) {
		$rstr = strrev($string);
		
		$arr = preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
		$r_arr = array_reverse($arr);
		$r_str = implode($r_arr);

		$r_str = preg_replace_callback(
				"/(\d+)/" , function($matches) {
					return strrev($matches[0]);
				}, 
			$r_str);
		$r_str = preg_replace("/(\d+)([-])(\d+)/", '\\3\\2\\1', $r_str);
		$r_str = preg_replace("/([)])(.*?)([(])/", '\\3\\2\\1', $r_str);
		$r_str = preg_replace("/([}])(.*?)([{}])/", '\\3\\2\\1', $r_str);
		$r_str = preg_replace("/([]])(.*?)([[]])/", '\\3\\2\\1', $r_str);

		return $r_str;
	}
	
	// echo "<pre>";
	// var_dump($this->get_shipping_notes());
	// echo "</pre>";
?>

<table class="head container">
	<tr>
		<td class="shop-info">
			<div class="shop-name"><h3><?php $this->shop_name(); ?></h3></div>
			<div class="shop-address"><?php $this->shop_address(); ?>
				<?php
					//echo rtl("זול פה קניות שוות") . "<br>";
					//echo rtl("כתובת: רחוב אהוד קינמון (כניסה מהצד) ,35 בת ים.") . "<br>";
					//echo "03-5569285 " . rtl("טלפון") . ":";
				?>
			</div>
		</td>
		<td class="header">
		<?php
		if( $this->has_header_logo() ) {
			$this->header_logo();
		} else {
			echo apply_filters( 'wpo_wcpdf_invoice_title', __( 'Invoice', 'woocommerce-pdf-invoices-packing-slips' ) );
		}
		?>
		</td>
	</tr>
</table>

<h1 class="document-type-label">
<?php if( $this->has_header_logo() ) echo rtl('פרוט הזמנה'); echo ( ' / Order Invoice'); ?>
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<table class="order-data-addresses">
	<tr>
		<td class="order-data">
			<table>
				<?php do_action( 'wpo_wcpdf_before_order_data', $this->type, $this->order ); ?>
				<?php if ( isset($this->settings['display_number']) ) { ?>
				<tr class="invoice-number">
					<td><?php $this->invoice_number(); ?></td>
					<th><?php _e( 'Invoice Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
				</tr>
				<?php } ?>
				<?php if ( isset($this->settings['display_date']) ) { ?>
				<tr class="invoice-date">
					<td><?php $this->invoice_date(); ?></td>
					<th><?php _e( 'Invoice Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
				</tr>
				<?php } ?>
				<tr class="order-number">
					<td><?php $this->order_number(); ?></td>
					<th><?php _e( 'Order Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
				</tr>
				<tr class="order-date">
					<td><?php $this->order_date(); ?></td>
					<th><?php _e( 'Order Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
				</tr>
				<tr class="payment-method">
					<td><?php echo rtl($this->order->payment_method_title); ?></td>
					<th><?php _e( 'Payment Method:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
				</tr>
				<?php do_action( 'wpo_wcpdf_after_order_data', $this->type, $this->order ); ?>
			</table>			
		</td>
		<td class="address shipping-address">
			<?php if ( isset($this->settings['display_shipping_address']) && $this->ships_to_different_address()) { ?>
			<h3><?php _e( 'Ship To:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
			<?php $this->shipping_address(); ?>
			<?php } ?>
		</td>
		<td class="address billing-address">
			<!-- <h3><?php _e( 'Billing Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3> -->
			<?php
				echo rtl($this->order->get_data()['billing']["first_name"]) . " " . rtl($this->order->get_data()['billing']["last_name"]) . "<br>";
				echo rtl($this->order->get_data()['billing']["address_1"]) . "<br>";
				echo rtl($this->order->get_data()['billing']["address_2"]) . "<br>";
				echo rtl($this->order->get_data()['billing']["city"]) . "<br>";
				echo rtl($this->order->get_data()['billing']["postcode"]);
			?>
			<?php //$this->billing_address(); ?>
			<?php if ( isset($this->settings['display_email']) ) { ?>
			<div class="billing-email"><?php $this->billing_email(); ?></div>
			<?php } ?>
			<?php if ( isset($this->settings['display_phone']) ) { ?>
			<div class="billing-phone"><?php $this->billing_phone(); ?></div>
			<?php } ?>
			<div class="country">ISRAEL</div>
		</td>
	</tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<table class="order-details">
	<thead>
		<tr>
			<th class="price"><?php _e('Price', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="image">Image</th>
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items(); if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) :?>
		<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
			<td class="price"><?php echo $item['order_price']; ?></td>
			<td class="quantity"><?php echo $item['quantity']; ?></td>
			<td class="product">
				<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation 
				$engname = get_field ('name_of_product_in_english',  $item['product_id']);	?>
				<span class="item-name"> <?php echo rtl($item['name']);  ?><?php if($engname) echo '<br/>'.  $engname ; ?></span>
				<?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
				<span class="item-meta"><?php echo $item['meta']; ?></span>
				<dl class="meta">
					<?php $description_label = __( 'SKU', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
					<?php if( !empty( $item['sku'] ) ) : ?><dt class="sku"><?php _e( 'SKU:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="sku"><?php echo $item['sku']; ?></dd><?php endif; ?>
					<?php if( !empty( $item['weight'] ) ) : ?><dt class="weight"><?php _e( 'Weight:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="weight"><?php echo $item['weight']; ?><?php echo get_option('woocommerce_weight_unit'); ?></dd><?php endif; ?>
				</dl>
				<?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
			</td>
			<td class="image">
				<?php 
				if(isset($item["thumbnail"]))
					echo $item["thumbnail"]; 
				?>
			</td>
		</tr>
		<?php endforeach; endif; ?>
	</tbody>
	<tfoot>
		<tr class="no-borders">
			<td class="no-borders" colspan="4">
				<table class="totals">
					<tfoot>
						<?php foreach( $this->get_woocommerce_totals() as $key => $total ) : ?>
						<tr class="<?php echo $key; ?>">
							<td class="no-borders"></td>
							<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
							<th class="description"><?php echo $total['label']; ?></th>
						</tr>
						<?php endforeach; ?>
					</tfoot>
				</table>
			</td>
			<!-- <td class="no-borders">
				<div class="customer-notes">
					<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->type, $this->order ); ?>
					<?php if ( $this->get_shipping_notes() ) : ?>
						<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
						<?php $this->shipping_notes(); ?>
					<?php endif; ?>
					<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->type, $this->order ); ?>
				</div>				
			</td> -->
		</tr>
	</tfoot>
</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>
