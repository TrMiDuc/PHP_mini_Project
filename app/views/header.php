<?php
$currentPath = $_SERVER['REQUEST_URI'];

if (strpos($currentPath, '?') !== false) {
    $currentPath = strstr($currentPath, '?', true);
}

$hideWelcomePaths = [
    '/PHP_mini_Project/public/auth/login',
    '/PHP_mini_Project/public/auth/signup'
];
?>

<body>
    <div
        style="background-color: #333; color: white; padding: 10px 20px; font-family: Arial, sans-serif; position: relative; z-index: 9999;">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <div style="font-size: 20px; display: flex">
                <a href="/PHP_mini_Project/public/" style="color: cyan; text-decoration: none;">🌐 <strong>PHP_mini</strong></a>
            </div>

            <?php if (!in_array($currentPath, $hideWelcomePaths)): ?>
            <div class="dropdown" style="position: relative; z-index: 99999;">
                <div id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="position: relative; padding-right: 1rem; min-width: 11vw; max-width: 15vw; text-align: center; background: none">
                    <?= (!empty($username) && $username !== 'Guest') ? '👤 ' . htmlspecialchars($username) : '👋 Guest' ?>
                </div>

                <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="userDropdown"
                    style="min-width: 100%; z-index: 999999; text-align: center">
                    <li class="dropdown-header " style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                        Welcome,
                        <strong style="color: blue; font-size; 20"><?= (!empty($username) && $username !== 'Guest') ? htmlspecialchars($username) : 'Guest' ?></strong>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <?php if (!empty($username) && $username !== 'Guest'): ?>
                    <li
                        style="text-align: left !important; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                        <a class="dropdown-item " href="#">Change Information</a></li>
                    <li
                        style="text-align: left !important; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                        <a class="dropdown-item " href="/PHP_mini_Project/public/auth/logout">Logout</a></li>
                    <?php else: ?>
                    <li
                        style="text-align: left !important; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                        <a class="dropdown-item " href="/PHP_mini_Project/public/auth/login">Login</a></li>
                    <li
                        style="text-align: left !important; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                        <a class="dropdown-item " href="/PHP_mini_Project/public/auth/signup">Register</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <?php endif; ?>
        </div>
    </div>
</body>