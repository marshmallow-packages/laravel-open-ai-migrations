<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ChatGPT API Key
    |--------------------------------------------------------------------------
    |
    | This value is your ChatGPT API key that will be used to connect to the API.
    | Please visit the ChatGPT website to obtain your API key. Sadly using the
    | API wont be free in all cases so you might need a paid account.
    |
    */
    'chatgpt_api_key' => null,

    /*
    |--------------------------------------------------------------------------
    | Promt Template
    |--------------------------------------------------------------------------
    |
    | This is where the magic happens. We need to create a promt that uses the least
    | amount of tokens on the request but gives the best possible result. Change
    | this as you like but always use the {{MIGRATION_NAME}} placeholder
    */
    'prompt_template' => 'Create a Laravel Migration from the following command: {{MIGRATION_NAME}}. Only return the code that should be placed in the up method. If the command asked to put it after a column, add the code where the columns are created in a callable like the following example: $table->after("AFTER COLUMN HERE", function (Blueprint $table) { CODE HERE }). Always wrap the code in the Schema:: methods.',

    /*
    |--------------------------------------------------------------------------
    | Language Model
    |--------------------------------------------------------------------------
    |
    | You can change the language model that we use in the ChatGPT API by changing
    | this config value below. We have found that 'text-davinci-003' will
    | give the best results. Please let us know if you dont agree.
    */
    'model' => 'text-davinci-003',

    /*
    |--------------------------------------------------------------------------
    | Max tokens
    |--------------------------------------------------------------------------
    |
    | This is the maximum amount of tokens you want to spent on your request to
    | the ChatGPT API. The max tokens takes the request and response into
    | account. The request will use around a 100 tokens per request.
    |
    */
    'max_tokens' => 200,
];
