
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        label { display: block; margin-top: 15px; }

        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .error { color: #dc2626; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Produk</h1>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali input kamu:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="sku">SKU</label>
        <input id="sku" name="sku" value="{{ old('sku') }}"
               maxlength="50" required>

        <label for="name">Nama Produk</label>
        <input id="name" name="name" value="{{ old('name') }}"
               maxlength="150" required>

        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>

        <label for="price">Harga</label>
        <input id="price" type="number" name="price" min="0"
               step="0.01" value="{{ old('price', '0') }}" required>

        <label for="stock">Stok Awal</label>
        <input id="stock" type="number" name="stock" min="0"
               step="1" value="{{ old('stock', '0') }}" required>

        <label for="minimum_stock">Stok Minimum</label>
        <input id="minimum_stock" type="number" name="minimum_stock" min="0"
               step="1" value="{{ old('minimum_stock', '0') }}" required>

        <button type="submit" class="btn">Simpan Produk</button>
        <a href="{{ route('products.index') }}" class="btn">Kembali</a>
    </form>
</div>
</body>
</html>
