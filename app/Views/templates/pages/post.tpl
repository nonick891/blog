{extends file="layouts/default.tpl"}

{block name=title}PHP Blog - {$post['title']}{/block}

{block name=content}
    <article>
        <h2>{$post['title']}</h2>
        {if $post['image']}
            <img src="{$post['image']}" alt="{$post['title']}" style="max-width: 100%; height: auto;">
        {/if}
        <p>{$post['description']}</p>
        <div>{$post['body']}</div>
        <hr>
        <p>Views: {$post['views']} &middot; {$post['created_at']}</p>
        <a href="javascript:history.back()">&laquo; Back</a>
    </article>
    <br>
    <section>
        {include file="components/similar-posts.tpl"}
    </section>
{/block}