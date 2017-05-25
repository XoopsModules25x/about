
<div class="breadcrumbs">
    <{foreach item=itm from=$xoBreadcrumbs name=bcloop}>
        <{if $itm.link}><a href="<{$itm.link}>" title="<{$itm.title}>"><{$itm.title}></a><{else}><{$itm.title}><{/if}>
        <{if !$smarty.foreach.bcloop.last}>&raquo;<{/if}>
    <{/foreach}>
</div>
<div>
<ul class="treeview" id="tree">
    <{foreach item=item from=$pagemenu name=menu}>
      <li>
        <{if ($item.page_id != $page.page_id)}><a href="index.php?page_id=<{$item.page_id}>"><{$item.page_menu_title}></a><{else}><span><{$item.page_menu_title}></span><{/if}>
        <{* if !$item.page_text}><a href="index.php?page_id=<{$item.page_id}>"><{$item.page_menu_title}></a><{else}><span><{$item.page_menu_title}></span><{/if *}>
        <{if $item.child}>
          <{assign var="children" value=$item.child}>
          <{include file="db:about_menu.tpl"}>
        <{/if}>
      </li>
    <{/foreach}>
</ul>
</div>
<div>
    <h4><{$page.page_title}></h4>
    <div><{$page.page_text}></div>
</div>
<br style="clear:both;">
<script type="text/javascript">
$(function() {
    $("#tree").treeview({
        animated: "medium",
        persist: "location",
        collapsed: false,
        unique: true
    });
})
</script>

