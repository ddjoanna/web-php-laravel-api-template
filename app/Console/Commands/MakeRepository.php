<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/repository.stub');
    }

    /**
     * Get the path where the repository class should be created.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path('app/Repositories') . '/' . $name . 'Repository.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
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
            $this->error('Repository already exists!');
            return;
        }

        // 創建檔案目錄並將內容寫入檔案
        $this->makeDirectory($path);
        file_put_contents($path, $this->buildClass($name));

        $this->info('Repository created successfully!');
    }
}
