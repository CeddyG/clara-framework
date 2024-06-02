<?php

namespace CeddyG\Clara\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Process\Process;

class InstallCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clara:install {--pest : Indicate that Pest should be installed}
        {--no-front : Indicate that Bootstrap for front shouldn\'t be installed}
        {--no-migration : Indicate that Bootstrap for front shouldn\'t be installed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Clara controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@fortawesome/fontawesome-svg-core' => '^6.5.1',
                '@popperjs/core' => '^2.11.8',
                'admin-lte' => '^3.2',
                'bootstrap' => '^5.3.1',
            ] + $packages;
        });
        
        // Datatables...
        (new Filesystem)->ensureDirectoryExists(app_path('Datatables'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Datatables', app_path('Datatables'));

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Http/Controllers', app_path('Http/Controllers'));

        // Middleware...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Http/Middleware', app_path('Http/Middleware'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Http/Requests', app_path('Http/Requests'));
        
        // Models...
        (new Filesystem)->ensureDirectoryExists(app_path('Models'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Models', app_path('Models'));
        
        // Providers...
        (new Filesystem)->ensureDirectoryExists(app_path('Providers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/Datatables', app_path('Providers'));

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views', resource_path('views'));

        // Components...
        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/app/View/Components', app_path('View/Components'));

        // Tests...
        if (! $this->installTests()) {
            return 1;
        }

        // Routes...
        copy(__DIR__.'/../../stubs/default/routes/admin.php', base_path('routes/admin.php'));
        copy(__DIR__.'/../../stubs/default/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../stubs/default/routes/auth.php', base_path('routes/auth.php'));
        
        // Config...
        copy(__DIR__.'/../../stubs/default/config/admin-navbar.php', base_path('config/admin-navbar.php'));
        
        if (! $this->option('no-migration')) {
            //Database...
            (new Filesystem)->ensureDirectoryExists(base_path('database/migrations'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/database/migrations', base_path('database/migrations'));
        }
        
        //Images...
        (new Filesystem)->ensureDirectoryExists(base_path('public/images'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/public/images', base_path('public/images'));

        // "Dashboard" Route...
        $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
        $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Vite...
        copy(__DIR__.'/../../stubs/default/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../stubs/default/resources/scss/admin.scss', resource_path('css/admin.scss'));
        copy(__DIR__.'/../../stubs/default/resources/js/app.js', resource_path('js/admin.js'));
        
        if (! $this->option('no-front')) {
            copy(__DIR__.'/../../stubs/default/resources/scss/_variables.scss', resource_path('scss/_variables.scss'));
            copy(__DIR__.'/../../stubs/default/resources/scss/app.scss', resource_path('scss/app.scss'));
            copy(__DIR__.'/../../stubs/default/resources/js/app.js', resource_path('js/app.js'));
            copy(__DIR__.'/../../stubs/default/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        }
        
        $this->components->info('Installing and building Node dependencies.');

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Clara scaffolding installed successfully.');
    }

    /**
     * Install Breeze's tests.
     *
     * @return bool
     */
    protected function installTests()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));

        $stubStack = $this->argument('stack') === 'api' ? 'api' : 'default';

        if ($this->option('pest') || $this->isUsingPest()) {
            if ($this->hasComposerPackage('phpunit/phpunit')) {
                $this->removeComposerPackages(['phpunit/phpunit'], true);
            }

            if (! $this->requireComposerPackages(['pestphp/pest:^2.0', 'pestphp/pest-plugin-laravel:^2.0'], true)) {
                return false;
            }

            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Feature', base_path('tests/Feature'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Unit', base_path('tests/Unit'));
            (new Filesystem)->copy(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Pest.php', base_path('tests/Pest.php'));
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/tests/Feature', base_path('tests/Feature'));
        }

        return true;
    }

    /**
     * Determine if the given Composer package is installed.
     *
     * @param  string  $package
     * @return bool
     */
    protected function hasComposerPackage($package)
    {
        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        return array_key_exists($package, $packages['require'] ?? [])
            || array_key_exists($package, $packages['require-dev'] ?? []);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  array  $packages
     * @param  bool  $asDev
     * @return bool
     */
    protected function requireComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Removes the given Composer Packages from the application.
     *
     * @param  array  $packages
     * @param  bool  $asDev
     * @return bool
     */
    protected function removeComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

    /**
     * Determine whether the project is already using Pest.
     *
     * @return bool
     */
    protected function isUsingPest()
    {
        return class_exists(\Pest\TestSuite::class);
    }
}
