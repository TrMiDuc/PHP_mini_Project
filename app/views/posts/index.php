<?php
// Lưu ý: $user_id cần được truyền vào từ controller nếu có đăng nhập
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Tin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 600px;
        margin: 2rem auto;
    }

    .card {
        margin-bottom: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body>

    <div class="container">
        <?php if (empty($posts)): ?>
        <div class="empty-state">
            <h4 class="mb-3">🫥 Ở đây có vẻ hơi trống trải</h4>
            <p class="mb-4">Hãy khiến nó sôi động hơn nào!</p>
            <a href="/PHP_mini_Project/public/posts/create" class="btn btn-primary">Đăng bài</a>
        </div>
        <?php else: ?>
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4>Bảng Tin</h4>
            <a href="/PHP_mini_Project/public/posts/create" class="btn btn-success">+ Đăng bài</a>
        </div>

        <?php foreach ($posts as $post): ?>
        <div class="card p-3">
            <h5 class="card-title"><?= htmlspecialchars($post->getTitle()) ?></h5>

            <!-- ✅ Hiển thị tên người đăng -->
            <p class="text-muted mb-1" style="font-size: 0.9rem;">
                Đăng bởi: <strong><?= htmlspecialchars($post->getUsername()) ?></strong>
            </p>

            <p class="card-text"><?= nl2br(htmlspecialchars($post->getContent())) ?></p>

            <div class="mt-2 d-flex justify-content-end gap-2">
                <a href="/PHP_mini_Project/public/posts/show/<?= $post->getID() ?>"
                    class="btn btn-sm btn-outline-primary">Xem</a>

                <?php if (isset($user_id) && $post->getUserID() === $user_id): ?>
                <a href="/PHP_mini_Project/public/posts/edit/<?= $post->getID() ?>"
                    class="btn btn-sm btn-outline-secondary">Sửa</a>
                <a href="/PHP_mini_Project/public/posts/delete/<?= $post->getID() ?>"
                    class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?');">Xóa</a>
                <?php endif; ?>
            </div>
        </div>

        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>