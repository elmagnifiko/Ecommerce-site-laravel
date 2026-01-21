@extends('layouts.app')

@section('title', 'Mon Profil - E-Commerce')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="profilePage()">
    <!-- Check if user is logged in -->
    <template x-if="!user">
        <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Accès restreint</h3>
            <p class="text-gray-600 mb-4">Vous devez être connecté pour accéder à cette page</p>
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Se connecter
            </a>
        </div>
    </template>

    <template x-if="user">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <!-- User Info -->
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-bold">
                            <span x-text="user?.name?.charAt(0).toUpperCase()"></span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900" x-text="user?.name"></h2>
                        <p class="text-gray-600" x-text="user?.email"></p>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-2">
                        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-lg transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mon profil
                        </button>
                        <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-lg transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Mes commandes
                        </button>
                        <button @click="activeTab = 'password'" :class="activeTab === 'password' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-lg transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Mot de passe
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Profile Tab -->
                <div x-show="activeTab === 'profile'" class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informations personnelles</h3>
                    
                    <div x-show="message" x-transition class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" style="display: none;">
                        <p x-text="message"></p>
                    </div>

                    <form @submit.prevent="updateProfile" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input 
                                type="text" 
                                x-model="profileData.name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input 
                                type="email" 
                                x-model="profileData.email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Mettre à jour
                        </button>
                    </form>
                </div>

                <!-- Orders Tab -->
                <div x-show="activeTab === 'orders'" class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Mes commandes</h3>
                    
                    <div x-show="orders.length === 0" class="text-center py-12">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-gray-600">Vous n'avez pas encore de commandes</p>
                    </div>

                    <div x-show="orders.length > 0" class="space-y-4">
                        <template x-for="order in orders" :key="order.id">
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">Commande #<span x-text="order.id"></span></p>
                                        <p class="text-sm text-gray-600" x-text="new Date(order.created_at).toLocaleDateString('fr-FR')"></p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium" :class="{
                                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                        'bg-blue-100 text-blue-800': order.status === 'processing',
                                        'bg-green-100 text-green-800': order.status === 'completed',
                                        'bg-red-100 text-red-800': order.status === 'cancelled'
                                    }" x-text="order.status"></span>
                                </div>
                                <p class="text-lg font-bold text-blue-600"><span x-text="order.total_amount"></span> CFA</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Password Tab -->
                <div x-show="activeTab === 'password'" class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Changer le mot de passe</h3>
                    
                    <div x-show="passwordMessage" x-transition class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" style="display: none;">
                        <p x-text="passwordMessage"></p>
                    </div>

                    <form @submit.prevent="changePassword" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                            <input 
                                type="password" 
                                x-model="passwordData.current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input 
                                type="password" 
                                x-model="passwordData.new_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                            <input 
                                type="password" 
                                x-model="passwordData.new_password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Changer le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
function profilePage() {
    return {
        user: null,
        activeTab: 'profile',
        message: '',
        passwordMessage: '',
        profileData: {
            name: '',
            email: ''
        },
        passwordData: {
            current_password: '',
            new_password: '',
            new_password_confirmation: ''
        },
        orders: [],
        
        init() {
            this.user = JSON.parse(localStorage.getItem('user') || 'null');
            if (this.user) {
                this.profileData.name = this.user.name;
                this.profileData.email = this.user.email;
                this.loadOrders();
            }
        },
        
        async updateProfile() {
            const token = localStorage.getItem('auth_token');
            
            try {
                const response = await fetch('/api/user', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.profileData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.user = data.data;
                    localStorage.setItem('user', JSON.stringify(data.data));
                    this.message = 'Profil mis à jour avec succès !';
                    setTimeout(() => this.message = '', 3000);
                }
            } catch (error) {
                console.error('Update profile error:', error);
            }
        },
        
        async changePassword() {
            const token = localStorage.getItem('auth_token');
            
            try {
                const response = await fetch('/api/change-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.passwordData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.passwordMessage = 'Mot de passe changé avec succès !';
                    this.passwordData = {
                        current_password: '',
                        new_password: '',
                        new_password_confirmation: ''
                    };
                    setTimeout(() => this.passwordMessage = '', 3000);
                }
            } catch (error) {
                console.error('Change password error:', error);
            }
        },
        
        async loadOrders() {
            const token = localStorage.getItem('auth_token');
            
            try {
                const response = await fetch('/api/orders', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.orders = data.data;
                }
            } catch (error) {
                console.error('Load orders error:', error);
            }
        }
    }
}
</script>
@endpush
@endsection
