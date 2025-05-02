<!DOCTYPE html>
<html>
<head>
    <title>Image Test</title>
</head>
<body>
    <h1>Image Test</h1>
    
    @if($product)
        <h2>Product: {{ $product->name }}</h2>
        
        <h3>Media Information:</h3>
        <ul>
            <li>First Media URL: {{ $product->getFirstMediaUrl('images') }}</li>
            <li>Media Count: {{ $product->getMedia('images')->count() }}</li>
        </ul>

        <h3>Image:</h3>
        @if($product->getFirstMediaUrl('images'))
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" style="max-width: 500px;">
        @else
            <p>No image available</p>
        @endif

        <h3>Storage Path:</h3>
        <p>{{ storage_path('app/public') }}</p>
    @else
        <p>No product found</p>
    @endif
</body>
</html> 