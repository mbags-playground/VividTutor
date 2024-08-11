<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChapterController extends Controller
{
    public function show($id)
    {
        $client = new Client();
        // Load the chapter along with its course and chatBots
        $chapter = Chapter::with(['course', 'chatBots'])->findOrFail($id);

        if($chapter->content==""){
           
            //create content 
            try {
                // Make API request
                $response = $client->get('https://vividtutor.mdsyxsqr4v.workers.dev/?chapter=' . urlencode($chapter->title));
                
                // Check response status
                if ($response->getStatusCode() == 200) {
                    $apiResponse = json_decode($response->getBody()->getContents(), true);
          
                    // Check parsed response
                    if ($apiResponse) {
                        $chapter->content = $apiResponse["response"]; // Adjust as per your JSON structure
                        $chapter->save();
                    } else {
                        dd("Failed to decode parsed response");
                    }
                   
                } else {
                    dd("API request failed with status code: " . $response->getStatusCode());
                }
            } catch (\Exception $e) {
                dd("Error fetching or parsing API response: " . $e->getMessage());
            }
        }
        // Pass the chapter and its related course to the view
    
        return view('chapters.show', [
            'chapter' => $chapter,
            'course' => $chapter->course
        ]);
    }

    public function completeChapter($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->completed = true;
        $chapter->save();

        return redirect()->route('chapters.show', $chapter->id);
    }
}
