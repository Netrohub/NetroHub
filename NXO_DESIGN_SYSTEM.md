# NXO Design System
*Digital Marketplace Platform*

## 🎨 Brand Identity

### Primary Colors
```css
/* Purple-Blue Gradient Theme */
--primary-purple: #8B5CF6
--primary-blue: #3B82F6
--primary-cyan: #06B6D4

/* Gradient Combinations */
--gradient-primary: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 50%, #06B6D4 100%)
--gradient-gaming: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%)
```

### Neutral Colors
```css
/* Dark Theme */
--bg-primary: #0F172A
--bg-secondary: #1E293B
--bg-tertiary: #334155
--bg-card: #1E293B
--bg-glass: rgba(30, 41, 59, 0.8)

/* Text Colors */
--text-primary: #FFFFFF
--text-secondary: #E2E8F0
--text-muted: #94A3B8
--text-placeholder: #64748B

/* Border Colors */
--border-primary: #475569
--border-gaming: #8B5CF6
--border-muted: #334155
```

## 🔤 Typography

### Font Families
```css
/* Primary Fonts */
--font-primary: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif
--font-display: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif

/* Arabic Support */
--font-arabic: 'Tajawal', 'Cairo', -apple-system, BlinkMacSystemFont, sans-serif
```

### Type Scale
```css
/* Headings */
--text-6xl: 3.75rem (60px) - font-black
--text-5xl: 3rem (48px) - font-bold
--text-4xl: 2.25rem (36px) - font-bold
--text-3xl: 1.875rem (30px) - font-bold
--text-2xl: 1.5rem (24px) - font-bold

/* Body Text */
--text-xl: 1.25rem (20px) - font-medium
--text-lg: 1.125rem (18px) - font-normal
--text-base: 1rem (16px) - font-normal
--text-sm: 0.875rem (14px) - font-normal
--text-xs: 0.75rem (12px) - font-normal
```

## 🧩 Components

### Buttons

#### Primary Button
```css
/* Style */
background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%)
color: #FFFFFF
border: none
border-radius: 0.75rem
padding: 0.75rem 1.5rem
font-weight: 600
box-shadow: 0 10px 25px rgba(139, 92, 246, 0.25)

/* Hover */
background: linear-gradient(135deg, #7C3AED 0%, #2563EB 100%)
box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4)
transform: translateY(-1px)

/* States */
- Default: Purple gradient
- Hover: Darker gradient + shadow
- Active: Pressed state
- Disabled: 50% opacity
```

#### Secondary Button
```css
/* Style */
background: #374151
color: #E2E8F0
border: 1px solid #4B5563
border-radius: 0.75rem
padding: 0.75rem 1.5rem
font-weight: 600

/* Hover */
background: #4B5563
border-color: #6B7280
```

### Form Elements

#### Input Fields
```css
/* Style */
background: rgba(30, 41, 59, 0.5)
border: 1px solid #475569
border-radius: 0.75rem
padding: 0.75rem 1rem
color: #E2E8F0
font-size: 1rem
min-height: 44px

/* Placeholder */
color: #64748B

/* Focus */
border-color: #8B5CF6
box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1)
outline: none

/* Error */
border-color: #EF4444
background: rgba(239, 68, 68, 0.05)
```

#### Select Dropdowns
```css
/* Style */
background: rgba(30, 41, 59, 0.5)
border: 1px solid #475569
border-radius: 0.75rem
padding: 0.75rem 1rem
color: #E2E8F0
min-height: 44px

/* Options */
background: #1E293B
color: #E2E8F0
```

### Cards

#### Product Card
```css
/* Container */
background: #1E293B
border: 1px solid #334155
border-radius: 1rem
overflow: hidden
transition: all 0.3s ease

/* Hover */
transform: translateY(-4px)
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3)
border-color: #8B5CF6

/* Image */
aspect-ratio: 4/3
object-fit: cover
border-radius: 0.75rem

/* Content */
padding: 1rem
```

#### Glass Card
```css
/* Style */
background: rgba(30, 41, 59, 0.8)
backdrop-filter: blur(20px)
border: 1px solid rgba(139, 92, 246, 0.2)
border-radius: 1.5rem
box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25)
```

### Navigation

#### Header
```css
/* Container */
background: rgba(15, 23, 42, 0.95)
backdrop-filter: blur(20px)
border-bottom: 1px solid #334155
padding: 1rem 0

/* Logo */
font-size: 1.5rem
font-weight: 900
background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%)
-webkit-background-clip: text
-webkit-text-fill-color: transparent
```

