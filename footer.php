</main>

<footer class="site-footer">
    <div class="container">
        <?php
        // フッターにもロゴを表示
        if (!empty($site_config['logo_image_path'])): 
            $logo_url = $base_path . '/' . ltrim($site_config['logo_image_path'], '/');
        ?>
            <div class="footer-logo" style="margin-bottom: 20px; text-align: center;">
                <a href="<?php echo $base_path; ?>/">
                    <img src="<?php echo htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($site_config['site_name'] ?? 'Logo', ENT_QUOTES, 'UTF-8'); ?>" style="max-height: 40px;" onerror="this.style.display='none';">
                </a>
            </div>
        <?php endif; ?>

        <?php
        if (isset($site_config['menu_locations']['footer'], $site_config['menus'][$site_config['menu_locations']['footer']])) {
            $footer_menu = $site_config['menus'][$site_config['menu_locations']['footer']]['items'] ?? [];
            if (!empty($footer_menu)) {
                echo '<nav class="footer-nav"><ul>';
                foreach ($footer_menu as $item) {
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
        <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site_config['footer_text'] ?? $site_config['site_name'] ?? 'RP-Official', ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</footer>

</body>
</html>