// Exemples d'utilisation de l'API Laravel avec Next.js

const API_BASE_URL = 'http://localhost:8080/api';

// Fonction utilitaire pour les appels API
const apiCall = async (endpoint, options = {}) => {
  const token = localStorage.getItem('auth_token');
  
  const config = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      ...(token && { 'Authorization': `Bearer ${token}` }),
      ...options.headers,
    },
    ...options,
  };

  const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
  const data = await response.json();
  
  if (!response.ok) {
    throw new Error(data.message || 'Une erreur est survenue');
  }
  
  return data;
};

// 1. AUTHENTIFICATION
export const authAPI = {
  // Connexion
  login: async (email, password) => {
    return apiCall('/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
  },

  // Inscription
  register: async (name, email, password, password_confirmation) => {
    return apiCall('/register', {
      method: 'POST',
      body: JSON.stringify({ name, email, password, password_confirmation }),
    });
  },

  // Déconnexion
  logout: async () => {
    return apiCall('/logout', { method: 'POST' });
  },

  // Utilisateur connecté
  getUser: async () => {
    return apiCall('/user');
  },
};

// 2. PRODUITS
export const productsAPI = {
  // Liste des produits avec filtres
  getProducts: async (params = {}) => {
    const queryString = new URLSearchParams(params).toString();
    return apiCall(`/products?${queryString}`);
  },

  // Détail d'un produit
  getProduct: async (id) => {
    return apiCall(`/products/${id}`);
  },

  // Produits par catégorie
  getProductsByCategory: async (categoryId) => {
    return apiCall(`/products/category/${categoryId}`);
  },

  // Créer un produit (Admin)
  createProduct: async (productData) => {
    return apiCall('/products', {
      method: 'POST',
      body: JSON.stringify(productData),
    });
  },
};

// 3. PANIER
export const cartAPI = {
  // Voir le panier
  getCart: async () => {
    return apiCall('/cart');
  },

  // Ajouter au panier
  addToCart: async (product_id, quantity = 1) => {
    return apiCall('/cart/add', {
      method: 'POST',
      body: JSON.stringify({ product_id, quantity }),
    });
  },

  // Modifier quantité
  updateCartItem: async (id, quantity) => {
    return apiCall(`/cart/${id}`, {
      method: 'PUT',
      body: JSON.stringify({ quantity }),
    });
  },

  // Supprimer un article
  removeCartItem: async (id) => {
    return apiCall(`/cart/${id}`, { 
      method: 'DELETE' 
    });
  },

  // Vider le panier
  clearCart: async () => {
    return apiCall('/cart', { 
      method: 'DELETE' 
    });
  },
};

// 4. COMMANDES
export const ordersAPI = {
  // Historique des commandes
  getOrders: async () => {
    return apiCall('/orders');
  },

  // Créer une commande
  createOrder: async (orderData) => {
    return apiCall('/orders', {
      method: 'POST',
      body: JSON.stringify(orderData),
    });
  },

  // Détail d'une commande
  getOrder: async (id) => {
    return apiCall(`/orders/${id}`);
  },
};

// 5. CATÉGORIES
export const categoriesAPI = {
  // Liste des catégories
  getCategories: async () => {
    return apiCall('/categories');
  },

  // Détail d'une catégorie
  getCategory: async (id) => {
    return apiCall(`/categories/${id}`);
  },
};

// 6. UPLOAD D'IMAGES
export const imageAPI = {
  // Upload image
  uploadImage: async (imageFile) => {
    const formData = new FormData();
    formData.append('image', imageFile);
    
    const token = localStorage.getItem('auth_token');
    return fetch(`${API_BASE_URL}/upload-image`, {
      method: 'POST',
      headers: {
        ...(token && { 'Authorization': `Bearer ${token}` }),
      },
      body: formData,
    }).then(res => res.json());
  },
};

// EXEMPLE D'UTILISATION DANS UN COMPOSANT NEXT.JS/REACT
/*
import { useEffect, useState } from 'react';
import { productsAPI, cartAPI, authAPI } from './api-examples';

// ============================================
// EXEMPLE 1: Liste de produits avec panier
// ============================================
export default function ProductList() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [cartCount, setCartCount] = useState(0);

  useEffect(() => {
    fetchProducts();
    loadCartCount();
  }, []);

  const fetchProducts = async () => {
    try {
      const response = await productsAPI.getProducts({ per_page: 12 });
      if (response.success) {
        setProducts(response.data.data); // Laravel pagination
      }
    } catch (error) {
      console.error('Erreur:', error);
    } finally {
      setLoading(false);
    }
  };

  const loadCartCount = async () => {
    try {
      const response = await cartAPI.getCart();
      if (response.success) {
        setCartCount(response.data.count);
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  };

  const handleAddToCart = async (productId) => {
    try {
      const response = await cartAPI.addToCart(productId, 1);
      if (response.success) {
        alert('Produit ajouté au panier !');
        loadCartCount(); // Recharger le compteur
      }
    } catch (error) {
      console.error('Erreur:', error);
      alert(error.message || 'Erreur lors de l\'ajout au panier');
    }
  };

  if (loading) return <div>Chargement...</div>;

  return (
    <div>
      <header>
        <h1>Boutique</h1>
        <div>Panier: {cartCount} article(s)</div>
      </header>

      <div className="grid">
        {products.map(product => (
          <div key={product.id} className="product-card">
            <img src={`http://localhost:8080/images/${product.image}`} alt={product.name} />
            <h3>{product.name}</h3>
            <p>{product.description}</p>
            <p className="price">{product.price} CFA</p>
            <button 
              onClick={() => handleAddToCart(product.id)}
              disabled={product.stock === 0}
            >
              {product.stock > 0 ? 'Ajouter au panier' : 'Rupture de stock'}
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}

// ============================================
// EXEMPLE 2: Page Panier
// ============================================
export function CartPage() {
  const [cartItems, setCartItems] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadCart();
  }, []);

  const loadCart = async () => {
    setLoading(true);
    try {
      const response = await cartAPI.getCart();
      if (response.success) {
        setCartItems(response.data.items);
        setTotal(response.data.total);
      }
    } catch (error) {
      console.error('Erreur:', error);
    } finally {
      setLoading(false);
    }
  };

  const updateQuantity = async (itemId, newQuantity) => {
    try {
      const response = await cartAPI.updateCartItem(itemId, newQuantity);
      if (response.success) {
        loadCart(); // Recharger le panier
      }
    } catch (error) {
      alert(error.message);
    }
  };

  const removeItem = async (itemId) => {
    if (!confirm('Retirer cet article ?')) return;
    
    try {
      const response = await cartAPI.removeCartItem(itemId);
      if (response.success) {
        loadCart();
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  };

  const clearCart = async () => {
    if (!confirm('Vider tout le panier ?')) return;
    
    try {
      const response = await cartAPI.clearCart();
      if (response.success) {
        loadCart();
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  };

  if (loading) return <div>Chargement...</div>;

  if (cartItems.length === 0) {
    return (
      <div>
        <h2>Votre panier est vide</h2>
        <a href="/">Continuer mes achats</a>
      </div>
    );
  }

  return (
    <div>
      <h1>Mon Panier</h1>
      
      <div className="cart-items">
        {cartItems.map(item => (
          <div key={item.id} className="cart-item">
            <img src={`http://localhost:8080/images/${item.product.image}`} alt={item.product.name} />
            <div>
              <h3>{item.product.name}</h3>
              <p>{item.product.price} CFA</p>
            </div>
            <div>
              <button onClick={() => updateQuantity(item.id, item.quantity - 1)} disabled={item.quantity <= 1}>
                -
              </button>
              <span>{item.quantity}</span>
              <button onClick={() => updateQuantity(item.id, item.quantity + 1)}>
                +
              </button>
            </div>
            <div>
              <p>Sous-total: {item.subtotal} CFA</p>
              <button onClick={() => removeItem(item.id)}>Supprimer</button>
            </div>
          </div>
        ))}
      </div>

      <div className="cart-summary">
        <button onClick={clearCart}>Vider le panier</button>
        <h2>Total: {total} CFA</h2>
        <button>Passer commande</button>
      </div>
    </div>
  );
}

// ============================================
// EXEMPLE 3: Authentification
// ============================================
export function LoginForm() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async (e) => {
    e.preventDefault();
    
    try {
      const response = await authAPI.login(email, password);
      if (response.success) {
        // Sauvegarder le token
        localStorage.setItem('auth_token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        
        // Rediriger
        window.location.href = '/';
      }
    } catch (error) {
      alert(error.message || 'Erreur de connexion');
    }
  };

  return (
    <form onSubmit={handleLogin}>
      <input 
        type="email" 
        value={email} 
        onChange={(e) => setEmail(e.target.value)}
        placeholder="Email"
        required
      />
      <input 
        type="password" 
        value={password} 
        onChange={(e) => setPassword(e.target.value)}
        placeholder="Mot de passe"
        required
      />
      <button type="submit">Se connecter</button>
    </form>
  );
}

// ============================================
// EXEMPLE 4: Upload d'image
// ============================================
export function ImageUpload() {
  const [uploading, setUploading] = useState(false);

  const handleUpload = async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    setUploading(true);
    try {
      const response = await imageAPI.uploadImage(file);
      if (response.success) {
        console.log('Image uploadée:', response.data.url);
        alert('Image uploadée avec succès !');
      }
    } catch (error) {
      alert(error.message || 'Erreur lors de l\'upload');
    } finally {
      setUploading(false);
    }
  };

  return (
    <div>
      <input 
        type="file" 
        accept="image/*" 
        onChange={handleUpload}
        disabled={uploading}
      />
      {uploading && <p>Upload en cours...</p>}
    </div>
  );
}
*/