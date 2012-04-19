<?php

namespace MQM\AssetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use MQM\AssetBundle\Helper\AssetFileHelper;

class InstallScriptCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mqm_asset:install:script')
            ->setDescription('Copy asset-graber scripts from bundle/Resources/web to app/web')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getContainer()->get('mqm_asset.file_helper');
        $helper->copyScriptsFromBundleToAppWebRootDir();
    }
}