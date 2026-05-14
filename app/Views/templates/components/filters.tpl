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