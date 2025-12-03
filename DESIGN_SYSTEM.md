# Design System & Theme Documentation

Complete style guide for the Laravel Queue & Cache Demo application, featuring dark mode with system-based light mode support.

---

## Color Palette

### Dark Theme (Default)
Primary colors used throughout the dark mode interface:

```css
/* Background Gradients */
--bg-primary: from-gray-900 via-gray-800 to-gray-900
--bg-card: bg-gray-800
--bg-card-inner: bg-gray-900
--bg-input: bg-gray-700

/* Text Colors */
--text-primary: text-gray-100
--text-secondary: text-gray-300  
--text-tertiary: text-gray-400
--text-muted: text-gray-500
--text-subtle: text-gray-600

/* Accent Colors */
--accent-blue: text-blue-400, bg-blue-900, border-blue-700
--accent-purple: text-purple-400, bg-purple-900, border-purple-700
--accent-green: text-green-400, bg-green-900, border-green-700
--accent-yellow: text-yellow-400, bg-yellow-900, border-yellow-700
--accent-red: text-red-400, bg-red-900, border-red-700

/* Gradients */
--gradient-primary: from-blue-400 to-purple-400
--gradient-button: from-blue-600 to-purple-600
--gradient-button-hover: from-blue-500 to-purple-500
--gradient-card: from-gray-800 to-gray-900

/* Borders */
--border-default: border-gray-700
--border-hover: border-gray-600
```

### Light Theme (System Preference)
For daytime/light mode when user's system is set to light:

```css
/* Background Colors */
--bg-light-primary: from-gray-50 via-gray-100 to-gray-50
--bg-light-card: bg-white
--bg-light-card-inner: bg-gray-50
--bg-light-input: bg-gray-100

/* Text Colors */
--text-light-primary: text-gray-900
--text-light-secondary: text-gray-700
--text-light-tertiary: text-gray-600
--text-light-muted: text-gray-500
--text-light-subtle: text-gray-400

/* Accent Colors (brighter for light mode) */
--accent-light-blue: text-blue-600, bg-blue-100, border-blue-300
--accent-light-purple: text-purple-600, bg-purple-100, border-purple-300
--accent-light-green: text-green-600, bg-green-100, border-green-300
--accent-light-yellow: text-yellow-600, bg-yellow-100, border-yellow-300
--accent-light-red: text-red-600, bg-red-100, border-red-300

/* Gradients */
--gradient-light-primary: from-blue-600 to-purple-600
--gradient-light-button: from-blue-500 to-purple-500
--gradient-light-button-hover: from-blue-600 to-purple-700

/* Borders */
--border-light-default: border-gray-200
--border-light-hover: border-gray-300
```

---

## Typography

### Font Families
```css
/* System Font Stack (Tailwind Default) */
font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 
             "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;

/* Monospace (for code/IDs) */
font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 
             "Liberation Mono", "Courier New", monospace;
```

### Font Sizes
```css
text-xs: 0.75rem (12px)
text-sm: 0.875rem (14px)
text-base: 1rem (16px)
text-lg: 1.125rem (18px)
text-xl: 1.25rem (20px)
text-2xl: 1.5rem (24px)
text-3xl: 1.875rem (30px)
text-4xl: 2.25rem (36px)
text-5xl: 3rem (48px)
text-6xl: 3.75rem (60px)
```

### Font Weights
```css
font-normal: 400
font-medium: 500
font-semibold: 600
font-bold: 700
```

---

## Layout Patterns

### Container Structure
```html
<!-- Page Container -->
<div class="container mx-auto px-4 py-12">
  <!-- Content -->
</div>
```

### Card Pattern (Dark)
```html
<div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
  <!-- Card Header -->
  <h2 class="text-2xl font-semibold mb-6 text-blue-400">Title</h2>
  
  <!-- Card Content -->
  <div class="space-y-4">
    <!-- Content items -->
  </div>
</div>
```

### Inner Card Pattern (Dark)
```html
<div class="bg-gray-900 p-4 rounded-lg border border-gray-700 hover:border-gray-600 transition">
  <!-- Inner content -->
</div>
```

---

## Component Styles

### Buttons

**Primary Button (Dark)**
```html
<button class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 
               hover:from-blue-500 hover:to-purple-500 
               rounded-lg font-semibold text-lg 
               transition-all transform hover:scale-[1.02] shadow-lg">
  Button Text
</button>
```

**Secondary Button (Dark)**
```html
<button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 
               rounded-lg transition">
  Button Text
</button>
```

### Form Inputs

**Text Input (Dark)**
```html
<input type="text" 
       class="w-full px-4 py-3 
              bg-gray-700 border border-gray-600 
              rounded-lg 
              focus:ring-2 focus:ring-blue-500 focus:border-transparent 
              text-white">
```

**Range Slider (Dark)**
```html
<input type="range" 
       class="w-full h-2 bg-gray-700 rounded-lg 
              appearance-none cursor-pointer">
```

### Labels
```html
<label class="block text-sm font-medium text-gray-300 mb-2">
  Label Text
</label>
```

### Badges & Status

**Success Badge (Dark)**
```html
<span class="px-4 py-2 bg-green-900 text-green-300 rounded-lg font-semibold">
  Success
</span>
```

**Warning/Pending Badge (Dark)**
```html
<span class="px-3 py-1 bg-yellow-900 text-yellow-300 rounded-lg text-xs font-semibold">
  Pending
</span>
```

