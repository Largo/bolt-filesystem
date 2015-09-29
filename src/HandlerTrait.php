<?php

namespace Bolt\Filesystem;

trait HandlerTrait
{
    abstract public function getType();

    /**
     * Check whether the entree is a file.
     *
     * @return bool
     */
    public function isFile()
    {
        return in_array($this->getType(), ['file', 'image', 'document']);
    }

    /**
     * Check whether the entree is an image.
     *
     * @return bool
     */
    public function isImage()
    {
        return $this->getType() === 'image';
    }

    /**
     * Check whether the entree is a document.
     *
     * @return bool
     */
    public function isDocument()
    {
        return $this->getType() === 'document';
    }
}
