@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Query 9: Beban Kerja Petugas</h2>
    </div>
    
    <div class="highlight">
        <strong>📌 Kalimat Informasi:</strong> Menampilkan informasi petugas beserta jumlah invoice yang ditangani, untuk mengetahui beban kerja setiap petugas berdasarkan jumlah invoice yang menjadi tanggung jawabnya.
    </div>
    
    <div class="stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Petugas</div>
            <div class="stat-number">{{ $total_petugas }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Petugas Aktif</div>
            <div class="stat-number">{{ $petugas_aktif }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Invoice</div>
            <div class="stat-number">{{ $total_invoices_petugas }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rata-rata</div>
            <div class="stat-number">{{ $avg_invoice_per_petugas }}/org</div>
        </div>
    </div>
    
    <h3>✅ SQL JOIN:</h3>
    <div class="sql-box">
SELECT 
    p.Petugas_ID,
    p.Nama_Petugas,
    p.Jabatan_Pegawai,
    COUNT(ip.Invoice_ID) AS Jumlah_Invoice
FROM petugas p
JOIN invoice_petugas ip ON ip.Petugas_ID = p.Petugas_ID
GROUP BY p.Petugas_ID, p.Nama_Petugas, p.Jabatan_Pegawai
ORDER BY COUNT(ip.Invoice_ID) DESC;
    </div>
    
    <h3>🎯 Hasil Query JOIN:</h3>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Petugas</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th>Jumlah Invoice</th>
                <th>Peran</th>
                <th>Status Beban</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach($results_join as $row)
            <tr>
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
                <td>{{ $row->Nama_Petugas }}</td>
                <td><span class="badge" style="background-color: #0C2B4E;">{{ $row->Jabatan_Pegawai }}</span></td>
                <td><span class="badge" style="background-color: #1A3D64;">{{ $row->Divisi_Pegawai }}</span></td>
                <td style="color: #1D546C; font-weight: bold;">
                    {{ $row->Jumlah_Invoice }} invoice
                </td>
                <td>
                    @if(!empty($row->Peran_Peran))
                        <small>{{ $row->Peran_Peran }}</small>
                    @else
                        <small style="color: #666;">-</small>
                    @endif
                </td>
                <td>
                    @php
                        $workload = $row->Jumlah_Invoice;
                        if($workload >= $avg_invoice_per_petugas * 1.5) {
                            $status = 'Tinggi';
                            $color = '#dc3545';
                        } elseif($workload >= $avg_invoice_per_petugas) {
                            $status = 'Sedang';
                            $color = '#ffc107';
                        } else {
                            $status = 'Rendah';
                            $color = '#28a745';
                        }
                    @endphp
                    <span class="badge" style="background-color: {{ $color }};">{{ $status }}</span>
                </td>
            </tr>
            @php $rank++; @endphp
            @endforeach
        </tbody>
    </table>
    
    <h3>✅ SQL Bertingkat (SUBQUERY):</h3>
    <div class="sql-box">
SELECT 
    p.Petugas_ID,
    p.Nama_Petugas,
    p.Jabatan_Pegawai,
    (
        SELECT COUNT(ip.Invoice_ID)
        FROM invoice_petugas ip
        WHERE ip.Petugas_ID = p.Petugas_ID
    ) AS Jumlah_Invoice
FROM petugas p
ORDER BY (
    SELECT COUNT(ip.Invoice_ID)
    FROM invoice_petugas ip
    WHERE ip.Petugas_ID = p.Petugas_ID
) DESC;
    </div>
    
    <h3>📊 Grafik Beban Kerja:</h3>
    <div style="background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1rem 0;">
        <h4 style="margin-bottom: 1rem;">Distribusi Beban Kerja Petugas</h4>
        @foreach($results_join as $row)
        <div style="margin-bottom: 0.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                <span>{{ $row->Nama_Petugas }}</span>
                <span style="font-weight: bold;">{{ $row->Jumlah_Invoice }} invoice</span>
            </div>
            @php
                $max_invoice = $results_join[0]->Jumlah_Invoice;
                $width = $max_invoice > 0 ? ($row->Jumlah_Invoice / $max_invoice) * 100 : 0;
                
                if($row->Jumlah_Invoice >= $avg_invoice_per_petugas * 1.5) {
                    $color = '#dc3545';
                } elseif($row->Jumlah_Invoice >= $avg_invoice_per_petugas) {
                    $color = '#ffc107';
                } else {
                    $color = '#28a745';
                }
            @endphp
            <div style="background-color: #e0e0e0; border-radius: 4px; height: 20px;">
                <div style="background-color: {{ $color }}; height: 100%; width: {{ $width }}%; border-radius: 4px;"></div>
            </div>
        </div>
        @endforeach
        
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #ddd;">
            <div style="display: flex; gap: 1rem;">
                <div style="display: flex; align-items: center;">
                    <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 5px;"></div>
                    <small>Beban Tinggi (>{{ round($avg_invoice_per_petugas * 1.5) }} invoice)</small>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 15px; height: 15px; background-color: #ffc107; margin-right: 5px;"></div>
                    <small>Beban Sedang ({{ round($avg_invoice_per_petugas) }}-{{ round($avg_invoice_per_petugas * 1.5) }} invoice)</small>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 5px;"></div>
                    <small>Beban Rendah (<{{ round($avg_invoice_per_petugas) }} invoice)</small>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/" class="btn">🏠 Kembali ke Home</a>
    </div>
</div>
@endsection