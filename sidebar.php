<?php
/**
 * RP-Official — sidebar.php
 * $base_path は header.php で定義済み。未定義の場合のみ再計算。
 */
if (!isset($base_path)) {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $script_dir  = dirname($script_name);
    $script_dir  = str_replace('\\', '/', $script_dir);
    $base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
}
?>
<aside class="site-sidebar">

    <div class="widget">
        <h3>カテゴリー</h3>
        <ul>
            <?php if (!empty($all_categories) && is_array($all_categories)): ?>
                <?php foreach ($all_categories as $cat):
                    $cat_slug = $cat['slug'] ?? '';
                    $cat_name = $cat['name'] ?? '';
                    if (!$cat_slug) continue;
                ?>
                    <li>
                        <a href="<?php echo $base_path; ?>/category/<?php echo htmlspecialchars($cat_slug, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($cat_name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>カテゴリーはありません。</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="widget">
        <h3>最新の投稿</h3>
        <ul>
            <?php
            global $posts;
            $recent = is_array($posts) ? array_slice($posts, 0, 5) : [];
            if (!empty($recent)):
                foreach ($recent as $recent_post):
                    $permalink = get_permalink($recent_post);
                    // get_permalink が '/' 始まりの絶対パスを返すのでサブディレクトリ分を前置
                    if (str_starts_with($permalink, '/')) {
                        $permalink = $base_path . $permalink;
                    }
            ?>
                <li>
                    <a href="<?php echo htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($recent_post['title'] ?? '無題', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php
                endforeach;
            else:
            ?>
                <li>投稿はありません。</li>
            <?php endif; ?>
        </ul>
    </div>

</aside>