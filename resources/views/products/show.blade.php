
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        .container { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
        td:first-child { font-weight: bold; width: 35%; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #2563eb; color: white; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h1>Detail Produk</h1>

    <table>
        <tr><td>SKU</td><td>{{ $product->sku }}</td></tr>
        <tr><td>Nama Produk</td><td>{{ $product->name }}</td></tr>
        <tr><td>Kategori</td><td>{{ $product->category->name }}</td></tr>
        <tr><td>Deskripsi</td><td>{{ $product->description ?: '-' }}</td></tr>
        <tr><td>Harga</td><td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td></tr>
        <tr><td>Stok</td><td>{{ $product->stock }}</td></tr>
        <tr><td>Stok Minimum</td><td>{{ $product->minimum_stock }}</td></tr>
        <tr><td>Dibuat</td><td>{{ $product->created_at->format('d-m-Y H:i') }}</td></tr>
        <tr><td>Diperbarui</td><td>{{ $product->updated_at->format('d-m-Y H:i') }}</td></tr>
    </table>

    <a href="{{ route('products.index') }}" class="btn">Kembali ke Daftar Produk</a>
    <a href="{{ route('products.edit', $product) }}" class="btn">Edit Produk</a>
</div>
</body>
</html>
