<?php

namespace App\Http\Controllers\API;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSettings;
use Illuminate\Support\Facades\Http;

class ArticlesFeedController extends Controller
{
    //
    function getArticlesFeed(Request $request) {
        try {
            $data = [];
            $userSettings = UserSettings::firstWhere('user_id', $request->user()->id);
            if (!$request->user()->usersettings) {
                $data = $this->getallfeedData();
            } elseif ($request->user()->usersettings && $request->user()->usersettings->source_id === 1) {
                // $arr = [];
                foreach ($request->user()->usersettings->usersettingscatagories as $catagory) {
                    if ($catagory->catagory_id === 1) {
                        $articles = $this->getNewsAppleResponse($params = null);
                    } elseif ($catagory->catagory_id === 2) {
                        $articles = $this->getNewsTeslaResponse($params = null);
                    } elseif ($catagory->catagory_id === 3) {
                        $articles = $this->getNewsBusinessResponse($params = null);
                    } elseif ($catagory->catagory_id === 4) {
                        $articles = $this->getNewsTechResponse($params = null);
                    } else {
                        $articles = $this->getNewsWsjResponse($params = null);
                    }
                    $data = array_merge($data, $articles);
                }
            } elseif ($request->user()->usersettings && $request->user()->usersettings->source_id === 2) {
                // $arr = [];
                foreach ($request->user()->usersettings->usersettingscatagories as $catagory) {
                    if ($catagory->catagory_id === 6) {
                        $articles = $this->getTGUSResponse($params = null);
                    } elseif ($catagory->catagory_id === 7) {
                        $articles = $this->getTGWNResponse($params = null);
                    } elseif ($catagory->catagory_id === 8) {
                        $articles = $this->getTGFootballResponse($params = null);
                    } elseif ($catagory->catagory_id === 9) {
                        $articles = $this->getTGPoliticsResponse($params = null);
                    } elseif ($catagory->catagory_id === 10) {
                        $articles = $this->getTGOpinionResponse($params = null);
                    } else {
                        $articles = $this->getTGANResponse($params = null);
                    }
                    $data = array_merge($data, $articles);
                }
            } else {
                // $arr = [];
                foreach ($request->user()->usersettings->usersettingscatagories as $catagory) {
                    if ($catagory->catagory_id === 12) {
                        $articles = $this->getNYArtsResponse($params = null);
                    } elseif ($catagory->catagory_id === 13) {
                        $articles = $this->getNYScienceResponse($params = null);
                    } elseif ($catagory->catagory_id === 14) {
                        $articles = $this->getNYUSResponse($params = null);
                    } else {
                        $articles = $this->getNYWorldResponse($params = null);
                    }
                    $data = array_merge($data, $articles);
                }
            }

            return response()->json([
                "data" => $data,
                "message" => "Data successfully retrieved",
                "status" => 200,
                ], 
            200);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'trace' => $th->getTrace(),
                'status' =>  422
            ], 422);
        }
    }

    function getallfeedData() {
            $NYTArtsArticles = $this->getNYArtsResponse($params = null);
            $NYTScienceArticles = $this->getNYScienceResponse($params = null);
            $NYTUSArticles = $this->getNYUSResponse($params = null);
            $NYTWorldArticles = $this->getNYWorldResponse($params = null);
            $TGUSArticles = $this->getTGUSResponse($params = null);
            $TGWNArticles = $this->getTGWNResponse($params = null);
            $TGFArticles = $this->getTGFootballResponse($params = null);
            $TGPArticles = $this->getTGPoliticsResponse($params = null);
            $TGOArticles = $this->getTGOpinionResponse($params = null);
            $TGANArticles = $this->getTGANResponse($params = null);
            $NAArticles = $this->getNewsAppleResponse($params = null);
            $NTArticles = $this->getNewsTeslaResponse($params = null);
            $NBArticles = $this->getNewsBusinessResponse($params = null);
            $NTECHArticles = $this->getNewsTechResponse($params = null);
            $NWSArticles = $this->getNewsWsjResponse($params = null);
            $fullNYTaray = array_merge($NYTArtsArticles,$NYTScienceArticles, $NYTUSArticles, $NYTWorldArticles, $TGUSArticles, $TGWNArticles, $TGFArticles, $TGPArticles, $TGOArticles, $TGANArticles, $NAArticles, $NTArticles, $NBArticles, $NTECHArticles, $NWSArticles);
            return $fullNYTaray;
    }

    function getNYArtsResponse() {
        $nyTimesArtsResponse = Http::get('https://api.nytimes.com/svc/topstories/v2/arts.json?api-key=j4iZrQ5armfT25qV4MOyt5mBjRhBLOro');
        return $this->getRectifiedNYTData($nyTimesArtsResponse->json(), 'Arts');
    }

    function getNYScienceResponse() {
        $nyTimesScienceResponse = Http::get('https://api.nytimes.com/svc/topstories/v2/science.json?api-key=j4iZrQ5armfT25qV4MOyt5mBjRhBLOro');
        return $this->getRectifiedNYTData($nyTimesScienceResponse->json(), 'Science');
    }

    function getNYUSResponse() {
        $nyTimesUSResponse = Http::get('https://api.nytimes.com/svc/topstories/v2/us.json?api-key=j4iZrQ5armfT25qV4MOyt5mBjRhBLOro');
        return $this->getRectifiedNYTData($nyTimesUSResponse->json(), 'US');
    }

    function getNYWorldResponse() {
        $nyTimesWorldResponse = Http::get('https://api.nytimes.com/svc/topstories/v2/world.json?api-key=j4iZrQ5armfT25qV4MOyt5mBjRhBLOro');
        return $this->getRectifiedNYTData($nyTimesWorldResponse->json(), 'World');
    }

    function getRectifiedNYTData($data, $catagory) {
        $args = [];
        if(isset($data['results'])){
            foreach ($data['results'] as $row) {
                if($row['url'] !== '' && $row['url'] !== null && $row['url'] !== 'null'){
                    $dateString = $row['published_date'];
                    $date = Carbon::parse($dateString);
                    $formattedDate = $date->format('F j, Y, g:i a');#
                    $args[] = [
                        'title' => $row['title'],
                        'date' => $formattedDate,
                        'rawDate' => $row['published_date'],
                        'author' => $row['byline'],
                        'url' => $row['url'],
                        'source' => 'New York Times',
                        'img' => 'nyt.jpg',
                        'catagory' => $catagory,
                    ];
                }
            }
        }
        return $args;
    }

    function getNewsAppleResponse() {
        $response = Http::get('https://newsapi.org/v2/everything?q=apple&from=2023-06-25&to=2023-06-25&sortBy=popularity&apiKey=83c7532eb0e242578760702b187624a3');
        return $this->getRectifiedTNData($response->json(), 'Apple Articles');
    }

    function getNewsTeslaResponse() {
        $response = Http::get('https://newsapi.org/v2/everything?q=tesla&from=2023-05-26&sortBy=publishedAt&apiKey=83c7532eb0e242578760702b187624a3');
        return $this->getRectifiedTNData($response->json(), 'Tesla Car Articles');
    }

    function getNewsBusinessResponse() {
        $response = Http::get('https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=83c7532eb0e242578760702b187624a3');
        return $this->getRectifiedTNData($response->json(), 'Business Headlines in US');
    }

    function getNewsTechResponse() {
        $response = Http::get('https://newsapi.org/v2/top-headlines?sources=techcrunch&apiKey=83c7532eb0e242578760702b187624a3');
        return $this->getRectifiedTNData($response->json(), 'TechCrunch');
    }

    function getNewsWsjResponse() {
        $response = Http::get('https://newsapi.org/v2/everything?domains=wsj.com&apiKey=83c7532eb0e242578760702b187624a3');
        return $this->getRectifiedTNData($response->json(), 'Wall Street Journal');
    }

    function getRectifiedTNData($data, $catagory) {
        $args = [];
        if(isset($data['articles'])){
            foreach ($data['articles'] as $row) {
                if($row['url'] !== '' && $row['url'] !== null && $row['url'] !== 'null'){
                    $dateString = $row['publishedAt'];
                    $date = Carbon::parse($dateString);
                    $formattedDate = $date->format('F j, Y, g:i a');
                    $args[] = [
                        'title' => $row['title'],
                        'date' => $formattedDate,
                        'rawDate' => $row['publishedAt'],
                        'author' => $row['author'],
                        'url' => $row['url'],
                        'source' => 'The News API',
                        'img' => 'tn.jpg',
                        'catagory' => $catagory,
                    ];
                }
            }
        }
        return $args;
    }

    function getTGUSResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=usa&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'US News');
    }

    function getTGWNResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=world&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'World News');
    }

    function getTGFootballResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=football&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'Football');
    }

    function getTGPoliticsResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=politics&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'Politics');
    }

    function getTGOpinionResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=opinions&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'Opinion');
    }

    function getTGANResponse() {
        $response = Http::get('https://content.guardianapis.com/search?q=australia&api-key=7bb2f3a4-0ef4-4261-a32b-24b3c7f361f7');
        return $this->getRectifiedTGData($response->json(), 'Australian News');
    }

    function getRectifiedTGData($data, $catagory) {
        $args = [];
        if(isset($data['response']['results'])){
            foreach ($data['response']['results'] as $row) {
                if($row['webUrl'] !== '' && $row['webUrl'] !== null && $row['webUrl'] !== 'null'){
                    $dateString = $row['webPublicationDate'];
                    $date = Carbon::parse($dateString);
                    $formattedDate = $date->format('F j, Y, g:i a');
                    $args[] = [
                        'title' => $row['webTitle'],
                        'date' => $formattedDate,
                        'rawDate' => $row['webPublicationDate'],
                        'author' => 'N/A',
                        'url' => $row['webUrl'],
                        'source' => 'The Guardian',
                        'img' => 'tglogo.jpg',
                        'catagory' => $catagory,
                    ];
                }
            }
        }
        return $args;
    }
}
