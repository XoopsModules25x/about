<ul>
<{foreach item=child key=key from=$children name=childmenu}>
<{if $child.child}>
    <li>
    <{if !$child.page_text}><a href="index.php?page_id=<{$child.page_id}>"><{$child.page_menu_title}></a><{else}><span><{$child.page_menu_title}></span><{/if}>
        <{assign var="children" value=$child.child}>
        <{include file="db:about_menu.tpl"}>
    </li>
<{else}>
    <li><{if !$child.page_text}><a href="index.php?page_id=<{$child.page_id}>"><{$child.page_menu_title}></a><{else}><span><{$child.page_menu_title}></span><{/if}></li>
<{/if}>

<{/foreach}>
</ul>


