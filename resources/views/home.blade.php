<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Accueil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Mon E-Commerce
                    </h1>
                    <p class="text-blue-100 mt-1">Découvrez nos meilleurs produits</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Section Title -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Nos Produits</h2>
            <p class="text-gray-600 mt-1">Explorez notre collection de produits</p>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <!-- Product Image -->
                    <div class="relative h-64 bg-gray-200 overflow-hidden">
                        @if($product->image)
                            <!-- Debug: {{ $product->image }} -->
                            <img 
                                src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                onerror="console.log('Image failed to load: {{ asset('storage/' . $product->image) }}')"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($product->stock > 0)
                            <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                En stock
                            </span>
                        @else
                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                Rupture
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">
                            {{ $product->name }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $product->description }}
                        </p>

                        <!-- Price & Action -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">
                                    {{ number_format($product->price, 0, ',', ' ') }}
                                </span>
                                <span class="text-gray-500 text-sm ml-1">CFA</span>
                            </div>
                            
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit disponible</h3>
                <p class="text-gray-600">Les produits seront bientôt ajoutés à notre catalogue !</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2026 Mon E-Commerce. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>