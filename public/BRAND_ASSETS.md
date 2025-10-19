# NXO Brand Assets

This directory contains all the visual branding assets for NXO - Digital Marketplace.

## 🎨 Logo Files

### Main Logo
- **`stellar-assets/images/logo.svg`** - Primary NXO logo with purple-blue gradient
- **`stellar-assets/images/logo-light.svg`** - Light version for dark backgrounds
- **`stellar-assets/images/logo-monochrome.svg`** - Monochrome version for single-color use
- **`stellar-assets/images/logo-horizontal.svg`** - Horizontal version with "MARKETPLACE" tagline

### Usage Guidelines
- **Primary Logo**: Use for main branding, headers, and primary locations
- **Light Logo**: Use on dark backgrounds or when contrast is needed
- **Monochrome**: Use for single-color applications, fax, or low-resolution displays
- **Horizontal**: Use in wide spaces, email signatures, or when tagline is needed

## 🌐 Web Assets

### Favicon
- **`favicon.svg`** - Modern SVG favicon (recommended)
- **`favicon.ico`** - Traditional ICO favicon for older browsers
- **`generate-favicon.html`** - Tool to generate favicon from canvas

### Open Graph Images
- **`img/nxo-og.svg`** - Social media sharing image (1200x630)
- **`img/nxo-og.png`** - Placeholder (replace with actual PNG if needed)

## 🎯 Brand Colors

### Primary Gradient
- **Purple**: `#8B5CF6`
- **Blue**: `#3B82F6` 
- **Cyan**: `#06B6D4`

### Usage
- Use the gradient for primary branding elements
- Individual colors can be used for accents and highlights
- Maintain consistency across all touchpoints

## 📱 Social Media Assets

### Recommended Sizes
- **Profile Picture**: 400x400px (use logo.svg)
- **Cover Photo**: 1200x630px (use nxo-og.svg)
- **Post Images**: 1200x630px (use nxo-og.svg)
- **Stories**: 1080x1920px (adapt nxo-og.svg)

## 🛠️ Technical Specifications

### SVG Files
- All logos are vector-based for scalability
- Optimized for web use
- Include proper viewBox and dimensions
- Compatible with all modern browsers

### File Formats
- **SVG**: Primary format for web use
- **PNG**: For social media and print (generate from SVG)
- **ICO**: For favicon compatibility

## 📋 Implementation

### HTML Head
```html
<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/favicon.svg">

<!-- Open Graph -->
<meta property="og:image" content="/img/nxo-og.svg">
<meta name="twitter:image" content="/img/nxo-og.svg">
```

### Laravel Blade
```php
<!-- Logo -->
<img src="{{ asset('stellar-assets/images/logo.svg') }}" alt="NXO" />

<!-- Open Graph -->
<meta property="og:image" content="{{ asset('img/nxo-og.svg') }}">
```

## 🎨 Design Guidelines

### Logo Usage
- Maintain minimum clear space around logo
- Don't distort or modify the logo
- Use appropriate version for context
- Ensure sufficient contrast

### Color Usage
- Primary gradient for main branding
- Individual colors for accents
- Maintain brand consistency
- Test accessibility contrast ratios

## 📝 Notes

- All assets are optimized for web performance
- SVG files are preferred for scalability
- Regular updates may be needed for social media
- Test across different devices and browsers

## 🔄 Updates

When updating brand assets:
1. Update all logo variations
2. Test across different contexts
3. Update social media profiles
4. Clear browser caches
5. Update documentation

---

**Last Updated**: {{ date('Y-m-d') }}  
**Version**: 1.0  
**Brand**: NXO - Digital Marketplace
