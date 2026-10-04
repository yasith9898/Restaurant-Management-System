<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>

  <link rel="icon" type="image/png" href="assets/images/headlogo.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    :root {
      --bg-color: #f7f3e8;
      --list-item-bg: #F0E7D8;
      --text-color: #333;
      --border-color: #ccc;
      --header-color: #D8CFC2;
      --list-bg-color: rgb(240, 231, 216);
      --search-input-bg: #D8CFC2;
    }

    body {
      background-color: var(--bg-color);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: var(--text-color);
      margin: 0;
      height: 100vh;
      overflow: hidden;
    }

    .custom-ui-container {
      width: 100%;
      height: 100vh;
      display: flex;
      flex-direction: column;
      background-color: var(--list-item-bg);
    }

    .custom-header {
      background-color: var(--header-color);
      border-bottom: 1px solid var(--border-color);
      position: sticky;
      top: 0;
      z-index: 10;
      padding: 10px 0;
    }

    .custom-search-input {
      background-color: var(--search-input-bg);
      border: none;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      color: var(--text-color);
      flex-grow: 1;
      font-family: inherit;
    }

    .custom-search-input::placeholder {
      color: #666;
    }

    .custom-search-input:focus {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      outline: none;
    }

    .product-list-container {
      overflow-y: auto;
      flex-grow: 1;
      background-color: var(--list-bg-color);
      -webkit-overflow-scrolling: touch;
      padding: 10px 0;
    }

    .custom-list-item {
      padding: 1rem;
      border-bottom: 1px solid #e0e0e0;
      background-color: var(--list-item-bg);
      cursor: pointer;
      transition: background-color 0.2s ease;
      border-radius: 8px;
      margin: 0 10px 8px 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .custom-list-item:hover {
      background-color: #e3d8c6;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-list-item:last-child {
      border-bottom: none;
    }

    .product-name {
      font-size: 1.1rem;
      font-weight: 500;
      color: #333;
      margin-bottom: 0.25rem;
      line-height: 1.3;
    }

    .product-price {
      font-size: 0.9rem;
      color: #666;
      font-weight: 500;
      line-height: 1.2;
    }

    .product-info-container {
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .no-results {
      text-align: center;
      padding: 3rem 1rem;
      color: #666;
    }

    .no-results i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .loading-spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid #f3f3f3;
      border-top: 3px solid #3498db;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .product-list-container::-webkit-scrollbar {
      width: 6px;
    }

    .product-list-container::-webkit-scrollbar-thumb {
      background-color: #c4c4c4;
      border-radius: 4px;
    }

    /* --- Modal Styling (Matching Main Menu) --- */
    .product-detail-modal {
      width: 100vw;
      height: 100vh;
      margin: 0;
      padding: 0;
      max-width: 100%;
    }

    .product-modal-content {
      border: none;
      border-radius: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      background-color: #3b3c3e;
    }

    /* Close Button */
    .btn-close.custom-close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #000;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: center;
      background-size: 60%;
      opacity: 1;
      width: 30px;
      height: 30px;
      z-index: 20;
    }

    /* Scrollable Image Section */
    .product-image-container {
      flex: 1;
      overflow-y: auto;
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
    }

    .image-slide {
      width: 100%;
      height: 200vh;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }

    .header-title {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      background: transparent;
      padding: 1rem;
      z-index: 10;
    }

    /* Product Details Section */
    .product-details-section {
      background-color: #e9e4d9;
      padding: 1.5rem;
      flex-shrink: 0;
      overflow: hidden;
    }

    .product-name-heading {
      font-size: 1.8rem;
      font-weight: 700;
      color: #333;
    }

    /* Options List */
    .options-container {
      padding: 1rem 0;
    }

    .options-heading {
      font-size: 1.2rem;
      font-weight: 600;
      color: #6a5749;
      margin-bottom: 1rem;
    }

    .product-option {
      padding: 0.8rem 0;
      transition: background-color 0.2s;
      cursor: pointer;
      border-radius: 8px;
      padding-left: 0.5rem;
      padding-right: 0.5rem;
    }

    .product-option:hover {
      background-color: #f5f0e6;
    }

    .option-label {
      font-size: 1rem;
      font-weight: 500;
      color: #333;
    }

    .option-price {
      font-size: 1rem;
      font-weight: 700;
      color: #6a5749;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
      .custom-list-item {
        padding: 0.8rem;
        margin: 0 8px 6px 8px;
      }

      .product-name {
        font-size: 1rem;
      }

      .product-price {
        font-size: 0.85rem;
      }

      .custom-search-input {
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
      }

      .image-slide {
        height: 60vh;
      }

      .product-details-section {
        padding: 1rem;
      }

      .product-name-heading {
        font-size: 1.3rem;
      }

      .options-heading {
        font-size: 1.1rem;
      }

      .option-label, .option-price {
        font-size: 0.95rem;
      }
    }

    @media (max-width: 576px) {
      .custom-list-item {
        padding: 0.7rem;
        margin: 0 5px 5px 5px;
      }

      .product-name {
        font-size: 0.95rem;
      }

      .product-price {
        font-size: 0.8rem;
      }

      .custom-search-input {
        padding: 0.5rem 0.7rem;
        font-size: 0.85rem;
      }

      .image-slide {
        height: 50vh;
      }

      .product-details-section {
        padding: 0.8rem;
      }

      .product-name-heading {
        font-size: 1.2rem;
      }
    }

    /* Back button styling */
    .back-button {
      color: #18261F;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 8px;
      transition: background-color 0.2s;
    }

    .back-button:hover {
      background-color: rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div class="container-fluid p-0 custom-ui-container">
    <!-- Header -->
    <div class="custom-header">
      <div class="container-fluid">
        <div class="d-flex align-items-center px-3 gap-3">
          <a href="{{ route('menu.index') }}" class="back-button">
            <i class="bi bi-arrow-left fs-5"></i>
          </a>
          <input type="text" class="custom-search-input" id="productSearch" placeholder="Search product name..." autocomplete="off">
          <i class="bi bi-search fs-5" style="color: #18261F;"></i>
        </div>
      </div>
    </div>

    <!-- Product List -->
    <div class="product-list-container">
      <div id="productList">
        <div class="text-center py-5">
          <div class="loading-spinner"></div>
          <p class="mt-2">Loading products...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Detail Modal -->
  <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen m-0 product-detail-modal">
      <div class="modal-content product-modal-content">
        <button type="button" class="btn-close custom-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>

        <!-- Scrollable Image Section -->
        <div class="product-image-container">
          <div class="image-slide" id="product-modal-image">
            <div class="modal-header header-title border-0">
              <h5 class="modal-title text-white" id="productDetailModalLabel">{{ config('app.name', 'Baklava Inn') }}</h5>
            </div>
          </div>

          <div class="modal-body product-details-section">
            <div class="container-fluid p-0">
              <h2 class="product-name-heading mb-3" id="product-modal-name">Product Name</h2>
              <div class="options-container">
                <h3 class="options-heading">Choose</h3>
                <div id="product-options">
                  <!-- Options will be dynamically inserted here -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Language and translation system (matching main menu)
    let currentLang = 'English';
    let allProducts = [];

    const translations = {
      English: {
        'search-placeholder': 'Search product name...',
        'no-results': 'No products found',
        'choose': 'Choose',
        'standard': 'Standard',
        'with-ice-cream': 'With Ice Cream',
        'per-kilo': 'Per Kilo'
      },
      Türkçe: {
        'search-placeholder': 'Ürün adı ara...',
        'no-results': 'Ürün bulunamadı',
        'choose': 'Seçin',
        'standard': 'Standart',
        'with-ice-cream': 'Dondurmalı',
        'per-kilo': 'Kilo ile'
      },
      كوردی: {
        'search-placeholder': 'گەڕان بە ناوی کاڵا...',
        'no-results': 'هیچ کاڵایەک نەدۆزرایەوە',
        'choose': 'هەڵبژێرە',
        'standard': 'ستانداری',
        'with-ice-cream': 'بە ئایس کریم',
        'per-kilo': 'بە کیلۆ'
      },
      العربية: {
        'search-placeholder': 'ابحث باسم المنتج...',
        'no-results': 'لم يتم العثور على منتجات',
        'choose': 'اختر',
        'standard': 'قياسي',
        'with-ice-cream': 'مع آيس كريم',
        'per-kilo': 'بالكيلو'
      }
    };

    // Function to get product name in current language
    function getProductName(item) {
      const langMap = {
        'English': 'name_en',
        'Türkçe': 'name_tr',
        'كوردی': 'name_ku',
        'العربية': 'name_ar'
      };

      const field = langMap[currentLang] || 'name_en';
      return item[field] || item.name_en || 'Product Name';
    }

    // Function to get full image URL (robust version)
    function getImageUrl(imagePath) {
      // Fallback default image
      if (!imagePath) {
        return '{{ asset("images/default-item.png") }}';
      }

      // If it's already a full URL (http or https), return as is
      try {
        if (/^https?:\/\//i.test(imagePath)) {
          return imagePath;
        }
      } catch (e) {
        // continue to other heuristics
      }

      // Normalize by trimming leading slashes
      var normalized = imagePath.replace(/^\/+/, '');

      // If it already contains 'storage/' assume it's a storage URL
      if (normalized.indexOf('storage/') === 0 || normalized.indexOf('storage/') > 0) {
        return '{{ url("/") }}' + '/' + normalized;
      }

      // If it looks like an asset path (assets/ or images/) return full site url
      if (normalized.indexOf('assets/') === 0 || normalized.indexOf('images/') === 0) {
        return '{{ url("/") }}' + '/' + normalized;
      }

      // Default: assume it's stored in storage/app/public and use /storage prefix
      return '{{ url("/storage") }}' + '/' + normalized;
    }

    // Function to handle product click - show modal with product details
    function handleProductClick(item) {
      // Update modal content
      document.getElementById('product-modal-name').textContent = getProductName(item);

      // Update product image with correct path
      const modalImage = document.getElementById('product-modal-image');
      const imageUrl = getImageUrl(item.cover_image);
      modalImage.style.backgroundImage = `url('${imageUrl}')`;
      modalImage.style.backgroundSize = 'cover';
      modalImage.style.backgroundPosition = 'center';
      modalImage.style.backgroundRepeat = 'no-repeat';

      // Update product options
      const optionsContainer = document.getElementById('product-options');
      optionsContainer.innerHTML = '';

      if (item.options && item.options.length > 0) {
        item.options.forEach(option => {
          const optionElement = document.createElement('div');
          optionElement.className = 'product-option d-flex justify-content-between align-items-center mb-2';
          optionElement.innerHTML = `
            <span class="option-label">${option.label}</span>
            <span class="option-price">${option.price}</span>
          `;
          optionsContainer.appendChild(optionElement);
        });
      } else {
        // If no options, just show the price
        const optionElement = document.createElement('div');
        optionElement.className = 'product-option d-flex justify-content-between align-items-center mb-2';
        optionElement.innerHTML = `
          <span class="option-label">${translations[currentLang]['standard']}</span>
          <span class="option-price">${item.price}</span>
        `;
        optionsContainer.appendChild(optionElement);
      }

      // Show the modal
      const productModal = new bootstrap.Modal(document.getElementById('productDetailModal'));
      productModal.show();
    }

    // Render product list
    function renderProductList(products) {
      const productList = document.getElementById('productList');

      if (products.length === 0) {
        productList.innerHTML = `
          <div class="no-results">
            <i class="bi bi-search"></i>
            <h4>${translations[currentLang]['no-results']}</h4>
            <p class="text-muted">Try different search terms</p>
          </div>
        `;
        return;
      }

      const fragment = document.createDocumentFragment();

      products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.className = 'custom-list-item';

        const thumbUrl = getImageUrl(product.cover_image);

        productElement.innerHTML = `
          <div class="product-info-container">
            <div class="product-name">${getProductName(product)}</div>
            <div class="product-price">${product.price}</div>
          </div>
        `;

        productElement.addEventListener('click', () => {
          handleProductClick(product);
        });

        fragment.appendChild(productElement);
      });

      productList.innerHTML = '';
      productList.appendChild(fragment);
    }

    // Filter products based on search input
    function filterProducts(searchTerm) {
      if (!searchTerm.trim()) {
        renderProductList(allProducts);
        return;
      }

      const filtered = allProducts.filter(product => {
        const nameEn = product.name_en?.toLowerCase() || '';
        const nameAr = product.name_ar?.toLowerCase() || '';
        const nameKu = product.name_ku?.toLowerCase() || '';
        const nameTr = product.name_tr?.toLowerCase() || '';
        const search = searchTerm.toLowerCase();

        return nameEn.includes(search) ||
               nameAr.includes(search) ||
               nameKu.includes(search) ||
               nameTr.includes(search);
      });

      renderProductList(filtered);
    }

    // Load all products from backend
    async function loadAllProducts() {
      try {
        const response = await fetch('{{ route("menu.data") }}');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Flatten all products from all categories
        allProducts = [];
        Object.keys(data).forEach(categoryKey => {
          const categoryItems = data[categoryKey];
          if (categoryItems && categoryItems.length > 0) {
            allProducts = allProducts.concat(categoryItems);
          }
        });

        renderProductList(allProducts);
      } catch (error) {
        console.error('Error loading products:', error);
        const productList = document.getElementById('productList');
        productList.innerHTML = `
          <div class="text-center py-5">
            <i class="bi bi-exclamation-triangle display-4 text-danger"></i>
            <p class="text-danger mt-2">Failed to load products</p>
            <button class="btn btn-primary btn-sm" onclick="loadAllProducts()">Retry</button>
          </div>
        `;
      }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
      // Load products
      loadAllProducts();

      // Set up search functionality
      const searchInput = document.getElementById('productSearch');
      let searchTimeout;

      searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          filterProducts(this.value);
        }, 300);
      });

      // Set placeholder based on current language
      searchInput.placeholder = translations[currentLang]['search-placeholder'];

      // Load language from session or default
      const savedLang = localStorage.getItem('preferredLanguage') || 'English';
      if (savedLang !== currentLang) {
        currentLang = savedLang;
        searchInput.placeholder = translations[currentLang]['search-placeholder'];
      }

      // Focus on search input
      searchInput.focus();
    });

    // Handle Escape key to clear search
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const searchInput = document.getElementById('productSearch');
        searchInput.value = '';
        filterProducts('');
        searchInput.focus();
      }
    });
  </script>
</body>
</html>
