<ul>
	{foreach from=$sketches key=name item=childs}
		<li>
			{if $parent == ''}
			{capture assign=$fullName}{if $fullName !== ""}{@$fullName}/{/if}{@$name}{/capture}
			{$fullName|sketchTitle}
			{if $childs|count}
				{include file="sketchListRecursive" sketches=$childs parent=$fullName}
			{/if}
		</li>
	{/foreach}
</ul>
