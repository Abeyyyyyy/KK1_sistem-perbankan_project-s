@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 4: Invoice dengan Petugas yang Terlibat</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan invoice beserta nama petugas yang terlibat, untuk invoice yang ditangani oleh lebih dari satu petugas.
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT
    invoice.Invoice_ID,
    petugas.Nama_Petugas,
    invoice_petugas.Peran
FROM invoice
JOIN invoice_petugas
    ON invoice.Invoice_ID = invoice_petugas.Invoice_ID
JOIN petugas
    ON invoice_petugas.Petugas_ID = petugas.Petugas_ID;
    </div>
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT
    Invoice_ID
FROM invoice_petugas
GROUP BY Invoice_ID
HAVING COUNT(Petugas_ID) > 1;
    </div>
    
    <h3>🎯 Invoice dengan > 1 Petugas (Hasil Subquery):</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Jumlah Petugas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices_multi_petugas as $row)
            <tr>
                <td>INV-{{ str_pad($row->Invoice_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <?php 
                        $count = DB::select("SELECT COUNT(*) as total FROM invoice_petugas WHERE Invoice_ID = ?", [$row->Invoice_ID])[0]->total;
                    ?>
                    <span class="badge">{{ $count }} Petugas</span>
                </td>
                <td><span style="color: #1D546C; font-weight: bold;">✓ Ditangani Tim</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>🎯 Detail Petugas per Invoice (Hasil JOIN):</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Nama Petugas</th>
                <th>Peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>INV-{{ str_pad($row->Invoice_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $row->Nama_Petugas }}</td>
                <td><span class="badge">{{ $row->Peran }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection