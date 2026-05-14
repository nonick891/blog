{extends file="layouts/default.tpl"}

{block name=title}PHP Blog - {$category['name']|default:'Category'}{/block}

{block name=content}
    {if $category}
        <h2>{$category['name']}</h2>
        <p>{$category['description']}</p>
        <br>
        {include file="components/filters.tpl"}
        <br>
        {include file="components/pagination.tpl"}
        <div class="posts">
        {foreach $posts as $post}
            {capture assign=link}/category/{$category.id}/post/{$post.id}{/capture}
            {include file="components/post-card.tpl" post=$post link=$link}
        {/foreach}
        </div>
        {include file="components/pagination.tpl"}
    {else}
        <h2>Category not found</h2>
    {/if}
{/block}