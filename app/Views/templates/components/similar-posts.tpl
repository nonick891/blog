<div class="similar-posts">
{foreach $similarPosts as $post}
    {capture assign=link}/category/{$categoryId}/post/{$post.id}{/capture}
    {include file="components/post-card.tpl" post=$post link=$link}
{/foreach}
</div>