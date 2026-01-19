@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 5: Vendor dengan Total Tagihan Terbesar</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan vendor beserta total seluruh tagihan invoice yang dimilikinya, untuk vendor dengan total tagihan terbesar.
    </div>
    
    <h3>✅ SQL JOIN (Semua Vendor):</h3>
    <div class="sql-box">
SELECT
    vendor.Nama_Vendor,
    SUM(invoice.Total_Tagihan) AS Total_Tagihan_Vendor
FROM vendor
JOIN invoice
    ON vendor.Vendor_ID = invoice.Vendor_ID
GROUP BY vendor.Nama_Vendor
ORDER BY Total_Tagihan_Vendor DESC;
    </div>
    
    <h3>✅ SQL Bertingkat (Vendor Terbesar):</h3>
    <div class="sql-box">
SELECT
    vendor.Nama_Vendor,
    SUM(invoice.Total_Tagihan) AS Total_Tagihan_Vendor
FROM vendor
JOIN invoice
    ON vendor.Vendor_ID = invoice.Vendor_ID
GROUP BY vendor.Nama_Vendor
HAVING SUM(invoice.Total_Tagihan) = (
    SELECT MAX(Total_Tagihan_Vendor)
    FROM (
        SELECT SUM(Total_Tagihan) AS Total_Tagihan_Vendor
        FROM invoice
        GROUP BY Vendor_ID
    ) AS total_vendor
);
    </div>
    
    <h3>🏆 Vendor dengan Total Tagihan Terbesar:</h3>
    <div style="background-color: #e8f4fd; padding: 2rem; border-radius: 8px; text-align: center; margin: 1rem 0;">
        <h2 style="color: #1A3D64; margin-bottom: 0.5rem;">
            🥇 {{ $vendor_terbesar[0]->Nama_Vendor ?? 'Tidak ada data' }}
        </h2>
        <p style="font-size: 1.5rem; color: #1D546C; font-weight: bold;">
            Total Tagihan: Rp {{ isset($vendor_terbesar[0]) ? number_format($vendor_terbesar[0]->Total_Tagihan_Vendor, 0, ',', '.') : '0' }}
        </p>
    </div>
    
    <h3>📊 Ranking Semua Vendor:</h3>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Vendor</th>
                <th>Total Tagihan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_all = DB::table('invoices')->sum('Total_Tagihan');
                $rank = 1;
            @endphp
            @foreach($results as $row)
            <tr style="{{ $row->Nama_Vendor == ($vendor_terbesar[0]->Nama_Vendor ?? '') ? 'background-color: #f0f8ff; font-weight: bold;' : '' }}">
                <td>
                    @if($rank == 1)
                        🥇
                    @elseif($rank == 2)
                        🥈
                    @elseif($rank == 3)
                        🥉
                    @else
                        #{{ $rank }}
                    @endif
                </td>
                <td>{{ $row->Nama_Vendor }}</td>
                <td style="color: #1A3D64; font-weight: bold;">
                    Rp {{ number_format($row->Total_Tagihan_Vendor, 0, ',', '.') }}
                </td>
                <td>
                    @php
                        $percentage = ($total_all > 0) ? ($row->Total_Tagihan_Vendor / $total_all) * 100 : 0;
                    @endphp
                    <div style="background-color: #e0e0e0; border-radius: 4px; height: 20px; margin: 5px 0;">
                        <div style="background-color: #1D546C; height: 100%; width: {{ $percentage }}%; border-radius: 4px;"></div>
                    </div>
                    {{ number_format($percentage, 1) }}%
                </td>
            </tr>
            @php $rank++; @endphp
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection