@extends('layouts.app')

@section('title', 'Mon Panier - E-Commerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="cartPage()">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Mon Panier</h1>
        <p class="text-gray-600">Gérez vos articles avant de passer commande</p>
    </div>

    <!-- Loading -->
    <div x-show="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-orange-600 mx-auto"></div>
        <p class="text-gray-500 mt-4 text-lg">Chargement de votre panier...</p>
    </div>

    <!-- Empty Cart -->
    <div x-show="!loading && cartItems.length === 0" class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
        <p class="text-gray-600 mb-8 text-lg">Découvrez nos produits et ajoutez-les à votre panier</p>
        <a href="{{ route('home') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            🛍️ Découvrir nos produits
        </a>
    </div>

    <!-- Cart Content -->
    <div x-show="!loading && cartItems.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            <template x-for="item in cartItems" :key="item.id">
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex gap-6">
                        <!-- Product Image -->
                        <img :src="'/images/' + item.product.image" :alt="item.product.name" class="w-32 h-32 object-cover rounded-xl">
                        
                        <!-- Product Info -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900" x-text="item.product.name"></h3>
                                <button @click="removeItem(item.id)" class="text-red-500 hover:text-red-700 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <p class="text-2xl font-black text-orange-600 mb-4" x-text="formatPrice(item.product.price) + ' CFA'"></p>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-4">
                                <span class="text-gray-600 font-semibold">Quantité:</span>
                                <div class="flex items-center gap-3">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)" :disabled="item.quantity <= 1" class="bg-gray-100 border-2 border-gray-300 text-gray-700 w-10 h-10 rounded-xl font-bold hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                        -
                                    </button>
                                    <span class="font-bold text-gray-900 w-12 text-center text-lg" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="bg-gray-100 border-2 border-gray-300 text-gray-700 w-10 h-10 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                                        +
                                    </button>
                                </div>
                                <span class="text-gray-500 ml-auto">Sous-total: <span class="font-bold text-gray-900 text-lg" x-text="formatPrice(item.subtotal) + ' CFA'"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Clear Cart Button -->
            <button @click="clearCart()" class="text-red-600 font-bold hover:text-red-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Vider le panier
            </button>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                <h2 class="text-2xl font-black text-gray-900 mb-6">Résumé</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Sous-total (<span x-text="cartItems.length"></span> articles)</span>
                        <span class="font-bold" x-text="formatPrice(cartTotal) + ' CFA'"></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Livraison</span>
                        <span class="font-semibold text-green-600">Gratuite</span>
                    </div>
                    <div class="border-t-2 border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900">Total</span>
                        <span class="text-3xl font-black text-orange-600" x-text="formatPrice(cartTotal) + ' CFA'"></span>
                    </div>
                </div>

                <button @click="checkout()" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-4 rounded-xl font-black text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 mb-4">
                    🛒 Passer commande
                </button>
                
                <a href="{{ route('home') }}" class="block w-full text-center bg-white border-2 border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 transition-colors">
                    ← Continuer mes achats
                </a>

                <!-- Trust Badges -->
                <div class="mt-6 pt-6 border-t-2 border-gray-200 space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Paiement sécurisé</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Livraison gratuite</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        <span>Retour sous 30 jours</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_BASE_URL = 'http://localhost:8080/api';

function cartPage() {
    return {
        cartItems: [],
        cartTotal: 0,
        loading: false,

        init() {
            this.loadCart();
        },

        async loadCart() {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            this.loading = true;
            try {
                const response = await fetch(`${API_BASE_URL}/cart`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    this.cartItems = data.data.items;
                    this.cartTotal = data.data.total;
                    this.$root.cartCount = data.data.count;
                }
            } catch (error) {
                console.error('Error loading cart:', error);
            } finally {
                this.loading = false;
            }
        },

        async updateQuantity(itemId, newQuantity) {
            if (newQuantity < 1) return;

            const token = localStorage.getItem('auth_token');
            if (!token) return;

            try {
                const response = await fetch(`${API_BASE_URL}/cart/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                });
                const data = await response.json();
                
                if (data.success) {
                    await this.loadCart();
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour');
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
                alert('Erreur lors de la mise à jour');
            }
        },

        async removeItem(itemId) {
            if (!confirm('Retirer cet article du panier ?')) return;

            const token = localStorage.getItem('auth_token');
            if (!token) return;

            try {
                const response = await fetch(`${API_BASE_URL}/cart/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    await this.loadCart();
                }
            } catch (error) {
                console.error('Error removing item:', error);
            }
        },

        async clearCart() {
            if (!confirm('Vider tout le panier ?')) return;

            const token = localStorage.getItem('auth_token');
            if (!token) return;

            try {
                const response = await fetch(`${API_BASE_URL}/cart`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    await this.loadCart();
                }
            } catch (error) {
                console.error('Error clearing cart:', error);
            }
        },

        checkout() {
            alert('Fonctionnalité de commande à venir !');
            // TODO: Rediriger vers la page de checkout
        },

        formatPrice(price) {
            return new Intl.NumberFormat('fr-FR').format(price);
        }
    }
}
</script>
@endpush
@endsection
