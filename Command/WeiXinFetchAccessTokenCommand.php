<?php

namespace Liz\WeiXinBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeiXinFetchAccessTokenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lizwx:actk:update')
            ->setDescription('Update WeiXin access token...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('liz_wx.service.base')->updateAccessToken();
        $output->writeln('WeiXin access token had been save into cache dir.');
    }

}
