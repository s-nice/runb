<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="container">
  <style media="print">.printer {display:none;} .btn {display:none;}</style>
	<p style="text-align: right;"><button class="btn right" type="button" onclick="window.print()" class="printer"><?php echo $text_print; ?></button></p>
  <?php foreach ($orders as $order) { ?>
  <div style="page-break-after: always;">
    <h1 style="text-align: center;"><?php echo $order['store_name']; ?><?php echo $text_invoice; ?> </h1>
    <table class="table">
      <tbody>
      	<tr>
      		<td style="width: 50%;">
            <b><?php echo $text_contacter; ?></b><?php echo $order['shipping_name']; ?> <br/>
            <b><?php echo $text_telephone; ?></b><?php echo $order['telephone']; ?> <br/>
            <b><?php echo $text_email; ?></b><?php echo $order['email']; ?>  <br />
            <b><?php echo $text_address; ?></b><?php echo $order['shipping_address']; ?> <br />
      		</td>
      		<td style="width: 50%;">
      			<br/><br/>
						<b><?php echo $text_order_id; ?></b> <?php echo $order['order_id']; ?> <br/>
						<b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
      		</td>
      	</tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $column_index; ?></b></td>
          <td><b><?php echo $column_product; ?></b></td>
          <td><b><?php echo $column_model; ?></b></td>
          <td class="text-right"><b><?php echo $column_quantity; ?></b></td>
          <td class="text-right"><b><?php echo $column_price; ?></b></td>
          <td class="text-right"><b><?php echo $column_total; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <?php $index = 0; ?>
        <?php foreach ($order['product'] as $product) { ?>
        <?php $index += 1; ?>
        <tr>
          <td><?php echo $index; ?></td>
          <td><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td><?php echo $product['model']; ?></td>
          <td class="text-right"><?php echo $product['quantity']; ?></td>
          <td class="text-right"><?php echo $product['price']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['voucher'] as $voucher) { ?>
        <tr>
          <td><?php echo $voucher['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['recharge'] as $recharge) { ?>
        <tr>
          <td><?php echo $recharge['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $recharge['amount']; ?></td>
          <td class="text-right"><?php echo $recharge['amount']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['total'] as $total) { ?>
        <tr>
          <td class="text-right" colspan="5"><b><?php echo $total['title']; ?></b></td>
          <td class="text-right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <table class="table">
      <thead>
        <tr>
          <td style="width: 50%;"><b><?php echo $column_order_total; ?></b><?php echo $order['order_total']; ?></td>
          <td style="width: 50%;"><b><?php echo $column_order_total_1; ?></b><?php echo $order['order_total_1']; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2">
          	<?php echo $text_invoice_comment; ?>
          	<b><?php echo $order['store_name']; ?></b> <br />
          	<b><?php echo $text_telephone; ?></b> <?php echo $order['store_telephone']; ?><br />
            <?php if ($order['store_fax']) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
            <b><?php echo $text_email; ?></b> <?php echo $order['store_email']; ?><br />
            <b><?php echo $text_website; ?></b> <a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a></td>

          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php } ?>
</div>
</body>
</html>