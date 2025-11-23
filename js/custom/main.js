/**
 * Main JavaScript File
 * E-Learning System UI Modernization
 * 
 * This file contains global JavaScript utilities and enhancements
 */

(function() {
  'use strict';

  // ============================================
  // Loading States
  // ============================================
  
  /**
   * Show loading overlay
   */
  function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.id = 'globalLoadingOverlay';
    overlay.innerHTML = '<div class="spinner spinner-lg"></div>';
    document.body.appendChild(overlay);
  }

  /**
   * Hide loading overlay
   */
  function hideLoading() {
    const overlay = document.getElementById('globalLoadingOverlay');
    if (overlay) {
      overlay.remove();
    }
  }

  /**
   * Add loading state to button
   */
  function setButtonLoading(button, isLoading) {
    if (isLoading) {
      button.classList.add('loading');
      button.disabled = true;
    } else {
      button.classList.remove('loading');
      button.disabled = false;
    }
  }

  // ============================================
  // Form Enhancements
  // ============================================
  
  /**
   * Enhance form submissions with loading states
   */
  document.addEventListener('submit', function(e) {
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
    
    if (submitBtn && !form.dataset.noLoading) {
      setButtonLoading(submitBtn, true);
      
      // Re-enable after 5 seconds as fallback
      setTimeout(() => {
        setButtonLoading(submitBtn, false);
      }, 5000);
    }
  });

  // ============================================
  // Smooth Scroll
  // ============================================
  
  /**
   * Smooth scroll for anchor links
   */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href !== '#' && href.length > 1) {
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
  });

  // ============================================
  // AJAX Enhancements
  // ============================================
  
  /**
   * Enhanced AJAX with loading states
   */
  if (typeof jQuery !== 'undefined') {
    // Show loading on AJAX start
    $(document).ajaxStart(function() {
      // Optional: show global loading indicator
    });

    $(document).ajaxStop(function() {
      // Optional: hide global loading indicator
    });

    // Add loading to AJAX buttons
    $(document).on('click', '[data-ajax]', function() {
      const $btn = $(this);
      if (!$btn.data('no-loading')) {
        setButtonLoading(this, true);
      }
    });
  }

  // ============================================
  // Accessibility Enhancements
  // ============================================
  
  /**
   * Skip to main content
   */
  const skipLink = document.createElement('a');
  skipLink.href = '#content';
  skipLink.className = 'skip-to-main';
  skipLink.textContent = 'Skip to main content';
  document.body.insertBefore(skipLink, document.body.firstChild);

  /**
   * Keyboard navigation for dropdowns
   */
  document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.click();
      }
    });
  });

  // ============================================
  // Image Lazy Loading
  // ============================================
  
  /**
   * Lazy load images
   */
  if ('loading' in HTMLImageElement.prototype) {
    // Native lazy loading supported
    document.querySelectorAll('img[data-src]').forEach(img => {
      img.src = img.dataset.src;
      img.loading = 'lazy';
    });
  } else {
    // Fallback for older browsers
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.classList.remove('lazy');
          observer.unobserve(img);
        }
      });
    });

    document.querySelectorAll('img.lazy').forEach(img => {
      imageObserver.observe(img);
    });
  }

  // ============================================
  // Toast Notifications (if needed)
  // ============================================
  
  /**
   * Show toast notification
   */
  window.showToast = function(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} toast-notification`;
    toast.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      min-width: 300px;
      box-shadow: var(--shadow-xl);
      animation: slideInRight 0.3s ease-out;
    `;
    toast.innerHTML = `
      <div class="d-flex align-items-center">
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
        <span>${message}</span>
        <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
      </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
      toast.style.animation = 'slideOutRight 0.3s ease-out';
      setTimeout(() => toast.remove(), 300);
    }, 5000);
  };

  // ============================================
  // Export utilities
  // ============================================
  
  window.UIUtils = {
    showLoading,
    hideLoading,
    setButtonLoading,
    showToast
  };

  // ============================================
  // Animations
  // ============================================
  
  /**
   * Add fade-in animation to cards on load
   */
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card, .category-card, .content-card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 50);
    });
  });

})();

// Add CSS for toast animations
const style = document.createElement('style');
style.textContent = `
  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
  
  @keyframes slideOutRight {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(100%);
      opacity: 0;
    }
  }
`;
document.head.appendChild(style);

