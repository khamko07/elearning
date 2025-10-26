/**
 * Theme Manager
 * Handles dark/light mode switching and user preferences
 */

class ThemeManager {
  constructor() {
    this.storageKey = 'theme-preference';
    this.init();
  }

  init() {
    // Get saved theme or detect system preference
    const savedTheme = localStorage.getItem(this.storageKey);
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    const initialTheme = savedTheme || systemTheme;

    // Apply initial theme
    this.setTheme(initialTheme);

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (!localStorage.getItem(this.storageKey)) {
        this.setTheme(e.matches ? 'dark' : 'light');
      }
    });

    // Setup theme toggle buttons
    this.setupToggleButtons();
  }

  setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(this.storageKey, theme);
    
    // Update toggle button states
    this.updateToggleButtons(theme);
    
    // Dispatch custom event for other components
    window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
  }

  toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    this.setTheme(newTheme);
  }

  getCurrentTheme() {
    return document.documentElement.getAttribute('data-theme') || 'light';
  }

  setupToggleButtons() {
    // Find all theme toggle buttons
    const toggleButtons = document.querySelectorAll('[data-theme-toggle]');
    
    toggleButtons.forEach(button => {
      button.addEventListener('click', () => {
        this.toggleTheme();
      });
    });
  }

  updateToggleButtons(theme) {
    const toggleButtons = document.querySelectorAll('[data-theme-toggle]');
    
    toggleButtons.forEach(button => {
      const icon = button.querySelector('i');
      if (icon) {
        if (theme === 'dark') {
          icon.className = 'fas fa-sun';
          button.setAttribute('title', 'Switch to light mode');
        } else {
          icon.className = 'fas fa-moon';
          button.setAttribute('title', 'Switch to dark mode');
        }
      }
    });
  }

  // Create a theme toggle button
  createToggleButton(className = 'btn btn-ghost') {
    const button = document.createElement('button');
    button.className = className;
    button.setAttribute('data-theme-toggle', '');
    button.setAttribute('aria-label', 'Toggle theme');
    
    const icon = document.createElement('i');
    icon.className = this.getCurrentTheme() === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    
    button.appendChild(icon);
    return button;
  }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.themeManager = new ThemeManager();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = ThemeManager;
}