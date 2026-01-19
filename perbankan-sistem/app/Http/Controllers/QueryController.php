<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function home()
    {
        $totalVendors = DB::table('vendors')->count();
        $totalInvoices = DB::table('invoices')->count();
        $totalTagihan = DB::table('invoices')->sum('Total_Tagihan');
        $totalPembayaran = DB::table('pembayarans')->sum('Total_Bayar');

        // Untuk menghindari query berat, kita batasi 10 invoice terbaru
        $recentInvoices = DB::table('invoices')
            ->join('vendors', 'invoices.Vendor_ID', '=', 'vendors.Vendor_ID')
            ->select('invoices.*', 'vendors.Nama_Vendor')
            ->orderBy('Tanggal_Dokumen', 'desc')
            ->limit(10)
            ->get();

        return view('home', compact('totalVendors', 'totalInvoices', 'totalTagihan', 'totalPembayaran', 'recentInvoices'));
    }

    public function query1()
    {
        $sql = "SELECT i.Invoice_ID, v.Nama_Vendor, i.Tanggal_Dokumen, i.Total_Tagihan
                FROM invoices i
                JOIN vendors v ON i.Vendor_ID = v.Vendor_ID
                WHERE i.Total_Tagihan > (SELECT AVG(Total_Tagihan) FROM invoices)
                ORDER BY i.Total_Tagihan DESC";

        $results = DB::select($sql);
        $average = DB::table('invoices')->avg('Total_Tagihan');

        return view('query1', compact('results', 'average', 'sql'));
    }

    public function query2()
    {
        // Optimasi query untuk performa lebih baik
        $sql = "SELECT i.Invoice_ID, i.Tanggal_Dokumen,
                       COUNT(it.Item_ID) AS Jumlah_Item,
                       SUM(it.Nominal) AS Total_Nominal_Item
                FROM invoices i
                JOIN items it ON i.Invoice_ID = it.Invoice_ID
                GROUP BY i.Invoice_ID, i.Tanggal_Dokumen
                HAVING COUNT(it.Item_ID) > 1
                ORDER BY COUNT(it.Item_ID) DESC";

        $results = DB::select($sql);

        return view('query2', compact('results', 'sql'));
    }

    public function query3()
    {
        $sql = "SELECT
                    p.Pembayaran_ID,
                    v.Nama_Vendor,
                    p.Metode_Pembayaran,
                    p.Tanggal_Bayar,
                    p.Total_Bayar
                FROM pembayarans p
                JOIN invoices i ON p.Invoice_ID = i.Invoice_ID
                JOIN vendors v ON i.Vendor_ID = v.Vendor_ID
                ORDER BY p.Tanggal_Bayar DESC";

        $results = DB::select($sql);

        $sql_subquery = "SELECT *
                        FROM pembayarans
                        WHERE Invoice_ID IN (
                            SELECT Invoice_ID
                            FROM invoices
                        )";

        return view('query3', compact('results', 'sql', 'sql_subquery'));
    }

    public function query4()
    {
        $sql = "SELECT
                    i.Invoice_ID,
                    p.Nama_Petugas,
                    ip.Peran
                FROM invoices i
                JOIN invoice_petugas ip ON i.Invoice_ID = ip.Invoice_ID
                JOIN petugas p ON ip.Petugas_ID = p.Petugas_ID
                ORDER BY i.Invoice_ID, p.Nama_Petugas";

        $results = DB::select($sql);

        $sql_subquery = "SELECT
                            Invoice_ID,
                            COUNT(Petugas_ID) as jumlah_petugas
                         FROM invoice_petugas
                         GROUP BY Invoice_ID
                         HAVING COUNT(Petugas_ID) > 1
                         ORDER BY COUNT(Petugas_ID) DESC";

        $invoices_multi_petugas = DB::select($sql_subquery);

        return view('query4', compact('results', 'sql', 'sql_subquery', 'invoices_multi_petugas'));
    }

    public function query5()
    {
        $sql = "SELECT
                    v.Nama_Vendor,
                    SUM(i.Total_Tagihan) AS Total_Tagihan_Vendor
                FROM vendors v
                JOIN invoices i ON v.Vendor_ID = i.Vendor_ID
                GROUP BY v.Nama_Vendor
                ORDER BY Total_Tagihan_Vendor DESC";

        $results = DB::select($sql);

        $sql_subquery = "SELECT
                            v.Nama_Vendor,
                            SUM(i.Total_Tagihan) AS Total_Tagihan_Vendor
                         FROM vendors v
                         JOIN invoices i ON v.Vendor_ID = i.Vendor_ID
                         GROUP BY v.Nama_Vendor
                         HAVING SUM(i.Total_Tagihan) = (
                            SELECT MAX(Total_Tagihan_Vendor)
                            FROM (
                                SELECT SUM(Total_Tagihan) AS Total_Tagihan_Vendor
                                FROM invoices
                                GROUP BY Vendor_ID
                            ) AS total_vendor
                         )";

        $vendor_terbesar = DB::select($sql_subquery);

        return view('query5', compact('results', 'sql', 'sql_subquery', 'vendor_terbesar'));
    }

    public function query6()
    {
        // Query 6: Petugas divisi Keuangan dengan perannya
        $sql_join = "SELECT p.Nama_Petugas, ip.Peran
                FROM petugas p
                JOIN invoice_petugas ip ON p.Petugas_ID = ip.Petugas_ID
                WHERE p.Divisi_Pegawai = 'Keuangan'";

        $results_join = DB::select($sql_join);

        $sql_subquery = "SELECT 
                        (SELECT Nama_Petugas FROM petugas WHERE Petugas_ID = ip.Petugas_ID) AS Nama_Petugas,
                        ip.Peran
                    FROM invoice_petugas ip
                    WHERE ip.Petugas_ID IN (
                        SELECT Petugas_ID 
                        FROM petugas 
                        WHERE Divisi_Pegawai = 'Keuangan'
                    )";

        $results_subquery = DB::select($sql_subquery);

        // Hitung statistik
        $total_petugas_keuangan = DB::table('petugas')->where('Divisi_Pegawai', 'Keuangan')->count();
        $roles_count = DB::select("
        SELECT ip.Peran, COUNT(*) as jumlah
        FROM invoice_petugas ip
        WHERE ip.Petugas_ID IN (
            SELECT Petugas_ID 
            FROM petugas 
            WHERE Divisi_Pegawai = 'Keuangan'
        )
        GROUP BY ip.Peran
    ");

        return view('query6', compact('sql_join', 'sql_subquery', 'results_join', 'results_subquery', 'total_petugas_keuangan', 'roles_count'));
    }


    public function query7()
    {
        // Query 7: Vendor yang menjual item "printer"
        $sql_join = "SELECT DISTINCT v.Nama_Vendor, v.Bank_Vendor, v.No_Rekening
                FROM vendors v
                JOIN invoices i ON v.Vendor_ID = i.Vendor_ID
                JOIN items it ON i.Invoice_ID = it.Invoice_ID
                WHERE LOWER(it.Nama_Item) LIKE '%printer%'
                ORDER BY v.Nama_Vendor";

        $results_join = DB::select($sql_join);

        $sql_subquery = "SELECT Nama_Vendor, Bank_Vendor, No_Rekening
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
                    ORDER BY Nama_Vendor";

        $results_subquery = DB::select($sql_subquery);

        // Hitung statistik
        $total_vendors = DB::table('vendors')->count();
        $vendors_with_printer = count($results_join);
        $printer_percentage = ($total_vendors > 0) ? round(($vendors_with_printer / $total_vendors) * 100, 1) : 0;

        // Hitung total item printer
        $printer_items = DB::select("
        SELECT it.Nama_Item, COUNT(*) as jumlah, SUM(it.Nominal) as total_nominal
        FROM items it
        WHERE LOWER(it.Nama_Item) LIKE '%printer%'
        GROUP BY it.Nama_Item
    ");

        return view('query7', compact(
            'sql_join',
            'sql_subquery',
            'results_join',
            'results_subquery',
            'total_vendors',
            'vendors_with_printer',
            'printer_percentage',
            'printer_items'
        ));
    }

    public function query8()
    {
        // Query 8: Invoice dengan total nilai item vs total tagihan
        $sql_join = "SELECT 
                    i.Invoice_ID,
                    i.No_Referensi,
                    i.Tanggal_Dokumen,
                    i.Total_Tagihan,
                    SUM(it.Nominal) AS Total_Item,
                    (i.Total_Tagihan - SUM(it.Nominal)) AS Selisih
                FROM invoices i
                JOIN items it ON it.Invoice_ID = i.Invoice_ID
                GROUP BY i.Invoice_ID, i.No_Referensi, i.Tanggal_Dokumen, i.Total_Tagihan
                ORDER BY ABS(i.Total_Tagihan - SUM(it.Nominal)) DESC";

        $results_join = DB::select($sql_join);

        $sql_subquery = "SELECT 
                        i.Invoice_ID,
                        i.No_Referensi,
                        i.Tanggal_Dokumen,
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
                    )) DESC";

        $results_subquery = DB::select($sql_subquery);

        // Hitung statistik
        $total_invoices = count($results_join);
        $exact_match = 0;
        $overcharge = 0;
        $undercharge = 0;

        foreach ($results_join as $row) {
            if ($row->Selisih == 0)
                $exact_match++;
            elseif ($row->Selisih > 0)
                $overcharge++;
            else
                $undercharge++;
        }

        return view('query8', compact(
            'sql_join',
            'sql_subquery',
            'results_join',
            'results_subquery',
            'total_invoices',
            'exact_match',
            'overcharge',
            'undercharge'
        ));
    }

    public function query9()
    {
        // Query 9: Petugas dengan jumlah invoice yang ditangani
        $sql_join = "SELECT 
                    p.Petugas_ID,
                    p.Nama_Petugas,
                    p.Jabatan_Pegawai,
                    p.Divisi_Pegawai,
                    COUNT(ip.Invoice_ID) AS Jumlah_Invoice,
                    GROUP_CONCAT(DISTINCT ip.Peran ORDER BY ip.Peran SEPARATOR ', ') AS Peran_Peran
                FROM petugas p
                JOIN invoice_petugas ip ON ip.Petugas_ID = p.Petugas_ID
                GROUP BY p.Petugas_ID, p.Nama_Petugas, p.Jabatan_Pegawai, p.Divisi_Pegawai
                ORDER BY COUNT(ip.Invoice_ID) DESC";

        $results_join = DB::select($sql_join);

        $sql_subquery = "SELECT 
                        p.Petugas_ID,
                        p.Nama_Petugas,
                        p.Jabatan_Pegawai,
                        p.Divisi_Pegawai,
                        (
                            SELECT COUNT(ip.Invoice_ID)
                            FROM invoice_petugas ip
                            WHERE ip.Petugas_ID = p.Petugas_ID
                        ) AS Jumlah_Invoice,
                        (
                            SELECT GROUP_CONCAT(DISTINCT ip.Peran ORDER BY ip.Peran SEPARATOR ', ')
                            FROM invoice_petugas ip
                            WHERE ip.Petugas_ID = p.Petugas_ID
                        ) AS Peran_Peran
                    FROM petugas p
                    ORDER BY (
                        SELECT COUNT(ip.Invoice_ID)
                        FROM invoice_petugas ip
                        WHERE ip.Petugas_ID = p.Petugas_ID
                    ) DESC";

        $results_subquery = DB::select($sql_subquery);

        // Hitung statistik
        $total_petugas = DB::table('petugas')->count();
        $petugas_aktif = DB::table('invoice_petugas')->distinct('Petugas_ID')->count('Petugas_ID');
        $total_invoices_petugas = DB::table('invoice_petugas')->count();
        $avg_invoice_per_petugas = $petugas_aktif > 0 ? round($total_invoices_petugas / $petugas_aktif, 1) : 0;

        return view('query9', compact(
            'sql_join',
            'sql_subquery',
            'results_join',
            'results_subquery',
            'total_petugas',
            'petugas_aktif',
            'total_invoices_petugas',
            'avg_invoice_per_petugas'
        ));
    }
}