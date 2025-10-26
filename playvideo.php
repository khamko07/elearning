<?php  
@$id = $_GET['id'];
if($id == '') {
    redirect("index.php");
}

$lesson = New Lesson();
$res = $lesson->single_lesson($id);

if (!$res) {
    redirect("index.php?q=lesson");
}

// Get next and previous lessons for navigation
$sqlNext = "SELECT LessonID, LessonTitle FROM tbllesson WHERE LessonID > {$id} AND Category='Video' ORDER BY LessonID ASC LIMIT 1";
$mydb->setQuery($sqlNext);
$nextLesson = $mydb->loadSingleResult();

$sqlPrev = "SELECT LessonID, LessonTitle FROM tbllesson WHERE LessonID < {$id} AND Category='Video' ORDER BY LessonID DESC LIMIT 1";
$mydb->setQuery($sqlPrev);
$prevLesson = $mydb->loadSingleResult();

$videoUrl = web_root.'admin/modules/lesson/'.$res->FileLocation;
?>

<div class="video-player-container">
    <!-- Video Player Header -->
    <div class="video-header">
        <div class="header-navigation">
            <a href="index.php?q=lesson" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Quay lại danh sách</span>
            </a>
            
            <div class="video-controls">
                <button class="control-btn" id="playlistBtn" title="Danh sách phát">
                    <i class="fas fa-list"></i>
                </button>
                <button class="control-btn" id="settingsBtn" title="Cài đặt">
                    <i class="fas fa-cog"></i>
                </button>
                <button class="control-btn" id="bookmarkBtn" title="Đánh dấu">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
        </div>
        
        <div class="video-meta">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="index.php?q=lesson">Bài học</a>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($res->LessonTitle); ?></span>
            </div>
            
            <div class="video-progress">
                <div class="progress-bar">
                    <div class="progress-fill" id="videoProgress"></div>
                </div>
                <span class="progress-time">
                    <span id="currentTime">0:00</span> / <span id="totalTime">0:00</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Video Player -->
    <div class="video-player-wrapper">
        <div class="video-player" id="videoPlayer">
            <video 
                id="mainVideo" 
                class="video-element"
                preload="metadata"
                poster=""
                playsinline
            >
                <source src="<?php echo $videoUrl; ?>" type="video/mp4">
                <source src="<?php echo $videoUrl; ?>" type="video/webm">
                <p>Trình duyệt của bạn không hỗ trợ video HTML5.</p>
            </video>
            
            <!-- Custom Video Controls -->
            <div class="video-controls-overlay" id="videoControls">
                <div class="controls-top">
                    <div class="video-title"><?php echo htmlspecialchars($res->LessonTitle); ?></div>
                    <button class="control-btn close-btn" id="closeBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="controls-center">
                    <button class="play-pause-btn" id="playPauseBtn">
                        <i class="fas fa-play"></i>
                    </button>
                </div>
                
                <div class="controls-bottom">
                    <div class="progress-container">
                        <div class="progress-track" id="progressTrack">
                            <div class="progress-buffer" id="progressBuffer"></div>
                            <div class="progress-played" id="progressPlayed"></div>
                            <div class="progress-thumb" id="progressThumb"></div>
                        </div>
                    </div>
                    
                    <div class="controls-row">
                        <div class="controls-left">
                            <button class="control-btn" id="playBtn">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="control-btn" id="prevBtn" <?php echo !$prevLesson ? 'disabled' : ''; ?>>
                                <i class="fas fa-step-backward"></i>
                            </button>
                            <button class="control-btn" id="nextBtn" <?php echo !$nextLesson ? 'disabled' : ''; ?>>
                                <i class="fas fa-step-forward"></i>
                            </button>
                            <div class="volume-control">
                                <button class="control-btn" id="volumeBtn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                                <div class="volume-slider">
                                    <input type="range" id="volumeSlider" min="0" max="100" value="100">
                                </div>
                            </div>
                            <div class="time-display">
                                <span id="currentTimeDisplay">0:00</span>
                                <span>/</span>
                                <span id="durationDisplay">0:00</span>
                            </div>
                        </div>
                        
                        <div class="controls-right">
                            <div class="speed-control">
                                <button class="control-btn" id="speedBtn">
                                    <span>1x</span>
                                </button>
                                <div class="speed-menu" id="speedMenu">
                                    <button data-speed="0.5">0.5x</button>
                                    <button data-speed="0.75">0.75x</button>
                                    <button data-speed="1" class="active">1x</button>
                                    <button data-speed="1.25">1.25x</button>
                                    <button data-speed="1.5">1.5x</button>
                                    <button data-speed="2">2x</button>
                                </div>
                            </div>
                            <button class="control-btn" id="pipBtn" title="Picture in Picture">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                            <button class="control-btn" id="fullscreenBtn">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Loading Spinner -->
            <div class="video-loading" id="videoLoading">
                <div class="loading-spinner"></div>
                <p>Đang tải video...</p>
            </div>
            
            <!-- Error Message -->
            <div class="video-error" id="videoError" style="display: none;">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3>Không thể phát video</h3>
                <p>Vui lòng thử lại sau hoặc liên hệ hỗ trợ.</p>
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="fas fa-refresh"></i>
                    Thử lại
                </button>
            </div>
        </div>
    </div>

    <!-- Video Information -->
    <div class="video-info">
        <div class="video-details">
            <div class="video-main-info">
                <h1 class="video-title"><?php echo htmlspecialchars($res->LessonTitle); ?></h1>
                
                <div class="video-meta-info">
                    <div class="meta-item">
                        <i class="fas fa-book"></i>
                        <span>Chương <?php echo htmlspecialchars($res->LessonChapter); ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-play-circle"></i>
                        <span>Video Lesson</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span id="videoDuration">Đang tải...</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye"></i>
                        <span>1,234 lượt xem</span>
                    </div>
                </div>
                
                <div class="video-actions">
                    <button class="action-btn like-btn" id="likeBtn">
                        <i class="far fa-thumbs-up"></i>
                        <span>Hữu ích</span>
                        <span class="count">0</span>
                    </button>
                    <button class="action-btn share-btn" id="shareBtn">
                        <i class="fas fa-share-alt"></i>
                        <span>Chia sẻ</span>
                    </button>
                    <button class="action-btn download-btn" id="downloadBtn">
                        <i class="fas fa-download"></i>
                        <span>Tải xuống</span>
                    </button>
                </div>
            </div>
            
            <div class="video-description">
                <h3>Mô tả</h3>
                <p>
                    Video bài giảng <?php echo htmlspecialchars($res->LessonTitle); ?> 
                    thuộc chương <?php echo htmlspecialchars($res->LessonChapter); ?>. 
                    Nội dung được trình bày một cách sinh động và dễ hiểu, 
                    giúp học viên nắm vững kiến thức một cách hiệu quả.
                </p>
            </div>
        </div>
    </div>

    <!-- Video Navigation -->
    <nav class="video-navigation">
        <div class="nav-item prev">
            <?php if ($prevLesson): ?>
                <a href="index.php?q=playvideo&id=<?php echo $prevLesson->LessonID; ?>" class="nav-link">
                    <div class="nav-direction">
                        <i class="fas fa-chevron-left"></i>
                        <span>Video trước</span>
                    </div>
                    <div class="nav-title"><?php echo htmlspecialchars($prevLesson->LessonTitle); ?></div>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="nav-item next">
            <?php if ($nextLesson): ?>
                <a href="index.php?q=playvideo&id=<?php echo $nextLesson->LessonID; ?>" class="nav-link">
                    <div class="nav-direction">
                        <span>Video tiếp</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="nav-title"><?php echo htmlspecialchars($nextLesson->LessonTitle); ?></div>
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('mainVideo');
    const videoPlayer = document.getElementById('videoPlayer');
    const videoControls = document.getElementById('videoControls');
    const videoLoading = document.getElementById('videoLoading');
    const videoError = document.getElementById('videoError');
    
    // Control elements
    const playPauseBtn = document.getElementById('playPauseBtn');
    const playBtn = document.getElementById('playBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const volumeBtn = document.getElementById('volumeBtn');
    const volumeSlider = document.getElementById('volumeSlider');
    const speedBtn = document.getElementById('speedBtn');
    const speedMenu = document.getElementById('speedMenu');
    const pipBtn = document.getElementById('pipBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const bookmarkBtn = document.getElementById('bookmarkBtn');
    
    // Progress elements
    const progressTrack = document.getElementById('progressTrack');
    const progressBuffer = document.getElementById('progressBuffer');
    const progressPlayed = document.getElementById('progressPlayed');
    const progressThumb = document.getElementById('progressThumb');
    const currentTimeDisplay = document.getElementById('currentTimeDisplay');
    const durationDisplay = document.getElementById('durationDisplay');
    const videoProgress = document.getElementById('videoProgress');
    const currentTime = document.getElementById('currentTime');
    const totalTime = document.getElementById('totalTime');
    const videoDuration = document.getElementById('videoDuration');
    
    let isPlaying = false;
    let isDragging = false;
    let controlsTimeout;
    
    // Initialize video
    video.addEventListener('loadstart', function() {
        videoLoading.style.display = 'flex';
        videoError.style.display = 'none';
    });
    
    video.addEventListener('loadedmetadata', function() {
        videoLoading.style.display = 'none';
        updateDuration();
    });
    
    video.addEventListener('error', function() {
        videoLoading.style.display = 'none';
        videoError.style.display = 'flex';
    });
    
    video.addEventListener('canplay', function() {
        videoLoading.style.display = 'none';
    });
    
    // Play/Pause functionality
    function togglePlay() {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }
    
    video.addEventListener('play', function() {
        isPlaying = true;
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        playBtn.innerHTML = '<i class="fas fa-pause"></i>';
    });
    
    video.addEventListener('pause', function() {
        isPlaying = false;
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        playBtn.innerHTML = '<i class="fas fa-play"></i>';
    });
    
    playPauseBtn.addEventListener('click', togglePlay);
    playBtn.addEventListener('click', togglePlay);
    video.addEventListener('click', togglePlay);
    
    // Progress tracking
    video.addEventListener('timeupdate', function() {
        if (!isDragging) {
            updateProgress();
        }
    });
    
    video.addEventListener('progress', function() {
        updateBuffer();
    });
    
    function updateProgress() {
        const progress = (video.currentTime / video.duration) * 100;
        progressPlayed.style.width = progress + '%';
        progressThumb.style.left = progress + '%';
        videoProgress.style.width = progress + '%';
        
        currentTimeDisplay.textContent = formatTime(video.currentTime);
        currentTime.textContent = formatTime(video.currentTime);
    }
    
    function updateBuffer() {
        if (video.buffered.length > 0) {
            const buffered = (video.buffered.end(video.buffered.length - 1) / video.duration) * 100;
            progressBuffer.style.width = buffered + '%';
        }
    }
    
    function updateDuration() {
        const duration = formatTime(video.duration);
        durationDisplay.textContent = duration;
        totalTime.textContent = duration;
        videoDuration.textContent = duration + ' phút';
    }
    
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return mins + ':' + (secs < 10 ? '0' : '') + secs;
    }
    
    // Progress bar interaction
    progressTrack.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        video.currentTime = pos * video.duration;
    });
    
    // Volume control
    volumeSlider.addEventListener('input', function() {
        video.volume = this.value / 100;
        updateVolumeIcon();
    });
    
    volumeBtn.addEventListener('click', function() {
        video.muted = !video.muted;
        updateVolumeIcon();
    });
    
    function updateVolumeIcon() {
        const icon = volumeBtn.querySelector('i');
        if (video.muted || video.volume === 0) {
            icon.className = 'fas fa-volume-mute';
        } else if (video.volume < 0.5) {
            icon.className = 'fas fa-volume-down';
        } else {
            icon.className = 'fas fa-volume-up';
        }
    }
    
    // Speed control
    const speedButtons = speedMenu.querySelectorAll('button');
    speedButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const speed = parseFloat(this.dataset.speed);
            video.playbackRate = speed;
            speedBtn.querySelector('span').textContent = speed + 'x';
            
            speedButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Navigation
    if (prevBtn && !prevBtn.disabled) {
        prevBtn.addEventListener('click', function() {
            <?php if ($prevLesson): ?>
                window.location.href = 'index.php?q=playvideo&id=<?php echo $prevLesson->LessonID; ?>';
            <?php endif; ?>
        });
    }
    
    if (nextBtn && !nextBtn.disabled) {
        nextBtn.addEventListener('click', function() {
            <?php if ($nextLesson): ?>
                window.location.href = 'index.php?q=playvideo&id=<?php echo $nextLesson->LessonID; ?>';
            <?php endif; ?>
        });
    }
    
    // Picture in Picture
    if (pipBtn && 'pictureInPictureEnabled' in document) {
        pipBtn.addEventListener('click', function() {
            if (document.pictureInPictureElement) {
                document.exitPictureInPicture();
            } else {
                video.requestPictureInPicture();
            }
        });
    } else if (pipBtn) {
        pipBtn.style.display = 'none';
    }
    
    // Fullscreen
    fullscreenBtn.addEventListener('click', function() {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            videoPlayer.requestFullscreen();
        }
    });
    
    document.addEventListener('fullscreenchange', function() {
        const icon = fullscreenBtn.querySelector('i');
        if (document.fullscreenElement) {
            icon.className = 'fas fa-compress';
        } else {
            icon.className = 'fas fa-expand';
        }
    });
    
    // Controls visibility
    function showControls() {
        videoControls.classList.add('show');
        clearTimeout(controlsTimeout);
        controlsTimeout = setTimeout(hideControls, 3000);
    }
    
    function hideControls() {
        if (!video.paused) {
            videoControls.classList.remove('show');
        }
    }
    
    videoPlayer.addEventListener('mousemove', showControls);
    videoPlayer.addEventListener('mouseleave', hideControls);
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName.toLowerCase() === 'input') return;
        
        switch(e.code) {
            case 'Space':
                e.preventDefault();
                togglePlay();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                video.currentTime -= 10;
                break;
            case 'ArrowRight':
                e.preventDefault();
                video.currentTime += 10;
                break;
            case 'ArrowUp':
                e.preventDefault();
                video.volume = Math.min(1, video.volume + 0.1);
                volumeSlider.value = video.volume * 100;
                updateVolumeIcon();
                break;
            case 'ArrowDown':
                e.preventDefault();
                video.volume = Math.max(0, video.volume - 0.1);
                volumeSlider.value = video.volume * 100;
                updateVolumeIcon();
                break;
            case 'KeyF':
                e.preventDefault();
                fullscreenBtn.click();
                break;
            case 'KeyM':
                e.preventDefault();
                volumeBtn.click();
                break;
        }
    });
    
    // Bookmark functionality
    const videoId = new URLSearchParams(window.location.search).get('id');
    const isBookmarked = localStorage.getItem('video_bookmark_' + videoId) === 'true';
    
    if (isBookmarked) {
        bookmarkBtn.classList.add('active');
        bookmarkBtn.querySelector('i').className = 'fas fa-bookmark';
    }
    
    bookmarkBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const isCurrentlyBookmarked = this.classList.contains('active');
        
        if (isCurrentlyBookmarked) {
            this.classList.remove('active');
            icon.className = 'far fa-bookmark';
            localStorage.removeItem('video_bookmark_' + videoId);
        } else {
            this.classList.add('active');
            icon.className = 'fas fa-bookmark';
            localStorage.setItem('video_bookmark_' + videoId, 'true');
        }
    });
    
    // Video actions
    const likeBtn = document.getElementById('likeBtn');
    const shareBtn = document.getElementById('shareBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    
    likeBtn.addEventListener('click', function() {
        this.classList.toggle('active');
        const count = this.querySelector('.count');
        let currentCount = parseInt(count.textContent);
        count.textContent = this.classList.contains('active') ? currentCount + 1 : Math.max(0, currentCount - 1);
    });
    
    shareBtn.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo htmlspecialchars($res->LessonTitle); ?>',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Đã sao chép liên kết!');
            });
        }
    });
    
    downloadBtn.addEventListener('click', function() {
        const a = document.createElement('a');
        a.href = video.src;
        a.download = '<?php echo htmlspecialchars($res->LessonTitle); ?>.mp4';
        a.click();
    });
    
    // Initialize
    showControls();
});
</script> 
		