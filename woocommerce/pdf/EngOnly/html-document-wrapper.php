<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php 
	if ($this->get_type()=="invoice"){
		echo //$this->get_title() . "_";  
		$this->invoice_number();}
	else{
		echo $this->get_title() . "_";  $this->order_number();}	
	?></title>
	<style type="text/css"><?php $this->template_styles(); ?></style>
	<style type="text/css"><?php do_action( 'wpo_wcpdf_custom_styles', $this->get_type(), $this ); ?></style>
	<style>
@page { margin: 5px 20px; }
</style>
</head>
<body class="<?php echo $this->get_type(); ?>">
<?php echo $content; ?>
</body>
</html>