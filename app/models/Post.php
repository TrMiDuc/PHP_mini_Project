<?php
require_once realpath(__DIR__ . '/../../core/Model.php');

class Post extends Model {
    private $id;
    private $title;
    private $content;
    private $user_id;
    private $username;
    private $created_at;

    public function __construct($id, $title, $content, $user_id, $username, $created_at = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->created_at = $created_at;
    }

    public function getID() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getUserID() { return $this->user_id; }
    public function getUsername() { return $this->username; } 
    public function getCreatedAt() { return $this->created_at; }

    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }

    public static function all() {
        $query = "SELECT posts.id, posts.title, posts.content, posts.user_id, users.username 
                  FROM posts 
                  JOIN users ON posts.user_id = users.id 
                  ORDER BY posts.created_at DESC";

        $result = self::doQuery($query, '', [], 'Posts retrieved successfully.', 'No posts found.');

        if ($result['success'] && !empty($result['data'])) {
            return array_map(function($post) {
                return new self(
                    $post['id'],
                    $post['title'],
                    $post['content'],
                    $post['user_id'],
                    $post['username'],
                );
            }, $result['data']);
        }

        return [];
    }

    public static function create(Post $post) {
        $query = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        $params = [$post->getTitle(), $post->getContent(), $post->getUserID()];

        $result = self::doQuery($query, 'ssi', $params, 'Post created successfully.', 'Failed to create post.');

        if ($result['success']) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => $result['message']];
    }

    public static function findByID($id) {
        $query = "SELECT posts.id, posts.title, posts.content, posts.user_id, posts.created_at, users.username 
                  FROM posts 
                  JOIN users ON posts.user_id = users.id 
                  WHERE posts.id = ?";

        $result = self::doQuery($query, 'i', [$id], 'Post found.', 'Post not found.');

        if ($result['success'] && !empty($result['data'])) {
            $post = $result['data'][0];
            return new self(
                $post['id'],
                $post['title'],
                $post['content'],
                $post['user_id'],
                $post['username'],
                $post['created_at']
            );
        }

        return null;
    }

    public static function update(Post $post) {
        $query = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $params = [$post->getTitle(), $post->getContent(), $post->getID()];

        $result = self::doQuery($query, 'ssi', $params, 'Post updated successfully.', 'Failed to update post.');

        return $result['success'];
    }

    public static function delete($id) {
        $query = "DELETE FROM posts WHERE id = ?";
        $result = self::doQuery($query, 'i', [$id], 'Post deleted successfully.', 'Failed to delete post.');

        return $result['success'];
    }
}
