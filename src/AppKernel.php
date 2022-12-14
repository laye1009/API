<?php

//use App\Kernel;

use Symfony\Component\HttpKernel\Kernel;


// in app/AppKernel.php
class AppKernel extends Kernel implements KernelInterface, RebootableInterface, TerminableInterface
{
    // ...

    public function registerBundles()
    {
        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            // ...
            $bundles[] = new Overblog\GraphiQLBundle\OverblogGraphiQLBundle();
        }
    }

        /**
     * Builds the service container.
     *
     * @return ContainerBuilder
     *
     * @throws \RuntimeException
     */
    protected function buildContainer()
    {
        foreach (['cache' => $this->getCacheDir(), 'build' => $this->warmupDir ?: $this->getBuildDir(), 'logs' => $this->getLogDir()] as $name => $dir) {
            if (!is_dir($dir)) {
                if (false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException(sprintf('Unable to create the "%s" directory (%s).', $name, $dir));
                }
            } elseif (!is_writable($dir)) {
                throw new \RuntimeException(sprintf('Unable to write in the "%s" directory (%s).', $name, $dir));
            }
        }

        $container = $this->getContainerBuilder();
        $container->addObjectResource($this);
        $this->prepareContainer($container);

        if (null !== $cont = $this->registerContainerConfiguration($this->getContainerLoader($container))) {
            trigger_deprecation('symfony/http-kernel', '5.3', 'Returning a ContainerBuilder from "%s::registerContainerConfiguration()" is deprecated.', get_debug_type($this));
            $container->merge($cont);
        }
    }
} 