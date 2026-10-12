
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris</title>

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
            margin-bottom: 25px;
        }

        .menu a {
            display: inline-block;
            margin: 0 8px 8px 0;
            padding: 10px 15px;
            background: #166534;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #00000010;
        }

        .card h3 {
            margin-top: 0;
            font-size: 15px;
            color: #666;
        }

        .angka {
            font-size: 28px;
            font-weight: bold;
            color: #166534;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 25px;
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

        .menipis {
            color: #dc2626;
            font-weight: bold;
        }

        .kosong {
            color: #15803d;
            padding: 15px;
            background: white;
        }
    </style>
</head>

<body>
    <h1>Dashboard Inventaris</h1>
    <p>Ringkasan kondisi persediaan produk kamu.</p>

    <div class="menu">
        <a href="{{ route('products.index') }}">Data Produk</a>
        <a href="{{ route('stock-movements.index') }}">Transaksi Stok</a>
        <a href="{{ route('stock-reports.index') }}">Laporan Stok</a>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Total Produk</h3>
            <div class="angka">{{ $totalProducts }}</div>
        </div>

        <div class="card">
            <h3>Total Stok</h3>
            <div class="angka">{{ number_format($totalStock, 0, ',', '.') }}</div>
            <p>Unit barang</p>
        </div>

        <div class="card">
            <h3>Produk Stok Menipis</h3>
            <div class="angka">{{ $lowStockProducts->count() }}</div>
        </div>

        <div class="card">
            <h3>Total Transaksi Stok</h3>
            <div class="angka">{{ $totalMovements }}</div>
        </div>
    </div>

    <h2>Produk dengan Stok Menipis</h2>

    @if ($lowStockProducts->isEmpty())
        <p class="kosong">Semua produk memiliki stok di atas batas minimum.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Stok Minimum</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="menipis">{{ $product->stock }}</td>
                        <td>{{ $product->minimum_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>5 Transaksi Stok Terbaru</h2>

    @if ($recentMovements->isEmpty())
        <p class="kosong">Belum ada transaksi stok.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentMovements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $movement->product->name ?? '-' }}</td>
                        <td>{{ $movement->type }}</td>
                        <td>{{ $movement->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