#### Mobile Menu
```css
/* Overlay */
background: rgba(0, 0, 0, 0.8)
backdrop-filter: blur(10px)

/* Menu */
background: #1E293B
border: 1px solid #334155
border-radius: 1rem
padding: 1.5rem
```

## 📐 Layout & Spacing

### Grid System
```css
/* Container */
max-width: 1200px
margin: 0 auto
padding: 0 1rem

/* Responsive Breakpoints */
--sm: 640px
--md: 768px
--lg: 1024px
--xl: 1280px
```

### Spacing Scale
```css
/* Consistent Spacing */
--space-1: 0.25rem (4px)
--space-2: 0.5rem (8px)
--space-3: 0.75rem (12px)
--space-4: 1rem (16px)
--space-6: 1.5rem (24px)
--space-8: 2rem (32px)
--space-10: 2.5rem (40px)
--space-12: 3rem (48px)
--space-16: 4rem (64px)
--space-20: 5rem (80px)
```

### Section Padding
```css
/* Mobile */
padding: 2.5rem 1rem

/* Desktop */
padding: 3.5rem 1.5rem
```

## 🎭 Interactive States

### Hover Effects
```css
/* Buttons */
transform: translateY(-1px)
box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4)

/* Cards */
transform: translateY(-4px)
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3)

/* Links */
color: #8B5CF6
transition: color 0.2s ease
```

### Focus States
```css
/* Form Elements */
outline: none
border-color: #8B5CF6
box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1)

/* Buttons */
outline: none
box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2)
```

## 🖼️ Assets

### Logo Variations
- **Primary**: NXO with purple-blue gradient
- **Light**: White background with gradient text
- **Monochrome**: Single color version
- **Horizontal**: Wide format with "MARKETPLACE" tagline

### Icons
- **Platform Icons**: Gaming platform logos
- **UI Icons**: Navigation, actions, status
- **Social Icons**: Social media platforms

## 📱 Responsive Design

### Mobile First Approach
```css
/* Base styles for mobile */
.component {
  padding: 1rem;
  font-size: 0.875rem;
}

/* Tablet and up */
@media (min-width: 768px) {
  .component {
    padding: 1.5rem;
    font-size: 1rem;
  }
}

/* Desktop and up */
@media (min-width: 1024px) {
  .component {
    padding: 2rem;
    font-size: 1.125rem;
  }
}
```

### Touch Targets
```css
/* Minimum touch target size */
min-height: 44px
min-width: 44px
```

## 🎨 Visual Effects

### Gradients
```css
/* Primary Gradient */
background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 50%, #06B6D4 100%)

/* Gaming Gradient */
background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%)

/* Glass Effect */
background: rgba(30, 41, 59, 0.8)
backdrop-filter: blur(20px)
```

### Shadows
```css
/* Card Shadow */
box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2)

/* Button Shadow */
box-shadow: 0 10px 25px rgba(139, 92, 246, 0.25)

/* Hover Shadow */
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3)
```

## 🚀 Implementation Notes

### CSS Variables
```css
:root {
  --primary-purple: #8B5CF6;
  --primary-blue: #3B82F6;
  --primary-cyan: #06B6D4;
  --bg-primary: #0F172A;
  --bg-secondary: #1E293B;
  --text-primary: #FFFFFF;
  --text-secondary: #E2E8F0;
  --text-muted: #94A3B8;
}
```

### Tailwind Classes
```css
/* Common combinations */
.bg-gaming-gradient { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); }
.text-gradient { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); -webkit-background-clip: text; }
.glass-card { background: rgba(30, 41, 59, 0.8); backdrop-filter: blur(20px); }
```

---

## 📋 Figma Setup Checklist

### 1. Create Color Styles
- [ ] Add all primary colors as color styles
- [ ] Create gradient styles for primary and gaming gradients
- [ ] Set up neutral color palette

### 2. Create Text Styles
- [ ] Set up heading styles (H1-H6)
- [ ] Create body text styles
- [ ] Add caption and label styles

### 3. Create Components
- [ ] Button variants (primary, secondary, ghost)
- [ ] Form elements (input, select, checkbox)
- [ ] Cards (product, glass, info)
- [ ] Navigation components

### 4. Set Up Layout
- [ ] Create grid system
- [ ] Set up responsive breakpoints
- [ ] Create layout templates

### 5. Add Assets
- [ ] Import logo variations
- [ ] Add icon library
- [ ] Create image placeholders

This design system provides everything you need to recreate your NXO design in Figma with consistency and scalability.
