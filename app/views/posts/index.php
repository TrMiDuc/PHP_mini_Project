<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Index</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <h1>Posts</h1>
    <a href="/posts/create">Create New Post</a>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post->title); ?></td>
                    <td>
                        <a href="/posts/show/<?php echo $post->id; ?>">View</a>
                        <a href="/posts/edit/<?php echo $post->id; ?>">Edit</a>
                        <a href="/posts/delete/<?php echo $post->id; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>