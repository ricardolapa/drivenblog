<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use DateTime;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index()
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
            $this->insert(json_decode($response, true));
        }
        
        return $this->render('news/index.html.twig', [
            'controller_name' => 'Dados Inseridos',
        ]);
    }

    public function insert($response)
    {
        foreach ($response['articles'] as $article) {
            $entityManager = $this->getDoctrine()->getManager();

            $newsArticle = new News();
            $newsArticle->setTitle($article['title']);
            $newsArticle->setImage($article['urlToImage']);
            $newsArticle->setDescription($article['description']);
            $newsArticle->setAuthor($article['author']);
            $newsArticle->setDate($this->toDate($article['publishedAt']));

            $entityManager->persist($newsArticle);

            $entityManager->flush();
        }

    }

    public function toDate($date)
    {
        $obj = explode('T', $date);
        return new DateTime($obj[0]);
    }
}
