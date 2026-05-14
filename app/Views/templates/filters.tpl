<div class="filter">
    <label for="sort">Sort: </label>
    <select name="sort" id="sort" onchange="window.location.href='?sort='+this.value+'&order={$order}&per_page={$perPage}&page={$page}'">
        <option value="created_at"{if $sort == 'created_at'} selected{/if}>Date</option>
        <option value="views"{if $sort == 'views'} selected{/if}>Views</option>
    </select>
    <a href="?sort={$sort}&order=asc&per_page={$perPage}&page={$page}" class="order-arrow{if $order == 'asc'} active{/if}">&uarr;</a>
    <a href="?sort={$sort}&order=desc&per_page={$perPage}&page={$page}" class="order-arrow{if $order == 'desc'} active{/if}">&darr;</a>
    <a href="?" class="clear-filter">Clear</a>
</div>
<style>
    .filter { display: flex; align-items: center; gap: 6px; }
    .order-arrow { text-decoration: none; padding: 2px 6px; border: 1px solid #ccc; border-radius: 3px; color: #666; font-size: 14px; line-height: 1; }
    .order-arrow.active { background: #007bff; color: #fff; border-color: #007bff; }
    .order-arrow:not(.active):hover { background: #f0f0f0; }
    .clear-filter { text-decoration: none; color: #999; font-size: 13px; margin-left: 4px; }
    .clear-filter:hover { color: #c00; }
</style>