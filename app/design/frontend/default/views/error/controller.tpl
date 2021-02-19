{literal}
<style media="screen">
	pre {
		background-color: #242424;
		color: lime;
		font-size: 16px;
		font-family: "Lucida Console", Monaco, monospace;
	}
	h3 { color: #242424; background-color: lime; width: 25%; text-align: center; margin-left: auto; margin-right: auto; }
</style>
{/literal}

<pre>
<h3>DEBUG CONSOLE</h3>
>  <strong>MESSAGE: CONTROLLER NOT FOUND</strong>
>
>  How to fix this error: make sure that <span class="btn-danger">{$controller}_Controller.php</span> exists in your Controllers directory:
> 
>  {$smarty.const.CONTROLLERS_PATH}
>
>  If the file already exists, ensure that the server has read permissions to the file. 
>  Also ensure that the class name matches the file name -- {$controller}_Controller, 
>  as well as extends the core controller class:
>
   <strong><span style="color: #ff6666">&lt?php 
       namespace Web\Controller;
       use Hal\Controller\Base_Controller;
 
       class {$controller}_Controller extends Base_Controller{}</span></strong>
>
>  Finally, ensure that the index() method exists within the {$controller} class. Each controller falls back
>  on the index() method as the default action.
>
>  View <a href="{$smarty.const.SITE_URL}documentation/mvc/controllers" style="color: #ff6666">the Controllers documentation</a> for more information.
</pre>