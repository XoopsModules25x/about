<{* $xoTheme->addStylesheet("modules/`$xoops_dirname`/assets/css/style.css") *}>

<div id="about_index_crumb" class="breadcrumbs marg5">
  <{foreach item=itm from=$xoBreadcrumbs name=bcloop}>
    <{if $itm.link}><a href="<{$itm.link}>" title="<{$itm.title}>"><{$itm.title}></a><{else}><{$itm.title}><{/if}>
    <{if !$smarty.foreach.bcloop.last}>&raquo;<{/if}>
  <{/foreach}>
</div>

<div id="list">
  <{foreach item=item from=$list}>
    <br style="clear:both;">
    <div class="marg3">
      <span class="floatleft"><a href="index.php?page_id=<{$item.page_id}>" target="_blank"><{$item.page_menu_title}></a></span>
      <span class="floatleft">[<{$item.page_pushtime}>]</span><br>

      <{if $item.page_image}><span class="floatleft pad3]"><img src="<{$xoops_url}>/uploads/about/<{$item.page_image}>" width="200" height="150"></span><{/if}>

      <span class="floatleft"><{$item.page_text}></span>
      <span class="floatleft small"><a href="index.php?page_id=<{$item.page_id}>" target="_blank"><{$smarty.const._MD_ABOUT_DETAIL}></a></span>
    </div>
  <{/foreach}>
</div>
