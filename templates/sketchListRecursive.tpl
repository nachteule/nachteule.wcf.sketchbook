<ul>
	{foreach from=$sketches key=name item=childs}
		<li>
			{if $parent == ''}
			{capture assign=$fullName}{if $fullName !== ""}{@$fullName}/{/if}{@$name}{/capture}
			{$titles[$fullName]}
			{if $childs|count}
				{include file="sketchListRecursive" sketches=$childs parent=$fullName titles=$titles}
			{/if}
		</li>
	{/foreach}
</ul>
