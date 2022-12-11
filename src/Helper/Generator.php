<?php

namespace Piash\Helper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class Generator
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getAppRootDir(): float|array|bool|int|string|null
    {
        return $this->params->get('kernel.project_dir');
    }
}

