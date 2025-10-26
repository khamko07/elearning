/**
 * Admin Sidebar JavaScript
 * Handles sidebar collapse, mobile menu, and admin-specific interactions
 */

class AdminSidebar {
  constructor() {
    this.sidebar = document.getElementById('adminSidebar');
    this.sidebarToggle = document.getElementById('sidebarToggle');
    this.mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    this.sidebarOverlay = document.getElementById('sidebarOverlay');
    this.adminMain = document.querySelector('.admin-main');
    
    this.isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    this.isMobile = window.innerWidth <= 1024;
    
    this.init();
  }

  init() {
    this.setupSidebarToggle();
    this.setupMobileSidebar();
    this.setupResponsive();
    this.setupNavigation();
    this.setupTooltips();
    this.restoreState();
  }

  setupSidebarToggle() {
    if (!this.sidebarToggle || !this.sidebar) return;

    this.sidebarToggle.addEventListener('click', () => {
      this.toggleSidebar();
    });
  }

  setupMobileSidebar() {
    if (!this.mobileSidebarToggle || !this.sidebar) return;

    // Mobile toggle button
    this.mobileSidebarToggle.addEventListener('click', () => {
      this.openMobileSidebar();
    });

    // Overlay click to close
    if (this.sidebarOverlay) {
      this.sidebarOverlay.addEventListener('click', () => {
        this.closeMobileSidebar();
      });
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.sidebar.classList.contains('mobile-open')) {
        this.closeMobileSidebar();
      }
    });
  }

  setupResponsive() {
    let resizeTimeout;
    
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        const wasMobile = this.isMobile;
        this.isMobile = window.innerWidth <= 1024;
        
        if (wasMobile !== this.isMobile) {
          this.handleResponsiveChange();
        }
      }, 150);
    });
  }

  setupNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        // Remove active class from all links
        navLinks.forEach(l => l.classList.remove('active'));
        
        // Add active class to clicked link
        link.classList.add('active');
        
        // Close mobile sidebar if open
        if (this.isMobile && this.sidebar.classList.contains('mobile-open')) {
          this.closeMobileSidebar();
        }
        
        // Store active navigation
        localStorage.setItem('active-nav', link.getAttribute('href'));
      });
    });
  }

  setupTooltips() {
    if (!this.sidebar) return;

    const navLinks = this.sidebar.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      const navText = link.querySelector('.nav-text');
      if (navText) {
        link.setAttribute('title', navText.textContent);
      }
    });
  }

  toggleSidebar() {
    if (this.isMobile) return;
    
    this.isCollapsed = !this.isCollapsed;
    this.updateSidebarState();
    this.saveState();
  }

  openMobileSidebar() {
    if (!this.isMobile) return;
    
    this.sidebar.classList.add('mobile-open');
    if (this.sidebarOverlay) {
      this.sidebarOverlay.classList.add('active');
    }
    document.body.style.overflow = 'hidden';
    
    // Focus management
    const firstNavLink = this.sidebar.querySelector('.nav-link');
    if (firstNavLink) {
      setTimeout(() => firstNavLink.focus(), 100);
    }
  }

  closeMobileSidebar() {
    this.sidebar.classList.remove('mobile-open');
    if (this.sidebarOverlay) {
      this.sidebarOverlay.classList.remove('active');
    }
    document.body.style.overflow = '';
    
    // Return focus to mobile toggle
    if (this.mobileSidebarToggle) {
      this.mobileSidebarToggle.focus();
    }
  }

  updateSidebarState() {
    if (this.isCollapsed) {
      this.sidebar.classList.add('collapsed');
    } else {
      this.sidebar.classList.remove('collapsed');
    }
    
    // Dispatch event for other components
    window.dispatchEvent(new CustomEvent('sidebarToggle', {
      detail: { collapsed: this.isCollapsed }
    }));
  }

  handleResponsiveChange() {
    if (this.isMobile) {
      // Mobile mode
      this.sidebar.classList.remove('collapsed');
      this.closeMobileSidebar();
    } else {
      // Desktop mode
      this.sidebar.classList.remove('mobile-open');
      if (this.sidebarOverlay) {
        this.sidebarOverlay.classList.remove('active');
      }
      document.body.style.overflow = '';
      
      // Restore collapsed state
      this.updateSidebarState();
    }
  }

  saveState() {
    localStorage.setItem('sidebar-collapsed', this.isCollapsed.toString());
  }

  restoreState() {
    // Restore collapsed state
    if (!this.isMobile) {
      this.updateSidebarState();
    }
    
    // Restore active navigation
    const activeNav = localStorage.getItem('active-nav');
    if (activeNav) {
      const activeLink = document.querySelector(`[href="${activeNav}"]`);
      if (activeLink) {
        activeLink.classList.add('active');
      }
    }
  }

  // Public methods
  collapse() {
    if (this.isMobile) return;
    this.isCollapsed = true;
    this.updateSidebarState();
    this.saveState();
  }

  expand() {
    if (this.isMobile) return;
    this.isCollapsed = false;
    this.updateSidebarState();
    this.saveState();
  }

  updateBadge(navSelector, count) {
    const navLink = document.querySelector(navSelector);
    if (!navLink) return;
    
    let badge = navLink.querySelector('.nav-badge');
    
    if (count > 0) {
      if (!badge) {
        badge = document.createElement('span');
        badge.className = 'nav-badge';
        navLink.appendChild(badge);
      }
      badge.textContent = count > 99 ? '99+' : count.toString();
    } else if (badge) {
      badge.remove();
    }
  }

  setActiveNav(href) {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === href) {
        link.classList.add('active');
      }
    });
    localStorage.setItem('active-nav', href);
  }

  showNotification(message, type = 'info') {
    // This could integrate with a notification system
    console.log(`Admin Notification (${type}): ${message}`);
  }
}

// Initialize admin sidebar when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  // Only initialize if we're in admin area
  if (document.getElementById('adminSidebar')) {
    window.adminSidebar = new AdminSidebar();
  }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = AdminSidebar;
}