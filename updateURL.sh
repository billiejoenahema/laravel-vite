#!/bin/bash

# 置換対象の文字列を引数として受け取ります
TARGET_STRING="$1"

# 置換後の文字列を引数として受け取ります
REPLACEMENT_STRING="$2"

# .envファイルのパスを指定します
ENV_FILE="./src/.env"

# ファイルの存在を確認します
if [ ! -f "$ENV_FILE" ]; then
    echo "File not found: $ENV_FILE"
    exit 1
fi

# 置換を実行します
sed -i "s/$TARGET_STRING/$REPLACEMENT_STRING/g" "$ENV_FILE"

echo "Replacement complete."
