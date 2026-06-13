<?php
/**
 * RP-Official — index.php (テーマ トップページ)
 */

if (!isset($base_path)) {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $script_dir  = dirname($script_name);
    $script_dir  = str_replace('\\', '/', $script_dir);
    $base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
}

get_template_part('header');

global $posts, $all_categories;
$display_posts = [];
if (is_array($posts)) {
    foreach ($posts as $p) {
        if (($p['status'] ?? '') !== 'public') continue;
        $display_posts[] = $p;
    }
}
?>

<div class="container layout-1col">
    <div class="content-area">

        <div class="post-list">
            <?php if (!empty($display_posts)): ?>
                <?php foreach ($display_posts as $post):
                    $permalink = get_permalink($post);
                    if (str_starts_with($permalink, '/')) {
                        $permalink = $base_path . $permalink;
                    }
                ?>
                    <article class="post-card">
                        <h2>
                            <a href="<?php echo htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($post['title'] ?? '無題', ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h2>
                        <div class="post-meta">
                            <time datetime="<?php echo htmlspecialchars(substr($post['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(substr($post['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                            </time>
                        </div>
                        <?php if (!empty($post['excerpt'])): ?>
                            <p class="post-excerpt"><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="post-card">
                    <p>表示できる記事がありません。</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php get_template_part('footer'); ?>