<?php

namespace Forum\Http\Controllers\Forum;

use Forum\Models\Topic;
use Forum\Http\Requests;
use Forum\Models\Section;
use Illuminate\Http\Request;
use Forum\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;
use Forum\Http\Requests\Forum\GetTopicsFormRequest;
use Forum\Http\Requests\Forum\CreateTopicFormRequest;

class TopicController extends Controller
{
    /**
     * Get the view to create a new topic.
     * @param  Topic    $topic    Topic model injection.
     * @param  Section  $section  Section model injection.
     * @return \Illuminate\Http\Response
     */
    public function index(Topic $topic, Section $section)
    {
        $sections = $section->get();

        return view('forum.topic.new')->withSections($sections);
    }
    
    /**
     * Get the view that displays all of the topics.
     * @param  Topic  $topic  Topic model injection.
     * @return \Illuminate\Http\Response
     */
    public function all(Topic $topic)
    {
        $topics = $topic->get();

        return view('forum.topic.all')->withTopics($topics);
    }

    /**
     * Get the view that displays a single topic with its replies.
     * @param  integer  $id     Topic identifier.
     * @param  Topic    $topic  Topic model injection.
     * @return \Illuminate\Http\Response
     */
    public function show($id, Topic $topic)
    {
        $show = $topic->findOrFail($id);

        return view('forum.topic.show', [
            'topic' => $show,
            'posts' => $show->posts()->get()
        ]);
    }

    /**
     * Store the new topic in database.
     * @param  CreateTopicFormRequest  $request  Form request for validation.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTopicFormRequest $request)
    {
        $topic = $request->user()->topics()->create([
            'title' => $request->input('title'),
            'slug' => str_slug($request->input('title')),
            'body' => Markdown::convertToHtml($request->input('body')),
            'section_id' => $request->input('section_id'),
        ]);

        return redirect()->route('forum.topic.show', [
            'id' => $topic->id,
        ]);
    }
}
