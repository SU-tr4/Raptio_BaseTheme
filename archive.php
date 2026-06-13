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

// site_config の読み込みとグローバル化（ヘッダーメニューなどの表示に必要）
global $site_config;
if (!isset($site_config)) {
    $data_dir    = dirname(__DIR__, 2) . '/data';
    $site_config = file_exists($data_dir . '/site_config.json')
        ? json_decode(file_get_contents($data_dir . '/site_config.json'), true)
        : [];
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
            }
            if (in_array((string)$cat_id, array_map('strval', $c_ids), true)) {
                $display_posts[] = $p;
            }
        }
    }
    $archive_title = htmlspecialchars($current_category['name'] ?? 'カテゴリー', ENT_QUOTES, 'UTF-8');

} else if (!empty($req_cpt)) {
    // ── カスタム投稿タイプ(CPT)アーカイブ ──────────────────
    if (is_array($posts)) {
        foreach ($posts as $p) {
            if (($p['status'] ?? '') !== 'public') continue;
            if (($p['post_type'] ?? 'post') === $req_cpt) {
                $display_posts[] = $p;
            }
        }
    }
    // CPTのラベル名を取得
    $cpt_file = dirname(__DIR__, 2) . '/data/cpt_config.json';
    $cpt_data = file_exists($cpt_file) ? json_decode(file_get_contents($cpt_file), true) : [];
    $cpt_label = $cpt_data[$req_cpt]['label'] ?? $req_cpt;
    $archive_title = htmlspecialchars($cpt_label, ENT_QUOTES, 'UTF-8');
}

// 日付順にソート（新しい順）
if (!empty($display_posts)) {
    usort($display_posts, function($a, $b) {
        return strcmp($b['date'] ?? '', $a['date'] ?? '');
    });
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