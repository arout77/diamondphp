<form class="form">
	<table class="table table-responsive col-sm-12 col-md-3">
		<tr>
			<td><strong>Card Number</strong></td>
			<td><input type="number" name="cc_num" value="{$ccnum}"></td>
		</tr>
		<tr>
			<td><strong>Expiration Date</strong></td>
			<td><input type="string" maxlength="7" name="expires" value="{$expires}"></td>
		</tr>
		<tr>
			<td><strong>CVV</strong></td>
			<td><input type="number" max="999" name="cvv" value="{$cvv}"></td>
		</tr>
</form>