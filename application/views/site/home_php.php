{include file='site/en/layout/header.html'}

<!-- {include file='site/en/right_banner.html'} -->
{if $filename != '' }
{if $filename == 'site/en/dashboard.html'} 
{/if}
{include file=$filename}
{else}
{include file='site/en/dashboard.html'}
{/if}  
{include file='site/en/layout/footer_html.html'}
