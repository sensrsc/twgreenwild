<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute must be accepted.',
    'active_url'           => ':attribute is not a valid URL.',
    'after'                => ':attribute must be a date after :date.',
    'after_or_equal'       => ':attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute may only contain letters.',
    'alpha_dash'           => ':attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => ':attribute may only contain letters and numbers.',
    'array'                => ':attribute must be an array.',
    'before'               => ':attribute must be a date before :date.',
    'before_or_equal'      => ':attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute 必須介於 :min 到 :max.',
        'file'    => ':attribute 必須介於 :min 到 :max KB',
        'string'  => ':attribute 必須介於 :min 到 :max 個字',
        'array'   => ':attribute 必須介於 :min 到 :max items.',
    ],
    'boolean'              => ':attribute 欄位必須是 true or false.',
    'confirmed'            => ':attribute confirmation does not match.',
    'date'                 => ':attribute 不是一個有效日期',
    'date_format'          => ':attribute 不符合格式 :format.',
    'different'            => ':attribute 跟 :other 必須有所不同.',
    'digits'               => ':attribute must be :digits digits.',
    'digits_between'       => ':attribute must be between :min and :max digits.',
    'dimensions'           => ':attribute has invalid image dimensions.',
    'distinct'             => ':attribute field has a duplicate value.',
    'email'                => ':attribute 必須是有效的Email地址',
    'exists'               => 'selected :attribute is invalid.',
    'file'                 => ':attribute must be a file.',
    'filled'               => ':attribute field must have a value.',
    'image'                => ':attribute 必須是圖片',
    'in'                   => 'selected :attribute is invalid.',
    'in_array'             => ':attribute field does not exist in :other.',
    'integer'              => ':attribute must be an integer.',
    'ip'                   => ':attribute must be a valid IP address.',
    'ipv4'                 => ':attribute must be a valid IPv4 address.',
    'ipv6'                 => ':attribute must be a valid IPv6 address.',
    'json'                 => ':attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute 不能大於 :max',
        'file'    => ':attribute 不能大於 :max KB',
        'string'  => ':attribute 不能大於 :max 個字',
        'array'   => ':attribute 不能大於 :max items.',
    ],
    'mimes'                => ':attribute must be a file of type: :values.',
    'mimetypes'            => ':attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 必須最少 :min',
        'file'    => ':attribute 必須最少 :min KB',
        'string'  => ':attribute 必須最少 :min 個字',
        'array'   => ':attribute 必須最少 :min items.',
    ],
    'not_in'               => 'selected :attribute is invalid.',
    'numeric'              => ':attribute 必須是數字',
    'present'              => ':attribute field must be present.',
    'regex'                => ':attribute 格式錯誤',
    'required'             => ':attribute 欄位是必填',
    'required_if'          => ':attribute field is required when :other is :value.',
    'required_unless'      => ':attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute field is required when :values is present.',
    'required_with_all'    => ':attribute field is required when :values is present.',
    'required_without'     => ':attribute field is required when :values is not present.',
    'required_without_all' => ':attribute field is required when none of :values are present.',
    'same'                 => ':attribute 跟 :other 必須相同',
    'size'                 => [
        'numeric' => ':attribute must be :size.',
        'file'    => ':attribute must be :size kilobytes.',
        'string'  => ':attribute must be :size characters.',
        'array'   => ':attribute must contain :size items.',
    ],
    'string'               => ':attribute 必須是字串',
    'timezone'             => ':attribute 必須是有效的區域.',
    'unique'               => ':attribute 已經被使用了',
    'uploaded'             => ':attribute 未能上傳',
    'url'                  => ':attribute 格式錯誤',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
