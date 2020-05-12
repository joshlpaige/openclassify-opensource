<?php

return [
    'folders' => [
        'name'         => 'フォルダー',
        'instructions' => 'このフィールドで使用できるフォルダを指定します。すべてのフォルダを表示するには、空白のままにします。',
        'warning'      => '既存のフォルダのアクセス許可は、選択したフォルダよりも優先されます。',
    ],
    'min'     => [
        'label'        => '最小限の選択',
        'instructions' => '許可される選択の最小数を入力してください。',
    ],
    'max'     => [
        'label'        => '最大の選択',
        'instructions' => '許可される選択の最大数を入力します。',
    ],
    'mode'    => [
        'name'         => '入力モード',
        'instructions' => 'ユーザーはどのようにファイル入力を提供する必要がありますか？',
        'option'       => [
            'default' => 'ファイルをアップロードまたは選択します。',
            'select'  => 'ファイルのみを選択します。',
            'upload'  => 'ファイルのみをアップロードします。',
        ],
    ],
];
