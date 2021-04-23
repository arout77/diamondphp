{include file=$sidebar}
{include file=$layout}

<p>
	If you've used other PHP frameworks, you know that you'll often need to manually link URLs to controllers. This can be very cumbersome and labor intensive when maintaining your site, especially as it grows larger. DiamondPHP takes a different approach in order to simplify things and reduce the time and effort needed to map URLs. <br>
	In DiamondPHP, the router is responsible for mapping URLs to their corresponding controllers. <br>When you create a <a target="_blank" href="{$smarty.const.SITE_URL}documentation/mvc/controllers">controller</a>, you are creating a new (blank) page on your website. You will then typically use <a target="_blank" href="{$smarty.const.SITE_URL}documentation/mvc/models">models</a> to fetch data and <a target="_blank" href="{$smarty.const.SITE_URL}documentation/mvc/views">views</a> to display the data and render the HTML.<br>
	The router then reads the URL, and instantiates the proper controller and action. See the example below.
</p>

<legend>Mapping URLs to Controllers</legend>

<p>
	<small><em>File: /public/controllers/Example_Controller.php</em></small><br>
	<small><em>URL: {$smarty.const.SITE_URL}example</em></small>
<pre class="terminal">
&lt;?php
namespace Web\Controller;
use App\Controller\Base_Controller;

class Example_Controller extends Base_Controller {

	public function index() {
		// index() method gets executed by default 
		// if no action is specified
	}
}

?&gt;
</pre>
	In the above example, we created a controller named "Example_Controller". To access this page, we would navigate to {$smarty.const.SITE_URL}example. When we request that URL, the router knows that "Example_Controller" is being requested, since it is the first URL segment after your domain name. The second URL segment to appear after your domain name is called the "action". The action looks for a method of the same name inside the controller class "Example_Controller". Since we did not specify an action, the router will default to "index". If instead, we navigate to {$smarty.const.SITE_URL}example/widgets, the router will create an <code>Example_Controller</code> object, and then look for and execute the method named <code>widgets</code> in the Example_Controller class:
</p>

<p>
	<small><em>File: /public/controllers/Example_Controller.php</em></small><br>
	<small><em>URL: {$smarty.const.SITE_URL}example/widgets</em></small>
<pre class="terminal">
&lt;?php
namespace Web\Controller;
use App\Controller\Base_Controller;

class Example_Controller extends Base_Controller {

	public function index() {
		// We called the "widgets" action in the URL,
		// so index() gets ignored
	}

	public function widgets() {
		// Since we called the widgets action in the URL,
		// this method will get executed rather than index()
	}
}

?&gt;
</pre>
</p>

<div class="alert alert-info">
	It is important to remember that if there is no action present in the URL, the router will try to execute <code>index</code> by default; therefore, each controller should contain a method named index, else a 404 server error will be raised.
</div>

<legend>URL parameters</legend>

<p>
	
</p>

{include file=$layout_close}