{include file="documentHeader"}
<head>
	<title>{$sketch->getTitle()} - {lang}{PAGE_TITLE}{/lang}</title>
	{include file="headInclude" sandbox=false}
</head>
<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
{include file="header" sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}index.tpl{/icon}" alt="" /> <span>{lang}{PAGE_TITLE}{/lang}</span></a></li>
		
		{foreach from=$sketch->getBreadcrumbs() key=name item=title}
			<li>
				<a href="index.php?page=Sketch&amp;name={$name}{@SID_ARG_2ND}">
					<img src="{icons}sketchS.png,messageS.png{/icons}" alt="" />
					<span>{$title}</span>
				</a>
			</li>
		{/foreach}
	</ul>
	
	<div class="mainHeadline">
		<img src="{icons}sketchL.png,messageL.png{/icons}" alt="" />
		<div class="headlineContainer">
			<h2>{$sketch->title}</h2>
		</div>
	</div>
	
	{if $userMessages|isset}{@$userMessages}{/if}
	
	<div class="border content" class="sketch">
		<div class="container-1">
			{@$sketch->getFormattedContent()}
		</div>
	</div>
	
	<div class="border infoBox">
		<div class="container-1 infoBoxAuthors">
			<h3>{lang}wcf.sketchbook.sketch.infoBoxAuthors.headline{/lang}</h3>
			<p class="smallFont">
				{implode from=$sketch->getAuthors() item=author}<a href="index.php?page=User&amp;userID={@$author.userID}{@SID_ARG_2ND}">{$author.username}</a> ({@$author.time|shorttime}){/implode}
			</p>
		</div>
	</div>
</div>

{include file="footer" sandbox=false}
</body>
</html>