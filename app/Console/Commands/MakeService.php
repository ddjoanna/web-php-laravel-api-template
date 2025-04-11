<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/service.stub');
    }

    /**
     * Get the path where the service class should be created.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path('app/Services') . '/' . $name . 'Service.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getPath($name);

        // 檢查檔案是否已經存在
        if (file_exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        // 創建檔案目錄並將內容寫入檔
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info('Service created successfully.');
    }
}
