{include file="documentHeader"}
<head>
	<title>{if !$sketch->isRoot()}{$sketch->getTitle()} - {/if}{lang}wcf.sketchbook.list{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
	{include file="headInclude" sandbox=false}
</head>
<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
{include file="header" sandbox=false}

<div id="main">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}index.tpl{/icon}" alt="" /> <span>{lang}{PAGE_TITLE}{/lang}</span></a></li>
		
		{foreach from=$sketch->getBreadcrumbs() key=name item=title}
			<li>
				<a href="index.php?page=Sketchbook&amp;name={$name}{@SID_ARG_2ND}">
					<img src="{icons}sketchS.png,messageS.png{/icons}" alt="" />
					<span>{$title}</span>
				</a>
			</li>
		{/foreach}
	</ul>
	
	<div class="mainHeadline">
		<img src="{icons}sketchesL.png,messageL.png{/icons}" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.sketchbook.list{/lang}</h2>
			{if !$sketch->isRoot()}<p>{lang}wcf.sketchbook.list.description{/lang}</p>{/if}
		</div>
	</div>
	
	{if $userMessages|isset}{@$userMessages}{/if}
	
	<div class="border content" class="sketches">
		<div class="container-1">
			{include file="sketchListRecursive" sketches=$sketch->getAllChilds() parent=$sketch->name titles=$titles}
		</div>
	</div>
</div>

{include file="footer" sandbox=false}
</body>
</html>
