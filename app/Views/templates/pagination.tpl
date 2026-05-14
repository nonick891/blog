{if $totalPages > 1}
    <div class="pagination">
        {if $page > 1}
            <a href="?page={$page-1}&per_page={$perPage}">&laquo; Prev</a>
        {else}
            <span class="disabled">&laquo; Prev</span>
        {/if}

        {section name=p loop=$totalPages}
            {if $smarty.section.p.index+1 == $page}
                <span class="current">{$smarty.section.p.index+1}</span>
            {else}
                <a href="?page={$smarty.section.p.index+1}&per_page={$perPage}">{$smarty.section.p.index+1}</a>
            {/if}
        {/section}

        {if $page < $totalPages}
            <a href="?page={$page+1}&per_page={$perPage}">Next &raquo;</a>
        {else}
            <span class="disabled">Next &raquo;</span>
        {/if}
    </div>
{/if}
<style>
    .pagination { display: flex; gap: 4px; align-items: center; margin: 20px 0; }
    .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #ddd; text-decoration: none; color: #333; }
    .pagination a:hover { background: #f5f5f5; }
    .pagination .current { background: #007bff; color: #fff; border-color: #007bff; }
    .pagination .disabled { color: #999; }
</style>