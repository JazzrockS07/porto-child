<?php 
//function rtl($string) {
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
do_action( 'wpo_wcpdf_before_document', $this->type, $this->order );?>

<table class="head container">
	<tr>
		<td class="header" style="text-align:center;">
		<?php
		if( $this->has_header_logo() ) {
			//$this->header_logo();
		} else {
			echo apply_filters( 'wpo_wcpdf_packing_slip_title', __( 'Shipping label', 'woocommerce-pdf-invoices-packing-slips' ) );
		}
		?>
		<img src="https://toyoya.store/wp-content/themes/porto-child/img/toyoyaLogo.png" width="240">
		</td>
	</tr>
	<tr>
		<td class="shop-info" style="padding-bottom:30px; position:relative;">
			<div class="tracking-number"> <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/barcode.php?s=code-128&d=<?php $this->invoice_number(); ?>&sx=3&sy=1.2&f=svg"></div>
			<div style="font-size: 25px; text-align: center; letter-spacing: 4px; position:absolute; top:220px; background-color: #fff; padding: 5px 20px; left:140px;"><?php $this->invoice_number(); ?></div>
		</td>
	</tr>
</table>
		<h1 class="document-type-label">
<?php if( $this->has_header_logo() ) echo apply_filters( 'wpo_wcpdf_packing_slip_title', __( 'Shipping label', 'woocommerce-pdf-invoices-packing-slips' ) ); ?>
</h1>
<hr>
<br/>
<table>
	<tr class="secrow">
		<td>

<h2>From:</h2>
			<div class="shop-name"><h3><?php  $this->shop_name(); ?></h3></div> 
			<!-- <div class="shop-address"><?php $this->shop_address(); ?></div> -->
		</td>
	</tr>
	<tr  class="secrow">
		<td >
			<div class="tracking-number"><?php _e( 'Tracking Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?> - <?php $this->invoice_number(); ?> <br/>
			<?php _e( 'Order Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?>   <?php $this->order_number(); ?><br/>
			<?php  _e( 'Order Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?> <?php  $this->order_date(); ?>
			</div>
		</td>
	</tr>
	<tr  class="secrow" >
		<td colspan="2" class="address shipping-address" >
		<hr>
		<h2>To:</h2>
			<!-- <h3><?php _e( 'Shipping Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3> -->
			<div style="direction: rtl;">
						<?php
				echo ($this->order->get_data()['shipping']["first_name"]) . " " . ($this->order->get_data()['shipping']["last_name"]) . "<br>";
				echo ($this->order->get_data()['shipping']["address_1"]) . "<br>";
				echo ($this->order->get_data()['shipping']["address_2"]) . "<br>";
				echo ($this->order->get_data()['shipping']["city"]) . "<br>";
				echo ($this->order->get_data()['shipping']["postcode"]);
			?>
			</div>

			<?php if ( isset($this->settings['display_email']) ) { ?>
			<div class="shipping-email"><?php $this->billing_email(); ?></div>
			<?php } ?>
			<?php if ( isset($this->settings['display_phone']) ) { ?>
			<div class="shipping-phone" ><bdo dir="ltr">+972 <?php $this->billing_phone(); ?></bdo></div>
			<div class="shipping-phone">ISRAEL</div>
			<?php } ?>
			

		</td>
		
	</tr>
</table>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<hr>
<table class="order-details">
	<thead>
		<tr>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items(); if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) : ?>
		<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
			<td class="product">
				<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation 

					$engname = get_field ('name_of_product_in_english',  $item['product_id']);
					if($engname)		{?>
						<span class="item-name"> <?php echo  $engname ; ?></span>
					<?php } else {?>
						<span class="item-name"> <?php echo ($item['name']);  ?></span>
					<?php };?>
				

				<?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
				<?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
			</td>
			<td class="quantity"><?php echo $item['quantity']; ?></td>
		</tr>
		<?php endforeach; endif; ?>
	</tbody>
</table>
<?php 
$ordnumb = $this->order->id;
if (get_field('weight_order', $ordnumb)) {?>
<div class="wands"><p>Common weight: <?php echo get_field('weight_order', $ordnumb) ?> kg</p></div>
<?php }; 

if (
get_field('length_order', $ordnumb) &&
get_field('height_order', $ordnumb) &&
get_field('width_order', $ordnumb)
 ) {?>
<div class="wands"><p>Sizes: <br/> Height - <?php echo get_field('height_order', $ordnumb) ?>cm <br/>Width - <?php echo get_field('width_order', $ordnumb) ?>cm <br/>Deep <?php echo get_field('length_order', $ordnumb) ?>cm</p></div>

<p>Shipping volume weight - <?php echo round ((get_field('length_order', $ordnumb) * get_field('height_order', $ordnumb) * get_field('width_order', $ordnumb)/6000), 2); ?> Kg</p> 
<?php }; 

?>
<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->type, $this->order ); ?>
<div class="customer-notes">
	<?php if ( $this->get_shipping_notes() ) : ?>
		<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
		<?php $this->shipping_notes(); ?>
	<?php endif; ?>
</div>
<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>

<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>