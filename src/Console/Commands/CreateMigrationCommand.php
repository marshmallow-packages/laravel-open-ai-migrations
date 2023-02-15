<?php

namespace Marshmallow\LaravelOpenAiMigrations\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class CreateMigrationCommand extends BaseCommand implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:migration {name : The name of the migration}';

    /**
     * The default Laravel Migration Creator.
     *
     * @var MigrationCreator
     */
    protected MigrationCreator $creator;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new migration from the default Laravel stub and prefill it with what ChatGPT things it should be, and it will be correct!';

    public function __construct()
    {
        parent::__construct();
        $this->creator = new MigrationCreator(app()->files, __DIR__ . '/../../../stubs');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** Validate that we have an API key to call the API. */
        if (!config('laravel-open-ai-migrations.chatgpt_api_key')) {
            $this->components->error(
                __('The ChatGPT api key is missing. Publish the config file and add your key there.')
            );
            return Command::FAILURE;
        }

        /** Get the name from the command */
        $provided_command = $this->input->getArgument('name');

        /** Call the Open AI API and ask for some magic. */
        $response = Http::withToken(config('laravel-open-ai-migrations.chatgpt_api_key'))
            ->post('https://api.openai.com/v1/completions', [
                /** The language model */
                'model' => config('laravel-open-ai-migrations.model'),

                /** Create the promt from the config template. */
                'prompt' => Str::of(config('laravel-open-ai-migrations.prompt_template'))
                    ->replace('{{MIGRATION_NAME}}', $provided_command)
                    ->__toString(),

                /** Set the max token amount */
                'max_tokens' => config('laravel-open-ai-migrations.max_tokens'),
            ]);

        $response_array = $response->json();

        if (Arr::has($response_array, 'error')) {
            $this->components->error(
                Arr::get($response_array, 'error.message')
            );
            return Command::FAILURE;
        }

        /** Lets just get the first result from the response. */
        $ai_generated_code = Arr::get($response_array, 'choices.0.text');

        /** Create the default migration from the stub */
        $file_path = $this->creator->create(
            str_slug($provided_command, '_'),
            $this->getMigrationPath(),
            null,
            null
        );

        /** Get the content from the default stub so we can add our magic code. */
        $file_contents = file_get_contents($file_path);

        /** We need to strip some linebreaks at the top of the response. */
        [$empty, $command] = explode('Schema', $ai_generated_code);

        /** Past it all back together. */
        $ai_generated_code = Str::of($command)
            ->prepend('Schema')
            ->__toString();

        /** Add the magic code to the generated stub content */
        $stub_content = Str::of($file_contents)
            ->replace('// {{AI_GOES_HERE}}', $ai_generated_code)
            ->replace('\n', '');

        /** Add the new content to the generated migration file. */
        app()->files->put(
            $file_path,
            $stub_content
        );

        /** Let the console know that we are done! */
        $this->components->info(sprintf('Migration [%s] created successfully.', $file_path));
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => __('What should the migration be named?'),
        ];
    }
}
