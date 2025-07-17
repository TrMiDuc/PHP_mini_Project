<?php

class Controller {
    protected function render($view, $data = []) {
        extract($data);

        $viewFile = realpath(__DIR__ . '/../app/views/' . $view . '.php');
        if (!$viewFile || !file_exists($viewFile)) {
            die("View not found: $view");
        }

        require realpath(__DIR__ . '/../app/views/layout.php');
    }

    protected function redirect($url) {
        $location = BASE_PATH . $url;
        header("Location: $location");
        exit();
    }
}

