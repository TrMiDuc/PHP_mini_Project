<?php
require_once realpath(__DIR__ . '/baseController.php');
require_once realpath(__DIR__ . '/../models/Post.php');

class PostController extends BaseController {

    public function index() {
        $posts = Post::all();

        $user = $this->getUser();
        $username = $user ? $user->getUsername() : 'Guest';
        $id = $user ? $user->getID() : null;

        $this->render('posts/index', [
            'posts' => $posts,
            'username' => $username,
            'user_id' => $id
        ]);
    }

    public function create() {
        $user = $this->requireLogin();

        $this->render('posts/create', [
            'username' => $user->getUsername(),
            'user_id' => $user->getID()
        ]);
    }

    public function store() {
        $user = $this->requireLogin();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            $this->render('posts/create', [
                'message' => 'Title and content cannot be empty.',
                'username' => $user->getUsername(),
                'user_id' => $user->getID()
            ]);
            return;
        }

        $post = new Post(null, $title, $content, $user->getID(), $user->getUsername());
        $result = Post::create($post);

        if ($result['success']) {
            $this->redirect('/');
        } else {
            $this->render('posts/create', [
                'message' => 'Failed to create post.',
                'user_id' => $user->getID()
            ]);
        }
    }

    public function show($id) {
        $post = Post::findByID($id);

        if (!$post) {
            $this->render('errors/404', ['message' => 'Post not found.']);
            return;
        }

        $user = $this->getUser();
        $username = $user ? $user->getUsername() : 'Guest';
        $id = $user ? $user->getID() : null;

        $this->render('posts/show', [
            'post' => $post,
            'username' => $username,
            'user_id' => $id
        ]);
    }

    public function edit($id) {
        $user = $this->requireLogin();
        $post = Post::findByID($id);

        if (!$post || $post->getUserID() !== $user->getID()) {
            $this->render('errors/403', ['message' => 'You do not have permission to edit this post.']);
            return;
        }

        $this->render('posts/edit', [
            'post' => $post,
            'username' => $user->getUsername(),
            'user_id' => $user->getID()
        ]);
    }

    public function update($id) {
        $user = $this->requireLogin();
        $post = Post::findByID($id);

        if (!$post || $post->getUserID() !== $user->getID()) {
            $this->render('errors/403', ['message' => 'You do not have permission to edit this post.']);
            return;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            $this->render('posts/edit', [
                'message' => 'Title and content cannot be empty.',
                'post' => $post,
                'username' => $user->getUsername(),
                'user_id' => $user->getID()
            ]);
            return;
        }

        $post->setTitle($title);
        $post->setContent($content);
        Post::update($post);

        $this->redirect('/posts/show/' . $id);
    }

    public function delete($id) {
        $user = $this->requireLogin();
        $post = Post::findByID($id);

        if (!$post || $post->getUserID() !== $user->getID()) {
            $this->render('errors/403', ['message' => 'You do not have permission to delete this post.']);
            return;
        }

        Post::delete($id);
        $this->redirect('/');
    }
}
