<?php

Interface Table_structures {

    const T_TEXT_RESOURCES = [
        'name' => 'text_resources',
        'columns' => [
            'id' => 'ID',
            'key' => 'Text Key',
            'text_en' => 'Text English',
            'text_turk' => 'Text Turkish',
            'created_at' => '',
        ],
        'dates' => [
            'created_at' => 'Created Date',
        ]
    ];
    
}