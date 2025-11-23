# Custom CSS Architecture

## Cấu trúc File

Cấu trúc CSS mới được tổ chức theo component-based architecture:

```
css/
├── custom/
│   ├── variables.css      # Design tokens (colors, typography, spacing, etc.)
│   ├── base.css          # Reset, typography, base element styles
│   ├── components.css    # Reusable components (cards, buttons, forms)
│   ├── layouts.css       # Page-specific layouts
│   ├── utilities.css     # Helper utility classes
│   └── responsive.css    # Media queries and responsive styles
└── main.css              # Imports all custom CSS files
```

## Design System

### Colors
- **Primary**: `--primary-blue: #0043C8`
- **Semantic**: Success, Warning, Danger, Info
- **Neutral**: Gray scale từ 50-900

### Typography
- **Font Families**: Inter (primary), Poppins (headings)
- **Font Sizes**: Từ `--text-xs` (12px) đến `--text-5xl` (48px)
- **Font Weights**: Light (300) đến Bold (700)

### Spacing
- Spacing scale dựa trên 4px: `--space-1` (4px) đến `--space-20` (80px)

### Components
- Buttons: `.btn`, `.btn-primary`, `.btn-secondary`, etc.
- Cards: `.card`, `.content-card`, `.category-card`
- Forms: `.form-control`, `.form-group`, `.input-group`
- Navigation: `.navbar`, `.nav-link`, `.dropdown-menu`

## Cách sử dụng

1. Import `main.css` trong HTML:
```html
<link rel="stylesheet" href="css/main.css">
```

2. Sử dụng CSS custom properties:
```css
.my-component {
  color: var(--primary-blue);
  padding: var(--space-4);
  border-radius: var(--radius-lg);
}
```

3. Sử dụng utility classes:
```html
<div class="card p-6 mb-4 shadow-md">
  <h2 class="text-2xl font-bold mb-3">Title</h2>
  <p class="text-muted">Content</p>
</div>
```

## Responsive Design

Sử dụng mobile-first approach với breakpoints:
- Mobile: < 768px
- Tablet: 768px - 991px
- Desktop: 992px+
- Large Desktop: 1200px+

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Notes

- Tất cả styles sử dụng CSS custom properties để dễ dàng theme
- Component-based architecture giúp code dễ maintain
- Utility classes giúp tăng tốc độ development
- Mobile-first responsive design

