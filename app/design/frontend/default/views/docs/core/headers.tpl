{include file=$sidebar}
{include file=$layout}

<p>
	HTTP headers must be set before any HTML is output. While the framework will allow you to manage headers manually, the best way to ensure headers are sent at the appropriate time is to use the builtin <code>set_headers()</code> method. The method accepts either a string or an array as arguments.
</p>

<p>
	The set_headers() method is only available to your controllers; you will not be able to access it in models or views. The reason for this default behaviour is two-fold:
	<ol>
		<li>It is not the responsibility of models or views to be involved with an HTTP request. They each have their own specific purposes.</li>
		<li>In the case of views, and often calls to models as well, HTML will have already been sent to the browser.</li>
	</ol>
</p>

<p>
	<legend>Setting a single header</legend>
	If you only need to set a single header, you can pass it as a string to the set_headers() method. The string must be the exact same string that you would normally pass to PHP's header() function. For example, if we wanted to disable browser caching:<br>
	<div>
		<small><em>file: Example_Controller.php</em></small><br>
		<code>
			$headers = "Cache-Control: no-cache, must-revalidate";
		</code>
		<br>
		<code>
			$this->set_headers($headers);
		</code>
	</div>
</p>

<p>
	<legend>Setting multiple headers</legend>
	When setting multiple headers, pass an array of strings to the set_headers() method. Each string must be the exact same string that you would normally pass to PHP's header() function. For example, if we wanted to allow a user to download a CSV file:<br>
	<div>
		<small><em>file: Example_Controller.php</em></small><br>
		<code>
			$headers = [<br>
				&nbsp;&nbsp;&nbsp;&nbsp;'Content-Type: text/csv; charset=UTF-8',<br>
				&nbsp;&nbsp;&nbsp;&nbsp;'Content-Description: File Transfer',<br>
				&nbsp;&nbsp;&nbsp;&nbsp;'Content-Disposition: attachment; filename="download.csv"'<br>
			];
		</code>
		<br><br>
		<code>
			$this->set_headers($headers);
		</code>
	</div>
</p>

{include file=$layout_close}