**Info Badge (Dark)**
```html
<span class="px-4 py-2 bg-blue-900 text-blue-300 rounded-lg font-semibold">
  Info
</span>
```

---

## Effects & Animations

### Glassmorphism
```css
backdrop-blur-lg bg-opacity-90
```

### Hover Effects
```css
/* Scale on hover */
transition-all transform hover:scale-[1.02]

/* Border color change */
hover:border-gray-600 transition

/* Background change */
hover:bg-gray-600 transition
```

### Shadows
```css
/* Card shadow */
shadow-2xl

/* Button shadow */
shadow-lg
```

### Pulse Animation (for status indicators)
```html
<span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
```

---

## Spacing System

### Padding
```css
p-2: 0.5rem (8px)
p-3: 0.75rem (12px)
p-4: 1rem (16px)
p-6: 1.5rem (24px)
p-8: 2rem (32px)
p-12: 3rem (48px)
```

### Margin
```css
m-2: 0.5rem (8px)
m-4: 1rem (16px)
m-6: 1.5rem (24px)
mb-6: margin-bottom 1.5rem
mt-2: margin-top 0.5rem
```

### Gap (for flexbox/grid)
```css
gap-2: 0.5rem (8px)
gap-3: 0.75rem (12px)
gap-4: 1rem (16px)
space-y-3: vertical spacing between children
space-y-6: larger vertical spacing
```

---

## Border Radius

```css
rounded: 0.25rem (4px)
rounded-lg: 0.5rem (8px)
rounded-xl: 0.75rem (12px)
rounded-2xl: 1rem (16px)
rounded-full: 9999px (circular)
```

---

## Responsive Breakpoints

Tailwind default breakpoints used:
```css
sm: 640px   /* Small devices */
md: 768px   /* Medium devices */
lg: 1024px  /* Large devices */
xl: 1280px  /* Extra large devices */
2xl: 1536px /* 2X Extra large devices */
```

---

## System-Based Theme Detection

To enable automatic light/dark mode based on user's system preferences:

### HTML Structure
```html
<!-- Remove hardcoded 'dark' class, let Tailwind detect system preference -->
<html lang="en">
  <body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 
               dark:from-gray-900 dark:via-gray-800 dark:to-gray-900
               light:from-gray-50 light:via-gray-100 light:to-gray-50
               min-h-screen 
               text-gray-100 dark:text-gray-100 light:text-gray-900">
    <!-- Content -->
  </body>
</html>
```

### Tailwind Configuration
Add to `tailwind.config.js`:
```javascript
module.exports = {
  darkMode: 'media', // Uses prefers-color-scheme media query
  // or
  darkMode: 'class', // Manual toggle via class (more control)
  
  theme: {
    extend: {
      // Custom theme extensions
    }
  }
}
```

### Component Class Pattern
```html
<!-- Apply both light and dark classes -->
<div class="bg-gray-800 dark:bg-gray-800 light:bg-white 
            border-gray-700 dark:border-gray-700 light:border-gray-200">
  <h2 class="text-blue-400 dark:text-blue-400 light:text-blue-600">Title</h2>
</div>
```

---

## Usage Guidelines

### When to Use Each Color

**Blue**: Primary actions, links, informational content
**Purple**: Secondary accents, complementary to blue  
**Green**: Success states, completed actions
**Yellow**: Warnings, pending states
**Red**: Errors, destructive actions

### Contrast Requirements

- Ensure text has at least 4.5:1 contrast ratio for normal text
- Ensure text has at least 3:1 contrast ratio for large text (18px+)
- Test both dark and light modes for accessibility

### Animation Performance

- Use `transform` and `opacity` for animations (GPU accelerated)
- Avoid animating `width`, `height`, `margin`, `padding`
- Keep transitions under 300ms for responsiveness

---

## Quick Copy-Paste Templates

### Full Page Template (Dark Mode)
```html
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Title</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen text-gray-100">
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Page Title
            </h1>
            <p class="text-gray-400 text-lg">Description text</p>
        </div>

        <!-- Main Content Card -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
                <h2 class="text-2xl font-semibold mb-6 text-blue-400">Section Title</h2>
                
                <!-- Content -->
                <div class="space-y-4">
                    <!-- Your content here -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

### Notification/Alert
```html
<!-- Success -->
<div class="mt-6 p-4 rounded-lg bg-green-900 border border-green-700">
    <p class="font-semibold text-green-400">✓ Success message</p>
</div>

<!-- Error -->
<div class="mt-6 p-4 rounded-lg bg-red-900 border border-red-700">
    <p class="text-red-400">Error message</p>
</div>

<!-- Info -->
<div class="mt-6 p-4 rounded-lg bg-blue-900 border border-blue-700">
    <p class="text-blue-400">Info message</p>
</div>
```

---

## Files to Reference

- **Main CSS**: `resources/css/app.css`
- **Tailwind Config**: `tailwind.config.js`
- **Example Pages**:
  - `resources/views/home.blade.php`
  - `resources/views/queue-demo.blade.php`
  - `resources/views/cache-demo.blade.php`
  - `resources/views/livewire/queue-status.blade.php`

---

**Design Philosophy**: Modern, minimal, performant. Dark mode first with optional light mode based on system preferences. Smooth transitions, glassmorphism effects, and gradient accents create a premium feel while maintaining excellent readability and accessibility.
