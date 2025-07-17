<form action="/posts/update" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($post->id); ?>">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post->title); ?>" required>
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($post->content); ?></textarea>
    </div>
    <div>
        <button type="submit">Update Post</button>
    </div>
</form>