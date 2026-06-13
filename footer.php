</main>

<footer class="site-footer">
    <div class="container">
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