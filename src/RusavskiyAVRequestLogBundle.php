<?php

namespace RusavskiyAV\RequestLogBundle;

use RusavskiyAV\RequestLogBundle\DependencyInjection\Compiler\TwigPass;
use RusavskiyAV\RequestLogBundle\DependencyInjection\RusavskiyAVRequestLogExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RusavskiyAVRequestLogBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new RusavskiyAVRequestLogExtension();
        }
        return $this->extension;
    }
}
