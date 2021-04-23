<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<style>
	.expstickybar{
		position:fixed;
		color: white;
		padding: 5px;
		right:0; /*horizontally center bar in window*/
		left:0; /*horizontally center bar in window*/
		visibility:hidden;
		background: #27272A;
		z-index: 10000;
		width:auto; /*set width of bar to width of entire window*/
		font-weight:bold;
		border-top: 2px solid red;
		box-shadow: 10px 0px 0px 0px grey;
		box-shadow: 0px -12px 26px -2px #4a4141;
	}

	.expstickybar a{
		color: white;
	}
</style>

<script>
{literal}
jQuery.noConflict()

function expstickybar(usersetting){
	var setting=jQuery.extend({position:'bottom', peekamount:30, revealtype:'mouseover', speed:200}, usersetting)
	var thisbar=this
	var cssfixedsupport=!document.all || document.all && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //check for CSS fixed support
	if (!cssfixedsupport || window.opera)
		return
	jQuery(function($){ //on document.ready
		if (setting.externalcontent){
			thisbar.$ajaxstickydiv=$('<div id="ajaxstickydiv_'+setting.id+'"></div>').appendTo(document.body) //create blank div to house sticky bar DIV
			thisbar.loadcontent($, setting)
			}
		else
			thisbar.init($, setting)
	})
}

expstickybar.prototype={

	loadcontent:function($, setting){
		var thisbar=this
		var ajaxfriendlyurl=setting.externalcontent.replace(/^http:\/\/[^\/]+\//i, "http://"+window.location.hostname+"/")
		$.ajax({
			url: ajaxfriendlyurl, //path to external content
			async: true,
			dataType: 'html',
			error:function(ajaxrequest){
				alert('Error fetching Ajax content.<br />Server Response: '+ajaxrequest.responseText)
			},
			success:function(content){
				thisbar.$ajaxstickydiv.html(content)
				thisbar.init($, setting)
			}
		})

	},

	showhide:function(keyword, anim){
		var thisbar=this, $=jQuery
		var finalpx=(keyword=="show")? 0 : -(this.height-this.setting.peekamount)
		var positioncss=(this.setting.position=="bottom")? {bottom:finalpx} : {top:finalpx}
		this.$stickybar.stop().animate(positioncss, (anim)? this.setting.speed : 0, function(){
			thisbar.$indicators.each(function(){
				var $indicator=$(this)
				$indicator.attr('src', (thisbar.currentstate=="show")? $indicator.attr('data-closeimage') : $indicator.attr('data-openimage'))
			})
		})

		thisbar.currentstate=keyword
	},

	toggle:function(){
		var state=(this.currentstate=="show")? "hide" : "show"
		this.showhide(state, true)
	},

	init:function($, setting){
		var thisbar=this
		this.$stickybar=$('#'+setting.id).css('visibility', 'visible')
		this.height=this.$stickybar.outerHeight()
		this.currentstate="hide"
		setting.peekamount=Math.min(this.height, setting.peekamount)
		this.setting=setting
		if (setting.revealtype=="mouseover")
			this.$stickybar.bind("mouseenter mouseleave", function(e){
				thisbar.showhide((e.type=="mouseenter")? "show" : "hide", true)
		})
		this.$indicators=this.$stickybar.find('img[data-openimage]') //find images within bar with data-openimage attribute
		this.$stickybar.find('a[href=#togglebar]').click(function(){ //find links within bar with href=#togglebar and assign toggle behavior to them
			thisbar.toggle()
			return false
		})
		setTimeout(function(){
			thisbar.height=thisbar.$stickybar.outerHeight() //refetch height of bar after 1 second (last change to properly get height of sticky bar)
		}, 1000)
		this.showhide("hide")
	}
}


/////////////Initialization code://///////////////////////////

//Usage: var unqiuevar=new expstickybar(setting)

var mystickybar=new expstickybar({
	id: "stickybar", //id of sticky bar DIV
	position:'bottom', //'top' or 'bottom'
	revealtype:'mouseover', //'mouseover' or 'manual'
	peekamount:45, //number of pixels to reveal when sticky bar is closed
	externalcontent:'', //path to sticky bar content file on your server, or "" if content is defined inline on the page
	speed:250 //duration of animation (in millisecs)
})

{/literal}
</script>

<div id="stickybar" class="expstickybar">

<a href="#togglebar">
	<img src="{$smarty.const.SITE_URL}media/images/open.gif" data-closeimage="{$smarty.const.SITE_URL}media/images/close.gif" data-openimage="{$smarty.const.SITE_URL}media/images/open.gif" style="border-width:0; float:right;" />
</a>
<div class="row">
	<div class="col-md-1">
		<img src="{$smarty.const.SITE_URL}media/images/favicon.png" height="24px !important" /> 
	</div>
	<div class="col-md-3"></div>
	<div class="col-md-2">
		<i class="fa fa-clock-o orange"></i> Script exec. time: {$exec_time} sec
	</div>
	<div class="col-md-4">
		<i class="fa fa-memory orange"></i> [RAM usage] current: {$ram_usage} | Peak: {$ram_peak_usage}
	</div>
	<div class="col-md-3"></div>
</div>

<div class="row resources" style="margin-top:10px">

	<div class="col-md-4">
		<b>Web Development</b>
		<ul>
		<li><a href="http://www.dynamicdrive.com/">Dynamic Drive</a></li>
		<li><a href="http://www.cssdrive.com">CSS Drive</a></li>
		<li><a href="http://www.javascriptkit.com">JavaScript Kit</a></li>
		<li><a href="http://www.codingforums.com">Coding Forums</a></li>
		<li><a href="http://www.javascriptkit.com/domref/">DOM Reference</a></li>
		</ul>
	</div>

	<div class="col-md-4">
		<b>News Related</b>
		<ul>
		<li><a href="http://www.cnn.com/">CNN</a></li>
		<li><a href="http://www.msnbc.com">MSNBC</a></li>
		<li><a href="http://www.google.com">Google</a></li>
		<li><a href="http://news.bbc.co.uk">BBC News</a></li>
		</ul>
	</div>

	<div class="col-md-4">
		<b>Technology</b>
		<ul>
		<li><a href="http://www.news.com/">News.com</a></li>
		<li><a href="http://www.slashdot.com">SlashDot</a></li>
		<li><a href="http://www.digg.com">Digg</a></li>
		<li><a href="http://www.techcrunch.com">Tech Crunch</a></li>
		</ul>
	</div>

</div>

</div>