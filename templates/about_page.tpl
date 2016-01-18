<{$xoTheme->addStylesheet("modules/`$xoops_dirname`/assets/css/style.css")}>
<{$xoTheme->addStylesheet("modules/`$xoops_dirname`/assets/jquery-treeview/jquery.treeview.css")}>
<{$xoTheme->addScript("modules/`$xoops_dirname`/assets/jquery.js")}>
<{$xoTheme->addScript("modules/`$xoops_dirname`/assets/jquery-treeview/jquery.treeview.js")}>
<div class="breadcrumbs">
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

<ul class="treeview" id="tree">
    <{foreach item=item from=$pagemenu name=menu}>
    
    <{if $item.child}>
        <li>
        <{if !$item.page_text}><a href="index.php?page_id=<{$item.page_id}>"><{$item.page_menu_title}></a><{else}><span><{$item.page_menu_title}></span><{/if}>
        <{assign var="children" value=$item.child}>        
        <{include file="db:about_menu.tpl"}>
        </li>
    <{else}>
        <li><{if !$item.page_text}><a href="index.php?page_id=<{$item.page_id}>"><{$item.page_menu_title}></a><{else}><span><{$item.page_menu_title}></span><{/if}></li>
    <{/if}>
    <{/foreach}>
</ul>

<div>
    <h4><{$page.page_title}></h4>
    <div><{$page.page_text}></div>
</div>
<br style="clear:both;" />
<script type="text/javascript">
$(function() {
	$("#tree").treeview({
		animated: "medium",
		persist: "location",
		collapsed: true,
		unique: true
	});
})
</script>

