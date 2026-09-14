# ============================================================
# buat-zip-hosting.ps1
# Jalankan script ini di PowerShell dari folder proyek:
#   .\buat-zip-hosting.ps1
# Menghasilkan: sistem-fasilitas.zip (siap upload ke cPanel)
# ============================================================

$ProyekDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$OutputZip = Join-Path $ProyekDir "sistem-fasilitas.zip"

# Folder & file yang DIKECUALIKAN dari ZIP
$Exclude = @(
    "node_modules",
    ".git",
    ".gitignore",
    ".gitattributes",
    "buat-zip-hosting.ps1",
    "sistem-fasilitas.zip",
    "database\database.sqlite",
    "storage\logs\*.log",
    "bootstrap\cache\*.php"
)

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   Sistem Fasilitas - Buat ZIP Hosting  " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Folder proyek : $ProyekDir" -ForegroundColor Yellow
Write-Host "Output ZIP    : $OutputZip" -ForegroundColor Yellow
Write-Host ""

# Hapus ZIP lama jika ada
if (Test-Path $OutputZip) {
    Remove-Item $OutputZip -Force
    Write-Host "ZIP lama dihapus." -ForegroundColor Gray
}

Write-Host "Mengumpulkan file..." -ForegroundColor White

# Kumpulkan semua file kecuali yang dikecualikan
$FilesToZip = Get-ChildItem -Path $ProyekDir -Recurse | Where-Object {
    $_.FullName -notmatch "\\node_modules\\" -and
    $_.FullName -notmatch "\\\.git\\" -and
    $_.FullName -notmatch "\\sistem-fasilitas\.zip$" -and
    $_.FullName -notmatch "\\buat-zip-hosting\.ps1$" -and
    $_.FullName -notmatch "\\database\\database\.sqlite$" -and
    $_.Extension -ne ".log" -and
    !$_.PSIsContainer
}

$TotalFile = $FilesToZip.Count
Write-Host "Total file   : $TotalFile file" -ForegroundColor White
Write-Host ""
Write-Host "Membuat ZIP..." -ForegroundColor White

# Buat ZIP
Add-Type -AssemblyName System.IO.Compression.FileSystem
$ZipStream = [System.IO.Compression.ZipFile]::Open($OutputZip, [System.IO.Compression.ZipArchiveMode]::Create)

$Counter = 0
foreach ($File in $FilesToZip) {
    $RelativePath = $File.FullName.Substring($ProyekDir.Length + 1)
    $RelativePath = "sistem-fasilitas\" + $RelativePath  # Folder induk di dalam ZIP
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($ZipStream, $File.FullName, $RelativePath) | Out-Null
    $Counter++
    if ($Counter % 100 -eq 0) {
        Write-Host "  $Counter / $TotalFile file diproses..." -ForegroundColor Gray
    }
}

$ZipStream.Dispose()

# Info hasil
$ZipSize = [math]::Round((Get-Item $OutputZip).Length / 1MB, 2)
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "   ZIP BERHASIL DIBUAT!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "File  : $OutputZip" -ForegroundColor Green
Write-Host "Ukuran: $ZipSize MB" -ForegroundColor Green
Write-Host ""
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host "1. Upload 'sistem-fasilitas.zip' ke cPanel File Manager > public_html/" -ForegroundColor White
Write-Host "2. Extract ZIP di sana" -ForegroundColor White
Write-Host "3. Import 'db_fasilitas_export.sql' via phpMyAdmin" -ForegroundColor White
Write-Host "4. Edit file .env di server (isi DB credentials)" -ForegroundColor White
Write-Host "5. Akses storage_link.php via browser lalu hapus" -ForegroundColor White
Write-Host "6. Lihat HOSTING_GUIDE.md untuk panduan lengkap" -ForegroundColor White
Write-Host ""
