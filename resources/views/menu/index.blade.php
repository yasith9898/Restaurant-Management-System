<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Baklava Inn') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/headlogo.png') }}">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #fff url('{{ asset('assets/images/background.jpeg') }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            overflow: hidden;
            min-height: 100vh;
        }

        /* Topbar (fixed header) */
        .topbar {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #18261F;
        }

        .topbar h6 {
            margin: 0;
            font-weight: 500;
            font-size: 16px;
        }

        /* Cards */
        .menu-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            border: none;
            height: 100%;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .menu-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .menu-card .card-body {
            padding: 10px 15px;
        }

        .product-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .product-price {
            font-size: 13px;
            color: #444;
            margin-bottom: 0;
        }

        /* Fixed header wrapper */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: transparent;
            z-index: 1000;
            padding: 10px 0;
        }

        .fixed-header .container {
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-radius: 12px;
            padding: 10px 15px;
            margin: 10px auto;
            max-width: 95%;
        }

        /* Scrollable content below header */
        .scrollable-content {
            position: fixed;
            top: 188px;
            bottom: 0;
            left: 0;
            right: 0;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 20px 0;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        /* Modal Styles */
        .menu-modal {
            background: #fff;
            border-radius: 0;
            color: #fff;
        }

        .menu-scroll {
            max-height: calc(100vh - 190px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-bottom {
            position: fixed;
            bottom: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
        }

        .modal-bottom .modal-content {
            border-radius: 15px 15px 0 0;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }

        /* Fixed footer */
        .fixed-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            padding: 10px 0;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            height: 30px;
        }

        /* Section headers for catalog */
        .catalog-section-title {
            display: flex;
            align-items: start;
            justify-content: start;
            gap: .75rem;
            margin: 18px 0 10px;
            font-weight: 600;
            padding-left: 20px;
        }

        .catalog-section-title h6 {
            margin: 0;
            white-space: nowrap;
        }

        /* Language Dropdown */
        .dropdown-menu {
            background-color: #121212;
    border-radius: 8px;
    border: none;
    width: auto;          /* Let width adjust automatically */
    min-width: 100px;     /* Optional: prevent it from being too small */
    white-space: nowrap;  /* Prevent text from wrapping to next line */
        }

        .dropdown-item {
            color: white;
        }

        .dropdown-item:hover {
            background-color: #2e3d30;
            color: white;
        }

        /* Layout Toggle Styles */
        #layout-toggle {
            cursor: pointer;
        }

        /* 1. GRID VIEW (Mobile) */
        #catalog.layout-grid .menu-card {
            display: block;
            height: auto;
        }

        #catalog.layout-grid .menu-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        #catalog.layout-grid .menu-card .card-body {
            padding: 10px 15px;
            text-align: center;
        }

        #catalog.layout-grid .product-title {
            border-bottom: 1px solid rgba(0, 0, 0, .1);
        }

        /* 2. LIST VIEW (Mobile) */
        #catalog.layout-list .menu-card {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            height: auto;
            padding: 15px;
            background-color: #f7f3eb;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #catalog.layout-list .menu-card img {
            width: 140px;
            height: 110px;
            object-fit: cover;
            flex-shrink: 0;
            border-radius: 8px;
            order: 2;
        }

        #catalog.layout-list .menu-card .card-body {
            flex-grow: 1;
            padding: 0;
            order: 1;
            text-align: left;
        }

        #catalog.layout-list .product-title {
            border-bottom: none;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        #catalog.layout-list .product-price {
            font-size: 14px;
            color: #333;
        }

        /* Force list view to 1-column */
        #catalog.layout-list .row .col-6 {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        /* Mobile Responsive Fix for Category Row */
        .category-scroll-row {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            padding-left: 10px;
            padding-right: 10px;
        }

        .category-scroll-row::-webkit-scrollbar {
            display: none;
        }

        .category-scroll-row {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Desktop Overrides */
        @media (min-width: 992px) {
            #catalog.layout-grid .menu-card img {
                height: 550px;
            }

            #catalog.layout-list .menu-card img {
                width: 800px;
                height: 700px;
            }

            #catalog.layout-grid .menu-card .card-body {
                text-align: left;
            }
        }

        /* Make all product images responsive */
        .menu-card .card-img-top {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Desktop view */
        @media (min-width: 992px) {
            .menu-card .card-img-top {
                height: 250px;
            }
        }

        /* Tablet view */
        @media (min-width: 768px) and (max-width: 991px) {
            .menu-card .card-img-top {
                height: 200px;
            }
        }

        /* Mobile view - make square */
        @media (max-width: 767px) {
            .menu-card .card-img-top {
                aspect-ratio: 1 / 1;
                height: auto;
            }
        }

        /* Language dropdown styling */
        #languageSelector {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #current-lang {
            margin: 0 5px;
            font-size: 14px;
        }

        /* PRODUCT DETAIL MODAL STYLES */
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

        /* Responsive Styling for Product Modal */
        @media (max-width: 992px) {
            .image-slide {
                height: 60vh;
            }

            .product-name-heading {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .image-slide {
                height: 50vh;
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

            .btn-close.custom-close-btn {
                width: 25px;
                height: 25px;
                top: 8px;
                right: 8px;
            }
        }

        @media (max-width: 576px) {
            .image-slide {
                height: 45vh;
            }

            .product-details-section {
                padding: 0.8rem;
            }

            .product-name-heading {
                font-size: 1.2rem;
            }

            .options-heading {
                font-size: 1rem;
            }

            .option-label, .option-price {
                font-size: 0.9rem;
            }
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
    </style>
</head>

<body style="overflow: hidden; margin: 0; padding: 0;">
    <div class="page-shell" style="padding: 100px;">
        <!-- Fixed Header Section -->
        <div class="fixed-header">
            <div class="container-fluid">
                <!-- Topbar -->
                <div class="d-flex justify-content-between topbar">
                    <i class="bi bi-grid fs-5" role="button" data-bs-toggle="modal" data-bs-target="#menuModal"></i>
                    <span class="fw-semibold" data-translate="baklava-inn">{{ config('app.name', 'Baklava Inn') }}</span>
                    <a href="{{ route('menu.search') }}" class="text-dark"><i class="bi bi-search fs-5"></i></a>
                </div>

                <!-- feedback and language bars -->
                <div class="row mt-1 d-flex gap-4">
                    <div class="col d-flex align-items-center justify-content-center"
                        style="height: 35px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); background-color: #ecead2;">
                        <a href="{{ route('menu.feedback') }}"><i class="bi bi-chat-square-heart-fill text-dark"></i></a>
                    </div>

                    <div class="col position-relative"
                        style="height: 35px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); background-color: #ecead2;">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="dropdown">
                                    <div class="position-relative" style="height: 35px; border-radius: 8px;">
                                        <!-- Dropdown Toggle -->
                                        <div class="d-flex align-items-center justify-content-center h-100" id="languageSelector"
                                            data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                            <i class="bi bi-globe-americas text-dark me-1"></i>
                                            <span id="current-lang">English</span>
                                            <i class="bi bi-caret-down-fill text-dark" style="font-size: 12px;"></i>
                                        </div>
                                        <!-- Dropdown Menu -->
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#" data-lang="English">English</a></li>
                                            <li><a class="dropdown-item" href="#" data-lang="Türkçe">Türkçe</a></li>
                                            <li><a class="dropdown-item" href="#" data-lang="كوردی">كوردی</a></li>
                                            <li><a class="dropdown-item" href="#" data-lang="العربية">العربية</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Row -->
                <div class="row mt-1 g-1 g-sm-2 justify-content-center text-dark category-scroll-row" id="categories-row">
                    <div class="col-auto">
                        <div class="d-flex flex-column align-items-center">
                            <div class="loading-spinner"></div>
                            <span class="small">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="scrollable-content">
            <div class="">
                <!-- cover image -->
                <div class="row justify-content-center">
                    <div class="">
                        <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('assets/images/Container.png') }}" alt="" class="img-fluid"
                                style="width: 100%; height: 100%; object-fit: cover;"
                                onerror="this.style.display='none'">
                        </div>
                    </div>
                </div>

                <!-- Center title with separators -->
                <div class="catalog-section-title">
                    <div class="text-dark">
                        <a href="#" id="layout-toggle"><i class="bi bi-list fs-5 text-dark"></i></a>
                    </div>
                </div>

                <!-- Catalog container -->
                <div class="">
                    <div id="catalog" class="layout-grid">
                        <div class="text-center py-5">
                            <div class="loading-spinner"></div>
                            <p class="mt-2">Loading menu...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Product Detail Modal ===== -->
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
                                <h3 class="options-heading" data-translate="choose">Choose</h3>
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

    <!-- ===== Categories Modal ===== -->
    <div class="modal modal-bottom" id="menuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="height: 100%; max-width: 100%;">
            <div class="modal-content menu-modal rounded-4"
                style="margin-top: 50vh; background-color: #F0E7D8; position: absolute; bottom: 0;">
                <div class="modal-body pt-0 px-2 px-sm-3 pb-3 mt-4">
                    <div class="menu-scroll" id="modal-categories">
                        <div class="text-center py-3">
                            <div class="loading-spinner"></div>
                            <p class="mt-2">Loading categories...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Footer -->
    <div class="fixed-footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center">
                    <p class="text-dark mb-0">
                        <span data-translate="powered-by">Powered by</span>
                        <img src="{{ asset('assets/images/mynu logo.png') }}" alt="Emenu" width="50"
                             onerror="this.style.display='none'">
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== LANGUAGE SYSTEM =====
        let currentLang = 'English';
        let menuData = {};
        let categoriesData = [];

        // Translations object
        const translations = {
            English: {
                'baklava-inn': '{{ config('app.name', 'Baklava Inn') }}',
                'ice-coffee': 'Ice Coffee',
                'milk-shake': 'Milk Shake',
                'mocktails': 'Mocktails',
                'fresh-juices': 'Fresh Juices',
                'cake': 'Cake',
                'baklava': 'Baklava',
                'katmer': 'Katmer',
                'kunafa': 'Kunafa',
                'hot-drinks': 'Hot Drinks',
                'sweets': 'Sweets',
                'cakes': 'Cakes',
                'ice-cream': 'Ice Cream',
                'fresh-juice': 'Fresh Juice',
                'milkshakes': 'Milkshakes',
                'powered-by': 'Powered by',
                'all-items': 'All Items',
                'choose': 'Choose'
            },
            Türkçe: {
                'baklava-inn': '{{ config('app.name', 'Baklava Inn') }}',
                'ice-coffee': 'Soğuk Kahve',
                'milk-shake': 'Milkshake',
                'mocktails': 'Alkolsüz Kokteyl',
                'fresh-juices': 'Taze Meyve Suyu',
                'cake': 'Pasta',
                'baklava': 'Baklava',
                'katmer': 'Katmer',
                'kunafa': 'Künefe',
                'hot-drinks': 'Sıcak İçecekler',
                'sweets': 'Tatlılar',
                'cakes': 'Pastalar',
                'ice-cream': 'Dondurma',
                'fresh-juice': 'Taze Meyve Suyu',
                'milkshakes': 'Milkshake\'ler',
                'powered-by': 'Tarafından Desteklenmektedir',
                'all-items': 'Tüm Ürünler',
                'choose': 'Seçin'
            },
            كوردی: {
                'baklava-inn': '{{ config('app.name', 'Baklava Inn') }}',
                'ice-coffee': 'قهوهی سارد',
                'milk-shake': 'میلک شەیک',
                'mocktails': 'مۆکتەیل',
                'fresh-juices': 'شەربی تازە',
                'cake': 'کێک',
                'baklava': 'باقلوا',
                'katmer': 'کاتمێر',
                'kunafa': 'کنافة',
                'hot-drinks': 'خواردنەوەی گەرم',
                'sweets': 'شیرینی',
                'cakes': 'کێک',
                'ice-cream': 'ئایس کریم',
                'fresh-juice': 'شەربی تازە',
                'milkshakes': 'میلک شەیک',
                'powered-by': 'پشتیوانی لەلایەن',
                'all-items': 'هەموو کاڵاکان',
                'choose': 'هەڵبژێرە'
            },
            العربية: {
                'baklava-inn': '{{ config('app.name', 'Baklava Inn') }}',
                'ice-coffee': 'قهوة مثلجة',
                'milk-shake': 'ميلك شيك',
                'mocktails': 'مشروبات غير كحولية',
                'fresh-juices': 'عصائر طازجة',
                'cake': 'كيك',
                'baklava': 'بقلوا',
                'katmer': 'قطمر',
                'kunafa': 'كنافة',
                'hot-drinks': 'مشروبات ساخنة',
                'sweets': 'حلويات',
                'cakes': 'كيك',
                'ice-cream': 'آيس كريم',
                'fresh-juice': 'عصير طازج',
                'milkshakes': 'ميلك شيك',
                'powered-by': 'مدعوم من',
                'all-items': 'جميع العناصر',
                'choose': 'اختر'
            }
        };

        // Function to change language
        function changeLanguage(lang) {
            currentLang = lang;

            // Update current language indicator
            document.getElementById('current-lang').textContent = lang;

            // Update all translatable elements
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (translations[lang] && translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });

            // Update category names in header
            updateCategoryNames();

            // Update topbar title
            const title = document.querySelector('.topbar h6');
            if (title) {
                title.textContent = translations[lang]['all-items'] || 'All Items';
            }

            // Rebuild catalog with new language
            if (Object.keys(menuData).length > 0) {
                buildCatalog(menuData);
            }
        }

        // Function to update category names in header
        function updateCategoryNames() {
            const categoryElements = document.querySelectorAll('#categories-row .center-category span');
            categoryElements.forEach(element => {
                const categorySlug = element.closest('.center-category').getAttribute('data-category');
                const cat = categoriesData.find(c => c.slug === categorySlug);
                if (cat) {
                    element.textContent = getCategoryName(cat);
                } else if (categorySlug && translations[currentLang] && translations[currentLang][categorySlug]) {
                    element.textContent = translations[currentLang][categorySlug];
                }
            });

            // Update modal category names
            const modalCategoryElements = document.querySelectorAll('#modal-categories .product-title');
            modalCategoryElements.forEach(element => {
                const categorySlug = element.getAttribute('data-translate');
                const cat = categoriesData.find(c => c.slug === categorySlug);
                if (cat) {
                    element.textContent = getCategoryName(cat);
                } else if (categorySlug && translations[currentLang] && translations[currentLang][categorySlug]) {
                    element.textContent = translations[currentLang][categorySlug];
                }
            });
        }

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

        // Function to get category name in current language (uses fetched category fields)
        function getCategoryName(category) {
            if (!category) return '';
            const langMap = {
                'English': 'name_en',
                'Türkçe': 'name_tr',
                'كوردی': 'name_ku',
                'العربية': 'name_ar'
            };

            const field = langMap[currentLang] || 'name_en';
            return category[field] || category.name_en || '';
        }

        // Function to get full image URL - FIXED VERSION
        function getImageUrl(imagePath) {
            // Fallback default image
            if (!imagePath) {
                return '{{ asset("images/default-category.png") }}';
            }

            // If it's already a full URL (http or https), return as is
            try {
                if (/^https?:\/\//i.test(imagePath)) {
                    return imagePath;
                }
            } catch (e) {
                // If regex fails for any reason, continue to other heuristics
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
                    <span class="option-label">Standard</span>
                    <span class="option-price">${item.price}</span>
                `;
                optionsContainer.appendChild(optionElement);
            }

            // Show the modal
            const productModal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            productModal.show();
        }

        // Build ALL sections (each category gets a header + grid)
        function buildCatalog(data) {
            const catalog = document.getElementById('catalog');
            if (!catalog) return;

            menuData = data;
            catalog.innerHTML = '';

            Object.keys(data).forEach(categoryKey => {
                const categoryItems = data[categoryKey];
                if (!categoryItems || categoryItems.length === 0) return;

                const section = document.createElement('section');
                section.setAttribute('data-section', categoryKey);
                section.style.scrollMarginTop = '16px';

                const foundCat = categoriesData.find(c => c.slug === categoryKey);
                const categoryName = foundCat ? getCategoryName(foundCat) : (translations[currentLang] && translations[currentLang][categoryKey]) || categoryKey.replace('-', ' ');

                section.innerHTML = `
                    <div class="catalog-section-title text-center">
                        <h6 class="mb-0 text-dark fw-bold" style="width: 100%; text-align: center;">${categoryName}</h6>
                    </div>
                    <div class="row g-3"></div>
                `;

                const row = section.querySelector('.row');
                categoryItems.forEach(item => {
                    const col = document.createElement('div');
                    col.className = 'col-6';

                    const productName = getProductName(item);
                    const productImage = getImageUrl(item.cover_image);

                    col.innerHTML = `
                        <div class="card menu-card shadow-sm" data-product-id="${item.id}">
                            <img src="${productImage}" alt="${productName}"
                                 onerror="this.src='{{ asset("images/default-item.png") }}'">
                            <div class="card-body">
                                <p class="product-title text-dark">${productName}</p>
                                <p class="product-price text-dark">${item.price}</p>
                            </div>
                        </div>
                    `;

                    // Add click event to the card
                    const card = col.querySelector('.menu-card');
                    card.addEventListener('click', () => {
                        handleProductClick(item);
                    });

                    row.appendChild(col);
                });

                catalog.appendChild(section);
            });

            // If no items found
            if (Object.keys(data).length === 0) {
                catalog.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-2">No items available</p>
                    </div>
                `;
            }
        }

        // Load categories for the header - FIXED VERSION
        function loadCategories(categories) {
            categoriesData = categories; // Store categories for language updates
            const categoriesRow = document.getElementById('categories-row');
            const modalCategories = document.getElementById('modal-categories');

            if (!categoriesRow || !modalCategories) return;

            // Clear loading states
            categoriesRow.innerHTML = '';
            modalCategories.innerHTML = '';

            // Create modal layout
            const modalRow = document.createElement('div');
            modalRow.className = 'row row-cols-3 g-3';

            categories.forEach(category => {
                // Header category item
                const categoryCol = document.createElement('div');
                categoryCol.className = 'col-auto px-1 center-category';
                categoryCol.setAttribute('data-category', category.slug);

                const categoryName = getCategoryName(category) || (translations[currentLang] && translations[currentLang][category.slug]) || category.name_en;
                const categoryImage = getImageUrl(category.image);

                categoryCol.innerHTML = `
                    <div class="d-flex flex-column align-items-center" style="cursor: pointer;">
                        <img src="${categoryImage}" alt="${categoryName}"
                             class="img-fluid" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;"
                             onerror="this.src='{{ asset("images/default-category.png") }}'">
                        <span class="small" data-translate="${category.slug}">${categoryName}</span>
                    </div>
                `;
                categoriesRow.appendChild(categoryCol);

                // Modal category item
                const modalCol = document.createElement('div');
                modalCol.className = 'col';
                modalCol.innerHTML = `
                    <div class="card menu-card h-100" style="background-color: #F0E7D8;">
                        <img src="${categoryImage}" alt="${categoryName}"
                             class="card-img-top"
                             onerror="this.src='{{ asset("images/default-category.png") }}'"
                             style="height: 120px; object-fit: cover;">
                        <div class="card-body py-2 text-center">
                            <p class="product-title mb-1" style="border-bottom: 1px solid rgba(0,0,0,.1);"
                               data-translate="${category.slug}">${categoryName}</p>
                        </div>
                    </div>
                `;
                modalRow.appendChild(modalCol);
            });

            modalCategories.appendChild(modalRow);

            // Add event listeners to category items
            document.querySelectorAll('.center-category').forEach(tile => {
                tile.addEventListener('click', () => {
                    const key = tile.getAttribute('data-category');
                    if (key) scrollToCategory(key);
                });
            });
        }

        // Smooth scroll INSIDE the scrollable-content container
        function scrollToCategory(key) {
            const wrap = document.querySelector('.scrollable-content');
            const target = document.querySelector(`[data-section="${key}"]`);
            if (!wrap || !target) {
                console.log('Category not found:', key);
                return;
            }
            const top = target.offsetTop;
            wrap.scrollTo({ top, behavior: 'smooth' });
            const title = document.querySelector('.topbar h6');
            if (title) {
                const cat = categoriesData.find(c => c.slug === key);
                title.textContent = cat ? getCategoryName(cat) : (translations[currentLang] && translations[currentLang][key]) || key;
            }

            // Close modal if open
            const modal = bootstrap.Modal.getInstance(document.getElementById('menuModal'));
            if (modal) {
                modal.hide();
            }
        }

        // Load menu data from backend
        async function loadMenuData() {
            try {
                const response = await fetch('{{ route("menu.data") }}');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                buildCatalog(data);
            } catch (error) {
                console.error('Error loading menu data:', error);
                const catalog = document.getElementById('catalog');
                if (catalog) {
                    catalog.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-triangle display-4 text-danger"></i>
                            <p class="text-danger mt-2">Failed to load menu data</p>
                            <button class="btn btn-primary btn-sm" onclick="loadMenuData()">Retry</button>
                        </div>
                    `;
                }
            }
        }

        // Load categories from backend - FIXED VERSION
        async function loadCategoriesData() {
            try {
                const response = await fetch('{{ route("menu.categories") }}');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const categories = await response.json();

                loadCategories(categories);
            } catch (error) {
                console.error('Error loading categories:', error);
                const categoriesRow = document.getElementById('categories-row');
                if (categoriesRow) {
                    categoriesRow.innerHTML = `
                        <div class="col-auto">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                                <span class="small text-danger">Failed to load</span>
                            </div>
                        </div>
                    `;
                }
            }
        }

        // This script runs ONCE when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // 1) Load categories and menu data
            loadCategoriesData();
            loadMenuData();

            // 2) Set default title
            const title = document.querySelector('.topbar h6');
            if (title) title.textContent = translations[currentLang]['all-items'];

            // 3) Set up layout toggle button
            const layoutToggle = document.getElementById('layout-toggle');
            const catalogContainer = document.getElementById('catalog');

            if (layoutToggle && catalogContainer) {
                layoutToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const icon = layoutToggle.querySelector('i');

                    if (catalogContainer.classList.contains('layout-grid')) {
                        // Switch to LIST view
                        catalogContainer.classList.remove('layout-grid');
                        catalogContainer.classList.add('layout-list');
                        icon.classList.remove('bi-list');
                        icon.classList.add('bi-grid');
                    } else {
                        // Switch to GRID view
                        catalogContainer.classList.remove('layout-list');
                        catalogContainer.classList.add('layout-grid');
                        icon.classList.remove('bi-grid');
                        icon.classList.add('bi-list');
                    }
                });
            }

            // 4) Set up language switcher
            document.querySelectorAll('.dropdown-item[data-lang]').forEach(item => {
                item.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const lang = e.target.getAttribute('data-lang');
                    const langCode = {
                        'English': 'en',
                        'Türkçe': 'tr',
                        'كوردی': 'ku',
                        'العربية': 'ar'
                    }[lang] || 'en';

                    try {
                        const response = await fetch('{{ route("menu.changeLanguage") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ language: langCode })
                        });

                        if (response.ok) {
                            changeLanguage(lang);
                        } else {
                            console.error('Failed to change language');
                        }
                    } catch (error) {
                        console.error('Error changing language:', error);
                        // Still change the frontend language even if backend fails
                        changeLanguage(lang);
                    }
                });
            });

            // 5) Handle modal show event to ensure categories are loaded
            document.getElementById('menuModal').addEventListener('show.bs.modal', function () {
                // Categories are already loaded on page load, so no need to reload
            });
        });
    </script>
</body>
</html>
