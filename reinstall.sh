#!/bin/bash
# Run this from cPanel Terminal to force-reinstall the theme
# bash /home/asannmly/public_html/wp-content/themes/reinstall.sh

THEME_DIR="/home/asannmly/public_html/wp-content/themes"
REPO="https://github.com/aidooonline/asanteyhair.git"

echo "=== Step 1: Backup ==="
cp -r "$THEME_DIR/asanteyhair" "$THEME_DIR/asanteyhair_bak" 2>/dev/null && echo "Backed up" || echo "No backup needed"

echo "=== Step 2: Remove old folder ==="
rm -rf "$THEME_DIR/asanteyhair"

echo "=== Step 3: Fresh clone ==="
cd "$THEME_DIR"
git clone "$REPO" asanteyhair

echo "=== Step 4: Verify assets ==="
ls "$THEME_DIR/asanteyhair/assets/css/"

echo "=== Step 5: Fix permissions ==="
chmod -R 755 "$THEME_DIR/asanteyhair"

echo "=== DONE === Hard refresh https://asanteyhair.com"
