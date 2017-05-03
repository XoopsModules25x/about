
<ul>
<{foreach item=child key=key from=$children name=childmenu}>
  <li id="child_node_<{$child.page_id}>">
  <{if $child.page_id != $page.page_id}><a href="index.php?page_id=<{$child.page_id}>"><{$child.page_menu_title}></a><{else}><span><{$child.page_menu_title}></span><{/if}>
  <{* if !$child.page_text}><a href="index.php?page_id=<{$child.page_id}>"><{$child.page_menu_title}></a><{else}><span><{$child.page_menu_title}></span><{/if *}>
<{if $child.child}>
        <{assign var="children" value=$child.child}>
        <{include file="db:about_menu.tpl"}>
<{/if}>
  </li>
<{/foreach}>
</ul>
