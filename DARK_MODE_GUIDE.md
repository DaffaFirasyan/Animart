# Panduan Dark Mode - Animart

## Masalah yang Telah Diperbaiki

### 1. Konfigurasi Tailwind CSS
File `tailwind.config.js` sekarang sudah dikonfigurasi dengan:
```javascript
darkMode: 'class'
```

### 2. Implementasi Toggle Dark Mode
File `app.blade.php` sudah memiliki Alpine.js script yang menangani toggle dark mode dengan localStorage.

### 3. Build CSS
Tailwind CSS sudah di-build ulang dengan konfigurasi dark mode.

## Cara Menambahkan Dark Mode ke Halaman Baru

Untuk menambahkan dark mode ke halaman-halaman lain, tambahkan class `dark:` pada setiap elemen. Berikut panduannya:

### Pattern Umum Dark Mode Classes

#### 1. Background
```html
<!-- Light: bg-white, Dark: bg-gray-800 -->
<div class="bg-white dark:bg-gray-800">

<!-- Light: bg-gray-50, Dark: bg-gray-900 -->
<div class="bg-gray-50 dark:bg-gray-900">

<!-- Light: bg-red-50, Dark: bg-gray-800 -->
<div class="bg-red-50 dark:bg-gray-800">
```

#### 2. Text Colors
```html
<!-- Heading / Title -->
<h1 class="text-gray-800 dark:text-gray-200">

<!-- Body Text -->
<p class="text-gray-700 dark:text-gray-300">

<!-- Muted Text -->
<span class="text-gray-500 dark:text-gray-400">

<!-- Dark Gray Text -->
<span class="text-gray-900 dark:text-gray-100">
```

#### 3. Colored Text
```html
<!-- Red Text -->
<span class="text-red-600 dark:text-red-400">

<!-- Blue Text -->
<span class="text-blue-600 dark:text-blue-400">

<!-- Green Text -->
<span class="text-green-600 dark:text-green-400">

<!-- Yellow Text -->
<span class="text-yellow-600 dark:text-yellow-400">
```

#### 4. Borders
```html
<!-- Light border -->
<div class="border-gray-200 dark:border-gray-700">

<!-- Stronger border -->
<div class="border-gray-300 dark:border-gray-600">
```

#### 5. Form Elements
```html
<!-- Input / Select / Textarea -->
<input class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500">

<select class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

<textarea class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
```

#### 6. Buttons
```html
<!-- Primary Button (sudah ada di component) -->
<x-primary-button>

<!-- Custom Button -->
<button class="bg-blue-600 dark:bg-blue-500 text-white hover:bg-blue-700 dark:hover:bg-blue-600">
```

#### 7. Tables
```html
<table class="bg-white dark:bg-gray-800">
    <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="text-gray-700 dark:text-gray-300">Header</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b dark:border-gray-700">
            <td class="text-gray-900 dark:text-gray-100">Data</td>
        </tr>
    </tbody>
</table>
```

## Contoh Lengkap: Halaman Dashboard

Lihat file `resources/views/dashboard.blade.php` untuk contoh implementasi lengkap dark mode.

### Header
```blade
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>
```

### Card
```blade
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        Card Title
    </h3>
    <p class="text-gray-700 dark:text-gray-300">
        Card content
    </p>
</div>
```

## Halaman yang Sudah Diperbaiki

- ✅ `layouts/app.blade.php` - Layout utama dengan toggle dark mode
- ✅ `layouts/navigation.blade.php` - Sidebar navigation
- ✅ `layouts/navigation-content.blade.php` - Navigation items
- ✅ `components/dropdown.blade.php` - Dropdown menu
- ✅ `components/dropdown-link.blade.php` - Dropdown items
- ✅ `components/text-input.blade.php` - Input fields
- ✅ `components/input-label.blade.php` - Labels
- ✅ `components/primary-button.blade.php` - Primary button
- ✅ `dashboard.blade.php` - Dashboard page

## Halaman yang Perlu Diperbaiki

Berikut halaman-halaman yang masih perlu ditambahkan dark mode classes:

### Prioritas Tinggi (Halaman Utama)
- [ ] `kasir/index.blade.php` - Halaman Kasir/POS
- [ ] `laporan/index.blade.php` - Halaman Laporan
- [ ] `menu/index.blade.php` - Halaman Menu
- [ ] `bahan_baku/index.blade.php` - Halaman Bahan Baku

### Prioritas Sedang
- [ ] `menu/create.blade.php`
- [ ] `menu/edit.blade.php`
- [ ] `bahan_baku/create.blade.php`
- [ ] `bahan_baku/edit.blade.php`
- [ ] `bahan_baku/tambah-stok.blade.php`
- [ ] `profile/edit.blade.php`

### Prioritas Rendah
- [ ] `profile/partials/*.blade.php`
- [ ] `laporan_keuangan/index.blade.php`

## Cara Testing Dark Mode

1. Buka aplikasi di browser
2. Klik tombol "Toggle Mode" di sidebar
3. Periksa apakah:
   - Background berubah dari putih ke gelap
   - Text berubah dari gelap ke terang
   - Border dan shadow tetap terlihat
   - Form elements readable di kedua mode
   - Contrast tetap bagus untuk readability

## Tips

1. **Gunakan color palette yang konsisten:**
   - Light mode: `bg-white`, `text-gray-800`, `border-gray-300`
   - Dark mode: `bg-gray-800`, `text-gray-200`, `border-gray-700`

2. **Test contrast:**
   - Pastikan text contrast ratio minimal 4.5:1 (WCAG AA)
   - Gunakan tools seperti WebAIM Color Contrast Checker

3. **Jangan lupa form elements:**
   - Input, select, textarea perlu dark mode styling
   - Placeholder text juga perlu adjustment

4. **Build ulang setelah perubahan:**
   ```bash
   npm run build
   # atau untuk development
   npm run dev
   ```

## Troubleshooting

### Dark mode tidak berubah
- Pastikan `tailwind.config.js` memiliki `darkMode: 'class'`
- Clear browser cache dan reload (Ctrl+F5)
- Rebuild dengan `npm run build`

### Warna tidak kontras
- Gunakan lighter colors untuk dark mode
- Contoh: `text-red-600` → `dark:text-red-400`

### Element tertentu tidak berubah
- Periksa apakah element menggunakan inline styles
- Pastikan tidak ada `!important` di custom CSS
- Tambahkan `dark:` prefix di class yang relevan
