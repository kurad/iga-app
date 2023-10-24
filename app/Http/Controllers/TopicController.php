<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Services\TopicService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Topic\CreateTopicRequest;

class TopicController extends Controller
{
    public function __construct(public TopicService $topicService)
    {
    }

    public function index()
    {
        $topic = $this->topicService->allTopics()->toArray();
        return Response::json($topic);
    }
    public function store(CreateTopicRequest $request)
    {
        try {
            $topic = $this->topicService->createTopic($request->dto);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}