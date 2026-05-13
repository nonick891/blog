{foreach $categories as $category}
    <h2>{$category['name']}</h2>
    <p>{$category['description']}</p>
    {foreach $category['posts'] as $post}
        <div id="post-{$post['id']}">
            <div>{$post['id']} - {$post['title']}</div>
            <img src="{$post['image']}" width="150" alt="{$post['title']}"/>
            <p>{$post['description']}</p>
            <p>{$post['created_at']}</p>
        </div>
    {/foreach}
    <p><a href="/category/{$category['id']}">Все статьи</a></p>
{/foreach}