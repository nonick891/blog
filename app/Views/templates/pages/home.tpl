{extends file="layouts/default.tpl"}

{block name=title}PHP Blog - Home{/block}

{block name=content}
{foreach $categories as $category}
    <h2>{$category['name']}</h2>
    <p>{$category['description']}</p>
    <div class="posts">
    {foreach $category['posts'] as $post}
        {capture assign=link}/category/{$category.id}/post/{$post.id}{/capture}
        {include file="components/post-card.tpl" post=$post link=$link}
    {/foreach}
    </div>
    <p><a href="/category/{$category['id']}">All articles</a></p>
{/foreach}
{/block}