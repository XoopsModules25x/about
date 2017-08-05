<style>
    <!--
    .options a {
        font-weight: normal;
    }

    -->
</style>
<img src="../assets/images/page_add.png">
<a href="admin.page.php?op=new&amp;type=1"><{$smarty.const._AM_ABOUT_PAGE_INSERT}></a>
<img src="../assets/images/link_add.png">
<a href="admin.page.php?op=new&amp;type=2"><{$smarty.const._AM_ABOUT_INSERT_LINK}></a>

<br> <br>

<form id="form" name="form" method="post" action="admin.page.php">
    <{securityToken}><{*//mb*}>
    <table id="about-pageList" class="outer">
        <th width="5%" class="center"><{$smarty.const._AM_ABOUT_PAGE_MENU_ORDER}></th>
        <th width="4%" class="center"><{$smarty.const._AM_ABOUT_PAGE_CUS_INDEX}></th>
        <th class="center"><{$smarty.const._AM_ABOUT_PAGE_TITLE}></th>
        <th width="10%" class="center"><{$smarty.const._AM_ABOUT_PAGE_TEMPLATE}></th>
        <th width="4%" class="center"><{$smarty.const._AM_ABOUT_PAGE_TYPE}></th>
        <th width="4%" class="center"><{$smarty.const._AM_ABOUT_PAGE_STATUS_LIST}></th>
        <th width="4%" class="center"><{$smarty.const._AM_ABOUT_PAGE_MENU}></th>
        <th width="15%" class="center"><{$smarty.const._AM_ABOUT_TIME}></th>
        <th width="10%" class="center"><{$smarty.const._AM_ABOUT_PAGE_AUTHOR}></th>

        <{foreach item=page from=$pages}>
            <tr class="<{cycle values='odd, even'}> center top">
                <td><input name="page_order[<{$page.page_id}>]" type="text" id="<{$page.page_id}>" value="<{$page.page_order}>" size="1" maxlength="4"></td>
                <td><input name="page_index" type="radio" value="<{$page.page_id}>" id="<{$page.page_id}>" <{if $page.page_index}>checked="checked"<{/if}>></td>
                <td align="left">
                    <div><a href="admin.page.php?id=<{$page.page_id}>"><{$page.page_menu_title}></a></div>
                    <div class="options" style="padding:5px 0 0 0;">
                        <a href="admin.page.php?id=<{$page.page_id}>"><{$smarty.const._EDIT}></a> |
                        <a href="admin.page.php?op=delete&amp;id=<{$page.page_id}>" style="color:#f00;"><{$smarty.const._DELETE}></a> |
                        <a href="<{$xoops_url}>/modules/about/index.php?page_id=<{$page.page_id}>"><{$smarty.const._PREVIEW}></a>
                    </div>
                </td>
                <td><{$page.page_tpl}></td>
                <td class="center">
                    <{if $page.page_type eq 1}><img src="../assets/images/page.png"><{else}><img src="../assets/images/page_link.png"><{/if}>
                </td>
                <td class="center">
                    <{if $page.page_status eq 1}><img src="../assets/images/accept.png"><{else}><img src="../assets/images/delete.png"><{/if}>
                </td>
                <td class="center">
                    <{if $page.page_menu_status}><img src="../assets/images/tick.png"><{else}><img src="../assets/images/disabled.png"><{/if}>
                </td>
                <td class="center"><{$page.page_pushtime}></td>
                <td><{$page.page_author}></td>

            </tr>
        <{/foreach}>
        <tr>
            <td colspan="10">
                <input type="submit" name="button" id="button" value="<{$smarty.const._SUBMIT}>">
            </td>
        </tr>
    </table>
</form>

<script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js" type="text/javascript"></script>
<{* <script src="<{$xoops_url}>/modules/about/assets/js/jquery.js" type="text/javascript"></script> *}>
<script type="text/javascript">
    $(document).ready(function () {
        $(".options").css("visibility", "hidden");
        $("#about-pageList tr").hover(function () {
            $(this).find(".options").css("visibility", "visible");
        }, function () {
            $(this).find(".options").css("visibility", "hidden");
        });
    });
</script>

