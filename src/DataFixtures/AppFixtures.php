<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\Infosup;
use App\Entity\Property;
use App\Entity\Rating;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private  $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $createdAt = $faker->dateTimeBetween('-6 months');
        $startDate = $faker->dateTimeBetween('-3 months');
        $duration = mt_rand(3, 10);
        $endDate = (clone $startDate)->modify("+$duration days");

        $userAdmin = new User();
        $userAdmin->setUsername("Admin")
                ->setPassword($this->encoder->encodePassword($userAdmin, 'password'))
                ->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);

        $users = [];
        $types = [];
        $genres = ['male', 'female'];
        $typeGenres = ['Location', 'vente'];

        for ( $u = 1; $u <= 10; $u++){

            $user = new User();

            $user->setUsername($faker->userName)
                ->setPassword($this->encoder->encodePassword($userAdmin, 'password'))
                ->setRoles(['ROLE_USER']);


            $client = new Client();
            $genre = $faker->randomElement($genres);

            $client->setNom($faker->firstname($genre))
                ->setPrenom($faker->lastName)
                ->setLieuNaiss($faker->city)
                ->setAdresse($faker->address)
                ->setContact($faker->numberBetween(90000000, 99999999))
                ->setDateNaiss($faker->dateTimeBetween('-6 years'))
                ->setNumCin($faker->numberBetween(90000000, 9999999999))
                ->setNumPermis($faker->numberBetween(90000000, 9999999999))
                ->setUser($user);
            $manager->persist($client);

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 1; $i <= 2; $i++){
            $type = new Type();
            $typeGenre = $faker->randomElement($typeGenres);

            $type->setName($typeGenre);
            $manager->persist($type);
            $types[] =$type;
        }

        $type = $types[mt_rand(0, count($types) - 1)];

        for( $i = 1; $i <= 10; $i++){
            $voiture = new Voiture();


            $voiture->setMatricule($faker->numberBetween(1000, 9999))
                ->setModele('Avensise')
                ->setMarque('Toyota')
                ->setCompteur(0)
                ->setCouleur($faker->rgbCssColor)
                ->setIsDispo($faker->boolean)
                ->setDateDrive($faker->dateTimeBetween('-3 months'))
                ->setImage("2555b56ef91365aef5d493bf076b623b.jpeg")
                ->setType($type)
            ;

            $infoSup = new Infosup();

            $infoSup->setVoiture($voiture)
                ->setDateAssurFin($endDate)
                ->setDateAssurDep($startDate)
                ->setDateChanRouDep($startDate)
                ->setDateChanRouFin($endDate)
                ->setDateVidDep($startDate)
                ->setDateVidFin($endDate)
                ->setDateVisTechDep($startDate)
                ->setDateVisTechFin($endDate);
            $manager->persist($infoSup);

            for ($k = 1; $k <= mt_rand(0, 4); $k++){
                $ad =  new Ad();
                $title = $faker->sentence();
                $intro = $faker->paragraph(2);
                $content = '<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';
                $booker = $users[mt_rand(0, count($users) - 1)];

                $ad->setTitle($title)
                    ->setIntroduction($intro)
                    ->setPrice(mt_rand(40, 200))
                    ->setDescription($content)
                    ->setVoiture($voiture)
                ;
                for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                    $booking = new Booking();
                    $amout = $ad->getPrice() * $duration;

                    $booking->setCreatedAt($createdAt)
                        ->setAd($ad)
                        ->setBooker($booker)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setAmount($amout)
                    ;

                    $manager->persist($booking);

                }
                if(mt_rand(0,1)){
                    $comment = new Rating();
                    $comment->setAd($ad)
                        ->setAuthor($booker)
                        ->setRating(mt_rand(1, 5));
                    $manager->persist($comment);
                }
                $manager->persist($ad);
            }


            $manager->persist($voiture);
        }

        for( $i = 1; $i <= 30; $i++){
            $property = new Property();

            $title = $faker->sentence();
            $content = '<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';
            $createdAt = $faker->dateTimeBetween('-6 months');

            $property->setTitle($title)
                ->setDescription($content)
                ->setAdresse($faker->address)
                ->setBedrooms(mt_rand(0,6))
                ->setCity($faker->city)
                ->setCreatedAt($createdAt)
                ->setFloor(mt_rand(1,3))
                ->setPrice(mt_rand(1000000, 999999999))
                ->setRooms(mt_rand(1,7))
                ->setSold($faker->boolean)
                ->setSurface(mt_rand(10,100))
                ->setImage('diagonal-building.jpg')
                ->setType($type)
            ;
            for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();
                $amout = $ad->getPrice() * $duration;

                $booking->setCreatedAt($createdAt)
                    ->setProperty($property)
                    ->setBooker($booker)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setAmount($amout)
                ;

                $manager->persist($booking);

            }
            if(mt_rand(0,1)){
                $comment = new Rating();
                $comment->setProperty($property)
                    ->setAuthor($booker)
                    ->setRating(mt_rand(1, 5));
                $manager->persist($comment);
            }
            $manager->persist($property);
        }

        $manager->flush();
    }
}
