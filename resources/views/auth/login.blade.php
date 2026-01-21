@extends('layouts.app')

@section('title', 'Connexion - E-Commerce')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Connexion</h2>
            <p class="mt-2 text-gray-600">Connectez-vous à votre compte</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8" x-data="loginForm()">
            <!-- Alert Messages -->
            <div x-show="error" x-transition class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" style="display: none;">
                <p x-text="error"></p>
            </div>

            <div x-show="success" x-transition class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" style="display: none;">
                <p x-text="success"></p>
            </div>

            <form @submit.prevent="handleLogin" class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        x-model="formData.email"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="votre@email.com"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            x-model="formData.password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="••••••••"
                        >
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            x-model="formData.remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg x-show="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="loading ? 'Connexion...' : 'Se connecter'"></span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Ou</span>
                </div>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Créer un compte
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loginForm() {
    return {
        formData: {
            email: '',
            password: '',
            remember: false
        },
        showPassword: false,
        loading: false,
        error: '',
        success: '',
        
        async handleLogin() {
            this.error = '';
            this.success = '';
            this.loading = true;
            
            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: this.formData.email,
                        password: this.formData.password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store token
                    localStorage.setItem('auth_token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    
                    this.success = 'Connexion réussie ! Redirection...';
                    
                    // Redirect to home after 1 second
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1000);
                } else {
                    this.error = data.message || 'Identifiants incorrects';
                }
            } catch (error) {
                console.error('Login error:', error);
                this.error = 'Une erreur est survenue. Veuillez réessayer.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
@endsection
