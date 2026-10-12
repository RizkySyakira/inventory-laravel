
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Inventory Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #263238;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #00000010;
        }

        h1 { margin-top: 0; }

        .btn {
            display: inline-block;
            padding: 9px 13px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary { background: #64748b; }
        .btn-warning { background: #d97706; }
        .btn-danger { background: #dc2626; }

        .toolbar {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        input, select {
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th { background: #eff6ff; }

        .alert {
            padding: 12px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }

        .actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination { margin-top: 20px; }

        @media (max-width: 700px) {
            body { padding: 10px; }
            .container { padding: 15px; overflow-x: auto; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Inventory Management</h1>
    <p>Kelola data produk dan persediaan barang.</p>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="toolbar">
        <form action="{{ route('products.index') }}" method="GET">
            <input
                type="text"
                name="search"
                placeholder="Cari nama atau SKU..."
                value="{{ request('search') }}"
            >

            <select name="category_id">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort">
                @foreach ([
                    'created_at' => 'Tanggal dibuat',
                    'name' => 'Nama',
                    'sku' => 'SKU',
                    'price' => 'Harga',
                    'stock' => 'Stok'
                ] as $key => $label)
                    <option value="{{ $key }}" {{ $sort === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select name="direction">
                <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>
                    Naik
                </option>
                <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>
                    Turun
                </option>
            </select>

            <button type="submit" class="btn">Terapkan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </form>

        <a href="{{ route('products.create') }}" class="btn">
            + Tambah Produk
        </a>
    </div>

    <table>
        <thead>
        <tr>
            <th>No.</th>
            <th>SKU</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Stok Minimum</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $products->firstItem() + $loop->index }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->minimum_stock }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('products.show', $product) }}"
                           class="btn btn-secondary">Detail</a>

                        <a href="{{ route('products.edit', $product) }}"
                           class="btn btn-warning">Edit</a>

                        <form action="{{ route('products.destroy', $product) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center;">
                    Belum ada data produk.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>
</body>
</html>
