@extends('layouts.app')

@section('title', 'Inscription - E-Commerce')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Créer un compte</h2>
            <p class="mt-2 text-gray-600">Rejoignez-nous dès aujourd'hui</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8" x-data="registerForm()">
            <!-- Alert Messages -->
            <div x-show="error" x-transition class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" style="display: none;">
                <p x-text="error"></p>
            </div>

            <div x-show="success" x-transition class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" style="display: none;">
                <p x-text="success"></p>
            </div>

            <form @submit.prevent="handleRegister" class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        x-model="formData.name"
                        required
                        minlength="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="John Doe"
                    >
                </div>

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
                            minlength="8"
                            @input="checkPasswordStrength()"
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
                    <!-- Password Strength Indicator -->
                    <div x-show="formData.password.length > 0" class="mt-2">
                        <div class="flex gap-1">
                            <div class="h-1 flex-1 rounded" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                            <div class="h-1 flex-1 rounded" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                            <div class="h-1 flex-1 rounded" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                        </div>
                        <p class="text-xs mt-1" :class="{
                            'text-red-600': passwordStrength === 1,
                            'text-yellow-600': passwordStrength === 2,
                            'text-green-600': passwordStrength === 3
                        }" x-text="passwordStrengthText"></p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input 
                        :type="showPassword ? 'text' : 'password'" 
                        id="password_confirmation" 
                        x-model="formData.password_confirmation"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="••••••••"
                    >
                    <p x-show="formData.password_confirmation && formData.password !== formData.password_confirmation" class="text-xs text-red-600 mt-1">
                        Les mots de passe ne correspondent pas
                    </p>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        id="terms"
                        x-model="formData.acceptTerms"
                        required
                        class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        J'accepte les <a href="#" class="text-blue-600 hover:text-blue-700">conditions d'utilisation</a> et la <a href="#" class="text-blue-600 hover:text-blue-700">politique de confidentialité</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    :disabled="loading || !isFormValid()"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold py-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg x-show="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="loading ? 'Inscription...' : 'Créer mon compte'"></span>
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

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function registerForm() {
    return {
        formData: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            acceptTerms: false
        },
        showPassword: false,
        loading: false,
        error: '',
        success: '',
        passwordStrength: 0,
        passwordStrengthText: '',
        
        checkPasswordStrength() {
            const password = this.formData.password;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/) && password.match(/[^a-zA-Z0-9]/)) strength++;
            
            this.passwordStrength = strength;
            
            if (strength === 1) this.passwordStrengthText = 'Faible';
            else if (strength === 2) this.passwordStrengthText = 'Moyen';
            else if (strength === 3) this.passwordStrengthText = 'Fort';
        },
        
        isFormValid() {
            return this.formData.name.length >= 3 &&
                   this.formData.email &&
                   this.formData.password.length >= 8 &&
                   this.formData.password === this.formData.password_confirmation &&
                   this.formData.acceptTerms;
        },
        
        async handleRegister() {
            this.error = '';
            this.success = '';
            
            if (!this.isFormValid()) {
                this.error = 'Veuillez remplir tous les champs correctement';
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: this.formData.name,
                        email: this.formData.email,
                        password: this.formData.password,
                        password_confirmation: this.formData.password_confirmation
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store token
                    localStorage.setItem('auth_token', data.data.token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    
                    this.success = 'Inscription réussie ! Redirection...';
                    
                    // Redirect to home after 1 second
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1000);
                } else {
                    this.error = data.message || 'Une erreur est survenue lors de l\'inscription';
                }
            } catch (error) {
                console.error('Register error:', error);
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
