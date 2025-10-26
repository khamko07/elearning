/**
 * Keyboard Navigation Enhancement
 * Provides comprehensive keyboard navigation support for the E-Learning system
 */

class KeyboardNavigation {
    constructor() {
        this.focusableElements = [
            'a[href]',
            'button:not([disabled])',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])',
            '[contenteditable="true"]'
        ].join(', ');
        
        this.trapStack = [];
        this.lastFocusedElement = null;
        this.keyboardUser = false;
        
        this.init();
    }
    
    init() {
        this.detectKeyboardUser();
        this.setupGlobalKeyboardHandlers();
        this.setupFocusManagement();
        this.setupSkipLinks();
        this.setupModalFocusTraps();
        this.setupDropdownNavigation();
        this.setupTableNavigation();
        this.setupFormNavigation();
    }
    
    // Detect if user is using keyboard for navigation
    detectKeyboardUser() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                this.keyboardUser = true;
                document.body.classList.add('keyboard-nav-active');
            }
        });
        
        document.addEventListener('mousedown', () => {
            this.keyboardUser = false;
            document.body.classList.remove('keyboard-nav-active');
        });
    }
    
    // Global keyboard shortcuts
    setupGlobalKeyboardHandlers() {
        document.addEventListener('keydown', (e) => {
            // Alt + M: Go to main content
            if (e.altKey && e.key === 'm') {
                e.preventDefault();
                this.focusMainContent();
            }
            
            // Alt + N: Go to navigation
            if (e.altKey && e.key === 'n') {
                e.preventDefault();
                this.focusNavigation();
            }
            
            // Alt + S: Go to search
            if (e.altKey && e.key === 's') {
                e.preventDefault();
                this.focusSearch();
            }
            
            // Escape: Close modals, dropdowns, etc.
            if (e.key === 'Escape') {
                this.handleEscape();
            }
            
            // F6: Cycle through page regions
            if (e.key === 'F6') {
                e.preventDefault();
                this.cyclePageRegions();
            }
        });
    }
    
    // Enhanced focus management
    setupFocusManagement() {
        // Store last focused element before page navigation
        window.addEventListener('beforeunload', () => {
            const activeElement = document.activeElement;
            if (activeElement && activeElement !== document.body) {
                sessionStorage.setItem('lastFocusedElement', this.getElementSelector(activeElement));
            }
        });
        
        // Restore focus after page load
        window.addEventListener('load', () => {
            const lastFocusedSelector = sessionStorage.getItem('lastFocusedElement');
            if (lastFocusedSelector) {
                const element = document.querySelector(lastFocusedSelector);
                if (element) {
                    setTimeout(() => {
                        element.focus();
                    }, 100);
                }
                sessionStorage.removeItem('lastFocusedElement');
            }
        });
        
        // Focus management for dynamic content
        this.observeFocusableElements();
    }
    
    // Setup skip links functionality
    setupSkipLinks() {
        const skipLinks = document.querySelectorAll('.skip-link');
        
        skipLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                
                if (target) {
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Make target focusable if it's not already
                    if (!target.hasAttribute('tabindex')) {
                        target.setAttribute('tabindex', '-1');
                        target.addEventListener('blur', () => {
                            target.removeAttribute('tabindex');
                        }, { once: true });
                    }
                }
            });
        });
    }
    
    // Modal focus trap
    setupModalFocusTraps() {
        // Observe for modal creation
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        const modals = node.matches?.('.modal') ? [node] : node.querySelectorAll?.('.modal') || [];
                        modals.forEach(modal => {
                            if (modal.classList.contains('show') || modal.style.display === 'block') {
                                this.trapFocus(modal);
                            }
                        });
                    }
                });
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
        
        // Handle existing modals
        document.addEventListener('shown.bs.modal', (e) => {
            this.trapFocus(e.target);
        });
        
        document.addEventListener('hidden.bs.modal', (e) => {
            this.releaseFocusTrap(e.target);
        });
    }
    
    // Dropdown keyboard navigation
    setupDropdownNavigation() {
        document.addEventListener('keydown', (e) => {
            const dropdown = e.target.closest('.dropdown');
            if (!dropdown) return;
            
            const toggle = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu');
            const items = menu ? Array.from(menu.querySelectorAll('.dropdown-item:not(.disabled)')) : [];
            
            if (!items.length) return;
            
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (e.target === toggle) {
                        items[0].focus();
                    } else {
                        const currentIndex = items.indexOf(e.target);
                        const nextIndex = (currentIndex + 1) % items.length;
                        items[nextIndex].focus();
                    }
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    if (e.target === toggle) {
                        items[items.length - 1].focus();
                    } else {
                        const currentIndex = items.indexOf(e.target);
                        const prevIndex = currentIndex === 0 ? items.length - 1 : currentIndex - 1;
                        items[prevIndex].focus();
                    }
                    break;
                    
                case 'Home':
                    if (items.includes(e.target)) {
                        e.preventDefault();
                        items[0].focus();
                    }
                    break;
                    
                case 'End':
                    if (items.includes(e.target)) {
                        e.preventDefault();
                        items[items.length - 1].focus();
                    }
                    break;
                    
                case 'Escape':
                    if (menu && menu.classList.contains('show')) {
                        e.preventDefault();
                        toggle.click(); // Close dropdown
                        toggle.focus();
                    }
                    break;
            }
        });
    }
    
    // Table keyboard navigation
    setupTableNavigation() {
        document.addEventListener('keydown', (e) => {
            const table = e.target.closest('table');
            if (!table) return;
            
            const cell = e.target.closest('td, th');
            if (!cell) return;
            
            const row = cell.parentElement;
            const rows = Array.from(table.querySelectorAll('tr'));
            const cells = Array.from(row.children);
            
            const rowIndex = rows.indexOf(row);
            const cellIndex = cells.indexOf(cell);
            
            let targetCell = null;
            
            switch (e.key) {
                case 'ArrowRight':
                    targetCell = cells[cellIndex + 1];
                    break;
                    
                case 'ArrowLeft':
                    targetCell = cells[cellIndex - 1];
                    break;
                    
                case 'ArrowDown':
                    const nextRow = rows[rowIndex + 1];
                    if (nextRow) {
                        targetCell = nextRow.children[cellIndex];
                    }
                    break;
                    
                case 'ArrowUp':
                    const prevRow = rows[rowIndex - 1];
                    if (prevRow) {
                        targetCell = prevRow.children[cellIndex];
                    }
                    break;
                    
                case 'Home':
                    if (e.ctrlKey) {
                        targetCell = rows[0].children[0];
                    } else {
                        targetCell = cells[0];
                    }
                    break;
                    
                case 'End':
                    if (e.ctrlKey) {
                        const lastRow = rows[rows.length - 1];
                        targetCell = lastRow.children[lastRow.children.length - 1];
                    } else {
                        targetCell = cells[cells.length - 1];
                    }
                    break;
            }
            
            if (targetCell) {
                e.preventDefault();
                const focusableElement = targetCell.querySelector(this.focusableElements) || targetCell;
                if (focusableElement.tabIndex === undefined || focusableElement.tabIndex === -1) {
                    focusableElement.tabIndex = 0;
                }
                focusableElement.focus();
            }
        });
    }
    
    // Form keyboard navigation enhancements
    setupFormNavigation() {
        document.addEventListener('keydown', (e) => {
            const form = e.target.closest('form');
            if (!form) return;
            
            // Ctrl + Enter: Submit form
            if (e.ctrlKey && e.key === 'Enter') {
                const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitButton) {
                    e.preventDefault();
                    submitButton.click();
                }
            }
            
            // Handle radio button groups
            if (e.target.type === 'radio') {
                const radioGroup = form.querySelectorAll(`input[name="${e.target.name}"]`);
                const radios = Array.from(radioGroup);
                const currentIndex = radios.indexOf(e.target);
                
                let targetIndex = -1;
                
                switch (e.key) {
                    case 'ArrowDown':
                    case 'ArrowRight':
                        e.preventDefault();
                        targetIndex = (currentIndex + 1) % radios.length;
                        break;
                        
                    case 'ArrowUp':
                    case 'ArrowLeft':
                        e.preventDefault();
                        targetIndex = currentIndex === 0 ? radios.length - 1 : currentIndex - 1;
                        break;
                }
                
                if (targetIndex !== -1) {
                    radios[targetIndex].checked = true;
                    radios[targetIndex].focus();
                    radios[targetIndex].dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    }
    
    // Focus trap implementation
    trapFocus(container) {
        const focusableElements = container.querySelectorAll(this.focusableElements);
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        if (!firstElement) return;
        
        // Store the element that was focused before the trap
        this.lastFocusedElement = document.activeElement;
        
        // Focus the first element
        firstElement.focus();
        
        const trapHandler = (e) => {
            if (e.key === 'Tab') {
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
            }
        };
        
        container.addEventListener('keydown', trapHandler);
        
        // Store trap info for cleanup
        this.trapStack.push({
            container,
            handler: trapHandler,
            lastFocused: this.lastFocusedElement
        });
    }
    
    // Release focus trap
    releaseFocusTrap(container) {
        const trapIndex = this.trapStack.findIndex(trap => trap.container === container);
        if (trapIndex === -1) return;
        
        const trap = this.trapStack[trapIndex];
        container.removeEventListener('keydown', trap.handler);
        
        // Restore focus to the element that was focused before the trap
        if (trap.lastFocused && trap.lastFocused !== document.body) {
            trap.lastFocused.focus();
        }
        
        this.trapStack.splice(trapIndex, 1);
    }
    
    // Utility functions
    focusMainContent() {
        const mainContent = document.querySelector('main, [role="main"], #main-content, #main-dashboard, #admin-main-content');
        if (mainContent) {
            if (!mainContent.hasAttribute('tabindex')) {
                mainContent.setAttribute('tabindex', '-1');
            }
            mainContent.focus();
            mainContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    focusNavigation() {
        const nav = document.querySelector('nav, [role="navigation"], .navbar, .admin-sidebar');
        if (nav) {
            const firstLink = nav.querySelector('a, button');
            if (firstLink) {
                firstLink.focus();
            }
        }
    }
    
    focusSearch() {
        const searchInput = document.querySelector('input[type="search"], .search-input, #search');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    handleEscape() {
        // Close modals
        const openModal = document.querySelector('.modal.show');
        if (openModal) {
            const closeButton = openModal.querySelector('.btn-close, [data-bs-dismiss="modal"]');
            if (closeButton) {
                closeButton.click();
            }
            return;
        }
        
        // Close dropdowns
        const openDropdown = document.querySelector('.dropdown-menu.show');
        if (openDropdown) {
            const toggle = openDropdown.previousElementSibling;
            if (toggle) {
                toggle.click();
                toggle.focus();
            }
            return;
        }
        
        // Clear search
        const searchInput = document.querySelector('.search-input');
        if (searchInput && searchInput === document.activeElement && searchInput.value) {
            const clearButton = document.querySelector('.search-clear');
            if (clearButton) {
                clearButton.click();
            }
        }
    }
    
    cyclePageRegions() {
        const regions = [
            'header, [role="banner"]',
            'nav, [role="navigation"]',
            'main, [role="main"]',
            'aside, [role="complementary"]',
            'footer, [role="contentinfo"]'
        ];
        
        let currentRegion = null;
        const activeElement = document.activeElement;
        
        // Find current region
        for (const selector of regions) {
            const region = document.querySelector(selector);
            if (region && region.contains(activeElement)) {
                currentRegion = region;
                break;
            }
        }
        
        // Find next region
        let nextRegionIndex = 0;
        if (currentRegion) {
            const currentIndex = regions.findIndex(selector => 
                document.querySelector(selector) === currentRegion
            );
            nextRegionIndex = (currentIndex + 1) % regions.length;
        }
        
        // Focus next region
        for (let i = 0; i < regions.length; i++) {
            const regionIndex = (nextRegionIndex + i) % regions.length;
            const region = document.querySelector(regions[regionIndex]);
            
            if (region) {
                const focusableElement = region.querySelector(this.focusableElements);
                if (focusableElement) {
                    focusableElement.focus();
                    break;
                } else {
                    if (!region.hasAttribute('tabindex')) {
                        region.setAttribute('tabindex', '-1');
                    }
                    region.focus();
                    break;
                }
            }
        }
    }
    
    observeFocusableElements() {
        // Observe for dynamically added focusable elements
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        // Add keyboard event listeners to new elements
                        const focusableElements = node.matches?.(this.focusableElements) 
                            ? [node] 
                            : node.querySelectorAll?.(this.focusableElements) || [];
                            
                        focusableElements.forEach(element => {
                            this.enhanceElement(element);
                        });
                    }
                });
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
    
    enhanceElement(element) {
        // Add focus enhancement for dynamically created elements
        if (!element.hasAttribute('data-keyboard-enhanced')) {
            element.setAttribute('data-keyboard-enhanced', 'true');
            
            // Add focus event listeners for better UX
            element.addEventListener('focus', () => {
                if (this.keyboardUser) {
                    element.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest',
                        inline: 'nearest'
                    });
                }
            });
        }
    }
    
    getElementSelector(element) {
        if (element.id) {
            return `#${element.id}`;
        }
        
        if (element.className) {
            const classes = element.className.split(' ').filter(c => c.trim());
            if (classes.length > 0) {
                return `.${classes.join('.')}`;
            }
        }
        
        // Fallback to tag name with index
        const siblings = Array.from(element.parentElement?.children || []);
        const index = siblings.indexOf(element);
        return `${element.tagName.toLowerCase()}:nth-child(${index + 1})`;
    }
}

// Initialize keyboard navigation when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.keyboardNav = new KeyboardNavigation();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = KeyboardNavigation;
}