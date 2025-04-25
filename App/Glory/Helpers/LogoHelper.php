<?php
# App/Glory/Helpers/LogoHelper.php  
namespace App\Glory\Helpers;

class LogoHelper 
{
    /**
     * Fetches logos defined via the WordPress admin.
     * Placeholder for future implementation.
     *
     * @return array An array of logo data, e.g., [['url' => '...', 'alt' => '...'], ...]
     * @TODO Implement logic to retrieve logos from WP options, Customizer, CPTs, ACF Repeater, etc.
     */
    private static function fetchAdminLogos(): array
    {
        // Example: Fetch from an option that stores an array of logos
        // $logos = get_option('glory_client_logos', []);
        // return is_array($logos) ? $logos : [];

        // For now, return empty as it's not implemented
        return [];
    }

    /**
     * Fetches default logos (SVGs) from a specified theme folder.
     *
     * @param string $folderRelPath Relative path from the theme root (e.g., 'assets/svg/client-logos').
     * @return array An array of logo data [['url' => '...', 'alt' => '...'], ...].
     */
    private static function fetchDefaultLogos(string $folderRelPath): array
    {
        $defaultLogos = [];
        $themeDir = get_template_directory(); // Use parent theme directory
        $fullFolderPath = $themeDir . '/' . trim($folderRelPath, '/');
        $folderUrl = get_template_directory_uri() . '/' . trim($folderRelPath, '/');

        if (!is_dir($fullFolderPath)) {
            // Optionally log an error if the folder is expected but not found
            // error_log("LogoHelper: Default logo folder not found at {$fullFolderPath}"); // <--- Opcional: Actualizar mensaje si se usa
            return []; // Return empty array if folder doesn't exist
        }

        // Scan specifically for SVG files as per original logic
        $svgFiles = glob($fullFolderPath . '/*.svg');

        if ($svgFiles === false) {
             // error_log("LogoHelper: Failed to scan folder {$fullFolderPath}"); // <--- Opcional: Actualizar mensaje si se usa
             return []; // Error scanning directory
        }

        foreach ($svgFiles as $svgFilePath) {
            $fileName = basename($svgFilePath);
            $logoUrl  = $folderUrl . '/' . $fileName;
            // Generate a somewhat meaningful alt text from filename
            $altText  = 'Logo: ' . ucwords(str_replace(['-', '_'], ' ', pathinfo($fileName, PATHINFO_FILENAME)));

            $defaultLogos[] = [
                'url' => $logoUrl,
                'alt' => $altText,
                'type' => 'default-logo' // Add type for potential styling hooks
            ];
        }

        return $defaultLogos;
    }

    /**
     * Generates the HTML markup for the client logos.
     * Combines logos from admin (if enabled) and default folder.
     *
     * @param string $defaultLogoFolderRelPath Relative path to the default logos folder.
     * @param bool $includeAdminLogos Whether to include logos defined in WP Admin.
     * @return string HTML output for client logos, or empty string if none found.
     */
    private static function getHtml(string $defaultLogoFolderRelPath = 'assets/svg/client-logos', bool $includeAdminLogos = true): string
    {
        $adminLogos = [];
        if ($includeAdminLogos) {
            $adminLogos = self::fetchAdminLogos();
            // Ensure admin logos have the 'type' key for consistency
             foreach ($adminLogos as &$logo) { // Use reference to modify array directly
                $logo['type'] = 'admin-logo';
             }
             unset($logo); // Unset reference after loop
        }

        $defaultLogos = self::fetchDefaultLogos($defaultLogoFolderRelPath);

        // Combine logos - admin logos first (if any)
        $allLogos = array_merge($adminLogos, $defaultLogos);

        if (empty($allLogos)) {
            return ''; // No logos to display
        }

        ob_start();
        ?>
        <div class="client-logos-wrap">
            <?php foreach ($allLogos as $logo) : ?>
                <?php if (isset($logo['url']) && isset($logo['alt'])) : // Basic check for required data ?>
                    <div class="client-logo <?= esc_attr($logo['type']) ?>">
                        <img src="<?= esc_url($logo['url']) ?>" alt="<?= esc_attr($logo['alt']) ?>" loading="lazy">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Prints the client logos HTML structure directly.
     * Use this method in your theme template files.
     *
     * @param string $defaultLogoFolderRelPath Relative path within the theme to the folder containing default SVG logos. Defaults to 'assets/svg/client-logos'.
     * @param bool $includeAdminLogos Set to true to attempt loading logos from WP Admin (when implemented), false to only show defaults. Defaults to true.
     */
    public static function render(string $defaultLogoFolderRelPath = 'assets/svg/client-logos', bool $includeAdminLogos = true): void
    {
        echo self::getHtml($defaultLogoFolderRelPath, $includeAdminLogos);
    }
}