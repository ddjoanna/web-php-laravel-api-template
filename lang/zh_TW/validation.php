<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 驗證語言行
    |--------------------------------------------------------------------------
    |
    | 以下語言行包含驗證器類別使用的預設錯誤訊息。
    | 其中一些規則有多個版本，例如大小規則。
    | 請隨意調整此處的每個訊息。
    |
    */

    'accepted' => ':attribute 欄位必須接受。',
    'accepted_if' => '當 :other 為 :value 時，:attribute 欄位必須接受。',
    'active_url' => ':attribute 欄位必須是有效的 URL。',
    'after' => ':attribute 欄位必須是 :date 之後的日期。',
    'after_or_equal' => ':attribute 欄位必須是 :date 之後或相等的日期。',
    'alpha' => ':attribute 欄位只能包含字母。',
    'alpha_dash' => ':attribute 欄位只能包含字母、數字、破折號和底線。',
    'alpha_num' => ':attribute 欄位只能包含字母和數字。',
    'any_of' => ':attribute 欄位無效。',
    'array' => ':attribute 欄位必須是一個陣列。',
    'ascii' => ':attribute 欄位只能包含單一位元組的字母數字字符和符號。',
    'before' => ':attribute 欄位必須是 :date 之前的日期。',
    'before_or_equal' => ':attribute 欄位必須是 :date 之前或相等的日期。',
    'between' => [
        'array' => ':attribute 欄位必須有 :min 到 :max 個項目。',
        'file' => ':attribute 欄位必須在 :min 到 :max KB 之間。',
        'numeric' => ':attribute 欄位必須在 :min 到 :max 之間。',
        'string' => ':attribute 欄位必須在 :min 到 :max 個字元之間。',
    ],
    'boolean' => ':attribute 欄位必須是 true 或 false。',
    'can' => ':attribute 欄位包含未經授權的值。',
    'confirmed' => ':attribute 欄位的確認不符。',
    'contains' => ':attribute 欄位缺少必要的值。',
    'current_password' => '密碼不正確。',
    'date' => ':attribute 欄位必須是有效的日期。',
    'date_equals' => ':attribute 欄位必須是等於 :date 的日期。',
    'date_format' => ':attribute 欄位必須符合 :format 格式。',
    'decimal' => ':attribute 欄位必須有 :decimal 個小數位。',
    'declined' => ':attribute 欄位必須拒絕。',
    'declined_if' => '當 :other 為 :value 時，:attribute 欄位必須拒絕。',
    'different' => ':attribute 欄位和 :other 必須不同。',
    'digits' => ':attribute 欄位必須是 :digits 位數。',
    'digits_between' => ':attribute 欄位必須在 :min 到 :max 位數之間。',
    'dimensions' => ':attribute 欄位具有無效的圖片尺寸。',
    'distinct' => ':attribute 欄位具有重複的值。',
    'doesnt_end_with' => ':attribute 欄位不得以下列之一結尾：:values。',
    'doesnt_start_with' => ':attribute 欄位不得以下列之一開頭：:values。',
    'email' => ':attribute 欄位必須是有效的電子郵件地址。',
    'ends_with' => ':attribute 欄位必須以下列之一結尾：:values。',
    'enum' => '所選的 :attribute 無效。',
    'exists' => '所選的 :attribute 無效。',
    'extensions' => ':attribute 欄位必須具有以下其中一種擴展名：:values。',
    'file' => ':attribute 欄位必須是一個檔案。',
    'filled' => ':attribute 欄位必須具有一個值。',
    'gt' => [
        'array' => ':attribute 欄位必須有多於 :value 個項目。',
        'file' => ':attribute 欄位必須大於 :value KB。',
        'numeric' => ':attribute 欄位必須大於 :value。',
        'string' => ':attribute 欄位必須大於 :value 個字元。',
    ],
    'gte' => [
        'array' => ':attribute 欄位必須有 :value 個或更多個項目。',
        'file' => ':attribute 欄位必須大於或等於 :value KB。',
        'numeric' => ':attribute 欄位必須大於或等於 :value。',
        'string' => ':attribute 欄位必須大於或等於 :value 個字元。',
    ],
    'hex_color' => ':attribute 欄位必須是有效的十六進位顏色。',
    'image' => ':attribute 欄位必須是一張圖片。',
    'in' => '所選的 :attribute 無效。',
    'in_array' => ':attribute 欄位必須存在於 :other 中。',
    'integer' => ':attribute 欄位必須是一個整數。',
    'ip' => ':attribute 欄位必須是一個有效的 IP 地址。',
    'ipv4' => ':attribute 欄位必須是一個有效的 IPv4 地址。',
    'ipv6' => ':attribute 欄位必須是一個有效的 IPv6 地址。',
    'json' => ':attribute 欄位必須是一個有效的 JSON 字串。',
    'list' => ':attribute 欄位必須是一個列表。',
    'lowercase' => ':attribute 欄位必須是小寫。',
    'lt' => [
        'array' => ':attribute 欄位必須少於 :value 個項目。',
        'file' => ':attribute 欄位必須小於 :value KB。',
        'numeric' => ':attribute 欄位必須小於 :value。',
        'string' => ':attribute 欄位必須小於 :value 個字元。',
    ],
    'lte' => [
        'array' => ':attribute 欄位不得多於 :value 個項目。',
        'file' => ':attribute 欄位必須小於或等於 :value KB。',
        'numeric' => ':attribute 欄位必須小於或等於 :value。',
        'string' => ':attribute 欄位必須小於或等於 :value 個字元。',
    ],
    'mac_address' => ':attribute 欄位必須是一個有效的 MAC 地址。',
    'max' => [
        'array' => ':attribute 欄位不得多於 :max 個項目。',
        'file' => ':attribute 欄位不得大於 :max KB。',
        'numeric' => ':attribute 欄位不得大於 :max。',
        'string' => ':attribute 欄位不得大於 :max 個字元。',
    ],
    'max_digits' => ':attribute 欄位不得多於 :max 位數。',
    'mimes' => ':attribute 欄位必須是以下類型的文件：:values。',
    'mimetypes' => ':attribute 欄位必須是以下類型的文件：:values。',
    'min' => [
        'array' => ':attribute 欄位必須至少有 :min 個項目。',
        'file' => ':attribute 欄位必須至少為 :min KB。',
        'numeric' => ':attribute 欄位必須至少為 :min。',
        'string' => ':attribute 欄位必須至少為 :min 個字元。',
    ],
    'min_digits' => ':attribute 欄位必須至少有 :min 位數。',
    'missing' => ':attribute 欄位必須缺失。',
    'missing_if' => '當 :other 為 :value 時，:attribute 欄位必須缺失。',
    'missing_unless' => '除非 :other 在 :values 中，否則 :attribute 欄位必須缺失。',
    'missing_with' => '當 :values 存在時，:attribute 欄位必須缺失。',
    'missing_with_all' => '當 :values 存在時，:attribute 欄位必須缺失。',
    'multiple_of' => ':attribute 欄位必須是 :value 的倍數。',
    'not_in' => '所選的 :attribute 無效。',
    'not_regex' => ':attribute 欄位格式無效。',
    'numeric' => ':attribute 欄位必須是一個數字。',
    'password' => [
        'letters' => ':attribute 欄位必須包含至少一個字母。',
        'mixed' => ':attribute 欄位必須包含至少一個大寫字母和一個小寫字母。',
        'numbers' => ':attribute 欄位必須包含至少一個數字。',
        'symbols' => ':attribute 欄位必須包含至少一個符號。',
        'uncompromised' => '給定的 :attribute 出現在資料外洩中。請選擇不同的 :attribute。',
    ],
    'present' => ':attribute 欄位必須存在。',
    'present_if' => '當 :other 為 :value 時，:attribute 欄位必須存在。',
    'present_unless' => '除非 :other 在 :values 中，否則 :attribute 欄位必須存在。',
    'present_with' => '當 :values 存在時，:attribute 欄位必須存在。',
    'present_with_all' => '當 :values 存在時，:attribute 欄位必須存在。',
    'prohibited' => ':attribute 欄位被禁止。',
    'prohibited_if' => '當 :other 為 :value 時，:attribute 欄位被禁止。',
    'prohibited_if_accepted' => '當 :other 被接受時，:attribute 欄位被禁止。',
    'prohibited_if_declined' => '當 :other 被拒絕時，:attribute 欄位被禁止。',
    'prohibited_unless' => '除非 :other 在 :values 中，否則 :attribute 欄位被禁止。',
    'prohibits' => ':attribute 欄位禁止 :other 存在。',
    'regex' => ':attribute 欄位格式無效。',
    'required' => ':attribute 欄位是必填的。',
    'required_array_keys' => ':attribute 欄位必須包含以下條目：:values。',
    'required_if' => '當 :other 為 :value 時，:attribute 欄位是必填的。',
    'required_if_accepted' => '當 :other 被接受時，:attribute 欄位是必填的。',
    'required_if_declined' => '當 :other 被拒絕時，:attribute 欄位是必填的。',
    'required_unless' => '除非 :other 在 :values 中，否則 :attribute 欄位是必填的。',
    'required_with' => '當 :values 存在時，:attribute 欄位是必填的。',
    'required_with_all' => '當 :values 存在時，:attribute 欄位是必填的。',
    'required_without' => '當 :values 不存在時，:attribute 欄位是必填的。',
    'required_without_all' => '當 :values 都不存在時，:attribute 欄位是必填的。',
    'same' => ':attribute 欄位必須與 :other 匹配。',
    'size' => [
        'array' => ':attribute 欄位必須包含 :size 個項目。',
        'file' => ':attribute 欄位必須是 :size KB。',
        'numeric' => ':attribute 欄位必須是 :size。',
        'string' => ':attribute 欄位必須是 :size 個字元。',
    ],
    'starts_with' => ':attribute 欄位必須以下列之一開頭：:values。',
    'string' => ':attribute 欄位必須是一個字串。',
    'timezone' => ':attribute 欄位必須是一個有效的時區。',
    'unique' => ':attribute 已經存在。',
    'uploaded' => ':attribute 上傳失敗。',
    'uppercase' => ':attribute 欄位必須是大寫。',
    'url' => ':attribute 欄位必須是一個有效的 URL。',
    'ulid' => ':attribute 欄位必須是一個有效的 ULID。',
    'uuid' => ':attribute 欄位必須是一個有效的 UUID。',

    /*
    |--------------------------------------------------------------------------
    | 自訂驗證語言行
    |--------------------------------------------------------------------------
    |
    | 在這裡，您可以為屬性指定自訂驗證訊息，使用
    | 約定「attribute.rule」來命名這些行。這使得可以快速
    | 為給定的屬性規則指定特定的自訂語言行。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '自訂訊息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 自訂驗證屬性
    |--------------------------------------------------------------------------
    |
    | 以下語言行用於將我們的屬性佔位符替換為
    | 更易於閱讀的內容，例如「電子郵件地址」而不是「email」。
    | 這僅僅有助於使我們的訊息更具表現力。
    |
    */

    'attributes' => [],

];
