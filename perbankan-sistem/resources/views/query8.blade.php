@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 8: Invoice vs Total Nilai Item</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan informasi invoice beserta total nilai item, untuk mengetahui total nominal seluruh item pada setiap invoice dan membandingkannya dengan total tagihan invoice.
    </div>
    
    <div class="stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Invoice</div>
            <div class="stat-number">{{ $total_invoices }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sesuai</div>
            <div class="stat-number">{{ $exact_match }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Lebih Besar</div>
            <div class="stat-number">{{ $overcharge }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Lebih Kecil</div>
            <div class="stat-number">{{ $undercharge }}</div>
        </div>
    </div>
    
    <div style="background-color: #e8f4fd; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        <strong>📊 Keterangan:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            <li><strong>Sesuai:</strong> Total Tagihan = Total Item (Selisih = 0)</li>
            <li><strong>Lebih Besar:</strong> Total Tagihan > Total Item (Selisih positif)</li>
            <li><strong>Lebih Kecil:</strong> Total Tagihan < Total Item (Selisih negatif)</li>
        </ul>
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT 
    i.Invoice_ID,
    i.No_Referensi,
    i.Total_Tagihan,
    SUM(it.Nominal) AS Total_Item,
    (i.Total_Tagihan - SUM(it.Nominal)) AS Selisih
FROM invoices i
JOIN items it ON it.Invoice_ID = i.Invoice_ID
GROUP BY i.Invoice_ID, i.No_Referensi, i.Total_Tagihan
ORDER BY ABS(i.Total_Tagihan - SUM(it.Nominal)) DESC;
    </div>
    
    <h3>🎯 Hasil Query JOIN:</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>No. Referensi</th>
                <th>Tanggal</th>
                <th>Total Tagihan</th>
                <th>Total Item</th>
                <th>Selisih</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results_join as $row)
            <tr>
                <td>INV-{{ str_pad($row->Invoice_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $row->No_Referensi }}</td>
                <td>{{ date('d/m/Y', strtotime($row->Tanggal_Dokumen)) }}</td>
                <td style="color: #1A3D64; font-weight: bold;">
                    Rp {{ number_format($row->Total_Tagihan, 0, ',', '.') }}
                </td>
                <td style="color: #1D546C; font-weight: bold;">
                    Rp {{ number_format($row->Total_Item, 0, ',', '.') }}
                </td>
                <td style="font-weight: bold; color: {{ $row->Selisih == 0 ? '#28a745' : ($row->Selisih > 0 ? '#ffc107' : '#dc3545') }};">
                    Rp {{ number_format($row->Selisih, 0, ',', '.') }}
                </td>
                <td>
                    @if($row->Selisih == 0)
                        <span class="badge" style="background-color: #28a745;">✓ Sesuai</span>
                    @elseif($row->Selisih > 0)
                        <span class="badge" style="background-color: #ffc107;">↑ Lebih Besar</span>
                    @else
                        <span class="badge" style="background-color: #dc3545;">↓ Lebih Kecil</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT 
    i.Invoice_ID,
    i.No_Referensi,
    i.Total_Tagihan,
    (
        SELECT SUM(it.Nominal)
        FROM items it
        WHERE it.Invoice_ID = i.Invoice_ID
    ) AS Total_Item,
    (i.Total_Tagihan - (
        SELECT SUM(it.Nominal)
        FROM items it
        WHERE it.Invoice_ID = i.Invoice_ID
    )) AS Selisih
FROM invoices i
ORDER BY ABS(i.Total_Tagihan - (
    SELECT SUM(it.Nominal)
    FROM items it
    WHERE it.Invoice_ID = i.Invoice_ID
)) DESC;
    </div>
    
    <h3>📊 Distribusi Selisih:</h3>
    <div style="display: flex; gap: 1rem; margin: 1rem 0;">
        @php
            $exact_percentage = $total_invoices > 0 ? round(($exact_match / $total_invoices) * 100, 1) : 0;
            $over_percentage = $total_invoices > 0 ? round(($overcharge / $total_invoices) * 100, 1) : 0;
            $under_percentage = $total_invoices > 0 ? round(($undercharge / $total_invoices) * 100, 1) : 0;
        @endphp
        
        <div style="flex: 1; background-color: #28a745; color: white; padding: 1rem; border-radius: 4px; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: bold;">{{ $exact_match }}</div>
            <div>Sesuai</div>
            <div>{{ $exact_percentage }}%</div>
        </div>
        
        <div style="flex: 1; background-color: #ffc107; color: #212529; padding: 1rem; border-radius: 4px; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: bold;">{{ $overcharge }}</div>
            <div>Lebih Besar</div>
            <div>{{ $over_percentage }}%</div>
        </div>
        
        <div style="flex: 1; background-color: #dc3545; color: white; padding: 1rem; border-radius: 4px; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: bold;">{{ $undercharge }}</div>
            <div>Lebih Kecil</div>
            <div>{{ $under_percentage }}%</div>
        </div>
    </div>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection