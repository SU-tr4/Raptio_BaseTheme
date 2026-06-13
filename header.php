<?php
/**
 * RP-Official — header.php
 * $base_path: サブディレクトリ設置対応。末尾スラッシュなし、ルート設置時は空文字。
 */
$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$script_dir  = dirname($script_name);
$script_dir  = str_replace('\\', '/', $script_dir);
$base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_config['site_name'] ?? 'RP-Official', ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($site_config['site_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo $base_path; ?>/themes/RP-Official/style.css">
    <style>
        .site-nav ul { list-style: none; padding: 0; margin: 15px 0 0 0; display: flex; gap: 20px; flex-wrap: wrap; }
        .site-nav a { text-decoration: none; color: #333; font-weight: bold; }
        .site-nav a:hover { color: #0056b3; }
        .footer-nav ul { list-style: none; padding: 0; margin: 0 0 15px 0; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        .footer-nav a { text-decoration: none; color: #333; }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container">
        <h1 class="site-title">
            <a href="<?php echo $base_path; ?>/"><?php echo htmlspecialchars($site_config['site_name'] ?? 'RP-Official', ENT_QUOTES, 'UTF-8'); ?></a>
        </h1>
        <?php
        if (isset($site_config['menu_locations']['header'], $site_config['menus'][$site_config['menu_locations']['header']])) {
            $header_menu = $site_config['menus'][$site_config['menu_locations']['header']]['items'] ?? [];
            if (!empty($header_menu)) {
                echo '<nav class="site-nav"><ul>';
                foreach ($header_menu as $item) {
                    $label = htmlspecialchars($item['label'] ?? '', ENT_QUOTES, 'UTF-8');
                    $url   = htmlspecialchars($item['url']   ?? '', ENT_QUOTES, 'UTF-8');
                    if ($label) {
                        echo "<li><a href=\"{$url}\">{$label}</a></li>";
                    }
                }
                echo '</ul></nav>';
            }
        }
        ?>
    </div>
</header>
<main>