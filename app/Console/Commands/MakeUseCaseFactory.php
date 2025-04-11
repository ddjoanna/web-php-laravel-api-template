<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeUseCaseFactory extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:usecase-factory {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new UseCaseFactory with crud usecases';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/usecase_factory.stub');
    }

    /**
     * Get the path where the service class should be created.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path('app/Factories') . '/' . $name . 'UseCaseFactory.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getNamespace($rootNamespace)
    {
        return $rootNamespace . '\Factories';
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
