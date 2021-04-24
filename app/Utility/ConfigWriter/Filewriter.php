<?php

namespace App\Utility\ConfigWriter;

use Illuminate\Filesystem\Filesystem;
use App\Utility\ConfigWriter\Rewrite;
use JetBrains\PhpStorm\Pure;


class FileWriter
{
    /**
     * The filesystem instance.
     */
    protected Filesystem $files;

    /**
     * The default configuration path.
     */
    protected string $defaultPath;

    /**
     * The config rewriter object.
     */
    protected Rewrite $rewriter;

    #[Pure] public function __construct(Filesystem $files, string $defaultPath)
    {
        $this->files = $files;
        $this->defaultPath = $defaultPath;
        $this->rewriter = new Rewrite;
    }

    /**
     * Write an item value in a file.
     * @param  string  $item
     * @param $value
     * @param  string  $filename
     * @param  string  $fileExtension
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    public function write(string $item, $value, string $filename, string $fileExtension = '.php'): bool
    {
        $path = $this->getPath($item, $filename, $fileExtension);

        if (!$path) {
            return false;
        }

        $contents = $this->files->get($path);
        $contents = $this->rewriter->toContent($contents, [$item => $value]);

        return !($this->files->put($path, $contents) === false);
    }

    private function getPath(string $item, string $filename, string $ext = '.php'): ?string
    {
        $file = "{$this->defaultPath}/{$filename}{$ext}";

        if ($this->files->exists($file) && $this->hasKey($file, $item)) {
            return $file;
        }

        return null;
    }

    private function hasKey(string $path, string $key): bool
    {
        $contents = file_get_contents($path);
        $vars = eval('?>'.$contents);

        $keys = explode('.', $key);

        $isset = false;
        while ($key = array_shift($keys)) {
            $isset = isset($vars[$key]);
            if (is_array($vars[$key])) {
                $vars = $vars[$key];
            }
        }

        return $isset;
    }

}