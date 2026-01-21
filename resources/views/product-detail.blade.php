@extends('layouts.app')

@section('title', $product->name . ' - E-Commerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="productDetail()">
    <!-- Breadcrumb -->
    <nav class="mb-8 flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 transition-colors">Accueil</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="#" class="text-gray-500 hover:text-orange-600 transition-colors">{{ $product->category->name }}</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-semibold">{{ $product->name }}</span>
    </nav>

    <!-- Product Detail -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Product Image -->
        <div class="space-y-4">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-orange-100">
                @if($product->image)
                    <img 
                        src="{{ route('image', ['path' => $product->image]) }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-[500px] object-cover"
                    >
                @else
                    <div class="w-full h-[500px] flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div>
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <!-- Category Badge -->
                <span class="inline-block bg-orange-100 text-orange-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                    {{ $product->category->name }}
                </span>

                <!-- Product Name -->
                <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $product->name }}</h1>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-5xl font-black text-orange-600">{{ number_format($product->price, 0, ',', ' ') }}</span>
                    <span class="text-2xl text-gray-500 font-semibold ml-2">CFA</span>
                </div>

                <!-- Stock Status -->
                @if($product->stock > 0)
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-green-600 font-bold">En stock ({{ $product->stock }} disponibles)</span>
                    </div>
                @else
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-red-600 font-bold">Rupture de stock</span>
                    </div>
                @endif

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Quantité</label>
                    <div class="flex items-center gap-4">
                        <button @click="quantity > 1 && quantity--" class="bg-gray-100 border-2 border-gray-300 text-gray-700 w-12 h-12 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                            -
                        </button>
                        <span class="text-2xl font-bold text-gray-900 w-16 text-center" x-text="quantity"></span>
                        <button @click="quantity < {{ $product->stock }} && quantity++" class="bg-gray-100 border-2 border-gray-300 text-gray-700 w-12 h-12 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                            +
                        </button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button 
                    @click="addToCart()"
                    :disabled="{{ $product->stock == 0 ? 'true' : 'false' }}"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white py-5 rounded-2xl font-black text-xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105 mb-4 flex items-center justify-center gap-3"
                >
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>{{ $product->stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}</span>
                </button>

                <!-- Features -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t-2 border-gray-200">
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">Paiement sécurisé</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">Livraison gratuite</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">Retour 30 jours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 mb-8">Produits similaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <a href="{{ route('product.show', $relatedProduct->id) }}" class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group border-2 border-transparent hover:border-orange-500">
                <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    @if($relatedProduct->image)
                        <img 
                            src="{{ route('image', ['path' => $relatedProduct->image]) }}" 
                            alt="{{ $relatedProduct->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        >
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-orange-600 transition-colors">
                        {{ $relatedProduct->name }}
                    </h3>
                    <p class="text-2xl font-black text-orange-600">
                        {{ number_format($relatedProduct->price, 0, ',', ' ') }} <span class="text-sm text-gray-500">CFA</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function productDetail() {
    return {
        quantity: 1,

        async addToCart() {
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
                        product_id: {{ $product->id }},
                        quantity: this.quantity
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showNotification(`✓ ${this.quantity} x {{ $product->name }} ajouté au panier !`, 'success');
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    this.quantity = 1; // Reset quantity
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
