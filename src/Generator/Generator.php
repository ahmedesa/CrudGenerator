<?php

namespace essa\APIGenerator\Generator;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class Generator
{
    use FileManger;

    private $model;
    private $with_image;
    private $filesystem;

    /**
     * Generator constructor.
     * @param $model
     * @param $with_image
     */
    public function __construct($model, $with_image)
    {
        $this->model = $model;
        $this->with_image = $with_image;
        $this->filesystem = new Filesystem();
    }

    /**
     */
    public function process()
    {
        $this->createFolders();

        $this->filesystem->append(
            base_path('routes/api.php'),
            RouteGenerator::routeDefinition($this->model)
        );

        $this->calls();

        $this->createFiles();

        $this->moveFiles();
    }

    protected function moveFiles($baseFolder = '')
    {
        if (!file_exists(app_path($baseFolder . "/Helpers/MediaHelper.php"))) {
            file_put_contents(app_path($baseFolder . "/Helpers/MediaHelper.php"),
                file_get_contents(__DIR__ . '/../MediaHelper.php')
            );
        }
    }

    protected function createFolders($baseFolder = '')
    {
        if (!file_exists(app_path($baseFolder . "/Services"))) {
            $this->filesystem->makeDirectory(app_path($baseFolder . "/Services"));
        }

        if (!file_exists(app_path($baseFolder . "/Http/Controllers/API"))) {
            $this->filesystem->makeDirectory(app_path($baseFolder . "/Http/Controllers/API"));
        }

<<<<<<< HEAD
        if (!file_exists(app_path($baseFolder . "/Http/Resources"))) {
            $this->filesystem->makeDirectory(app_path($baseFolder . "/Http/Resources"));
        }

        if (!file_exists(app_path($baseFolder . "/Http/Resources/" . $this->model))) {
            $this->filesystem->makeDirectory(app_path($baseFolder . "/Http/Resources/" . $this->model));
        }

=======
>>>>>>> 1.0
        if (!file_exists(app_path($baseFolder . "/Helpers"))) {
            $this->filesystem->makeDirectory(app_path($baseFolder . "/Helpers"));
        }
    }

    private function createFiles()
    {
        $this->createModel();

        $this->createController();

        $this->createService();

<<<<<<< HEAD
        $this->createResources();

=======
>>>>>>> 1.0
        $this->createTest();
    }

    protected function createController()
    {
        file_put_contents(app_path("Http/Controllers/API/{$this->model}Controller.php"), $this->getTemplate('DummyController'));
    }

    protected function createModel()
    {
        file_put_contents(app_path("Models/{$this->model}.php"), $this->getTemplate('Dummy'));
    }

    protected function createTest()
    {
        file_put_contents(base_path("tests/Feature/{$this->model}Test.php"), $this->getTemplate('DummyTest'));
    }

    protected function createService()
    {
        file_put_contents(app_path("Services/{$this->model}Service.php"), $this->getTemplate('DummyService'));
    }

<<<<<<< HEAD
    protected function createResources()
    {
        file_put_contents(app_path("Http/Resources/{$this->model}/{$this->model}Collection.php"), $this->getTemplate('DummyResourceCollection'));

        file_put_contents(app_path("Http/Resources/{$this->model}/{$this->model}Resource.php"), $this->getTemplate('DummyResource'));
    }

=======
>>>>>>> 1.0
    /**
     */
    private function calls()
    {
        Artisan::call('make:migration', [
            'name' => 'create_' . Str::plural(Str::snake($this->model)) . '_table',
        ]);

        Artisan::call('make:factory', [
            'name'    => $this->model . 'Factory',
            '--model' => $this->model,
        ]);

        Artisan::call('make:request', [
            'name' => $this->model . '\Create' . $this->model . 'Request',
        ]);

        Artisan::call('make:request', [
            'name' => $this->model . '\Update' . $this->model . 'Request',
        ]);

        Artisan::call('make:seeder', [
            'name' => $this->model . 'Seeder',
        ]);
    }
}