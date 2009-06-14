<ul id="lx10th_netvigation">
  {if isset($prepage)}
    <li><a href="{$prepage}">上一頁</a></li>
  {/if}      
  
  {foreach from=$allpages item=page}
    {if $page.url eq $curpage}
      <li><a title="{$page.title}" href="{$page.url}" class="current">&nbsp;</a></li>
    {else}
      {if $page.thumb eq ""}
      <li><a title="{$page.title|truncate:30}" href="{$page.url}">&nbsp;</a></li>
      {else}
      <li><a title="<table><tr><td><img src='{$WEB_FILES_ROOT}img/thumbnail/{$page.thumb}'/></td><td>{$page.title|truncate:30}</td></tr></table>" href="{$page.url}">&nbsp;</a></li>
      {/if}
    {/if}
  {/foreach}

  {if isset($nextpage)}
    <li><a href="{$nextpage}">下一頁</a></li>
  {/if}  
</ul>

<br/>
<br/>

<link rel="stylesheet" href="{$WEB_JS_ROOT}vendor/jquery/jquery-tooltip/jquery.tooltip.css" type="text/css" media="screen, projection">
<script src="{$WEB_JS_ROOT}vendor/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="{$WEB_JS_ROOT}vendor/jquery/jquery-tooltip/lib/jquery.dimensions.js" type="text/javascript"></script>
<script src="{$WEB_JS_ROOT}vendor/jquery/jquery-tooltip/jquery.tooltip.js" type="text/javascript"></script>

<script type="text/javascript">
{literal} 
$(function() {
  $("#lx10th_netvigation li a").tooltip({ 
    track: true, 
    delay: 0, 
    showURL: false, 
    opacity: 1, 
    fixPNG: true, 
    showBody: " - ", 
    extraClass: "pretty fancy", 
    top: -15, 
    left: 5 
});
});
{/literal}
</script>