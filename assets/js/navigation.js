/**
 * Navigation System JavaScript
 * Handles mobile menu, search, notifications, and user interactions
 */

class NavigationManager {
  constructor() {
    this.mobileMenuToggle = document.getElementById('mobileMenuToggle');
    this.mobileNavOverlay = document.getElementById('mobileNavOverlay');
    this.mobileNavClose = document.getElementById('mobileNavClose');
    this.searchInput = document.getElementById('searchInput');
    this.notificationBadge = document.querySelector('.notification-badge');
    
    this.init();
  }

  init() {
    this.setupMobileMenu();
    this.setupSearch();
    this.setupNotifications();
    this.setupUserMenu();
    this.setupScrollBehavior();
    this.setupKeyboardNavigation();
  }

  setupMobileMenu() {
    if (!this.mobileMenuToggle || !this.mobileNavOverlay) return;

    // Toggle mobile menu
    this.mobileMenuToggle.addEventListener('click', () => {
      this.toggleMobileMenu();
    });

    // Close mobile menu
    if (this.mobileNavClose) {
      this.mobileNavClose.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }

    // Close on overlay click
    this.mobileNavOverlay.addEventListener('click', (e) => {
      if (e.target === this.mobileNavOverlay) {
        this.closeMobileMenu();
      }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.mobileNavOverlay.classList.contains('active')) {
        this.closeMobileMenu();
      }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth > 992 && this.mobileNavOverlay.classList.contains('active')) {
        this.closeMobileMenu();
      }
    });
  }

  toggleMobileMenu() {
    const isActive = this.mobileNavOverlay.classList.contains('active');
    
    if (isActive) {
      this.closeMobileMenu();
    } else {
      this.openMobileMenu();
    }
  }

  openMobileMenu() {
    this.mobileNavOverlay.classList.add('active');
    this.mobileMenuToggle.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Focus management
    const firstFocusable = this.mobileNavOverlay.querySelector('button, a, input');
    if (firstFocusable) {
      setTimeout(() => firstFocusable.focus(), 100);
    }
  }

  closeMobileMenu() {
    this.mobileNavOverlay.classList.remove('active');
    this.mobileMenuToggle.classList.remove('active');
    document.body.style.overflow = '';
    
    // Return focus to toggle button
    this.mobileMenuToggle.focus();
  }

  setupSearch() {
    if (!this.searchInput) return;

    let searchTimeout;
    
    // Search input handling
    this.searchInput.addEventListener('input', (e) => {
      clearTimeout(searchTimeout);
      const query = e.target.value.trim();
      
      if (query.length >= 2) {
        searchTimeout = setTimeout(() => {
          this.performSearch(query);
        }, 300);
      }
    });

    // Search form submission
    const searchForm = this.searchInput.closest('form');
    if (searchForm) {
      searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const query = this.searchInput.value.trim();
        if (query) {
          this.performSearch(query);
        }
      });
    }

    // Search shortcuts
    document.addEventListener('keydown', (e) => {
      // Ctrl/Cmd + K to focus search
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        this.searchInput.focus();
      }
    });
  }

  performSearch(query) {
    console.log('Searching for:', query);
    
    // Show loading state
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
      const originalIcon = searchBtn.innerHTML;
      searchBtn.innerHTML = '<div class="loading-spinner" style="width: 14px; height: 14px;"></div>';
      
      // Simulate search delay
      setTimeout(() => {
        searchBtn.innerHTML = originalIcon;
        // Here you would typically redirect to search results or show results
        // For now, we'll just log the search
        this.showSearchResults(query);
      }, 500);
    }
  }

  showSearchResults(query) {
    // This would typically show search results
    // For demo purposes, we'll show a simple alert
    console.log(`Search results for: ${query}`);
    
    // In a real implementation, you might:
    // - Redirect to a search results page
    // - Show a dropdown with results
    // - Filter current page content
  }

  setupNotifications() {
    const notificationItems = document.querySelectorAll('.notification-item');
    const markAllReadBtn = document.querySelector('.mark-all-read');
    
    // Handle notification clicks
    notificationItems.forEach(item => {
      item.addEventListener('click', () => {
        this.markNotificationAsRead(item);
      });
    });

    // Mark all as read
    if (markAllReadBtn) {
      markAllReadBtn.addEventListener('click', () => {
        this.markAllNotificationsAsRead();
      });
    }

    // Update notification badge
    this.updateNotificationBadge();
  }

  markNotificationAsRead(notificationItem) {
    notificationItem.classList.remove('unread');
    this.updateNotificationBadge();
  }

  markAllNotificationsAsRead() {
    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
    unreadNotifications.forEach(item => {
      item.classList.remove('unread');
    });
    this.updateNotificationBadge();
  }

  updateNotificationBadge() {
    if (!this.notificationBadge) return;
    
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    
    if (unreadCount > 0) {
      this.notificationBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
      this.notificationBadge.style.display = 'flex';
    } else {
      this.notificationBadge.style.display = 'none';
    }
  }

  setupUserMenu() {
    const userMenuBtn = document.querySelector('.user-menu-btn');
    const userMenu = document.querySelector('.user-menu');
    
    if (!userMenuBtn || !userMenu) return;

    // Handle dropdown toggle
    userMenuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = userMenu.classList.contains('show');
      
      // Close all other dropdowns
      document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
        menu.classList.remove('show');
      });
      
      if (!isOpen) {
        userMenu.classList.add('show');
      }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', () => {
      userMenu.classList.remove('show');
    });

    // Prevent dropdown from closing when clicking inside
    userMenu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  setupScrollBehavior() {
    const header = document.getElementById('mainHeader');
    if (!header) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    const updateHeader = () => {
      const currentScrollY = window.scrollY;
      
      if (currentScrollY > 100) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }

      // Hide/show header on scroll
      if (currentScrollY > lastScrollY && currentScrollY > 200) {
        header.classList.add('hidden');
      } else {
        header.classList.remove('hidden');
      }

      lastScrollY = currentScrollY;
      ticking = false;
    };

    const requestTick = () => {
      if (!ticking) {
        requestAnimationFrame(updateHeader);
        ticking = true;
      }
    };

    window.addEventListener('scroll', requestTick);
  }

  setupKeyboardNavigation() {
    // Handle keyboard navigation for dropdowns
    document.addEventListener('keydown', (e) => {
      const activeDropdown = document.querySelector('.dropdown-menu.show');
      if (!activeDropdown) return;

      const focusableElements = activeDropdown.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
      const firstElement = focusableElements[0];
      const lastElement = focusableElements[focusableElements.length - 1];

      switch (e.key) {
        case 'Escape':
          activeDropdown.classList.remove('show');
          const trigger = document.querySelector(`[data-bs-toggle="dropdown"]`);
          if (trigger) trigger.focus();
          break;
          
        case 'Tab':
          if (e.shiftKey) {
            if (document.activeElement === firstElement) {
              e.preventDefault();
              lastElement.focus();
            }
          } else {
            if (document.activeElement === lastElement) {
              e.preventDefault();
              firstElement.focus();
            }
          }
          break;
          
        case 'ArrowDown':
          e.preventDefault();
          const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);
          const nextIndex = currentIndex < focusableElements.length - 1 ? currentIndex + 1 : 0;
          focusableElements[nextIndex].focus();
          break;
          
        case 'ArrowUp':
          e.preventDefault();
          const currentUpIndex = Array.from(focusableElements).indexOf(document.activeElement);
          const prevIndex = currentUpIndex > 0 ? currentUpIndex - 1 : focusableElements.length - 1;
          focusableElements[prevIndex].focus();
          break;
      }
    });
  }

  // Public methods for external use
  showNotification(message, type = 'info') {
    // This could be used to show toast notifications
    console.log(`Notification (${type}): ${message}`);
  }

  updateUserInfo(userData) {
    const userNameElements = document.querySelectorAll('.user-name');
    const userAvatarElements = document.querySelectorAll('.user-avatar, .user-avatar-large, .mobile-user-avatar');
    
    userNameElements.forEach(element => {
      element.textContent = userData.name;
    });
    
    userAvatarElements.forEach(element => {
      element.src = userData.avatar;
      element.alt = `Avatar của ${userData.name}`;
    });
  }
}

// Initialize navigation when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.navigationManager = new NavigationManager();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = NavigationManager;
}