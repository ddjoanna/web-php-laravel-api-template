<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeUseCase extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:usecase {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new use case with request, use case, and response files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'UseCase';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // 這個方法現在返回一個預設的 stub
        return base_path('stubs/usecase.stub'); // 根據需要修改為一個預設模板
    }

    /**
     * Get the path to where the class should be created.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path('app/UseCases' . '/' . $name);
    }

    /**
     * Handle the creation of the use case and its associated files.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getPath($name);

        // 檢查檔案是否已經存在
        if (file_exists($path)) {
            $this->error('UseCase already exists!');
            return;
        }

        // 確保所有必要的目錄結構都被創建，包括父目錄
        if (!is_dir($path)) {
            // 使用 mkdir 創建多層目錄結構
            mkdir($path, 0755, true);  // 第三個參數設定為 true 以創建多層目錄
        }

        // 創建 Request.php
        $this->createFile($path, 'Request.php', 'request');

        // 創建 UseCase.php
        $this->createFile($path, 'UseCase.php', 'usecase');

        // 創建 Response.php
        $this->createFile($path, 'Response.php', 'response');

        $this->info('UseCase created successfully!');
    }

    /**
     * 創建檔案並填充內容
     *
     * @param string $path
     * @param string $filename
     * @param string $type
     * @return void
     */
    protected function createFile($path, $filename, $type)
    {
        $filePath = $path . '/' . $filename;

        // 根據檔案類型選擇對應的 stub
        $stub = $this->getStubForType($type);

        file_put_contents($filePath, $this->buildClassContent($stub, $filename));
    }

    /**
     * 根據檔案類型選擇對應的 stub
     *
     * @param string $type
     * @return string
     */
    protected function getStubForType($type)
    {
        if ($type == 'request') {
            return base_path('stubs/request.stub');
        } elseif ($type == 'usecase') {
            return base_path('stubs/usecase.stub');
        } elseif ($type == 'response') {
            return base_path('stubs/response.stub');
        }

        return $this->getStub(); // 默認使用預設 stub
    }

    /**
     * 根據檔案類型讀取相應的 stub
     *
     * @param string $stub
     * @param string $filename
     * @return string
     */
    protected function buildClassContent($stub, $filename)
    {
        $className = pathinfo($filename, PATHINFO_FILENAME);
        $stub = file_get_contents($stub);
        $stub = str_replace('{{ class }}', $className, $stub);
        $stub = str_replace('{{ useCaseName }}', ucfirst($this->argument('name')), $stub);

        return $stub;
    }

    /**
     * Overriding the buildClass method to return the correct content
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        return parent::buildClass($name);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getNamespace($rootNamespace)
    {
        return $rootNamespace . '\UseCases';
    }
}
