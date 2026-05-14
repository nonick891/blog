<div class="post" id="post-{$post.id}">
    {if $post.image}
        <img src="{$post.image}" alt="{$post.title}"/>
    {/if}
    <div class="post-body">
        <h4>{if $link}<a href="{$link}">{/if}{$post.title}{if $link}</a>{/if}</h4>
        <p class="meta">{$post.created_at}{if $post.views} &middot; {$post.views} views{/if}</p>
        <p>{$post.description}</p>
    </div>
</div>