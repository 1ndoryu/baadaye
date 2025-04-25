<?php
# App/Glory/ScriptManager.php
namespace App\Glory;

use WP_Scripts; 

class ScriptManager
{
    /** @var array Stores script definitions. */
    private static $scripts = [];

    /** @var bool Global development mode status. */
    private static $globalDevMode = false;

    /** @var string Global theme version (fallback). */
    private static $themeVersion = '1.0.0';

    /**
     * Sets global development mode status.
     * @param bool $enabled True to enable, False to disable.
     */
    public static function setGlobalDevMode(bool $enabled): void
    {
        self::$globalDevMode = $enabled;
    }

    /**
     * Sets global theme version to use as fallback.
     * @param string $version
     */
    public static function setThemeVersion(string $version): void
    {
        self::$themeVersion = $version;
    }

    /**
     * Defines a single script to enqueue.
     *
     * @param string $handle WP handle and base name of the script file (without .js).
     * @param string|null $path Relative path to the theme directory (e.g., 'js/custom/mi-script.js'). If null, uses "js/{$handle}.js".
     * @param array $deps Dependencies (other script handles).
     * @param string|null $version Script version. If null, uses global theme version.
     * @param bool $in_footer Load in footer (true) or in head (false).
     * @param bool|null $devMode Override development mode for this script: true (always cache-bust), false (never cache-bust), null (use global).
     */
    public static function define(
        string $handle,
        ?string $path = null,
        array $deps = [],
        ?string $version = null,
        bool $in_footer = true,
        ?bool $devMode = null
    ): void {
        # If no path is specified, build the default path
        if (is_null($path)) {
            $path = 'js/' . $handle . '.js';
        }

        self::$scripts[$handle] = [
            'path' => $path,
            'deps' => $deps,
            'version' => $version,
            'in_footer' => $in_footer,
            'dev_mode' => $devMode, # Stores the specific override
            'handle' => $handle
        ];
    }

    /**
     * Defines all .js scripts found in a specific folder.
     *
     * @param string $folderRelPath Relative path to the theme directory (e.g., 'js/vendor').
     * @param array $defaultDeps Default dependencies for all scripts in this folder.
     * @param bool $defaultInFooter Load in footer by default for these scripts.
     * @param bool|null $folderDevMode Override development mode for all scripts in this folder (unless individually overridden).
     * @param string $handlePrefix Optional prefix to add to each script handle.
     */
    public static function defineFolder(
        string $folderRelPath = 'js',
        array $defaultDeps = [],
        bool $defaultInFooter = true,
        ?bool $folderDevMode = null,
        string $handlePrefix = ''
    ): void {
        $fullFolderPath = get_template_directory() . '/' . trim($folderRelPath, '/');

        if (!is_dir($fullFolderPath)) {
            if (self::$globalDevMode) { # Only log in dev mode
                error_log("ScriptManager: Folder not found at {$fullFolderPath}");
            }
            return;
        }

        $files = glob($fullFolderPath . '/*.js');
        if ($files === false) {
            error_log("ScriptManager: Failed to scan folder {$fullFolderPath}");
            return; # Error reading directory
        }

        foreach ($files as $file) {
            $handle = $handlePrefix . basename($file, '.js');
            $relativePath = trim($folderRelPath, '/') . '/' . basename($file);

            # Use define() to add it, respecting possible overrides if already defined
            # If already defined with 'define()', this call won't overwrite it unless
            # you change the logic here to force overwrite if necessary.
            # For now, if already exists, does nothing (first one defined wins).
            if (!isset(self::$scripts[$handle])) {
                self::define(
                    $handle,
                    $relativePath,
                    $defaultDeps,
                    null, # Version will use global theme version
                    $defaultInFooter,
                    $folderDevMode # Applies folder dev mode
                );
            }
        }
    }

    /**
     * Registers the hook to enqueue defined scripts.
     */
    public static function register(): void
    {
        # Use a slightly higher priority (e.g., 20) in case other hooks need these scripts.
        add_action('wp_enqueue_scripts', [self::class, 'enqueueScripts'], 20);
    }

    /**
     * Function executed in the 'wp_enqueue_scripts' hook.
     * @internal Do not call directly.
     */
    public static function enqueueScripts(): void
    {
        if (empty(self::$scripts)) {
            return;
        }

        foreach (self::$scripts as $handle => $scriptDef) {
            # 1. Determine dev mode for THIS script
            $isDev = $scriptDef['dev_mode'] ?? self::$globalDevMode; # Uses override or global

            # 2. Determine version
            $scriptVersion = $scriptDef['version'] ?? self::$themeVersion; # Uses specific version or global

            # 3. Add cache buster if in dev mode
            if ($isDev) {
                # bin2hex(random_bytes(4)) is more secure than time() or rand()
                $cacheBuster = '.' . substr(md5(time() . rand()), 0, 6); # Simple alternative
                # $cacheBuster = '.' . bin2hex(random_bytes(4)); # More secure option if PHP >= 7.0
                $scriptVersion .= $cacheBuster;
            }

            # 4. Build absolute path and URL
            $relativePath = $scriptDef['path']; # Already have the correct relative path
            $filePath = get_template_directory() . '/' . $relativePath;
            $fileUrl = get_template_directory_uri() . '/' . $relativePath;

            # 5. Verify file exists
            if (!file_exists($filePath)) {
                if ($isDev) { # Only log in dev mode
                    error_log("ScriptManager: Script file not found at {$filePath} for handle '{$handle}'");
                }
                continue; # Skip this script if it doesn't exist
            }

            # 6. Enqueue the script
            wp_enqueue_script(
                $handle,
                $fileUrl,
                $scriptDef['deps'],
                $scriptVersion,
                $scriptDef['in_footer']
            );
        }
    }
} 


