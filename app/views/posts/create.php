<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center">✍️ Tạo Bài Viết Mới</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form action="/PHP_mini_Project/public/posts/create" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Đăng Bài</button>
    </form>
</div>
