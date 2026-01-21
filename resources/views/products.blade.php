@extends('layouts.app')

@section('title', 'Tous les Produits - E-Commerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="productList()">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">Tous nos Produits</h1>
        <p class="text-gray-600 text-lg">Découvrez notre collection complète</p>
    </div>

    <!-- Filters & Search -->
    <div class="mb-10 bg-white rounded-2xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            <!-- Search -->
            <div class="relative flex-1 w-full lg:max-w-md">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @input="filterProducts()"
                    placeholder="Rechercher un produit..." 
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <!-- Category Filter -->
                <select 
                    x-model="selectedCategory"
                    @change="filterProducts()"
                    class="px-5 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium transition-all"
                >
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Sort -->
                <select 
                    x-model="sortBy"
                    @change="filterProducts()"
                    class="px-5 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 font-medium transition-all"
                >
                    <option value="name">Nom</option>
                    <option value="price_asc">Prix croissant</option>
                    <option value="price_desc">Prix décroissant</option>
                    <option value="newest">Plus récents</option>
                </select>
            </div>
        </div>

        <!-- Results Count -->
        <div class="mt-4 pt-4 border-t-2 border-gray-100">
            <p class="text-gray-600">
                <span class="font-bold text-orange-600" x-text="filteredProducts.length"></span> 
                produit(s) trouvé(s)
            </p>
        </div>
    </div>

    @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
            @foreach($products as $product)
            <div 
                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group border-2 border-transparent hover:border-orange-500"
                x-show="isProductVisible({{ $product->id }})"
                x-transition
            >
                <a href="{{ route('product.show', $product->id) }}">
                    <!-- Product Image -->
                    <div class="relative h-72 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                        @if($product->image)
                            <img 
                                src="{{ route('image', ['path' => $product->image]) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($product->stock > 0)
                            <span class="absolute top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                ✓ En stock
                            </span>
                        @else
                            <span class="absolute top-4 right-4 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                ✗ Rupture
                            </span>
                        @endif

                        <!-- Category Badge -->
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-orange-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                            {{ $product->category->name }}
                        </span>

                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6">
                            <span class="bg-white text-gray-900 px-6 py-3 rounded-xl font-bold transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl">
                                👁️ Voir détails
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Product Info -->
                <div class="p-6">
                    <a href="{{ route('product.show', $product->id) }}">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-1 group-hover:text-orange-600 transition-colors">
                            {{ $product->name }}
                        </h3>
                    </a>
                    
                    <p class="text-gray-600 text-sm mb-5 line-clamp-2 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <!-- Price & Action -->
                    <div class="flex items-center justify-between pt-4 border-t-2 border-gray-100">
                        <div>
                            <span class="text-3xl font-black text-orange-600">
                                {{ number_format($product->price, 0, ',', ' ') }}
                            </span>
                            <span class="text-gray-500 text-sm ml-1 font-semibold">CFA</span>
                        </div>
                        
                        <button 
                            @click.stop="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                            :disabled="{{ $product->stock == 0 ? 'true' : 'false' }}"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white px-5 py-3 rounded-xl font-bold transition-all duration-300 flex items-center gap-2 shadow-lg hover:shadow-xl hover:scale-105"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results -->
        <div x-show="filteredProducts.length === 0" class="text-center py-20">
            <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun produit trouvé</h3>
            <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
            <button @click="searchQuery = ''; selectedCategory = ''; filterProducts()" class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition-colors">
                Réinitialiser les filtres
            </button>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-lg p-4">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun produit disponible</h3>
            <p class="text-gray-600">Les produits seront bientôt ajoutés à notre catalogue !</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
function productList() {
    return {
        products: @json($products->items()),
        searchQuery: '',
        selectedCategory: '',
        sortBy: 'newest',
        filteredProducts: @json($products->pluck('id')),
        
        init() {
            this.filterProducts();
        },
        
        filterProducts() {
            let filtered = this.products;
            
            // Filter by search
            if (this.searchQuery) {
                filtered = filtered.filter(p => 
                    p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    p.description.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            
            // Filter by category
            if (this.selectedCategory) {
                filtered = filtered.filter(p => p.category_id == this.selectedCategory);
            }
            
            // Sort
            if (this.sortBy === 'price_asc') {
                filtered.sort((a, b) => a.price - b.price);
            } else if (this.sortBy === 'price_desc') {
                filtered.sort((a, b) => b.price - a.price);
            } else if (this.sortBy === 'name') {
                filtered.sort((a, b) => a.name.localeCompare(b.name));
            } else if (this.sortBy === 'newest') {
                filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }
            
            this.filteredProducts = filtered.map(p => p.id);
        },
        
        isProductVisible(productId) {
            return this.filteredProducts.includes(productId);
        },
        
        async addToCart(productId, productName, productPrice) {
            const token = localStorage.getItem('auth_token');
            
            if (!token) {
                alert('Veuillez vous connecter pour ajouter des produits au panier');
                window.location.href = '/login';
                return;
            }

            try {
                const response = await fetch('http://localhost:8080/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showNotification(`✓ ${productName} ajouté au panier !`, 'success');
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    this.showNotification(data.message || 'Erreur lors de l\'ajout au panier', 'error');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                this.showNotification('Erreur: ' + error.message, 'error');
            }
        },

        showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-24 right-6 z-50 px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white font-bold`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            setTimeout(() => notification.classList.add('translate-x-0'), 10);
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    }
}
</script>
@endpush
@endsection
