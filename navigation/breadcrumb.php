<?php
/**
 * Breadcrumb Navigation Component
 * Generates breadcrumb navigation based on current page and parameters
 */

class BreadcrumbGenerator {
    private $breadcrumbs = [];
    private $separator = '<i class="fas fa-chevron-right"></i>';
    
    public function __construct() {
        $this->generateBreadcrumbs();
    }
    
    private function generateBreadcrumbs() {
        $currentPage = basename($_SERVER['PHP_SELF'], '.php');
        $currentQuery = isset($_GET['q']) ? $_GET['q'] : '';
        $isAdmin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
        
        // Always start with home
        if ($isAdmin) {
            $this->addBreadcrumb('Dashboard', web_root . 'admin/index.php', 'fas fa-tachometer-alt');
        } else {
            $this->addBreadcrumb('Trang chủ', web_root . 'index.php', 'fas fa-home');
        }
        
        // Add breadcrumbs based on current location
        if ($isAdmin) {
            $this->generateAdminBreadcrumbs();
        } else {
            $this->generateStudentBreadcrumbs();
        }
    }
    
    private function generateAdminBreadcrumbs() {
        $path = $_SERVER['REQUEST_URI'];
        
        if (strpos($path, '/lesson/') !== false) {
            $this->addBreadcrumb('Quản lý bài học', web_root . 'admin/modules/lesson/index.php', 'fas fa-book');
            
            if (strpos($path, '/add.php') !== false) {
                $this->addBreadcrumb('Thêm bài học', '', 'fas fa-plus');
            } elseif (strpos($path, '/edit.php') !== false) {
                $this->addBreadcrumb('Chỉnh sửa bài học', '', 'fas fa-edit');
            }
        } elseif (strpos($path, '/exercises/') !== false) {
            $this->addBreadcrumb('Quản lý bài tập', web_root . 'admin/modules/exercises/index.php', 'fas fa-question-circle');
            
            if (strpos($path, '/add.php') !== false) {
                $this->addBreadcrumb('Thêm bài tập', '', 'fas fa-plus');
            } elseif (strpos($path, '/edit.php') !== false) {
                $this->addBreadcrumb('Chỉnh sửa bài tập', '', 'fas fa-edit');
            }
        } elseif (strpos($path, '/students/') !== false) {
            $this->addBreadcrumb('Quản lý học viên', web_root . 'admin/modules/students/index.php', 'fas fa-users');
            
            if (strpos($path, '/add.php') !== false) {
                $this->addBreadcrumb('Thêm học viên', '', 'fas fa-user-plus');
            } elseif (strpos($path, '/edit.php') !== false) {
                $this->addBreadcrumb('Chỉnh sửa học viên', '', 'fas fa-user-edit');
            }
        } elseif (strpos($path, '/settings/') !== false) {
            $this->addBreadcrumb('Cài đặt hệ thống', web_root . 'admin/modules/settings/index.php', 'fas fa-cogs');
        }
    }
    
    private function generateStudentBreadcrumbs() {
        $currentQuery = isset($_GET['q']) ? $_GET['q'] : '';
        
        switch ($currentQuery) {
            case 'content':
                $this->addBreadcrumb('Nội dung học tập', web_root . 'index.php?q=content', 'fas fa-book-open');
                break;
                
            case 'lesson':
                $this->addBreadcrumb('Nội dung học tập', web_root . 'index.php?q=content', 'fas fa-book-open');
                $lessonId = isset($_GET['id']) ? $_GET['id'] : '';
                if ($lessonId) {
                    $this->addBreadcrumb('Bài học #' . $lessonId, '', 'fas fa-play-circle');
                }
                break;
                
            case 'categories':
                $this->addBreadcrumb('Bài tập', web_root . 'index.php?q=categories', 'fas fa-clipboard-check');
                break;
                
            case 'topics':
                $this->addBreadcrumb('Bài tập', web_root . 'index.php?q=categories', 'fas fa-clipboard-check');
                $categoryId = isset($_GET['id']) ? $_GET['id'] : '';
                if ($categoryId) {
                    $this->addBreadcrumb('Chủ đề #' . $categoryId, '', 'fas fa-folder-open');
                }
                break;
                
            case 'question':
                $this->addBreadcrumb('Bài tập', web_root . 'index.php?q=categories', 'fas fa-clipboard-check');
                $this->addBreadcrumb('Làm bài', '', 'fas fa-pencil-alt');
                break;
                
            case 'result':
                $this->addBreadcrumb('Kết quả học tập', web_root . 'index.php?q=result', 'fas fa-chart-line');
                break;
                
            case 'quizresult':
                $this->addBreadcrumb('Kết quả học tập', web_root . 'index.php?q=result', 'fas fa-chart-line');
                $this->addBreadcrumb('Chi tiết kết quả', '', 'fas fa-chart-bar');
                break;
        }
    }
    
    public function addBreadcrumb($title, $url = '', $icon = '') {
        $this->breadcrumbs[] = [
            'title' => $title,
            'url' => $url,
            'icon' => $icon
        ];
    }
    
    public function render($showHome = true, $showIcons = true) {
        if (empty($this->breadcrumbs)) {
            return '';
        }
        
        $html = '<nav class="breadcrumb-nav" aria-label="Breadcrumb">';
        $html .= '<ol class="breadcrumb-list">';
        
        $breadcrumbs = $showHome ? $this->breadcrumbs : array_slice($this->breadcrumbs, 1);
        $totalItems = count($breadcrumbs);
        
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $isLast = ($index === $totalItems - 1);
            $html .= '<li class="breadcrumb-item' . ($isLast ? ' active' : '') . '">';
            
            if (!$isLast && !empty($breadcrumb['url'])) {
                $html .= '<a href="' . htmlspecialchars($breadcrumb['url']) . '" class="breadcrumb-link">';
            } else {
                $html .= '<span class="breadcrumb-text">';
            }
            
            if ($showIcons && !empty($breadcrumb['icon'])) {
                $html .= '<i class="' . htmlspecialchars($breadcrumb['icon']) . '"></i>';
            }
            
            $html .= '<span>' . htmlspecialchars($breadcrumb['title']) . '</span>';
            
            if (!$isLast && !empty($breadcrumb['url'])) {
                $html .= '</a>';
            } else {
                $html .= '</span>';
            }
            
            if (!$isLast) {
                $html .= '<span class="breadcrumb-separator">' . $this->separator . '</span>';
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ol>';
        $html .= '</nav>';
        
        return $html;
    }
    
    public function getBreadcrumbs() {
        return $this->breadcrumbs;
    }
    
    public function getLastBreadcrumb() {
        return end($this->breadcrumbs);
    }
}

// Usage function
function renderBreadcrumb($showHome = true, $showIcons = true) {
    $breadcrumb = new BreadcrumbGenerator();
    return $breadcrumb->render($showHome, $showIcons);
}

// Auto-render if not included as component
if (!defined('BREADCRUMB_COMPONENT')) {
    $breadcrumbGenerator = new BreadcrumbGenerator();
    echo $breadcrumbGenerator->render();
}
?>