@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 7: Vendor yang Menjual Item "Printer"</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan daftar vendor yang menjual item dengan nama "printer" (atau mengandung kata printer) beserta informasi bank dan nomor rekening mereka.
    </div>
    
    <div class="stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Vendor</div>
            <div class="stat-number">{{ $total_vendors }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Vendor Jual Printer</div>
            <div class="stat-number">{{ $vendors_with_printer }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Persentase</div>
            <div class="stat-number">{{ $printer_percentage }}%</div>
        </div>
    </div>
    
    <div style="background-color: #e8f4fd; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        <strong>📊 Status:</strong> 
        <span style="color: {{ $printer_percentage > 0 ? '#28a745' : '#dc3545' }}; font-weight: bold;">
            @if($printer_percentage == 100)
            ✅ Semua vendor menjual printer
            @elseif($printer_percentage > 50)
            ✅ Mayoritas vendor menjual printer
            @elseif($printer_percentage > 0)
            ⚠ Beberapa vendor menjual printer
            @else
            ❌ Tidak ada vendor yang menjual printer
            @endif
        </span>
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT DISTINCT
    v.Nama_Vendor,
    v.Bank_Vendor,
    v.No_Rekening
FROM vendors v
JOIN invoices i ON v.Vendor_ID = i.Vendor_ID
JOIN items it ON i.Invoice_ID = it.Invoice_ID
WHERE LOWER(it.Nama_Item) LIKE '%printer%'
ORDER BY v.Nama_Vendor;
    </div>
    
    <h3>🎯 Hasil Query JOIN:</h3>
    @if(count($results_join) > 0)
    <table>
        <thead>
            <tr>
                <th>Nama Vendor</th>
                <th>Bank</th>
                <th>Nomor Rekening</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results_join as $row)
            <tr>
                <td>{{ $row->Nama_Vendor }}</td>
                <td><span class="badge">{{ $row->Bank_Vendor }}</span></td>
                <td><code>{{ $row->No_Rekening }}</code></td>
                <td><span style="color: #28a745; font-weight: bold;">✓ Jual Printer</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
        <strong>⚠ Tidak ada data:</strong> Tidak ditemukan vendor yang menjual item dengan nama "printer".
    </div>
    @endif
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT Nama_Vendor, Bank_Vendor, No_Rekening
FROM vendors
WHERE Vendor_ID IN (
    SELECT Vendor_ID
    FROM invoices
    WHERE Invoice_ID IN (
        SELECT Invoice_ID
        FROM items
        WHERE LOWER(Nama_Item) LIKE '%printer%'
    )
)
ORDER BY Nama_Vendor;
    </div>
    
    <h3>🎯 Hasil Query SUBQUERY:</h3>
    @if(count($results_subquery) > 0)
    <table>
        <thead>
            <tr>
                <th>Nama Vendor</th>
                <th>Bank</th>
                <th>Nomor Rekening</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results_subquery as $row)
            <tr>
                <td>{{ $row->Nama_Vendor }}</td>
                <td><span class="badge">{{ $row->Bank_Vendor }}</span></td>
                <td><code>{{ $row->No_Rekening }}</code></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
        <strong>⚠ Tidak ada data:</strong> Tidak ditemukan vendor yang menjual item dengan nama "printer".
    </div>
    @endif
    
    <h3>🖨️ Detail Item Printer:</h3>
    @if(count($printer_items) > 0)
    <table>
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Jumlah Transaksi</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($printer_items as $item)
            <tr>
                <td>{{ ucfirst($item->Nama_Item) }}</td>
                <td>{{ $item->jumlah }} transaksi</td>
                <td style="color: #1A3D64; font-weight: bold;">
                    Rp {{ number_format($item->total_nominal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="background-color: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; margin: 1rem 0;">
        <strong>ℹ Info:</strong> Tidak ditemukan item dengan nama "printer" dalam database.
    </div>
    @endif
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection