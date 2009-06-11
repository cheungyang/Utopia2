<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
  {include file="lx10th_common.tpl"}
</head>
<body>
  <div class="container">
    
    <div class="span-24 last">
      {include file="lx10th_head.tpl"} 
    </div> 

    <div class="span-24 last">
      {include file="lx10th_netvigation.tpl"} 
    </div>

    <h1>{$page.4}</h1>
    
    <div class="span-24 last">
      <img src="{$WEB_FILES_ROOT}img/{$page.3}" class="resize"/>
    </div>
    
    {if $page.5 neq ""}
    <div class="span-24 last photocaption">
      <p class="para">{$page.5}</p>
    </div>
    {/if}
    
    <div class="span-24 last">
      {include file="lx10th_tail.tpl"} 
    </div>
          
  </div>
</body>
</html>