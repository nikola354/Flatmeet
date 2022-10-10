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
    'accepted' => 'Трябва да се съгласите с :attribute.',
    'active_url' => 'Полето :attribute не е валиден URL.',
    'after' => 'Полето :attribute трябва да е дата след :date.',
    'after_or_equal' => 'Полето :attribute трябва да е дата не по-ранна от :date.',
    'alpha' => 'Полето :attribute може да съдържа само букви.',
    'alpha_dash' => 'Полето :attribute може да съдържа само букви, числа, тирета и наклонени черти.',
    'alpha_num' => 'Полето :attribute може да съдържа само букви и числа.',
    'array' => 'Полето :attribute трябва да бъде масив.',
    'before' => 'Полето :attribute трябва да е дата преди :date.',
    'before_or_equal' => 'Полето :attribute трябва да е дата не по-късна от :date.',
    'between' => [
        'numeric' => 'Полето :attribute трябва да е между :min и :max.',
        'file' => ':attribute трябва да е между :min и :max килобайта.',
        'string' => 'Полето :attribute трябва да е между :min и :max символа.',
        'array' => ':attribute може да съдържа само между :min и :max обекта.',
    ],
    'boolean' => 'Полето :attribute трябва да е с булева стойност (true или false).',
    'confirmed' => 'Полето :attribute не съответства с полето за потвърждаване.',
    'date' => 'Полето :attribute не е валидна дата.',
    'date_equals' => 'Полето :attribute трябва да е дата :date.',
    'date_format' => 'Полето :attribute не съответства на формата :format.',
    'different' => 'Полетата :attribute и :other трябва да са различни.',
    'digits' => 'Полето :attribute трябва да е с :digits цифри.',
    'digits_between' => 'Полето :attribute трябва да е с между :min и :max цифри.',
    'dimensions' => 'Полето :attribute има невалидно файлово разширение.',
    'distinct' => 'Полето :attribute трябва да е с уникална стойност.',
    'email' => 'Полето :attribute трябва да е валиден имейл адрес.',
    'ends_with' => 'Полето :attribute трябва да завършва на една от следните стойности: :values',
    'exists' => 'Полето :attribute е невалидно.',
    'file' => 'Полето :attribute трябва да е файл.',
    'filled' => 'Полето :attribute трябва да е попълнено.',
    'gt' => [
        'numeric' => 'Стойността на полето :attribute трябва да е по-голяма от :value.',
        'file' => 'Размерът на :attribute трябва да е по-голям от :value килобайта.',
        'string' => 'Дължината на :attribute трябва да е по-голяма от :value символа.',
        'array' => ':attribute трябва да съдържа повече от :value обекта.',
    ],
    'gte' => [
        'numeric' => 'Стойността на полето :attribute трябва да е не по-малка от :value.',
        'file' => 'Размерът на :attribute трябва да е не по-малък от :value килобайта.',
        'string' => 'Дължината на полето :attribute трябва да е не по-малка от :value символа.',
        'array' => ':attribute трябва да съдържа не по-малко от :value обекта.',
    ],
    'image' => 'Полето :attribute трябва да е изображение.',
    'in' => 'Полето :attribute е невалидно.',
    'in_array' => 'Полето :attribute не се съдържа в :other.',
    'integer' => 'Полето :attribute трябва да е цяло число.',
    'ip' => 'Полето :attribute трябва да е валиден IP адрес.',
    'ipv4' => 'Полето :attribute трябва да е валиден IPv4 адрес.',
    'ipv6' => 'Полето :attribute трябва да е валиден IPv6 адрес.',
    'json' => 'Полето :attribute трябва да е в JSON формат.',
    'lt' => [
        'numeric' => 'Стойността на полето :attribute трябва да е по-малка от :value.',
        'file' => 'Размерът на :attribute трябва да е по-малък от :value килобайта.',
        'string' => 'Дължината на :attribute трябва да е по-малка от :value символа.',
        'array' => ':attribute трябва да съдържа по-малко от :value обекта.',
    ],
    'lte' => [
        'numeric' => 'Стойността на полето :attribute трябва да е не по-голяма от :value.',
        'file' => 'Размерът на :attribute трябва да е не по-голям от :value килобайта.',
        'string' => 'Дължината на :attribute трябва да е не по-голяма от :value символа.',
        'array' => ':attribute трябва да съдържа не повече от :value обекта.',
    ],
    'max' => [
        'numeric' => 'Стойността на полето :attribute може да е най-много :max.',
        'file' => 'Размерът на :attribute може да е най-много :max килобайта.',
        'string' => 'Дължината на полето :attribute може да е най-много :max символа.',
        'array' => ':attribute може да съдържа най-много :max обекта.',
    ],
    'mimes' => 'Разширението на полето :attribute трябва да е от следните видове: :values.',
    'mimetypes' => 'Разширението на полето :attribute трябва да е от следните видове: :values.',
    'min' => [
        'numeric' => 'Стойността на полето :attribute може да е най-малко :min.',
        'file' => 'Размерът на полето :attribute може да е най-малко :min килобайта.',
        'string' => 'Дължината на полето :attribute може да е най-малко :min символа.',
        'array' => ':attribute може да съдържа най-малко :min обекта.',
    ],
    'not_in' => 'Полето :attribute е невалидно.',
    'not_regex' => 'Полето :attribute е в невалиден формат.',
    'numeric' => 'Полето :attribute трябва да е число.',
    'present' => 'Полето :attribute трябва да е попълнено.',
    'regex' => 'Полето :attribute е в невалиден формат.',
    'required' => 'Полето :attribute е задължително.',
    'required_if' => 'Полето :attribute е задължително, когато :other е :value.',
    'required_unless' => 'Полето :attribute е задължително освен ако :other не е във :values.',
    'required_with' => 'Полето :attribute е задължително, когато :values е попълнено.',
    'required_with_all' => 'Полето :attribute field е задължително, когато :values са попълнени.',
    'required_without' => 'Полето :attribute е задължително, когато :values не е попълнено.',
    'required_without_all' => 'Полето :attribute е задължително, когато нито едно от полетата :values са попълнени.',
    'same' => 'Полетата :attribute и :other трябва да са еднакви.',
    'size' => [
        'numeric' => 'Стойността на полето :attribute трябва да е :size.',
        'file' => 'Размерът на :attribute трябва да е :size килобайта.',
        'string' => 'Дължината на :attribute трябва да е :size символа.',
        'array' => ':attribute трябва да съдържа :size обекта.',
    ],
    'starts_with' => 'Полето :attribute трябва да започва с една от следните стойности: :values',
    'string' => 'Полето :attribute трябва да е текст.',
    'timezone' => 'Полето :attribute трябва да е валидна часова зона.',
    'unique' => 'Стойността на полето :attribute е вече заета.',
    'uploaded' => 'Възникна грешка при качването на :attribute.',
    'url' => 'Полето :attribute е в невалиден формат.',
    'uuid' => 'Полето :attribute трябва да е валиден UUID.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'имейл адрес',
        'shortAddress' => 'кратък адрес',
        'fullAddress' => 'пълен адрес',
        'apNumber' => 'номер на апартамента',
        'floor' => 'етаж',
        'family' => 'семейство',
        'paymentType' => 'тип на плащане',
        'month' => 'месец',
        'price' => 'цена',
        '' => '', // add payment page -> ap_num
        'oldPassword' => 'стара парола',
        'newPassword' => 'нова парола',
        'newPasswordConfirmed' => 'потвърждаване на новата парола',
        'code' => 'код',
        'password' => 'парола',
        'checkbox' => '',
        'firstName' => 'име',
        'lastName' => 'фамилия',
        'repeatPassword' => 'потвърждаване на паролата'
    ],
];