# =============================================================
# MySQL 8.0 Root Password Reset Script
# Run this script as ADMINISTRATOR in PowerShell
# =============================================================

$mysqld   = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe"
$mysql    = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe"
$initFile = "C:\Users\Haythem\Desktop\gestion_kiosque_web\scratch\reset_root.sql"
$dataDir  = "C:\ProgramData\MySQL\MySQL Server 8.0\Data"
$defaults = "C:\ProgramData\MySQL\MySQL Server 8.0\my.ini"

Write-Host "=== MySQL Root Password Reset ===" -ForegroundColor Cyan

# Step 1 – Stop the service
Write-Host "`n[1/4] Stopping MySQL80 service..." -ForegroundColor Yellow
Stop-Service -Name MySQL80 -Force -ErrorAction Stop
Start-Sleep -Seconds 3
Write-Host "      Service stopped." -ForegroundColor Green

# Step 2 – Start mysqld with --init-file (skip networking so no clients connect)
Write-Host "`n[2/4] Starting mysqld with --init-file to reset password..." -ForegroundColor Yellow
$args = "--defaults-file=`"$defaults`" --init-file=`"$initFile`" --skip-networking --console"
$proc = Start-Process -FilePath $mysqld -ArgumentList $args -PassThru -NoNewWindow
Write-Host "      Waiting 10 seconds for init to complete..." -ForegroundColor Yellow
Start-Sleep -Seconds 10

# Step 3 – Stop the temp instance
Write-Host "`n[3/4] Stopping temporary mysqld instance..." -ForegroundColor Yellow
Stop-Process -Id $proc.Id -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 3
Write-Host "      Temporary instance stopped." -ForegroundColor Green

# Step 4 – Restart the service
Write-Host "`n[4/4] Starting MySQL80 service normally..." -ForegroundColor Yellow
Start-Service -Name MySQL80
Start-Sleep -Seconds 5
Write-Host "      Service started." -ForegroundColor Green

# Verify
Write-Host "`n=== Verifying connection with empty password ===" -ForegroundColor Cyan
$result = & $mysql -u root -e "SELECT 'CONNECTION OK' AS result;" 2>&1
Write-Host $result

Write-Host "`n=== Done! Root password is now empty. ===" -ForegroundColor Green
Write-Host "    PHP config.php is already set with empty password." -ForegroundColor White
