<?php

return [

    'update' => [
        'error'                 => '更新時にエラーが発生しました。 ',
        'success'               => '更新に成功しました。',
    ],
    'backup' => [
        'delete_confirm'        => 'このバックアップファイルを削除してもよろしいですか？この操作は、もとに戻すことは出来ません。 ',
        'file_deleted'          => 'バックアップファイルの削除に成功しました。 ',
        'generated'             => '新しいバックアップファイルが作成されました。',
        'file_not_found'        => 'そのバックアップファイルをサーバー上に見つけることが出来ませんでした。',
        'restore_warning'       => '復元を行います。現在データベースにある既存のデータを上書きします。 これにより、既存のすべてのユーザー(あなたを含む) もログアウトします。',
        'restore_confirm'       => ':filename からデータベースを復元してもよろしいですか？'
    ],
    'purge' => [
        'error'     => 'パージ中にエラーが発生しました。 ',
        'validation_failed'     => 'パージの確定方法が正しくありません。入力してください、単語「削除」確認ボックス。',
        'success'               => 'パージによりレコードは削除されました',
    ],
    'mail' => [
        'sending' => 'テストメールを送信しています...',
        'success' => 'メール送信完了',
        'error' => 'メールが送信できません',
        'additional' => '追加のエラーメッセージはありません。メール設定とアプリのログを確認してください。'
    ],
    'ldap' => [
        'testing' => 'LDAP接続のテスト中…バインディングとクエリを行っています…',
        '500' => '500 Server Error. 詳しくは、サーバーのログをご確認ください。',
        'error' => '問題が発生しました。',
        'sync_success' => '設定に基づいてLDAPサーバーから返された10人のユーザーのサンプル:',
        'testing_authentication' => 'LDAP認証のテスト中...',
        'authentication_success' => 'LDAPによるユーザー認証に成功しました！'
    ],
    'slack' => [
        'sending' => 'Slackのテストメッセージを送信しています...',
        'success_pt1' => 'チェックに成功 ',
        'success_pt2' => ' テストメッセージのチャンネルで、設定を保存するには以下の「保存」をクリックしてください。',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. Slack responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];
