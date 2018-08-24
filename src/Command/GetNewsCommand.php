<?php namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\News;

class GetNewsCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:get-news')

            // the short description shown while running "php bin/console list"
            ->setDescription('Fetch all news into Entity.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to Get all News from API an insert into entity (news) on database')
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://newsapi.org/v2/top-headlines?sources=reuters&apiKey=9470ddf26d9d476ebaa3771ba66f1ac3",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            echo $response;
            // $this->insert(json_decode($response, true));
        }
        //$output->writeln($response);
    }

    public function insert($response)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        foreach ($response as $article) {
            $entityManager = $this->getDoctrine()->getManager();

            $newsArticle = new News();
            $newsArticle->setTitle($article['title']);
            $newsArticle->setImage($article['urlToImage']);
            $newsArticle->setDescription($article['description']);
            $newsArticle->setAuthor($article['author']);
            $newsArticle->setDate($article['publishedAt']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($newsArticle);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        // return new Response('Saved new product with id '.$product->getId());
    }
}