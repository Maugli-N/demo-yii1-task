#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
FRAMEWORK_DIR="$ROOT_DIR/framework"

YII_VERSION="${YII_VERSION:-1.1.32}"
TARBALL_URL="${YII_TARBALL_URL:-https://github.com/yiisoft/yii/archive/refs/tags/${YII_VERSION}.tar.gz}"

if [ -d "$FRAMEWORK_DIR" ]; then
    echo "framework already exists: $FRAMEWORK_DIR"
    exit 0
fi

TMP_DIR="$(mktemp -d)"
#
# /**
#  * Очистка временной директории.
#  *
#  * @result void - удаляет временные файлы.
#  */
cleanup() {
    rm -rf "$TMP_DIR"
}
trap cleanup EXIT

TARBALL="$TMP_DIR/yii-${YII_VERSION}.tar.gz"

if command -v curl >/dev/null 2>&1; then
    curl -fsSL "$TARBALL_URL" -o "$TARBALL"
elif command -v wget >/dev/null 2>&1; then
    wget -qO "$TARBALL" "$TARBALL_URL"
else
    echo "curl or wget is required to download Yii."
    exit 1
fi

tar -xzf "$TARBALL" -C "$TMP_DIR"

EXTRACTED_DIR="$(find "$TMP_DIR" -maxdepth 1 -type d -name "yii-*")"
if [ -z "$EXTRACTED_DIR" ]; then
    echo "Failed to extract Yii archive."
    exit 1
fi

if [ ! -d "$EXTRACTED_DIR/framework" ]; then
    echo "framework directory not found in archive."
    exit 1
fi

mv "$EXTRACTED_DIR/framework" "$FRAMEWORK_DIR"

echo "Installed Yii framework to $FRAMEWORK_DIR"
