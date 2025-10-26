# Design System Setup - UI/UX Refactor

## Overview

This document outlines the new design system setup for the E-Learning platform, transitioning from Bootstrap 3 to a modern design system with Bootstrap 5.

## Files Created/Updated

### CSS Architecture

1. **`assets/css/design-system.css`** - Core design system with CSS variables
   - Color palette (primary, secondary, neutral, semantic colors)
   - Typography scale (Inter + Poppins fonts)
   - Spacing system
   - Border radius, shadows, transitions
   - Dark theme support
   - Base reset and accessibility features

2. **`assets/css/components.css`** - Reusable UI components
   - Buttons (multiple variants and sizes)
   - Forms (inputs, labels, validation states)
   - Cards and layouts
   - Alerts and badges
   - Progress bars and loading states
   - Tooltips and interactive elements

3. **`assets/css/utilities.css`** - Atomic utility classes
   - Display utilities
   - Flexbox utilities
   - Position and layout
   - Spacing (margin/padding)
   - Typography utilities
   - Color utilities
   - Responsive utilities

4. **`assets/css/fonts.css`** - Font imports
   - Google Fonts (Inter, Poppins)
   - Font Awesome icons
   - Font display optimization

5. **`assets/css/main.css`** - Main entry point
   - Imports all design system files
   - Layout helpers (container, grid)
   - Authentication layouts
   - Dashboard layouts
   - Responsive adjustments

### JavaScript

1. **`assets/js/theme-manager.js`** - Theme switching functionality
   - Dark/light mode toggle
   - System preference detection
   - Local storage persistence
   - Dynamic theme switching

### Bootstrap 5

1. **`css/bootstrap5.min.css`** - Bootstrap 5.3.2 CSS
2. **`js/bootstrap5.min.js`** - Bootstrap 5.3.2 JavaScript

## Usage

### Including the Design System

Replace the old Bootstrap 3 includes with:

```html
<!-- Bootstrap 5 -->
<link href="css/bootstrap5.min.css" rel="stylesheet">

<!-- Our Design System -->
<link href="assets/css/main.css" rel="stylesheet">

<!-- Scripts -->
<script src="js/bootstrap5.min.js"></script>
<script src="assets/js/theme-manager.js"></script>
```

### Theme Toggle Button

Add a theme toggle button anywhere in your HTML:

```html
<button data-theme-toggle class="btn btn-ghost" title="Toggle theme">
    <i class="fas fa-moon"></i>
</button>
```

### Using Components

#### Authentication Layout
```html
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="logo.png" alt="Logo" class="auth-logo">
            <h1 class="auth-title">Đăng nhập</h1>
            <p class="auth-subtitle">Chào mừng trở lại!</p>
        </div>
        
        <form class="auth-form">
            <div class="form-group">
                <label class="form-label required">Email</label>
                <input type="email" class="form-input" placeholder="Nhập email...">
            </div>
            
            <button type="submit" class="btn btn-primary btn-full">
                Đăng nhập
            </button>
        </form>
    </div>
</div>
```

#### Dashboard Layout
```html
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Chào mừng!</h1>
        <p class="dashboard-subtitle">Hãy tiếp tục học tập</p>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>12</h3>
                <p>Bài học hoàn thành</p>
            </div>
        </div>
    </div>
</div>
```

## Color System

### Primary Colors
- `--primary-blue`: #2563eb
- `--primary-blue-light`: #3b82f6
- `--primary-blue-dark`: #1d4ed8

### Secondary Colors
- `--secondary-green`: #10b981
- `--secondary-orange`: #f59e0b
- `--secondary-red`: #ef4444

### Usage
```css
.my-element {
    background-color: var(--primary-blue);
    color: var(--text-primary);
    padding: var(--space-4);
    border-radius: var(--radius-lg);
}
```

## Typography

### Font Families
- Primary: Inter (body text)
- Heading: Poppins (headings)

### Font Sizes
- `--text-xs`: 0.75rem (12px)
- `--text-sm`: 0.875rem (14px)
- `--text-base`: 1rem (16px)
- `--text-lg`: 1.125rem (18px)
- `--text-xl`: 1.25rem (20px)
- `--text-2xl`: 1.5rem (24px)
- `--text-3xl`: 1.875rem (30px)
- `--text-4xl`: 2.25rem (36px)

## Spacing System

Uses a consistent 4px base unit:
- `--space-1`: 0.25rem (4px)
- `--space-2`: 0.5rem (8px)
- `--space-3`: 0.75rem (12px)
- `--space-4`: 1rem (16px)
- `--space-6`: 1.5rem (24px)
- `--space-8`: 2rem (32px)

## Dark Theme

The system automatically supports dark theme. Users can toggle between light and dark modes using the theme toggle button. The theme preference is saved in localStorage.

## Demo

Open `demo-new-design.html` in your browser to see the design system in action. The demo includes:
- Authentication layout
- Dashboard layout
- Component showcase
- Theme switching

## Migration Notes

1. **Bootstrap 3 → Bootstrap 5**: Update class names where needed
2. **CSS Variables**: Use the new CSS custom properties for consistency
3. **Components**: Replace old components with new design system components
4. **Theme Support**: Add theme toggle buttons where appropriate

## Next Steps

1. Update existing PHP templates to use new CSS classes
2. Replace Bootstrap 3 includes with Bootstrap 5 + design system
3. Test all pages for compatibility
4. Add theme toggle buttons to navigation
5. Optimize for performance and accessibility