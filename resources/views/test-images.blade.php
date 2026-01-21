<!DOCTYPE html>
<html>
<head>
    <title>Test Images</title>
</head>
<body style="background: white; padding: 20px;">
    <h1>Test des images</h1>
    
    @foreach($products as $product)
        <div style="margin: 20px; border: 1px solid #ccc; padding: 10px;">
            <h3>{{ $product->name }}</h3>
            <p>Image path: {{ $product->image }}</p>
            <p>URL: {{ route('image', ['path' => $product->image]) }}</p>
            <img 
                src="{{ route('image', ['path' => $product->image]) }}" 
                alt="{{ $product->name }}"
                style="width: 200px; height: 200px; object-fit: cover; border: 2px solid red;"
            >
        </div>
    @endforeach
</body>
</html>
