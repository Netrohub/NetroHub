# NXO Figma Setup Guide

## 🎨 Quick Figma Setup

### Step 1: Create New Figma File
1. Open Figma
2. Create new file: "NXO - Digital Marketplace"
3. Set up your artboards (Desktop: 1440px, Tablet: 768px, Mobile: 375px)

### Step 2: Import Design System

#### Colors (Create Color Styles)
```
Primary Purple: #8B5CF6
Primary Blue: #3B82F6  
Primary Cyan: #06B6D4

Background Primary: #0F172A
Background Secondary: #1E293B
Background Tertiary: #334155

Text Primary: #FFFFFF
Text Secondary: #E2E8F0
Text Muted: #94A3B8
```

#### Gradients (Create Gradient Styles)
```
Primary Gradient: 135deg, #8B5CF6 → #3B82F6 → #06B6D4
Gaming Gradient: 135deg, #8B5CF6 → #3B82F6
```

### Step 3: Typography Styles

#### Headings
```
H1: Poppins, 60px, Black, #FFFFFF
H2: Poppins, 48px, Bold, #FFFFFF  
H3: Poppins, 36px, Bold, #FFFFFF
H4: Poppins, 30px, Bold, #FFFFFF
H5: Poppins, 24px, Bold, #FFFFFF
```

#### Body Text
```
Body Large: Inter, 20px, Medium, #E2E8F0
Body: Inter, 16px, Regular, #E2E8F0
Body Small: Inter, 14px, Regular, #94A3B8
Caption: Inter, 12px, Regular, #94A3B8
```

## 🧩 Component Library

### 1. Buttons

#### Primary Button
```
Size: 48px height, Auto width
Background: Primary Gradient
Text: White, 16px, Semibold
Border Radius: 12px
Shadow: 0px 10px 25px rgba(139, 92, 246, 0.25)

Hover State:
- Transform: translateY(-1px)
- Shadow: 0px 10px 25px rgba(139, 92, 246, 0.4)
```

#### Secondary Button
```
Size: 48px height, Auto width
Background: #374151
Text: #E2E8F0, 16px, Semibold
Border: 1px solid #4B5563
Border Radius: 12px
```

### 2. Form Elements

#### Input Field
```
Size: 44px height, Auto width
Background: rgba(30, 41, 59, 0.5)
Border: 1px solid #475569
Border Radius: 12px
Padding: 12px 16px
Text: #E2E8F0, 16px, Regular
Placeholder: #64748B

Focus State:
- Border: 1px solid #8B5CF6
- Shadow: 0px 0px 0px 3px rgba(139, 92, 246, 0.1)
```

### 3. Cards

#### Product Card
```
Size: 320px width, Auto height
Background: #1E293B
Border: 1px solid #334155
Border Radius: 16px
Padding: 16px
Shadow: 0px 10px 25px rgba(0, 0, 0, 0.2)

Hover State:
- Transform: translateY(-4px)
- Shadow: 0px 20px 40px rgba(0, 0, 0, 0.3)
- Border: 1px solid #8B5CF6
```

#### Glass Card
```
Background: rgba(30, 41, 59, 0.8)
Backdrop Filter: Blur 20px
Border: 1px solid rgba(139, 92, 246, 0.2)
Border Radius: 24px
Shadow: 0px 25px 50px rgba(0, 0, 0, 0.25)
```

## 📐 Layout Specifications

### Grid System
```
Desktop: 12 columns, 24px gutters, 1200px max-width
Tablet: 8 columns, 20px gutters, 768px max-width  
Mobile: 4 columns, 16px gutters, 375px max-width
```

### Spacing Scale
```
4px, 8px, 12px, 16px, 24px, 32px, 40px, 48px, 64px, 80px
```

### Section Padding
```
Mobile: 40px vertical, 16px horizontal
Desktop: 56px vertical, 24px horizontal
```

## 🖼️ Key Screens to Design

### 1. Homepage
```
Hero Section:
- Background: Dark gradient
- Logo: NXO with gradient text
- Headline: "Digital Marketplace"
- CTA: Primary button
- Product showcase grid

Features Section:
- 3-column layout
- Icon + title + description
- Glass card styling

Footer:
- Dark background
- Links organized in columns
- Social media icons
```

### 2. Product Listing
```
Header:
- Search bar
- Filter buttons
- Sort dropdown

Product Grid:
- 4 columns desktop, 2 tablet, 1 mobile
- Product cards with images
- Price and platform badges

Pagination:
- Numbered pagination
- Previous/Next buttons
```

### 3. Product Detail
```
Layout: 2-column (image + details)
Left: Product image (4:3 aspect ratio)
Right: 
- Product title
- Price
- Platform badge
- Description
- Add to cart button
- Seller info
```

### 4. Authentication
```
Layout: Centered form
Background: Dark with subtle pattern
Form:
- Logo at top
- Input fields
- Turnstile widget
- Submit button
- Links to other pages
```

## 🎨 Visual Elements

### Logo Design
```
Primary Logo:
- Text: "NXO" in bold
- Background: Circular gradient
- Colors: Purple to blue gradient
- Size: 42px diameter

Horizontal Logo:
- Text: "NXO MARKETPLACE"
- Background: Rounded rectangle gradient
- Size: 120px x 42px
```

### Icons
```
Style: Outline icons, 24px
Color: #94A3B8 (muted)
Hover: #8B5CF6 (primary purple)

Common Icons:
- User profile
- Shopping cart
- Search
- Filter
- Heart (favorites)
- Share
- Settings
```

### Images
```
Product Images: 4:3 aspect ratio
Profile Images: 1:1 aspect ratio (circular)
Hero Images: 16:9 aspect ratio
Thumbnails: 1:1 aspect ratio
```

## 📱 Responsive Breakpoints

### Mobile (375px)
```
- Single column layout
- Stacked navigation
- Full-width buttons
- 16px padding
```

### Tablet (768px)
```
- 2-column product grid
- Side navigation
- Medium buttons
- 20px padding
```

### Desktop (1440px)
```
- 4-column product grid
- Top navigation
- Large buttons
- 24px padding
```

## 🚀 Prototyping

### Interactions
```
Button Hover: Scale 1.02, Shadow increase
Card Hover: TranslateY(-4px), Shadow increase
Form Focus: Border color change, Shadow
Navigation: Smooth transitions
```

### Animations
```
Duration: 0.3s
Easing: ease-out
Properties: transform, opacity, box-shadow
```

## 📋 Figma Checklist

### Setup
- [ ] Create new file
- [ ] Set up artboards (Mobile, Tablet, Desktop)
- [ ] Import color styles
- [ ] Create text styles
- [ ] Set up grid system

### Components
- [ ] Create button variants
- [ ] Design form elements
- [ ] Build card components
- [ ] Create navigation components
- [ ] Design modal components

### Screens
- [ ] Homepage
- [ ] Product listing
- [ ] Product detail
- [ ] Authentication pages
- [ ] User dashboard
- [ ] Admin panel

### Assets
- [ ] Logo variations
- [ ] Icon library
- [ ] Image placeholders
- [ ] Brand illustrations

### Prototyping
- [ ] Add hover states
- [ ] Create page transitions
- [ ] Test responsive behavior
- [ ] Add micro-interactions

This guide gives you everything needed to recreate your NXO design in Figma with pixel-perfect accuracy!
