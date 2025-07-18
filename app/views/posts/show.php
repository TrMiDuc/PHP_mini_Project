<div class="container mt-5" style="max-width: 700px;">
    <div class="card p-4 shadow-sm">
        <h2 class="card-title mb-3"><?= htmlspecialchars($post->getTitle()) ?></h2>
        
        <p class="text-muted mb-2" style="font-size: 14px;">
            🕒 Đăng lúc: <?= date("H:i d/m/Y", strtotime($post->getCreatedAt())) ?>
        </p>

        <p class="card-text" style="white-space: pre-wrap;">
            <?= nl2br(htmlspecialchars($post->getContent())) ?>
        </p>

        <div class="mt-4 d-flex justify-content-between">
            <?php if (isset($user_id) && $user_id === $post->getUserID()): ?>
                <div class="btn-group">
                    <a href="/PHP_mini_Project/public/posts/edit/<?= $post->getID() ?>" class="btn btn-outline-secondary">✏️ Chỉnh sửa</a>
                    <a href="/PHP_mini_Project/public/posts/delete/<?= $post->getID() ?>" class="btn btn-outline-danger" onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?');">🗑️ Xoá</a>
                </div>
            <?php endif; ?>

            <a href="/PHP_mini_Project/public/" class="btn btn-outline-primary">⬅️ Quay lại danh sách</a>
        </div>
    </div>
</div>
