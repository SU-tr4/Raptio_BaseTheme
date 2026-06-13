<?php
/**
 * RP-Official — index.php (ブログトップ)
 */

if (!isset($base_path)) {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $script_dir  = dirname($script_name);
    $script_dir  = str_replace('\\', '/', $script_dir);
    $base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
}

get_template_part('header');

global $posts, $all_categories, $site_config;

if (!isset($site_config)) {
    $data_dir    = dirname(__DIR__, 2) . '/data';
    $site_config = file_exists($data_dir . '/site_config.json')
        ? json_decode(file_get_contents($data_dir . '/site_config.json'), true)
        : [];
}

// 公開済み投稿を新しい順に並べる
$display_posts = [];
if (is_array($posts)) {
    foreach ($posts as $p) {
        if (($p['status'] ?? '') === 'public') {
            $display_posts[] = $p;
        }
    }
    usort($display_posts, function($a, $b) {
        return strcmp($b['date'] ?? '', $a['date'] ?? '');
    });
}
?>

<div class="container layout-2col">
    <div class="content-area">

        <h1 class="archive-title">
            <?php echo htmlspecialchars($site_config['site_name'] ?? 'ブログ', ENT_QUOTES, 'UTF-8'); ?>
        </h1>

        <div class="post-list">
            <?php if (!empty($display_posts)): ?>
                <?php foreach ($display_posts as $post):
                    $permalink = get_permalink($post);
                    if (str_starts_with($permalink, '/')) {
                        $permalink = $base_path . $permalink;
                    }
                    $excerpt = '';
                    if (!empty($post['excerpt'])) {
                        $excerpt = $post['excerpt'];
                    } elseif (!empty($post['content'])) {
                        $plain = strip_tags($post['content']);
                        $excerpt = mb_strimwidth($plain, 0, 120, '…');
                    }
                ?>
                    <article class="post-card">
                        <div class="post-meta">
                            <time datetime="<?php echo htmlspecialchars(substr($post['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(substr($post['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                            </time>
                        </div>
                        <h2>
                            <a href="<?php echo htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($post['title'] ?? '無題', ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h2>
                        <?php if ($excerpt): ?>
                            <p class="post-excerpt"><?php echo htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="post-card">
                    <p>まだ投稿がありません。</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?php get_template_part('sidebar'); ?>
</div>

<?php get_template_part('footer'); ?>