<?php

namespace Statamic\Tags;

use Statamic\API\URL;
use Statamic\Tags\Tags;
use Statamic\API\Config;
use Statamic\API\Path as PathAPI;

class Path extends Tags
{
    /**
     * Maps to the {{ path }} tag
     *
     * @return string
     */
    public function index()
    {
        // If no src param was used, we will treat this as a regular `path` variable.
        if (! $src = $this->get(['src', 'to'])) {
            return array_get($this->context, 'path');
        }

        $url = PathAPI::tidy(Config::getSiteUrl() . $src);

        if ($this->getBool('absolute', false)) {
            $url = URL::makeAbsolute($url);
        }

        return $url;
    }
}