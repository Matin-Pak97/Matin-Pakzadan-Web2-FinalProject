<?php

namespace App\Command;

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:all-guest-booking:report',
    description: 'A Command for make a report of all bookings which are related to guest',
)]
class AllGuestBookingReportCommand extends Command
{
    protected static $defaultName = 'app:all-guest-booking:report';
    protected static $defaultDescription = 'A Command for make a report of all bookings which are related to guest';

    /** @var BookingRepository */
    private BookingRepository $bookingRepository;

    /** @var Filesystem */
    private Filesystem $filesystem;

    /**
     * PriceUpdateCommand constructor.
     * @param BookingRepository $bookingRepository
     * @param Filesystem $filesystem
     * @param string|null $name
     */
    public function __construct(
        BookingRepository $bookingRepository,
        Filesystem $filesystem,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->bookingRepository = $bookingRepository;
        $this->filesystem = $filesystem;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->bookingRepository->createQueryBuilder("b")
            ->innerJoin("b.bookedBy", "u")
            ->innerJoin("b.property", "p")
            ->innerJoin("b.ratePlan", "rp")
            ->select("u.email as createdUserName")
            ->addSelect("b.id as bookingId")
            ->addSelect("p.id as propertyId")
            ->addSelect("p.marketName as propertyMarketName")
            ->addSelect("rp.name as ratePlanName")
            ->addSelect("DATE_FORMAT(b.bookingStartDate, '%Y-%m-%d') as startDate")
            ->addSelect("DATE_FORMAT(b.bookingEndDate, '%Y-%m-%d') as endDate")
            ->addSelect("b.numberOfGuest as numOfGuests")
            ->addSelect("b.extraGuestTotalPrice as extraPrice")
            ->addSelect("b.totalBookingPrice as totalPrice")
            ->where("u.roles")
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_GUEST%')
            ->getQuery()
            ->getArrayResult();

        $buffered = new BufferedOutput();
        $table = new Table($buffered);
        $table->setHeaders(["Booked By", "Booking ID", "Property ID", "Property Name", "RatePlan Name", "Booking Start Date", "Booking End Date", "Number Of Guests", "Total Extra Price", "Total Price"]);
        $table->setRows($result);
        $table->setStyle("box-double");
        $table->render();

        $this->filesystem->appendToFile("/var/www/html/var/report.txt", $buffered->fetch());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return Command::SUCCESS;
    }
}
