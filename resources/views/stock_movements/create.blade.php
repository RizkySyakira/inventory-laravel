
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Stok Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 40px;
            color: #263238;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }
        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #087f5b;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        .error {
            color: #c62828;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Transaksi Stok Baru</h1>

    <a class="back" href="{{ route('stock-movements.index') }}">
        Kembali ke Riwayat
    </a>

    @if ($errors->any())
        <div class="error">
            <p>Periksa kembali data berikut:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stock-movements.store') }}" method="POST">
        @csrf

        <label for="product_id">Produk</label>
        <select name="product_id" id="product_id" required>
            <option value="">-- Pilih Produk --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }} (Stok: {{ $product->stock }})
                </option>
            @endforeach
        </select>

        <label for="type">Jenis Transaksi</label>
        <select name="type" id="type" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="IN" {{ old('type') === 'IN' ? 'selected' : '' }}>
                Stok Masuk
            </option>
            <option value="OUT" {{ old('type') === 'OUT' ? 'selected' : '' }}>
                Stok Keluar
            </option>
        </select>

        <label for="quantity">Jumlah</label>
        <input type="number" name="quantity" id="quantity"
            min="1" value="{{ old('quantity') }}" required>

        <label for="notes">Catatan (opsional)</label>
        <textarea name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>

        <button type="submit">Simpan Transaksi</button>
    </form>
</div>
</body>
</html>
