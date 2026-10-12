<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan CampRent</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #FF7A00;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #FF7A00;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .summary-box {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box td {
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            text-align: center;
        }
        .summary-box .value {
            font-size: 18px;
            font-weight: bold;
            color: #111;
        }
        .summary-box .label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penyewaan CampRent</h1>
        <p>
            @if($monthFilter)
                Periode: {{ \Carbon\Carbon::parse($monthFilter)->translatedFormat('F Y') }}
            @else
                Periode: Keseluruhan
            @endif
        </p>
    </div>

    <h3>Ringkasan</h3>
    <table class="summary-box">
        <tr>
            <td>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="label">Total Pendapatan</div>
            </td>
            <td>
                <div class="value">{{ $bookingSelesai }}</div>
                <div class="label">Selesai</div>
            </td>
            <td>
                <div class="value">{{ $bookingAktif }}</div>
                <div class="label">Aktif</div>
            </td>
            <td>
                <div class="value">{{ $bookingBatal }}</div>
                <div class="label">Batal</div>
            </td>
        </tr>
    </table>

    <h3>Ringkasan Per Bulan</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="text-center">Total Booking</th>
                <th class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monthlyStats as $row)
                <tr>
                    <td>{{ $row->bulan }}</td>
                    <td class="text-center">{{ $row->total }}</td>
                    <td class="text-right">Rp {{ number_format($row->pendapatan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Daftar Transaksi</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Kode Booking</th>
                <th>Pelanggan</th>
                <th>Tanggal Sewa</th>
                <th>Status</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
