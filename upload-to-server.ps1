# NetroHub Server Upload Script
# Run this from your Windows machine to upload configuration files to your Ubuntu server

param(
    [Parameter(Mandatory=$true)]
    [string]$ServerIP,
    
    [Parameter(Mandatory=$false)]
    [string]$ServerUser = "root",
    
    [Parameter(Mandatory=$false)]
    [string]$ServerPath = "/var/www/netrohub"
)

Write-Host "================================" -ForegroundColor Cyan
Write-Host " NetroHub - Upload to Server" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Check if SCP is available
try {
    scp 2>&1 | Out-Null
} catch {
    Write-Host "ERROR: SCP not found. Please install OpenSSH Client." -ForegroundColor Red
    Write-Host "Go to: Settings > Apps > Optional Features > Add OpenSSH Client" -ForegroundColor Yellow
    exit 1
}

# Files to upload
$files = @(
    "package.json",
    "vite.config.js",
    "tailwind.config.js",
    "postcss.config.js",
    ".npmrc"
)

Write-Host "Server: $ServerUser@$ServerIP" -ForegroundColor Green
Write-Host "Target: $ServerPath" -ForegroundColor Green
Write-Host ""

# Check if files exist
$missing = @()
foreach ($file in $files) {
    if (-Not (Test-Path $file)) {
        $missing += $file
    }
}

if ($missing.Count -gt 0) {
    Write-Host "ERROR: Missing files:" -ForegroundColor Red
    foreach ($file in $missing) {
        Write-Host "  - $file" -ForegroundColor Red
    }
    exit 1
}

Write-Host "Files to upload:" -ForegroundColor Yellow
foreach ($file in $files) {
    Write-Host "  ✓ $file" -ForegroundColor Green
}
Write-Host ""

# Confirm upload
$confirm = Read-Host "Continue with upload? (yes/no)"
if ($confirm -ne "yes") {
    Write-Host "Upload cancelled." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "Uploading files..." -ForegroundColor Cyan

# Upload each file
$success = 0
$failed = 0

foreach ($file in $files) {
    Write-Host "Uploading $file..." -NoNewline
    
    try {
        scp "$file" "${ServerUser}@${ServerIP}:${ServerPath}/" 2>&1 | Out-Null
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host " ✓" -ForegroundColor Green
            $success++
        } else {
            Write-Host " ✗" -ForegroundColor Red
            $failed++
        }
    } catch {
        Write-Host " ✗ ERROR: $_" -ForegroundColor Red
        $failed++
    }
}

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Upload Summary:" -ForegroundColor Cyan
Write-Host "  Success: $success" -ForegroundColor Green
Write-Host "  Failed: $failed" -ForegroundColor $(if ($failed -gt 0) { "Red" } else { "Green" })
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

if ($failed -eq 0) {
    Write-Host "✓ All files uploaded successfully!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps on your server:" -ForegroundColor Yellow
    Write-Host "  1. SSH into server: ssh $ServerUser@$ServerIP" -ForegroundColor White
    Write-Host "  2. Go to directory: cd $ServerPath" -ForegroundColor White
    Write-Host "  3. Install dependencies: npm install" -ForegroundColor White
    Write-Host "  4. Build assets: npm run build" -ForegroundColor White
    Write-Host ""
    Write-Host "See DEPLOYMENT_GUIDE.md for complete instructions." -ForegroundColor Cyan
} else {
    Write-Host "✗ Some files failed to upload. Please check your connection." -ForegroundColor Red
    exit 1
}

