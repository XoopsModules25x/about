<ul class="about_menu">
    <{foreach item=item from=$block}>
        <li><a href="<{$item.links}>"><{$item.page_menu_title}></a></li>
    <{/foreach}>
</ul>
