<?php

namespace App\Command;

use App\Entity\Status;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatusCreationCommand extends Command
{
    protected static $defaultName = 'app:create-status';
    protected static $defaultDescription = 'Création des 4 status';
    private EntityManagerInterface $em;
    private StatusRepository $repository;

    public function __construct(EntityManagerInterface $em, StatusRepository $repository, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->repository = $repository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if (0 === count($this->repository->findAll())) {
            $status1 = (new Status())
                ->setName('Pas encore pris en compte')
                ->setColor('danger');
            $status2 = (new Status())
                ->setName('Pris en compte')
                ->setColor('warning');
            $status3 = (new Status())
                ->setName('En cours de résolution')
                ->setColor('info');
            $status4 = (new Status())
                ->setName('Résolu')
                ->setColor('success');
            $this->em->persist($status1);
            $this->em->persist($status2);
            $this->em->persist($status3);
            $this->em->persist($status4);
            $this->em->flush();
            $io->success('Status créés.');

            return Command::SUCCESS;
        } else {
            $io->error('Les status existent déja');

            return Command::FAILURE;
        }
    }
}