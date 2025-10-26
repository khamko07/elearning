/**
 * Lazy Loading Implementation
 * Provides comprehensive lazy loading for images, videos, and content
 */

class LazyLoader {
    constructor(options = {}) {
        this.options = {
            imageSelector: 'img[data-src], img[loading="lazy"]',
            videoSelector: 'video[data-src]',
            contentSelector: '[data-lazy-content]',
            rootMargin: '50px 0px',
            threshold: 0.1,
            enableNativeLazy: true,
            placeholderClass: 'lazy-placeholder',
            loadingClass: 'lazy-loading',
            loadedClass: 'lazy-loaded',
            errorClass: 'lazy-error',
            ...options
        };
        
        this.observer = null;
        this.loadedElements = new Set();
        this.loadingElements = new Set();
        
        this.init();
    }
    
    init() {
        // Check for Intersection Observer support
        if (!('IntersectionObserver' in window)) {
            this.loadAllElements();
            return;
        }
        
        this.createObserver();
        this.observeElements();
        this.setupNativeLazyLoading();
        this.observeNewElements();
    }
    
    createObserver() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadElement(entry.target);
                    this.observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: this.options.rootMargin,
            threshold: this.options.threshold
        });
    }
    
    observeElements() {
        // Observe images
        const images = document.querySelectorAll(this.options.imageSelector);
        images.forEach(img => this.observeImage(img));
        
        // Observe videos
        const videos = document.querySelectorAll(this.options.videoSelector);
        videos.forEach(video => this.observeVideo(video));
        
        // Observe content sections
        const contentSections = document.querySelectorAll(this.options.contentSelector);
        contentSections.forEach(section => this.observeContent(section));
    }
    
    observeImage(img) {
        if (this.loadedElements.has(img)) return;
        
        // Skip if native lazy loading is supported and enabled
        if (this.options.enableNativeLazy && 'loading' in HTMLImageElement.prototype) {
            if (img.loading === 'lazy') {
                this.setupImagePlaceholder(img);
                return;
            }
        }
        
        // Setup placeholder
        this.setupImagePlaceholder(img);
        
        // Observe with Intersection Observer
        this.observer.observe(img);
    }
    
    observeVideo(video) {
        if (this.loadedElements.has(video)) return;
        
        this.setupVideoPlaceholder(video);
        this.observer.observe(video);
    }
    
    observeContent(section) {
        if (this.loadedElements.has(section)) return;
        
        this.setupContentPlaceholder(section);
        this.observer.observe(section);
    }
    
    setupImagePlaceholder(img) {
        if (img.classList.contains(this.options.placeholderClass)) return;
        
        img.classList.add(this.options.placeholderClass);
        
        // Create placeholder based on image dimensions
        const width = img.getAttribute('width') || img.dataset.width || 300;
        const height = img.getAttribute('height') || img.dataset.height || 200;
        
        // Generate placeholder SVG
        const placeholder = this.generateImagePlaceholder(width, height);
        
        // Set placeholder as src if no src exists
        if (!img.src || img.src === window.location.href) {
            img.src = placeholder;
        }
        
        // Store original src
        if (img.dataset.src) {
            img.dataset.originalSrc = img.dataset.src;
        }
    }
    
    setupVideoPlaceholder(video) {
        if (video.classList.contains(this.options.placeholderClass)) return;
        
        video.classList.add(this.options.placeholderClass);
        
        // Create video poster if not exists
        if (!video.poster && video.dataset.poster) {
            video.poster = video.dataset.poster;
        }
        
        // Disable autoplay until loaded
        video.preload = 'none';
    }
    
    setupContentPlaceholder(section) {
        if (section.classList.contains(this.options.placeholderClass)) return;
        
        section.classList.add(this.options.placeholderClass);
        
        // Create skeleton placeholder
        const skeleton = this.createSkeletonPlaceholder(section);
        section.appendChild(skeleton);
    }
    
    loadElement(element) {
        if (this.loadingElements.has(element)) return;
        
        this.loadingElements.add(element);
        element.classList.add(this.options.loadingClass);
        
        if (element.tagName === 'IMG') {
            this.loadImage(element);
        } else if (element.tagName === 'VIDEO') {
            this.loadVideo(element);
        } else if (element.hasAttribute('data-lazy-content')) {
            this.loadContent(element);
        }
    }
    
    loadImage(img) {
        const src = img.dataset.src || img.dataset.originalSrc;
        if (!src) {
            this.onElementError(img);
            return;
        }
        
        // Create new image to preload
        const imageLoader = new Image();
        
        imageLoader.onload = () => {
            img.src = src;
            img.srcset = img.dataset.srcset || '';
            this.onImageLoaded(img);
        };
        
        imageLoader.onerror = () => {
            this.onElementError(img);
        };
        
        // Start loading
        imageLoader.src = src;
        
        // Handle srcset
        if (img.dataset.srcset) {
            imageLoader.srcset = img.dataset.srcset;
        }
    }
    
    loadVideo(video) {
        const src = video.dataset.src;
        if (!src) {
            this.onElementError(video);
            return;
        }
        
        // Create source element
        const source = document.createElement('source');
        source.src = src;
        source.type = video.dataset.type || 'video/mp4';
        
        video.appendChild(source);
        
        // Set preload to metadata
        video.preload = 'metadata';
        
        video.addEventListener('loadedmetadata', () => {
            this.onVideoLoaded(video);
        }, { once: true });
        
        video.addEventListener('error', () => {
            this.onElementError(video);
        }, { once: true });
        
        // Load the video
        video.load();
    }
    
    loadContent(section) {
        const contentUrl = section.dataset.lazyContent;
        const contentType = section.dataset.contentType || 'html';
        
        if (!contentUrl) {
            this.onElementError(section);
            return;
        }
        
        // Fetch content
        fetch(contentUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return contentType === 'json' ? response.json() : response.text();
            })
            .then(content => {
                this.onContentLoaded(section, content, contentType);
            })
            .catch(error => {
                console.error('Lazy loading error:', error);
                this.onElementError(section);
            });
    }
    
    onImageLoaded(img) {
        img.classList.remove(this.options.placeholderClass, this.options.loadingClass);
        img.classList.add(this.options.loadedClass);
        
        // Remove data attributes
        delete img.dataset.src;
        delete img.dataset.srcset;
        delete img.dataset.originalSrc;
        
        this.loadingElements.delete(img);
        this.loadedElements.add(img);
        
        // Trigger custom event
        img.dispatchEvent(new CustomEvent('lazyloaded', {
            bubbles: true,
            detail: { element: img, type: 'image' }
        }));
    }
    
    onVideoLoaded(video) {
        video.classList.remove(this.options.placeholderClass, this.options.loadingClass);
        video.classList.add(this.options.loadedClass);
        
        // Remove data attributes
        delete video.dataset.src;
        delete video.dataset.type;
        
        this.loadingElements.delete(video);
        this.loadedElements.add(video);
        
        // Trigger custom event
        video.dispatchEvent(new CustomEvent('lazyloaded', {
            bubbles: true,
            detail: { element: video, type: 'video' }
        }));
    }
    
    onContentLoaded(section, content, contentType) {
        // Remove skeleton placeholder
        const skeleton = section.querySelector('.skeleton-placeholder');
        if (skeleton) {
            skeleton.remove();
        }
        
        // Insert content
        if (contentType === 'json') {
            this.renderJsonContent(section, content);
        } else {
            section.innerHTML = content;
        }
        
        section.classList.remove(this.options.placeholderClass, this.options.loadingClass);
        section.classList.add(this.options.loadedClass);
        
        // Remove data attributes
        delete section.dataset.lazyContent;
        delete section.dataset.contentType;
        
        this.loadingElements.delete(section);
        this.loadedElements.add(section);
        
        // Observe new elements in loaded content
        this.observeElements();
        
        // Trigger custom event
        section.dispatchEvent(new CustomEvent('lazyloaded', {
            bubbles: true,
            detail: { element: section, type: 'content', content }
        }));
    }
    
    onElementError(element) {
        element.classList.remove(this.options.placeholderClass, this.options.loadingClass);
        element.classList.add(this.options.errorClass);
        
        this.loadingElements.delete(element);
        
        // Show error placeholder
        if (element.tagName === 'IMG') {
            element.src = this.generateErrorPlaceholder();
            element.alt = 'Không thể tải hình ảnh';
        }
        
        // Trigger custom event
        element.dispatchEvent(new CustomEvent('lazyerror', {
            bubbles: true,
            detail: { element, type: element.tagName.toLowerCase() }
        }));
    }
    
    generateImagePlaceholder(width, height) {
        const svg = `
            <svg width="${width}" height="${height}" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="shimmer" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#f0f0f0;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#e0e0e0;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f0f0f0;stop-opacity:1" />
                        <animateTransform attributeName="gradientTransform" type="translate" 
                            values="-100 0;100 0;-100 0" dur="2s" repeatCount="indefinite"/>
                    </linearGradient>
                </defs>
                <rect width="100%" height="100%" fill="url(#shimmer)" />
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" 
                    fill="#999" font-family="Arial, sans-serif" font-size="14">
                    Đang tải...
                </text>
            </svg>
        `;
        
        return `data:image/svg+xml;base64,${btoa(svg)}`;
    }
    
    generateErrorPlaceholder() {
        const svg = `
            <svg width="300" height="200" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#f5f5f5" stroke="#ddd" stroke-width="1"/>
                <text x="50%" y="45%" text-anchor="middle" dy=".3em" 
                    fill="#999" font-family="Arial, sans-serif" font-size="14">
                    ⚠️
                </text>
                <text x="50%" y="60%" text-anchor="middle" dy=".3em" 
                    fill="#999" font-family="Arial, sans-serif" font-size="12">
                    Không thể tải hình ảnh
                </text>
            </svg>
        `;
        
        return `data:image/svg+xml;base64,${btoa(svg)}`;
    }
    
    createSkeletonPlaceholder(element) {
        const skeleton = document.createElement('div');
        skeleton.className = 'skeleton-placeholder';
        
        // Determine skeleton type based on element
        const skeletonType = element.dataset.skeletonType || 'text';
        
        switch (skeletonType) {
            case 'card':
                skeleton.innerHTML = this.createCardSkeleton();
                break;
            case 'list':
                skeleton.innerHTML = this.createListSkeleton();
                break;
            case 'table':
                skeleton.innerHTML = this.createTableSkeleton();
                break;
            default:
                skeleton.innerHTML = this.createTextSkeleton();
        }
        
        return skeleton;
    }
    
    createTextSkeleton() {
        return `
            <div class="skeleton-line skeleton-line-full"></div>
            <div class="skeleton-line skeleton-line-75"></div>
            <div class="skeleton-line skeleton-line-50"></div>
        `;
    }
    
    createCardSkeleton() {
        return `
            <div class="skeleton-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line skeleton-line-75"></div>
                    <div class="skeleton-line skeleton-line-50"></div>
                    <div class="skeleton-line skeleton-line-25"></div>
                </div>
            </div>
        `;
    }
    
    createListSkeleton() {
        return `
            <div class="skeleton-list">
                ${Array(5).fill().map(() => `
                    <div class="skeleton-list-item">
                        <div class="skeleton-avatar"></div>
                        <div class="skeleton-content">
                            <div class="skeleton-line skeleton-line-75"></div>
                            <div class="skeleton-line skeleton-line-50"></div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    createTableSkeleton() {
        return `
            <div class="skeleton-table">
                <div class="skeleton-table-header">
                    ${Array(4).fill().map(() => '<div class="skeleton-line skeleton-line-full"></div>').join('')}
                </div>
                ${Array(5).fill().map(() => `
                    <div class="skeleton-table-row">
                        ${Array(4).fill().map(() => '<div class="skeleton-line skeleton-line-75"></div>').join('')}
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    renderJsonContent(section, data) {
        // Basic JSON content rendering
        // This should be customized based on your data structure
        if (Array.isArray(data)) {
            const list = document.createElement('ul');
            data.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = typeof item === 'string' ? item : JSON.stringify(item);
                list.appendChild(listItem);
            });
            section.appendChild(list);
        } else if (typeof data === 'object') {
            const pre = document.createElement('pre');
            pre.textContent = JSON.stringify(data, null, 2);
            section.appendChild(pre);
        } else {
            section.textContent = data;
        }
    }
    
    setupNativeLazyLoading() {
        if (!this.options.enableNativeLazy || !('loading' in HTMLImageElement.prototype)) {
            return;
        }
        
        // Add loading="lazy" to images that don't have it
        const images = document.querySelectorAll('img:not([loading])');
        images.forEach(img => {
            if (!img.src || img.dataset.src) {
                img.loading = 'lazy';
            }
        });
    }
    
    observeNewElements() {
        // Observe for dynamically added elements
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        // Check if the node itself matches
                        if (node.matches?.(this.options.imageSelector)) {
                            this.observeImage(node);
                        } else if (node.matches?.(this.options.videoSelector)) {
                            this.observeVideo(node);
                        } else if (node.matches?.(this.options.contentSelector)) {
                            this.observeContent(node);
                        }
                        
                        // Check for matching children
                        const images = node.querySelectorAll?.(this.options.imageSelector) || [];
                        const videos = node.querySelectorAll?.(this.options.videoSelector) || [];
                        const content = node.querySelectorAll?.(this.options.contentSelector) || [];
                        
                        images.forEach(img => this.observeImage(img));
                        videos.forEach(video => this.observeVideo(video));
                        content.forEach(section => this.observeContent(section));
                    }
                });
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
    
    loadAllElements() {
        // Fallback for browsers without Intersection Observer
        const allElements = [
            ...document.querySelectorAll(this.options.imageSelector),
            ...document.querySelectorAll(this.options.videoSelector),
            ...document.querySelectorAll(this.options.contentSelector)
        ];
        
        allElements.forEach(element => this.loadElement(element));
    }
    
    // Public methods
    loadElement(element) {
        if (this.observer) {
            this.observer.unobserve(element);
        }
        this.loadElement(element);
    }
    
    refresh() {
        this.observeElements();
    }
    
    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
        this.loadedElements.clear();
        this.loadingElements.clear();
    }
}

// Initialize lazy loading when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.lazyLoader = new LazyLoader({
        rootMargin: '100px 0px',
        threshold: 0.1
    });
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LazyLoader;
}