#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
FRAMEWORK_DIR="$ROOT_DIR/framework"
RUNTIME_DIR="$ROOT_DIR/protected/runtime"
YIIC_FILE="$ROOT_DIR/protected/yiic"
UPLOADS_DIR="$ROOT_DIR/web/uploads"
DATA_UPLOADS_DIR="$ROOT_DIR/protected/data/uploads"

YII_VERSION="${YII_VERSION:-1.1.32}"
TARBALL_URL="${YII_TARBALL_URL:-https://github.com/yiisoft/yii/archive/refs/tags/${YII_VERSION}.tar.gz}"

if [ -d "$FRAMEWORK_DIR" ]; then
    echo "framework already exists: $FRAMEWORK_DIR"
else
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
fi

mkdir -p "$RUNTIME_DIR" "$UPLOADS_DIR" "$DATA_UPLOADS_DIR"
chmod 777 "$RUNTIME_DIR" "$UPLOADS_DIR" "$DATA_UPLOADS_DIR"
echo "Prepared runtime directory: $RUNTIME_DIR (writable for all)"
echo "Prepared uploads directory: $UPLOADS_DIR (writable for all)"
echo "Prepared uploads directory: $DATA_UPLOADS_DIR (writable for all)"
if [ -f "$YIIC_FILE" ]; then
    chmod 777 "$YIIC_FILE"
    echo "Prepared yiic file: $YIIC_FILE (executable for all)"
fi
