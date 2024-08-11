<?php

namespace App\Http\Controllers;

use App\Models\ChatBot;
use App\Models\Chapter;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    public function show($id)
    {
        $chapter = Chapter::with('chatBots')->findOrFail($id);
        return view('chapters.show', compact('chapter'));
    }

    public function completeChapter($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->completed = true;
        $chapter->save();

        return redirect()->route('chapters.show', $chapter->id);
    }

    public function send(Request $request, $chapterId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chapter = Chapter::findOrFail($chapterId);
        $client = new Client();

        try {
            // Make API request
            $response = $client->get('https://vividtutor.mdsyxsqr4v.workers.dev/?chapter=' . urlencode($chapter->title).'&message=' . urlencode($request->input('message')));
            
            // Check response status
            if ($response->getStatusCode() == 200) {
                $apiResponse = json_decode($response->getBody()->getContents(), true);
                
                // Check and parse API response
                if ($apiResponse && isset($apiResponse['response'])) {
                   
                    // Create user message
                    $userMessage = new ChatBot();
                    $userMessage->question = $request->input('message');
                    $userMessage->answer = $apiResponse['response'] ?? 'Ooohh sorry for inconvinience'; // Adjust based on API response
                    $userMessage->chapter_id = $chapterId;
                    $userMessage->save();

                    // Fetch the latest messages
                    $chatMessages = $chapter->chatBots()->latest()->get();

                    return response()->json([
                        'question' => $userMessage->question,
                        'answer' => $userMessage->answer,
                    ]);
                } else {
                    return response()->json(['error' => 'Failed to parse API response'], 500);
                }
            } else {
                return response()->json(['error' => 'API request failed'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching or parsing API response: ' . $e->getMessage()], 500);
        }
    }
}
