<?php
/**
 * RP-Official — header.php
 */
$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$script_dir  = dirname($script_name);
$script_dir  = str_replace('\\', '/', $script_dir);
$base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
$root_dir    = $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_config['site_name'] ?? 'RP-Official', ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($site_config['site_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo $base_path; ?>/themes/RP-Official/style.css">
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        .site-nav ul { list-style: none; padding: 0; margin: 15px 0 0 0; display: flex; gap: 20px; flex-wrap: wrap; }
        .site-nav a { text-decoration: none; color: #333; font-weight: bold; }
        .site-nav a:hover { color: #0056b3; }
        .site-title img { max-height: 50px; display: block; }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container">
        <h1 class="site-title">
            <a href="<?php echo $base_path; ?>/">
                <?php
                $logo_path = $site_config['logo_image_path'] ?? '';
                $full_file_path = $root_dir . $base_path . '/' . ltrim($logo_path, '/');
                
                // 画像が存在する場合のみ表示
                if (!empty($logo_path) && file_exists($full_file_path)) {
                    $logo_url = $base_path . '/' . ltrim($logo_path, '/');
                    echo '<img src="' . htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($site_config['site_name'] ?? 'Logo', ENT_QUOTES, 'UTF-8') . '">';
                } else {
                    echo htmlspecialchars($site_config['site_name'] ?? 'RP-Official', ENT_QUOTES, 'UTF-8');
                }
                ?>
            </a>
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
<main class="site-main">
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>