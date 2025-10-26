<?php
/**
 * Asset Loader Helper
 * Handles loading of optimized CSS and JavaScript assets
 */

class AssetLoader {
    private static $instance = null;
    private $manifest = null;
    private $manifestPath;
    private $webRoot;
    private $isDevelopment;
    
    private function __construct() {
        $this->webRoot = defined('web_root') ? web_root : '/';
        $this->manifestPath = $_SERVER['DOCUMENT_ROOT'] . $this->webRoot . 'dist/manifest.json';
        $this->isDevelopment = defined('ENVIRONMENT') && ENVIRONMENT === 'development';
        $this->loadManifest();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadManifest() {
        if (file_exists($this->manifestPath)) {
            $content = file_get_contents($this->manifestPath);
            $this->manifest = json_decode($content, true);
        }
    }
    
    /**
     * Get CSS assets HTML
     */
    public function getCSSAssets($critical = false) {
        $html = '';
        
        if ($this->isDevelopment || !$this->manifest) {
            // Development mode - load individual files
            if ($critical) {
                $html .= $this->getCriticalCSS();
            } else {
                $html .= '<link rel="stylesheet" href="' . $this->webRoot . 'assets/css/main.css">' . "\n";
            }
        } else {
            // Production mode - load minified assets
            if ($critical) {
                $html .= $this->getCriticalCSS();
            }
            
            $cssFile = $this->manifest['files']['css'];
            $integrity = $this->manifest['integrity']['css'] ?? '';
            
            $html .= '<link rel="stylesheet" href="' . $this->webRoot . $cssFile . '"';
            if ($integrity) {
                $html .= ' integrity="' . $integrity . '" crossorigin="anonymous"';
            }
            $html .= '>' . "\n";
        }
        
        return $html;
    }
    
    /**
     * Get JavaScript assets HTML
     */
    public function getJSAssets() {
        $html = '';
        
        if ($this->isDevelopment || !$this->manifest) {
            // Development mode - load individual files
            $jsFiles = [
                'assets/js/theme-manager.js',
                'assets/js/keyboard-navigation.js',
                'assets/js/table-keyboard-nav.js',
                'assets/js/lazy-loading.js'
            ];
            
            foreach ($jsFiles as $file) {
                $html .= '<script src="' . $this->webRoot . $file . '"></script>' . "\n";
            }
        } else {
            // Production mode - load minified assets
            $jsFile = $this->manifest['files']['js'];
            $integrity = $this->manifest['integrity']['js'] ?? '';
            
            $html .= '<script src="' . $this->webRoot . $jsFile . '"';
            if ($integrity) {
                $html .= ' integrity="' . $integrity . '" crossorigin="anonymous"';
            }
            $html .= '></script>' . "\n";
        }
        
        return $html;
    }
    
    /**
     * Get critical CSS inline
     */
    public function getCriticalCSS() {
        $criticalPath = $_SERVER['DOCUMENT_ROOT'] . $this->webRoot . 'assets/css/critical.css';
        
        if (file_exists($criticalPath)) {
            $css = file_get_contents($criticalPath);
            
            // Minify CSS for inline use
            $css = $this->minifyCSS($css);
            
            return '<style>' . $css . '</style>' . "\n";
        }
        
        return '';
    }
    
    /**
     * Preload critical resources
     */
    public function getPreloadLinks() {
        $html = '';
        
        if (!$this->isDevelopment && $this->manifest) {
            // Preload CSS
            $cssFile = $this->manifest['files']['css'];
            $html .= '<link rel="preload" href="' . $this->webRoot . $cssFile . '" as="style">' . "\n";
            
            // Preload JS
            $jsFile = $this->manifest['files']['js'];
            $html .= '<link rel="preload" href="' . $this->webRoot . $jsFile . '" as="script">' . "\n";
        }
        
        // Preload fonts
        $html .= '<link rel="preload" href="' . $this->webRoot . 'fonts/font-awesome.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
        
        return $html;
    }
    
    /**
     * Get DNS prefetch links
     */
    public function getDNSPrefetchLinks() {
        $domains = [
            '//fonts.googleapis.com',
            '//fonts.gstatic.com',
            '//cdnjs.cloudflare.com'
        ];
        
        $html = '';
        foreach ($domains as $domain) {
            $html .= '<link rel="dns-prefetch" href="' . $domain . '">' . "\n";
        }
        
        return $html;
    }
    
    /**
     * Get resource hints
     */
    public function getResourceHints() {
        $html = '';
        
        // DNS prefetch
        $html .= $this->getDNSPrefetchLinks();
        
        // Preconnect to important domains
        $html .= '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        
        return $html;
    }
    
    /**
     * Get cache busting version
     */
    public function getVersion() {
        if ($this->manifest && isset($this->manifest['version'])) {
            return $this->manifest['version'];
        }
        
        return time(); // Fallback to timestamp
    }
    
    /**
     * Check if assets are optimized
     */
    public function isOptimized() {
        return !$this->isDevelopment && $this->manifest !== null;
    }
    
    /**
     * Get asset URL with version
     */
    public function asset($path) {
        $version = $this->getVersion();
        $separator = strpos($path, '?') !== false ? '&' : '?';
        
        return $this->webRoot . $path . $separator . 'v=' . $version;
    }
    
    /**
     * Simple CSS minification
     */
    private function minifyCSS($css) {
        // Remove comments
        $css = preg_replace('/\/\*[\s\S]*?\*\//', '', $css);
        
        // Remove unnecessary whitespace
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Remove whitespace around certain characters
        $css = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $css);
        
        // Remove trailing semicolons
        $css = str_replace(';}', '}', $css);
        
        return trim($css);
    }
}

// Helper functions for easy use in templates
function asset_css($critical = false) {
    return AssetLoader::getInstance()->getCSSAssets($critical);
}

function asset_js() {
    return AssetLoader::getInstance()->getJSAssets();
}

function asset_preload() {
    return AssetLoader::getInstance()->getPreloadLinks();
}

function asset_hints() {
    return AssetLoader::getInstance()->getResourceHints();
}

function asset_url($path) {
    return AssetLoader::getInstance()->asset($path);
}

function is_assets_optimized() {
    return AssetLoader::getInstance()->isOptimized();
}
?>