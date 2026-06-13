<?php
/**
 * RP-Official — archive.php
 * カテゴリーアーカイブ / CPTアーカイブ共用テンプレート
 */

// $base_path が header.php で定義されていない場合の安全策
if (!isset($base_path)) {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $script_dir  = dirname($script_name);
    $script_dir  = str_replace('\\', '/', $script_dir);
    $base_path   = ($script_dir === '/' || $script_dir === '.') ? '' : rtrim($script_dir, '/');
}

get_template_part('header');

global $posts, $all_categories, $req_category, $req_cpt, $current_category;

$display_posts = [];

if (!empty($req_category)) {
    // ── カテゴリーアーカイブ ──────────────────────────────
    $cat_id = $current_category['id'] ?? null;
    if ($cat_id !== null && is_array($posts)) {
        foreach ($posts as $p) {
            if (($p['status'] ?? '') !== 'public') continue;
            // category_id（文字列）・category_ids（配列）・categories（配列）いずれにも対応
            if (isset($p['category_id']) && $p['category_id'] !== '') {
                $c_ids = [$p['category_id']];
            } else {
                $c_ids = $p['categories'] ?? $p['category_ids'] ?? [];
                if (!is_array($c_ids)) $c_ids = [$c_ids];
            }
            if (in_array($cat_id, $c_ids, false)) {
                $display_posts[] = $p;
            }
        }
    }
    $archive_title = 'カテゴリー: ' . htmlspecialchars($current_category['name'] ?? $req_category, ENT_QUOTES, 'UTF-8');

} elseif (!empty($req_cpt)) {
    // ── CPTアーカイブ ─────────────────────────────────────
    // CPTインデックスは /data/posts_{cpt}_index.json に存在する
    $cpt_index_file = SITE_ROOT . '/data/posts_' . $req_cpt . '_index.json';
    if (file_exists($cpt_index_file)) {
        $cpt_data = json_decode(file_get_contents($cpt_index_file), true);
        if (is_array($cpt_data)) {
            foreach ($cpt_data as $p) {
                if (($p['status'] ?? '') !== 'public') continue;
                $display_posts[] = $p;
            }
        }
    }
    $archive_title = 'アーカイブ: ' . htmlspecialchars($req_cpt, ENT_QUOTES, 'UTF-8');

} else {
    // ── 全投稿アーカイブ（フォールバック） ────────────────
    if (is_array($posts)) {
        foreach ($posts as $p) {
            if (($p['status'] ?? '') !== 'public') continue;
            $display_posts[] = $p;
        }
    }
    $archive_title = 'アーカイブ';
}
?>

<div class="container layout-2col">
    <div class="content-area">

        <h1 class="archive-title"><?php echo $archive_title; ?></h1>

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
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="post-card">
                    <p>表示できる記事がありません。</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?php get_template_part('sidebar'); ?>
</div>

<?php get_template_part('footer'); ?>