#!/bin/sh
#
# アップロード対象フォルダを同期します
# 基本的にロードバランスされるため、相互にデータを取り合う形式になります。
#
#
#########################################

BASEPATH=$(cd `dirname $0`; pwd)

main() {

    fetch_host=${1:?}

    sync_paths[0]="/deploy/rakuichi-rakuza/public/files"
    sync_paths[1]="/deploy/rakuichi-rakuza/public/blog/wp-content/uploads"

    log "INFO" "コピーを開始します"
        set -x
        for sync_path in ${sync_paths[@]}
        do
            rsync -avn $fetch_host:$sync_path/* $sync_path
        done
        set +x

    log "INFO" "コピーを終了します"

}

log() {
    now=$(date "+%Y-%m-%d %H:%M:%S")
    mode=$1
    msg=$2
    echo "${now} [${mode}]: ${msg}"
}

main "$@"

