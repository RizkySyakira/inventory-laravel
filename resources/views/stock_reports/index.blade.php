
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f7fa;
            color: #333;
        }

        h1 {
            color: #166534;
        }

        .menu {
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 8px;
            background: #166534;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #166534;
            color: white;
        }

        .aman {
            color: #15803d;
            font-weight: bold;
        }

        .menipis {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Stok Produk</h1>
    
<form action="{{ route('stock-reports.index') }}" method="GET"
      style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">

    <input
        type="text"
        name="search"
        placeholder="Cari nama produk atau SKU..."
        value="{{ request('search') }}"
        style="padding: 10px; min-width: 220px;"
    >

    <select name="status" style="padding: 10px;">
        <option value="">Semua Status</option>
        <option value="aman" {{ request('status') === 'aman' ? 'selected' : '' }}>
            Stok Aman
        </option>
        <option value="menipis" {{ request('status') === 'menipis' ? 'selected' : '' }}>
            Stok Menipis
        </option>
    </select>

    <button type="submit"
            style="padding: 10px 15px; background: #166534; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Cari / Filter
    </button>

    <a href="{{ route('stock-reports.index') }}"
       style="padding: 10px 15px; background: #e5e7eb; color: #333; text-decoration: none; border-radius: 5px;">
        Reset
    </a>
</form>


    <div class="menu">
        <a href="{{ route('products.index') }}">Data Produk</a>
        <a href="{{ route('stock-movements.index') }}">Riwayat Transaksi</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok Saat Ini</th>
                <th>Stok Minimum</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->minimum_stock }}</td>
                    <td>
                        @if ($product->stock <= $product->minimum_stock)
                            <span class="menipis">Stok Menipis</span>
                        @else
                            <span class="aman">Stok Aman</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $products->links() }}
    </div>
</body>
</html>
