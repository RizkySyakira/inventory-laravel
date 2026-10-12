
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Stok</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f9;
            color: #263238;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }
        h1 { margin-top: 0; }
        a, button {
            display: inline-block;
            padding: 9px 14px;
            border: none;
            border-radius: 6px;
            background: #087f5b;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th { background: #e8f5e9; }
        .success {
            padding: 12px;
            background: #d1fae5;
            margin: 15px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Riwayat Transaksi Stok</h1>

    <a href="{{ route('products.index') }}">Kembali ke Produk</a>
    <a href="{{ route('stock-movements.create') }}">+ Transaksi Baru</a>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movements as $movement)
                <tr>
                    <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $movement->product->name }}</td>
                    <td>
                        {{ $movement->type === 'IN' ? 'Stok Masuk' : 'Stok Keluar' }}
                    </td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada transaksi stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $movements->links() }}
</div>
</body>
</html>
