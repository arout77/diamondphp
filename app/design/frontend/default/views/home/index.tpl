<div class='row'>
	<p>
		<h2>Welcome to DiamondPHP</h2>
	</p>
	<p><br></p>
	<p class='lead'>
		About this page
	</p>
	<p>
		This page is generated dynamically by DiamondPHP. To edit this page, you can find it at:
	</p>

	<div class="alert alert-info">
	<table class="table">
		<tr><th>Controller</th></tr>
			<tr>
				<td><code>{$data.controller}.php</code></td>
			</tr>
		<tr><th>View File</th></tr>
			<tr>
				<td><code>{$data.view}</code></td>
			</tr>
	</table>
	</div>

	<hr>

	<div>
		<table class="table" style="width: 370px;">
		<caption>Some information about your current environment:</caption>
			<tr>
				<td><strong>DiamondPHP Version</strong>:</td><td>{$data.software_ver}</td>
			</tr>
			<tr>
				<td><strong>PHP Version</strong>:</td><td>{$data.php_ver}</td>
			</tr>
			<tr>
				<td><strong>MySQL Version</strong>:</td><td>{$data.mysql_ver}</td>
			</tr>
			<tbody></tbody>
	</div>

	<hr>

	<div>
	<table>
		For more information and tips on using the framework, please view the documentation. We advise viewing the online documentation, which is updated periodically and may include information not found in the documentation provided with the framework.<br><br>

		<a href="https://diamondphp.org/documentation" target="_blank">View online documentation</a><br>
		<a href="{$data.site_url}documentation" target="_blank">View documentation locally</a>
	</table>
	</div>
</div>