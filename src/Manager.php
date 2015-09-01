<?php
namespace Bolt\Filesystem;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;

class Manager extends MountManager
{
    const DEFAULT_PREFIX = 'files';

    public function getFilesystem($prefix = null)
    {
        $prefix = isset($this->filesystems[$prefix]) ? $prefix : static::DEFAULT_PREFIX;

        return parent::getFilesystem($prefix);
    }

    public function mountFilesystems(array $filesystems)
    {
        foreach ($filesystems as $prefix => $filesystem) {
            if (!$filesystem instanceof FilesystemInterface) {
                $filesystem = $this->createFilesystem($filesystem);
            }
            $this->mountFilesystem($prefix, $filesystem);
        }

        return $this;
    }

    /**
     * Mounts a local filesystem if the directory exists.
     *
     * @param string $prefix
     * @param string $location
     *
     * @return $this
     */
    public function mount($prefix, $location)
    {
        return parent::mountFilesystem($prefix, $this->createFilesystem($location));
    }

    protected function createFilesystem($location)
    {
        return new Filesystem(is_dir($location) ? new Local($location) : new NullAdapter());
    }

    public function filterPrefix(array $arguments)
    {
        try {
            return parent::filterPrefix($arguments);
        } catch (\InvalidArgumentException $e) {
            return [static::DEFAULT_PREFIX, $arguments];
        }
    }
}
