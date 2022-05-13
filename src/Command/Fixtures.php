<?php

namespace App\Command;

use App\Entity\Account;
use App\Entity\Permission;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Fixtures extends Command
{
    protected static $defaultName = 'app:fixtures';
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->create($output);
        return (int)0;
    }

    private function create(OutputInterface $output): void
    {
        /**
         * Users
         */
        $output->writeln("<info>Chargement des utilisateurs ...</info>");

        $admin = new User();
        $admin->setEmail("test@example.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword("test");
        $this->em->persist($admin);

        $output->writeln($admin->getEmail() . " fait ...");


        $user = new User();
        $user->setEmail("test@example.com2")
            ->setRoles(['ROLE_USER'])
            ->setPassword("test");
        $this->em->persist($user);

        /**
         * Accounts
         */
        $output->writeln("<info>Chargement des comptes ...</info>");

        $chicago = new Account();
        $chicago->setName("Chicago");
        $this->em->persist($chicago);

        $output->writeln($chicago->getName() . " fait ...");

        $vegas = new Account();
        $vegas->setName("Vegas");
        $this->em->persist($vegas);

        $output->writeln($vegas->getName() . " fait ...");

        $miami = new Account();
        $miami->setName("Miami");
        $this->em->persist($miami);

        $output->writeln($miami->getName() . " fait ...");


        /**
         * Permissions
         */
        $output->writeln("<info>Chargement des permissions ...</info>");

        $permission = new Permission();
        $permission->setAccount($chicago)
            ->setUser($user);
        $this->em->persist($permission);


        $this->em->flush();
    }
}