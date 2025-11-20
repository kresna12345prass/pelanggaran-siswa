<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;


class BackupController extends Controller
{
    // Menampilkan halaman daftar file backup yang tersedia
    public function index()
    {
        $backups = [];
        $backupDir = storage_path('app/backups');
        
        // Membuat folder backup jika belum ada
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        // Membaca semua file backup dari folder
        if (is_dir($backupDir)) {
            $files = scandir($backupDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filePath = $backupDir . '/' . $file;
                    $backups[] = [
                        'filename' => $file,
                        'size' => $this->formatSize(filesize($filePath)),
                        'created_at' => Carbon::createFromTimestamp(filemtime($filePath)),
                        'path' => $filePath
                    ];
                }
            }
        }

        // Mengurutkan file dari yang terbaru
        $backups = collect($backups)->sortByDesc('created_at');

        return view('admin.backup.index', compact('backups'));
    }

    // Membuat file backup database baru
    public function create()
    {
        try {
            $filename = "backup-" . Carbon::now()->format('Y-m-d-H-i-s') . ".sql";
            
            // Membuat folder backup jika belum ada
            $backupDir = storage_path('app/backups');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $path = $backupDir . '/' . $filename;

            // Generate SQL backup menggunakan PHP
            $sql = $this->generateBackupSQL();
            
            if (empty($sql)) {
                return redirect()->back()->with('error', 'Gagal mengambil data dari database');
            }

            file_put_contents($path, $sql);

            if (!file_exists($path) || filesize($path) < 100) {
                return redirect()->back()->with('error', 'File backup gagal dibuat');
            }

            return redirect()->back()->with('success', 'Backup berhasil: ' . $filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Generate SQL backup dari semua tabel database
    private function generateBackupSQL()
    {
        $sql = "-- Database Backup\n";
        $sql .= "-- Generated: " . Carbon::now() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        try {
            // Mengambil semua tabel dari database
            $tables = \DB::select('SHOW TABLES');
            $dbName = env('DB_DATABASE');
            
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_{$dbName}"};
                
                // Mengambil struktur tabel
                $createTable = \DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Mengambil data dari tabel
                $rows = \DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "INSERT INTO `{$tableName}` VALUES\n";
                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = [];
                        foreach ($row as $value) {
                            $rowData[] = is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                        }
                        $values[] = '(' . implode(',', $rowData) . ')';
                    }
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            return $sql;
            
        } catch (\Exception $e) {
            Log::error('Backup SQL generation failed: ' . $e->getMessage());
            return null;
        }
    }

    // Download file backup
    public function download($filename)
    {
        // Validasi nama file untuk keamanan
        if (!preg_match('/^backup-\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
            return redirect()->back()->with('error', 'Nama file tidak valid.');
        }

        $path = storage_path("app/backups/{$filename}");
        if (file_exists($path)) {
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    // Menghapus file backup
    public function destroy($filename)
    {
        // Validasi nama file untuk keamanan
        if (!preg_match('/^backup-\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
            return redirect()->back()->with('error', 'Nama file tidak valid.');
        }

        $path = "backups/" . $filename;
        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    // Export daftar riwayat backup ke Excel
    public function export()
    {
        $backups = [];
        $backupDir = storage_path('app/backups');
        
        // Membuat folder backup jika belum ada
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        // Membaca semua file backup dari folder
        if (is_dir($backupDir)) {
            $files = scandir($backupDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $filePath = $backupDir . '/' . $file;
                    $backups[] = [
                        'filename' => $file,
                        'size' => $this->formatSize(filesize($filePath)),
                        'created_at' => Carbon::createFromTimestamp(filemtime($filePath))->format('d M Y, H:i:s'),
                        'path' => $filePath
                    ];
                }
            }
        }

        // Mengurutkan file dari yang terbaru
        $backups = collect($backups)->sortByDesc('created_at');

        // Menyiapkan data untuk Excel dengan styling
        $data = [
            // Header dengan styling
            ['<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font="Calibri" bold="1" height="25" border="1">No</style>',
             '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font="Calibri" bold="1" height="25" border="1">Nama File</style>',
             '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font="Calibri" bold="1" height="25" border="1">Ukuran</style>',
             '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font="Calibri" bold="1" height="25" border="1">Tanggal Backup</style>']
        ];

        foreach ($backups as $index => $backup) {
            $rowColor = ($index % 2 == 0) ? '#F2F2F2' : '#FFFFFF';
            $data[] = [
                '<style bgcolor="' . $rowColor . '" font-size="11" font="Calibri" border="1" align="center">' . ($index + 1) . '</style>',
                '<style bgcolor="' . $rowColor . '" font-size="11" font="Calibri" border="1">' . $backup['filename'] . '</style>',
                '<style bgcolor="' . $rowColor . '" font-size="11" font="Calibri" border="1" align="center">' . $backup['size'] . '</style>',
                '<style bgcolor="' . $rowColor . '" font-size="11" font="Calibri" border="1" align="center">' . $backup['created_at'] . '</style>'
            ];
        }

        $filename = 'riwayat-backup-' . Carbon::now()->format('Y-m-d-H-i-s') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);
        
        // Membuat folder temp jika belum ada
        if (!is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        
        $xlsx = SimpleXLSXGen::fromArray($data);
        $xlsx->saveAs($tempPath);
        
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    // Helper untuk format ukuran file (Bytes ke KB/MB/GB)
    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / (1024 ** $pow), 2) . ' ' . $units[$pow];
    }
}