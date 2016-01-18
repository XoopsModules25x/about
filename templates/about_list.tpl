<{$xoTheme->addStylesheet("modules/`$xoops_dirname`/assets/css/style.css")}>
<div id="about_index_crumb" class="breadcrumbs">
    <{foreach item=itm from=$xoBreadcrumbs name=bcloop}>
       
        <{if $itm.link}>
            <a href="<{$itm.link}>" title="<{$itm.title}>"><{$itm.title}></a>
        <{else}>
            <{$itm.title}>
        <{/if}>
        
        
        <{if !$smarty.foreach.bcloop.last}>
            &raquo;
        <{/if}>
    <{/foreach}>
</div>

<div id="list">
		<{foreachq item=item from=$list}>
        <div class="clear">
            <span class="fl"><a href="index.php?page_id=<{$item.page_id}>" target="_blank"><{$item.page_menu_title}></a></span>
            <span class="fl"><{$item.page_pushtime}></span><br />
            
            <{if $item.page_image}><span class="fl"><img src="<{$xoops_url}>/uploads/about/<{$item.page_image}>" width="200" height="150"></span><{/if}>
            
            <span class="fr"><{$item.page_text}></span>
            <span class="fl"><a href="index.php?page_id=<{$item.page_id}>" target="_blank"><{$smarty.const._MA_ABOUT_DETAIL}></a></span>
        </div>
		<{/foreach}>
</div>

<br style="clear:both;" />
