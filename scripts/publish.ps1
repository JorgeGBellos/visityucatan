#Requires -Version 5.1
<#
.SYNOPSIS
  Build frontend assets and push to GitHub (Hostinger Git auto-deploy pulls into public_html/visityucatan).

.DESCRIPTION
  Daily publish flow for Visit Yucatán on Hostinger:
  1. npm run build  -> public/build (committed so shared hosting needs no Node)
  2. git commit + push to main
  3. Hostinger auto-deploy runs composer install in public_html/visityucatan

  After the first setup, sync only NEW media with File Manager / Cursor MCP.
  Do NOT zip/upload the whole public/videos folder (~465MB) on every release.

.PARAMETER Message
  Commit message (required unless -SkipCommit).

.PARAMETER SkipCommit
  Only build + push existing commits.

.PARAMETER DryRun
  Show what would be committed; do not commit or push.
#>
param(
    [string] $Message = '',
    [switch] $SkipCommit,
    [switch] $DryRun
)

$ErrorActionPreference = 'Stop'
Set-Location (Split-Path $PSScriptRoot -Parent)

Write-Host '==> npm run build' -ForegroundColor Cyan
npm run build
if ($LASTEXITCODE -ne 0) { throw 'Vite build failed' }

git add -A
# Never stage env or videos even if force-added elsewhere
git reset HEAD -- .env 2>$null
git reset HEAD -- public/videos 2>$null
git reset HEAD -- "public/Videos-20260930T182812Z-1-001" 2>$null

if ($DryRun) {
    git status --short
    Write-Host 'Dry run: no commit/push.' -ForegroundColor Yellow
    exit 0
}

if (-not $SkipCommit) {
    if ([string]::IsNullOrWhiteSpace($Message)) {
        throw 'Pass -Message "your commit message" or -SkipCommit'
    }
    $pending = git status --porcelain
    if ($pending) {
        git commit -m $Message
    } else {
        Write-Host 'Nothing to commit.' -ForegroundColor Yellow
    }
}

Write-Host '==> git push origin main' -ForegroundColor Cyan
git push -u origin HEAD

Write-Host @"

Publish pushed. On Hostinger (after Git auto-deploy finishes):
  cd domains/aquamarine-cat-898212.hostingersite.com/public_html/visityucatan
  php artisan migrate --force
  php artisan view:clear
  php artisan config:cache

If CSS/JS changed, sync public/build -> public_html/build (File Manager or MCP),
or copy from visityucatan/public/build after deploy.
Filament assets, if they changed: public/js, public/css and public/fonts -> public_html/.

Media (videos/images): upload only new/changed files under public_html/.
"@ -ForegroundColor Green
