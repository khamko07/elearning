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
    
    // Detect Lao content
    $isLaoContent = preg_match('/[\x{0E80}-\x{0EFF}]/u', $content->Title . ' ' . $content->Body);
    $laoClass = $isLaoContent ? ' lao-content' : '';
    ?>
    
    <div class="container-fluid">
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php?q=content">
              <i class="fas fa-home me-1"></i>Learning Content
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?php echo htmlspecialchars($content->Title); ?>
          </li>
        </ol>
      </nav>

      <div class="card<?php echo $laoClass; ?>" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
          <h1 class="card-title mb-0"><?php echo htmlspecialchars($content->Title); ?></h1>
          <?php if ($content->Topic): ?>
            <span class="badge badge-primary mt-2"><?php echo htmlspecialchars($content->Topic); ?></span>
          <?php endif; ?>
        </div>
        
        <div class="card-body">
          <div class="content-body">
            <?php echo markdownToHtml($content->Body); ?>
          </div>
        </div>
        
        <div class="card-footer">
          <small class="text-muted">
            <i class="fas fa-calendar me-2"></i>Created: <?php echo date('F j, Y', strtotime($content->CreatedAt)); ?>
          </small>
          <a href="index.php?q=content" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Content List
          </a>
        </div>
      </div>
    </div>
    
    <style>
    /* Lao Language Font */
    @font-face {
        font-family: 'Phetsarath OT';
        src: url('fonts/Phetsarath OT.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    
    .lao-content,
    .lao-content * {
        font-family: 'Phetsarath OT', Arial, sans-serif !important;
    }
    
    .content-body {
        line-height: var(--leading-relaxed);
        font-size: var(--text-base);
        color: var(--text-primary);
    }
    
    .content-body h1 { 
        font-size: var(--text-3xl); 
        margin: var(--space-8) 0 var(--space-4) 0; 
        color: var(--text-primary);
        font-weight: var(--font-bold);
        border-bottom: 3px solid var(--primary-blue);
        padding-bottom: var(--space-3);
    }
    
    .content-body h2 { 
        font-size: var(--text-2xl); 
        margin: var(--space-6) 0 var(--space-3) 0; 
        color: var(--text-primary);
        font-weight: var(--font-semibold);
    }
    
    .content-body h3 { 
        font-size: var(--text-xl); 
        margin: var(--space-5) 0 var(--space-3) 0; 
        color: var(--text-secondary);
        font-weight: var(--font-semibold);
    }
    
    .content-body ul, .content-body ol { 
        margin: var(--space-6) 0; 
        padding-left: var(--space-8); 
    }
    
    .content-body li { 
        margin: var(--space-2) 0; 
        line-height: var(--leading-relaxed);
    }
    
    .content-body p { 
        margin: var(--space-4) 0; 
    }
    
    .content-body code { 
        background: var(--gray-100); 
        padding: var(--space-1) var(--space-2); 
        border-radius: var(--radius-sm); 
        font-family: var(--font-mono);
        font-size: var(--text-sm);
        color: var(--danger);
        border: 1px solid var(--gray-300);
    }
    
    .content-body pre {
        background: var(--gray-100);
        padding: var(--space-5);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--primary-blue);
        overflow-x: auto;
        margin: var(--space-6) 0;
        box-shadow: var(--shadow-sm);
    }
    
    .content-body pre code {
        background: none;
        padding: 0;
        border: none;
        color: var(--text-primary);
    }
    
    .content-body blockquote {
        border-left: 4px solid var(--primary-blue);
        padding: var(--space-4) var(--space-5);
        margin: var(--space-6) 0;
        color: var(--text-secondary);
        font-style: italic;
        background: var(--bg-light);
        border-radius: 0 var(--radius-md) var(--radius-md) 0;
    }
    </style>
    
    <?php
} else {
    // Show content list
    $sql = "SELECT * FROM tblcontent ORDER BY CreatedAt DESC";
    $mydb->setQuery($sql);
    $contents = $mydb->loadResultList();
    ?>
    
    <div class="container-fluid">
      <div class="mb-5">
        <h1 class="mb-3">
          <i class="fas fa-book me-2"></i>Learning Content
        </h1>
        <p class="lead text-muted">Explore educational materials and resources</p>
      </div>
      
      <?php if (empty($contents)): ?>
        <div class="empty-state">
          <i class="fas fa-book"></i>
          <h3>No Content Available</h3>
          <p>Learning content will appear here once created by administrators.</p>
        </div>
      <?php else: ?>
        <div class="content-grid">
          <?php foreach ($contents as $content): 
            $cardLaoClass = preg_match('/[\x{0E80}-\x{0EFF}]/u', $content->Title . ' ' . $content->Body) ? ' lao-content' : '';
          ?>
            <div class="content-card<?php echo $cardLaoClass; ?>">
              <div class="card-header">
                <h3 class="card-title">
                  <a href="index.php?q=content&id=<?php echo $content->ContentID; ?>" style="color: var(--text-white); text-decoration: none;">
                    <?php echo htmlspecialchars($content->Title); ?>
                  </a>
                </h3>
                <?php if ($content->Topic): ?>
                  <span class="badge badge-primary"><?php echo htmlspecialchars($content->Topic); ?></span>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <p class="card-text">
                  <?php 
                  $preview = strip_tags($content->Body);
                  echo htmlspecialchars(substr($preview, 0, 120)) . (strlen($preview) > 120 ? '...' : '');
                  ?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <i class="fas fa-calendar me-2"></i><?php echo date('M j, Y', strtotime($content->CreatedAt)); ?>
                </small>
                <a href="index.php?q=content&id=<?php echo $content->ContentID; ?>" class="btn btn-primary btn-sm">
                  Read More <i class="fas fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    
    <style>
    .lao-content,
    .lao-content * {
        font-family: 'Phetsarath OT', Arial, sans-serif !important;
    }
    </style>
    
    <?php
}

// PHP function to convert markdown (server-side)
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
