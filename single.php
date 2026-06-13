<?php get_template_part('header'); ?>

<div class="container layout-2col">
    <div class="content-area">

        <article class="single-post">
            <h1 class="post-title"><?php echo htmlspecialchars($post_meta['title'] ?? '無題', ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="post-meta">
                <time datetime="<?php echo htmlspecialchars(substr($post_meta['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars(substr($post_meta['date'] ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                </time>
            </div>
            <div class="post-content">
                <?php echo $content ?? '<p>本文がありません。</p>'; ?>
            </div>
        </article>

    </div>

    <?php get_template_part('sidebar'); ?>
</div>

<?php get_template_part('footer'); ?>