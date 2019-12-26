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

    'flash_message'        => 'Bitte überprüfen Sie die Formularfelder erneut.',
    'accepted'             => 'Das :attribute muss akzeptiert.',
    'active_url'           => 'Das :attribute ist kein valider URL.',
    'after'                => 'Das :attribute muss ein Datum sein nach :date.',
    'alpha'                => 'Das :attribute darf nur Buchstaben beinhalten.',
    'alpha_dash'           => 'Das :attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num'            => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => 'Das :attribute muss ein Array sein.',
    'before'               => 'Das :attribute muss ein Datum sein vor :date.',
    'between'              => [
        'numeric' => 'Das :attribute muss zwischen :min und :max sein.',
        'file'    => 'Das :attribute muss zwischen :min und :max Kilobytes sein.',
        'string'  => 'Das :attribute muss zwischen :min und :max Zeichen liegen.',
        'array'   => 'Das :attribute muss zwischen :min und :max Einträge haben.',
    ],
    'boolean'              => 'Das :attribute Feld muss wahr oder falsch sein.',
    'confirmed'            => 'Die :attribute Bestätigung stimmt nicht überein.',
    'date'                 => 'Das :attribute ist kein gültiges Datum.',
    'date_format'          => 'Das :attribute passt nicht zum Format :format.',
    'different'            => 'Die :attribute und :other müssen unterschiedlich sein.',
    'digits'               => 'Das :attribute müssen :digits Zeichen sein.',
    'digits_between'       => 'Das :attribute muss zwischen :min und :max Zeichen sein.',
    'dimensions'           => 'Das :attribute hat ungültige Bild Dimensionen.',
    'email'                => 'Das :attribute muss eine gültige E-Mailadresse sein.',
    'exists'               => 'Das ausgewählte :attribute ist ungültig.',
    'filled'               => 'Das :attribute Feld ist benötigt.',
    'image'                => 'Das :attribute muss ein Bild sein.',
    'in'                   => 'Das ausgewählte :attribute ist ungültig.',
    'integer'              => 'Das :attribute muss ein Integer sein.',
    'ip'                   => 'Das :attribute muss eine gültige IP Adresse sein.',
    'json'                 => 'Das :attribute muss ein JSON String sein.',
    'max'                  => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file'    => 'Das :attribute darf nicht größer sein als :max Kilobytes.',
        'string'  => 'Das :attribute darf nicht länger sein als :max Zeichen.',
        'array'   => 'Das :attribute darf nicht mehr als :max Einräge haben.',
    ],
    'mimes'                => 'Das :attribute muss ein gülter Dateityp sein von: :values.',
    'min'                  => [
        'numeric' => 'Das :attribute muss mindestens :min sein.',
        'file'    => 'Das :attribute muss mindestens :min Kilobytes haben.',
        'string'  => 'Das :attribute muss mindestens :min Zeichen haben.',
        'array'   => 'Das :attribute muss mindestens :min Einträge haben.',
    ],
    'not_in'               => 'Das ausgewählte :attribute ist nicht gültig.',
    'numeric'              => 'Das :attribute muss eine Zahl sein.',
    'regex'                => 'Das :attribute Format ist ungültig.',
    'required'             => 'Das :attribute Feld ist benötigt.',
    'required_if'          => 'Das :attribute Feld ist benötigt, wenn :other ist :value.',
    'required_unless'      => 'Das :attribute Feld ist benötigt, bis :other in :values ist.',
    'required_with'        => 'Das :attribute Feld ist benötigt, wenn :values vorhanden ist.',
    'required_with_all'    => 'Das :attribute Feld ist benötigt, wenn :values vorhanden ist.',
    'required_without'     => 'Das :attribute Feld ist benötigt, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute ist benötigt, wenn keiner von :values vorhanden ist.',
    'same'                 => 'Das :attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => 'Das :attribute muss :size sein.',
        'file'    => 'Das :attribute muss :size Kilobytes sein.',
        'string'  => 'Das :attribute muss :size Zeichen sein.',
        'array'   => 'Das :attribute muss :size Einträge beinhalten.',
    ],
    'string'               => 'Das :attribute muss ein String sein.',
    'timezone'             => 'Das :attribute muss eine gültige Zeitzone sein.',
    'unique'               => 'Das :attribute ist bereits vergeben.',
    'url'                  => 'Bitte geben Sie eine gültige Domain mit http/https ein.',

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

    'project'    => [
        'customer_name'  => [
            'required_without' => 'Customer name is required.',
        ],
        'customer_email' => [
            'required_without' => 'Customer email is required.',
        ],
    ],
    'agency'     => [
        'logo' => [
            'file_extension' => 'Please upload an image with <strong>.png</strong> format.',
        ],
    ],
    'select_one' => 'Select at least one item.',

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
