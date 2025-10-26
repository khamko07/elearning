<?php
if (!isset($_SESSION['StudentID'])) {
    redirect('login.php');
}

$contentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($contentId > 0) {
    // Show specific content
    $sql = "SELECT * FROM tblcontent WHERE ContentID = {$contentId}";
    $mydb->setQuery($sql);
    $content = $mydb->loadSingleResult();
    
    if (!$content) {
        redirect('index.php?q=content');
    }
    ?>
    <a href="index.php?q=content" class="back-btn">
        <i class="fa fa-arrow-left"></i> Back to Learning Content
    </a>
    
    <div class="content-viewer">
        <h1><?php echo htmlspecialchars($content->Title); ?></h1>
        <?php if ($content->Topic): ?>
            <p class="topic-badge"><span class="label label-primary"><?php echo htmlspecialchars($content->Topic); ?></span></p>
        <?php endif; ?>
        
        <div class="content-body">
            <?php echo markdownToHtml($content->Body); ?>
        </div>
        
        <div class="content-footer">
            <small class="text-muted">Created: <?php echo date('F j, Y', strtotime($content->CreatedAt)); ?></small>
        </div>
    </div>
    
    <style>
    /* Override the blue background for content page */
    body {
        background: #f5f7fb !important;
    }
    
    .content-viewer {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .content-viewer h1 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 2.5em;
        font-weight: 700;
        line-height: 1.2;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .topic-badge {
        margin-bottom: 25px;
    }
    
    .topic-badge .label {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .content-body {
        line-height: 1.8;
        font-size: 16px;
        color: #34495e;
        margin-top: 30px;
    }
    
    .content-body h1 { 
        font-size: 2.2em; 
        margin: 2em 0 1em 0; 
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 3px solid #667eea;
        padding-bottom: 10px;
    }
    
    .content-body h2 { 
        font-size: 1.8em; 
        margin: 1.5em 0 0.8em 0; 
        color: #34495e;
        font-weight: 600;
    }
    
    .content-body h3 { 
        font-size: 1.4em; 
        margin: 1.2em 0 0.6em 0; 
        color: #5a6c7d;
        font-weight: 600;
    }
    
    .content-body ul, .content-body ol { 
        margin: 1.5em 0; 
        padding-left: 2em; 
    }
    
    .content-body li { 
        margin: 0.8em 0; 
        line-height: 1.6;
    }
    
    .content-body p { 
        margin: 1.5em 0; 
        text-align: justify;
    }
    
    .content-body code { 
        background: linear-gradient(45deg, #f8f9fa, #e9ecef); 
        padding: 4px 8px; 
        border-radius: 4px; 
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 0.9em;
        color: #e83e8c;
        border: 1px solid #dee2e6;
    }
    
    .content-body pre {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        overflow-x: auto;
        margin: 2em 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .content-body pre code {
        background: none;
        padding: 0;
        border: none;
        color: #495057;
    }
    
    .content-body blockquote {
        border-left: 4px solid #667eea;
        padding-left: 20px;
        margin: 2em 0;
        color: #6c757d;
        font-style: italic;
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 0 8px 8px 0;
    }
    
    .content-footer {
        margin-top: 40px;
        padding-top: 25px;
        border-top: 2px solid #e9ecef;
        text-align: center;
    }
    
    .content-footer .text-muted {
        color: #6c757d;
        font-size: 14px;
    }
    
    /* Back button */
    .back-btn {
        background: linear-gradient(45deg, #6c757d, #495057);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .content-viewer {
            padding: 25px 20px;
            margin: 0 10px;
        }
        
        .content-viewer h1 {
            font-size: 2em;
        }
        
        .content-body {
            font-size: 15px;
        }
        
        .content-body h1 { font-size: 1.8em; }
        .content-body h2 { font-size: 1.5em; }
        .content-body h3 { font-size: 1.3em; }
    }
    </style>
    
    <script>
    // Simple Markdown to HTML converter (same as admin)
    function markdownToHtml(markdown) {
        let html = markdown
            .replace(/^### (.*$)/gim, '<h3>$1</h3>')
            .replace(/^## (.*$)/gim, '<h2>$1</h2>')
            .replace(/^# (.*$)/gim, '<h1>$1</h1>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/^\* (.*$)/gim, '<li>$1</li>')
            .replace(/^- (.*$)/gim, '<li>$1</li>')
            .replace(/^> (.*$)/gim, '<blockquote>$1</blockquote>')
            .replace(/\n\n/g, '</p><p>')
            .replace(/\n/g, '<br>');
        
        html = html.replace(/(<li>.*<\/li>)/gs, '<ul>$1</ul>');
        
        if (html && !html.startsWith('<h') && !html.startsWith('<ul') && !html.startsWith('<pre')) {
            html = '<p>' + html + '</p>';
        }
        
        return html;
    }
    
    // Convert markdown content to HTML
    document.addEventListener('DOMContentLoaded', function() {
        const contentBody = document.querySelector('.content-body');
        if (contentBody) {
            const markdownText = contentBody.textContent;
            contentBody.innerHTML = markdownToHtml(markdownText);
        }
    });
    </script>
    
    <?php
} else {
    // Show content list
    $sql = "SELECT * FROM tblcontent ORDER BY CreatedAt DESC";
    $mydb->setQuery($sql);
    $contents = $mydb->loadResultList();
    ?>
    
    <div class="page-header">
        <h1><i class="fa fa-book"></i> Learning Content</h1>
    </div>
    
    <?php if (empty($contents)): ?>
        <div class="empty-state">
            <i class="fa fa-book"></i>
            <h3>No Content Available</h3>
            <p>Learning content will appear here once created by administrators.</p>
        </div>
    <?php else: ?>
        <div class="content-grid">
            <?php foreach ($contents as $content): ?>
                <div class="content-card">
                    <div class="content-header">
                        <h3><a href="index.php?q=content&id=<?php echo $content->ContentID; ?>"><?php echo htmlspecialchars($content->Title); ?></a></h3>
                        <?php if ($content->Topic): ?>
                            <div class="topic-badge"><?php echo htmlspecialchars($content->Topic); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="content-preview">
                        <?php 
                        $preview = strip_tags($content->Body);
                        echo htmlspecialchars(substr($preview, 0, 120)) . (strlen($preview) > 120 ? '...' : '');
                        ?>
                    </div>
                    <div class="content-footer">
                        <small class="text-muted">
                            <i class="fa fa-calendar"></i> <?php echo date('M j, Y', strtotime($content->CreatedAt)); ?>
                        </small>
                        <a href="index.php?q=content&id=<?php echo $content->ContentID; ?>" class="btn btn-sm">
                            Read More <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <style>
    /* Override the blue background for content page */
    body {
        background: #f5f7fb !important;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin: -15px -15px 30px -15px;
        text-align: center;
        border-radius: 0;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 2.5em;
        font-weight: 300;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }
    
    .content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    
    .content-header {
        padding: 25px 25px 15px 25px;
        background: linear-gradient(45deg, #f8f9fa, #fff);
    }
    
    .content-header h3 {
        margin: 0 0 12px 0;
        font-size: 20px;
        font-weight: 600;
        line-height: 1.3;
    }
    
    .content-header h3 a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .content-header h3 a:hover {
        color: #667eea;
    }
    
    .topic-badge {
        display: inline-block;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .content-preview {
        padding: 20px 25px;
        color: #5a6c7d;
        line-height: 1.6;
        font-size: 14px;
        border-top: 1px solid #f1f3f4;
    }
    
    .content-footer {
        padding: 15px 25px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .content-footer .text-muted {
        color: #6c757d;
        font-size: 13px;
    }
    
    .content-footer .btn {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .content-footer .btn:hover {
        transform: translateX(2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    }
    
    .empty-state i {
        font-size: 4em;
        color: #dee2e6;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #adb5bd;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .page-header h1 {
            font-size: 2em;
        }
        
        .content-header, .content-preview, .content-footer {
            padding-left: 20px;
            padding-right: 20px;
        }
    }
    </style>
    
    <?php
}

// PHP function to convert markdown (server-side backup)
function markdownToHtml($markdown) {
    $html = $markdown;
    $html = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $html);
    $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/```(.*?)```/s', '<pre><code>$1</code></pre>', $html);
    $html = preg_replace('/`(.*?)`/', '<code>$1</code>', $html);
    $html = preg_replace('/^\* (.*$)/m', '<li>$1</li>', $html);
    $html = preg_replace('/^- (.*$)/m', '<li>$1</li>', $html);
    $html = preg_replace('/^> (.*$)/m', '<blockquote>$1</blockquote>', $html);
    $html = str_replace("\n\n", '</p><p>', $html);
    $html = str_replace("\n", '<br>', $html);
    $html = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $html);
    if ($html && !preg_match('/^<[h|u|p]/', $html)) {
        $html = '<p>' . $html . '</p>';
    }
    return $html;
}
?>