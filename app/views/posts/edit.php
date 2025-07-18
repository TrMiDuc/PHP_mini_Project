<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Bài Viết</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f7f9fc;">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4 text-center">✏️ Chỉnh Sửa Bài Viết</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="/PHP_mini_Project/public/posts/edit/<?= htmlspecialchars($post->getID()) ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    value="<?= htmlspecialchars($post->getTitle()) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea
                    class="form-control"
                    id="content"
                    name="content"
                    rows="6"
                    required
                ><?= htmlspecialchars($post->getContent()) ?></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">💾 Lưu Thay Đổi</button>
            <a href="/PHP_mini_Project/public/" class="btn btn-outline-secondary w-100 mt-2">⬅️ Quay lại</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
