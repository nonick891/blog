{if $category}
    <h2>{$category['name']}</h2>
    <p>{$category['description']}</p>
    <br>
    {include file="pagination.tpl"}
    {foreach $posts as $post}
        <div id="post-{$post['id']}">
            <h4>{$post['title']}</h4>
            <img src="{$post['image']}" width="150" alt="{$post['title']}"/>
            <p>{$post['description']} <a href="/category/{$category['id']}/post/{$post['id']}">Read more...</a></p>
            <p>{$post['created_at']}</p>
        </div>
        <br>
    {/foreach}
    {include file="pagination.tpl"}
{else}
    <h2>Category not found</h2>
{/if}