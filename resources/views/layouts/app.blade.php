<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="appData()" x-init="init()">
    <!-- Header -->
    <header class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-600 text-white shadow-2xl sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-5">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="bg-white/20 p-2 rounded-xl group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-tight">ShopZone</span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="relative font-semibold hover:text-orange-100 transition-colors group">
                        Accueil
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('products') }}" class="relative font-semibold hover:text-orange-100 transition-colors group">
                        Produits
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('categories') }}" class="relative font-semibold hover:text-orange-100 transition-colors group">
                        Catégories
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <!-- Cart Button -->
                    <button @click="cartOpen = !cartOpen" class="relative bg-white/20 hover:bg-white/30 p-3 rounded-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span x-show="cartCount > 0" x-text="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold shadow-lg"></span>
                    </button>

                    <!-- Auth Links -->
                    <div class="flex items-center gap-3">
                        <!-- If logged in -->
                        <div x-show="user" x-data="{ dropdownOpen: false }" class="relative" style="display: none;">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 px-5 py-2.5 bg-white text-orange-600 rounded-xl hover:bg-orange-50 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span x-text="user?.name"></span>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl py-2 z-50 border border-gray-100" style="display: none;">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Mon profil</a>
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Mes commandes</a>
                                <hr class="my-2">
                                <button @click="logout()" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    Déconnexion
                                </button>
                            </div>
                        </div>
                        
                        <!-- If not logged in -->
                        <div x-show="!user" class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-white hover:text-orange-100 transition-colors font-semibold">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white text-orange-600 rounded-xl hover:bg-orange-50 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105">
                                Inscription
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Sidebar -->
    <div x-show="cartOpen" @click.away="cartOpen = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed right-0 top-0 h-full w-full md:w-[450px] bg-white shadow-2xl z-50 flex flex-col" style="display: none;" x-data="cartManager()">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-2xl font-black">Mon Panier</h2>
                <button @click="cartOpen = false" class="hover:bg-white/20 p-2 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-orange-100" x-text="cartItems.length + ' article(s)'"></p>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            <!-- Loading -->
            <div x-show="loading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-600 mx-auto"></div>
                <p class="text-gray-500 mt-4">Chargement...</p>
            </div>

            <!-- Empty Cart -->
            <div x-show="!loading && cartItems.length === 0" class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Votre panier est vide</h3>
                <p class="text-gray-500 mb-6">Ajoutez des produits pour commencer</p>
                <button @click="cartOpen = false" class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition-colors">
                    Continuer mes achats
                </button>
            </div>

            <!-- Cart Items List -->
            <div x-show="!loading && cartItems.length > 0" class="space-y-4">
                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-gray-50 rounded-xl p-4 relative group">
                        <!-- Remove Button -->
                        <button @click="removeItem(item.id)" class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <div class="flex gap-4">
                            <!-- Product Image -->
                            <img :src="'/images/' + item.product.image" :alt="item.product.name" class="w-20 h-20 object-cover rounded-lg">
                            
                            <!-- Product Info -->
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 mb-1 pr-6" x-text="item.product.name"></h4>
                                <p class="text-orange-600 font-bold mb-3" x-text="formatPrice(item.product.price) + ' CFA'"></p>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-3">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)" :disabled="item.quantity <= 1" class="bg-white border-2 border-gray-300 text-gray-700 w-8 h-8 rounded-lg font-bold hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                        -
                                    </button>
                                    <span class="font-bold text-gray-900 w-8 text-center" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="bg-white border-2 border-gray-300 text-gray-700 w-8 h-8 rounded-lg font-bold hover:bg-gray-100 transition-colors">
                                        +
                                    </button>
                                    <span class="text-sm text-gray-500 ml-auto font-semibold" x-text="formatPrice(item.subtotal) + ' CFA'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer with Total and Checkout -->
        <div x-show="!loading && cartItems.length > 0" class="border-t-2 border-gray-200 p-6 bg-gray-50">
            <!-- Clear Cart -->
            <button @click="clearCart()" class="text-red-600 text-sm font-semibold mb-4 hover:text-red-700 transition-colors">
                🗑️ Vider le panier
            </button>

            <!-- Total -->
            <div class="bg-white rounded-xl p-4 mb-4 border-2 border-orange-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Sous-total</span>
                    <span class="font-bold" x-text="formatPrice(cartTotal) + ' CFA'"></span>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>Livraison</span>
                    <span>Calculée à l'étape suivante</span>
                </div>
                <div class="border-t-2 border-gray-200 mt-3 pt-3 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900">Total</span>
                    <span class="text-2xl font-black text-orange-600" x-text="formatPrice(cartTotal) + ' CFA'"></span>
                </div>
            </div>

            <!-- Checkout Button -->
            <button @click="checkout()" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-4 rounded-xl font-black text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 mb-3">
                🛒 Commander
            </button>
            <button @click="cartOpen = false" class="w-full bg-white border-2 border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 transition-colors">
                Continuer mes achats
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">À propos</h3>
                    <p class="text-gray-400">Votre boutique en ligne de confiance pour tous vos besoins.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Produits</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <p class="text-gray-400">Email: contact@ecommerce.com</p>
                    <p class="text-gray-400">Tél: +221 XX XXX XX XX</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2026 Mon E-Commerce. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // API Configuration
        const API_BASE_URL = 'http://localhost:8080/api';
        
        // App Data (root Alpine component)
        function appData() {
            return {
                cartOpen: false,
                cartCount: 0,
                user: null,

                init() {
                    this.user = JSON.parse(localStorage.getItem('user') || 'null');
                    this.loadCartCount();

                    // Listen for cart updates
                    window.addEventListener('cart-updated', () => {
                        this.loadCartCount();
                    });
                },

                async loadCartCount() {
                    const token = localStorage.getItem('auth_token');
                    if (!token) {
                        this.cartCount = 0;
                        return;
                    }

                    try {
                        const response = await fetch(`${API_BASE_URL}/cart`, {
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        
                        if (data.success) {
                            this.cartCount = data.data.count;
                        }
                    } catch (error) {
                        console.error('Error loading cart count:', error);
                    }
                }
            }
        }
        
        // Cart Manager
        function cartManager() {
            return {
                cartItems: [],
                cartTotal: 0,
                loading: false,

                init() {
                    this.loadCart();
                    
                    // Listen for cart updates
                    window.addEventListener('cart-updated', () => {
                        this.loadCart();
                    });

                    // Watch for cart open
                    this.$watch('$root.cartOpen', (value) => {
                        if (value) {
                            this.loadCart();
                        }
                    });
                },

                async loadCart() {
                    const token = localStorage.getItem('auth_token');
                    if (!token) {
                        this.cartItems = [];
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

        // Global logout function
        async function logout() {
            const token = localStorage.getItem('auth_token');
            
            if (token) {
                try {
                    await fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                } catch (error) {
                    console.error('Logout error:', error);
                }
            }
            
            // Clear local storage
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            
            // Redirect to home
            window.location.href = '/';
        }
    </script>

    @stack('scripts')
</body>
</html>
