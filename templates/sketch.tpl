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
			{if $sketch->sketchID}
				<h2>{$sketch->title}</h2>
			{else}
				<h2>{lang}wcf.sketchbook.sketch.add{/lang}</h2>
			{/if}
		</div>
	</div>
	
	{if $userMessages|isset}{@$userMessages}{/if}
	
	<div class="border content" class="sketch">
		<div class="container-1">
			<div class="contentBox">
				{if $sketch->sketchID}
					{@$sketch->getFormattedContent()}
				{else}
					<p>{lang}wcf.sketchbook.sketch.add.info{/lang}</p>
				{/if}
				
				<div class="buttonBar">
					<div class="smallButtons">
						<ul>
							<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{icon}upS.png{/icon}" alt="{lang}wcf.global.scrollUp{/lang}" /> <span class="hidden">{lang}wcf.global.scrollUp{/lang}</span></a></li>
							
							<li>
								<a href="index.php?form=SketchEdit&amp;name={$sketch->name}{@SID_ARG_2ND}">
									{if $sketch->sketchID}
										<img src="{icons}sketchEditS.png,editS.png{/icons}" alt="" />
										<span>{lang}wcf.sketchbook.sketch.edit{/lang}</span>
									{else}
										<img src="{icons}sketchAddS.png,addS.png{/icons}" alt="" />
										<span>{lang}wcf.sketchbook.sketch.add{/lang}</span>
									{/if}
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	{if $sketch->sketchID}
		<div class="border infoBox">
			<div class="container-1 infoBoxAuthors">
				<div class="containerIcon">
					<img src="{icons}sketchAuthorsM.png,membersM.png{/icons}" alt="" />
				</div>
				<div class="containerContent">
					<h3>{lang}wcf.sketchbook.sketch.infoBoxAuthors.headline{/lang}</h3>
					<p class="smallFont">
						{implode from=$sketch->getAuthors() item=author}<a href="index.php?page=User&amp;userID={@$author.userID}{@SID_ARG_2ND}">{$author.username}</a> ({@$author.time|shorttime}){/implode}
					</p>
				</div>
			</div>
			{if $sketch->getChilds()|count}
			<div class="container-2 infoBoxChilds">
				<div class="containerIcon">
					<img src="{icons}sketchesM.png,messageM.png{/icons}" alt="" />
				</div>
				<div class="containerContent">
					<h3>{lang}wcf.sketchbook.sketch.infoBoxChilds.headline{/lang}</h3>
					<p class="smallFont">
						{implode from=$sketch->getChilds() key=name item=child}
							{if $child.childs}
								<img src="{icons}sketchesS.png,messages.png{/icons}" alt="" />
							{else}
								<img src="{icons}sketchS.png,messages.png{/icons}" alt="" />
							{/if}
						
							<a href="index.php?page=Sketch&amp;name={$name}{@SID_ARG_2ND}">{$child.title}</a>
						{/implode}
					</p>
				</div>
			</div>
			{/if}
		</div>
	{/if}
</div>

{include file="footer" sandbox=false}
</body>
</html>
