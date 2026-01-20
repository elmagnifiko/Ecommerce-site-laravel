// Exemples d'utilisation de l'API Laravel avec Next.js

const API_BASE_URL = 'http://localhost:8080/api';

// Fonction utilitaire pour les appels API
const apiCall = async (endpoint, options = {}) => {
  const token = localStorage.getItem('auth_token');
  
  const config = {
    headers: {
      'Content-Type': 'application/json',
      ...(token && { 'Authorization': `Bearer ${token}` }),
      ...options.headers,
    },
    ...options,
  };

  const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
  return response.json();
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
  addToCart: async (product_id, quantity) => {
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
    return apiCall(`/cart/${id}`, { method: 'DELETE' });
  },

  // Vider le panier
  clearCart: async () => {
    return apiCall('/cart', { method: 'DELETE' });
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

// EXEMPLE D'UTILISATION DANS UN COMPOSANT NEXT.JS
/*
import { useEffect, useState } from 'react';
import { productsAPI, cartAPI } from './api-examples';

export default function ProductList() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
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

    fetchProducts();
  }, []);

  const handleAddToCart = async (productId) => {
    try {
      const response = await cartAPI.addToCart(productId, 1);
      if (response.success) {
        alert('Produit ajouté au panier !');
      }
    } catch (error) {
      console.error('Erreur:', error);
    }
  };

  if (loading) return <div>Chargement...</div>;

  return (
    <div>
      {products.map(product => (
        <div key={product.id}>
          <h3>{product.name}</h3>
          <p>{product.price}€</p>
          <button onClick={() => handleAddToCart(product.id)}>
            Ajouter au panier
          </button>
        </div>
      ))}
    </div>
  );
}
*/