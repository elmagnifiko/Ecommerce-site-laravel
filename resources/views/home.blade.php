<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Accueil</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 30px; }
        .product-card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .product-card h3 { color: #2c3e50; margin-bottom: 10px; }
        .product-card .price { color: #27ae60; font-size: 24px; font-weight: bold; margin: 10px 0; }
        .btn { background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        .empty-state { text-align: center; padding: 60px 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛒 Mon E-Commerce</h1>
        <p>Bienvenue sur votre boutique en ligne</p>
    </div>

    <div class="container">
        <h2>Nos Produits</h2>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
<div class="product-card">
    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover">
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->description }}</p>
    <p>{{ number_format($product->price) }} CFA</p>
</div>
@endforeach

            </div>
        @else
            <div class="empty-state">
                <h3>Aucun produit disponible pour le moment</h3>
                <p>Les produits seront bientôt ajoutés !</p>
            </div>
        @endif
        
    </div>
</body>
</html>