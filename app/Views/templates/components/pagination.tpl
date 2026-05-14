{if $totalPages > 1}
    <div class="pagination">
        {if $page > 1}
            <a href="?sort={$sort}&order={$order}&page={$page-1}&per_page={$perPage}">&laquo; Prev</a>
        {else}
            <span class="disabled">&laquo; Prev</span>
        {/if}

        {section name=p loop=$totalPages}
            {if $smarty.section.p.index+1 == $page}
                <span class="current">{$smarty.section.p.index+1}</span>
            {else}
                <a href="?sort={$sort}&order={$order}&page={$smarty.section.p.index+1}&per_page={$perPage}">{$smarty.section.p.index+1}</a>
            {/if}
        {/section}

        {if $page < $totalPages}
            <a href="?sort={$sort}&order={$order}&page={$page+1}&per_page={$perPage}">Next &raquo;</a>
        {else}
            <span class="disabled">Next &raquo;</span>
        {/if}
    </div>
{/if}