@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 1: Invoice dengan Total Tagihan di Atas Rata-rata</h2>
    </div>
    
    <div style="background-color: #e8f4fd; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        <strong>Rata-rata Total Tagihan:</strong> Rp {{ number_format($average, 0, ',', '.') }}
    </div>
    
    <h3>SQL Query:</h3>
    <div class="sql-box">{{ $sql }}</div>
    
    <h3>Hasil Query:</h3>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Nama Vendor</th>
                <th>Tanggal Dokumen</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>INV-{{ str_pad($row->Invoice_ID, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $row->Nama_Vendor }}</td>
                <td>{{ date('d/m/Y', strtotime($row->Tanggal_Dokumen)) }}</td>
                <td style="color: #1A3D64; font-weight: bold;">Rp {{ number_format($row->Total_Tagihan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">← Kembali ke Home</a>
    </div>
</div>
@endsection