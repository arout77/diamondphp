{include file=$sidebar}
{include file=$layout}

		<legend>Introduction</legend>

		<p>
			DiamondPHP implements the <a href="http://smarty.net">Smarty 3 template engine</a> to generate templates and view files. If you are familiar with MVC frameworks, or have already read through the <a href="{$smarty.const.SITE_URL}documentation/mvc/controllers">Controllers</a> and <a href="{$smarty.const.SITE_URL}documentation/mvc/models">Models</a> portion of the documentation, you'll already know that controllers and models do not present data, they only manage it. Views are what is responsible for outputting HTML and content to the browser.
		</p>

<<<<<<< HEAD
		<legend>File location</legend>
		<p>
			View files are stored inside the following location:<br>
			<code>/app/design/frontend/template_name/views/</code><br><br>
			Change "template_name" to the name of your template, as set in the <a href="{$smarty.const.SITE_URL}documentation/introduction/configuration">Configuration file</a>.
		</p>
		<p>
			It is highly recommended to create separate folders for your view files for each corresponding controller. For example, store view files for the Member controller in the following directory:<br>
			<code>/app/design/frontend/template_name/views/member</code><br><br>
			Organizing your views in such a manner will make it simple to find a specific file, and will help avoid name collisions.
		</p>
=======
	<!-- blogpost start -->
	<article class="clearfix blogpost" data-animation-effect="fadeInUpSmall" data-effect-delay="200">
		<div class="overlay-container">
			<h3 class="text-center">Use it: <code>$this->template->assign('content', 'example.tpl');</code></h3>
		</div>
		<div class="blogpost-body">
			<div class="post-info">
				<span class="day">04</span>
				<span class="month">Dec 2016</span>
			</div>
			<div class="blogpost-content">
				<header>
					<h2 class="title"><a href="#">Working with view files</a></h2>
					<div class="submitted"><i class="fa fa-user pr-5"></i> by <a href="#">Andrew Rout</a></div>
				</header>

				<legend>Introduction</legend>

				<p>
					DiamondPHP implements the <a href="http://smarty.net">Smarty 3 template engine</a> to generate templates and view files. If you are familiar with MVC frameworks, or have already read through the <a href="{$smarty.const.SITE_URL}documentation/mvc/controllers">Controllers</a> and <a href="{$smarty.const.SITE_URL}documentation/mvc/models">Models</a> portion of the documentation, you'll already know that controllers and models do not present data, they only manage it. Views are what is responsible for outputting HTML and content to the browser.
				</p>

				<legend>File location</legend>
				<p>
					View files are stored inside the following location:<br>
					<code>/app/design/frontend/template_name/views/</code><br><br>
					Change "template_name" to the name of your template, as set in the <a href="{$smarty.const.SITE_URL}documentation/introduction/configuration">Configuration file</a>.
				</p>
				<p>
					It is highly recommended to create separate folders for your view files for each corresponding controller. For example, store view files for the Member controller in the following directory:<br>
					<code>/app/design/frontend/template_name/views/member</code><br><br>
					Organizing your views in such a manner will make it simple to find a specific file, and will help avoid name collisions.
				</p>
>>>>>>> ec5adaa9c1057104c796a0bef4746beb58a29024

		<legend>Layout</legend>
		<p>
			Smarty template engine was the first major template engine produced for the PHP language. DiamondPHP chose Smarty for template management for it's class leading performance, ease of use and full feature set. Smarty 3, the latest version, has introduced many key features and upgrades over previous versions. One of the most important is <em>template inheritance</em>. As Smarty itself describes it, "template inheritance keeps template management minimal and efficient.". We will quickly review the default template layout of DiamondPHP framework.
		</p>
		<p>
			The framework relies on five seperate view files to generate the template and content:
		</p>
		<p>
			<dl>
			  <dt class="red">head.tpl</dt>
			  <dd>Sets page titles, and manages meta tags and other elements inside of the HTML &lt;head> tags</dd>
			  <dt class="red">footer.tpl</dt>
			  <dd>The page footer. Primary purpose is to load required Javascript files and display links</dd>
			  <dt class="red">nav_user.tpl</dt>
			  <dd>The navigation menu to display to logged in members</dd>
			  <dt class="red">nav_visitor.tpl</dt>
			  <dd>The navigation menu to display to site visitors who are not logged in</dd>
			  <dt class="red">layout.tpl</dt>
			  <dd>The entire HTML structure of the website. The other four files extend this base file</dd>
			</dl>
		</p>

		<legend>Assigning and displaying views</legend>

		<p>
			Views are assigned in the Controller for each web page, using the following syntax:<br>
<pre class="console">
$this->template->assign( 'content', 'example.tpl' );
</pre>
			Note that <strong>'content'</strong> is <span class="red">required</span> as the first parameter, in order to display a view.
		</p>
		<p>
			There are occasions where you may wish to display partial views, or multiple view files, on a web page. 
			To do so, simply create an array, with each key representing the view file to include, and pass the array as the second parameter. An example is provided below:
			<br>
<pre class="console">
$content = ['home/example_1.tpl', 'home/example_2.tpl', 'forms/example_3.tpl'];
$this->template->assign('content', $content);
</pre>
		</p>

		<legend>Assigning variables</legend>
		<p>
			Variables are assigned in the Controller, using the following syntax:<br>
			<code>$this->template->assign( parameter 1, parameter 2 );</code>
		</p>
		<p>
			In the above code, parameter 1 is setting the variable name that will be used and parsed inside the view file, and parameter 2 is the value assigned to parameter 1. The primary purpose of this function is to set data, and then pass that data to the view file. Please view the following example:
		</p>
		<em>Controller file</em>
<pre class="console">
public function get_user() 
{ldelim}
    # Use the Session Toolbox to fetch username
    if( $this->session->verify('username') ) 
    {ldelim}
        $username = $this->session->get('username');
    {rdelim}
    else 
    {ldelim}
    	$username = 'Visitor';
    {rdelim}

    # Now we can simply pass it to the view file
    $this->template->assign('user', $username);

    # Display the view file
    $this->template->assign('content', 'member/hello.tpl');
{rdelim}
</pre>

				<em>View (hello.tpl)</em>
<pre class="console">
# Say hello!
Hello, {ldelim}$user{rdelim}
</pre>				

					Full documentation on assigning variables is available on <a href="http://www.smarty.net/docs/en/api.assign.tpl" target="_blank">Smarty assign() documentation</a>.
					<br><br>
					<div class="alert alert-danger">
						<h4>Important</h4> <em>The Smarty template engine provides functions that allows you to retrieve data directly from your database. An example of that is seen in the link above.</em>
						<strong> DO NOT USE VIEW FILES TO MAKE DATABASE CALLS!</strong><br>
						Instead, use the provided 
						<a class="blue" href="{$smarty.const.SITE_URL}documentation/core/database">database functionality</a> and/or 
						<a class="blue" href="{$smarty.const.SITE_URL}documentation/mvc/models">Models</a> within your controller, and then pass that data to your view file using the <code>$this->template->assign()</code> function.
					</div>
				</p>
			

			</div>
		</div>
		<footer class="clearfix">
			{* <ul class="links pull-left">
				<li><i class="fa fa-comment-o pr-5"></i> <a href="#">0 comments</a></li> 
			</ul> *}
			<div class="fb-comments" data-href="{$smarty.const.SITE_URL}documentation/mvc/views" data-numposts="10"></div>
			{* <a class="pull-right link" href="blog-post.html"><span>Read more</span></a> *}
		</footer>
	</article>
</div>

{include file=$layout_close}