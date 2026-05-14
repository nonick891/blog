<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}PHP Blog{/block}</title>
    <link rel="stylesheet" href="/css/styles.css">
    {block name=head}{/block}
</head>
<body>
    <nav><a href="/">&larr; Home</a></nav>
    <main>
        {block name=content}{/block}
    </main>
    <footer>&copy; PHP Blog</footer>
</body>
</html>