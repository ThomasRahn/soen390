<?php

class AdminTopicController extends \BaseController
{
    protected static $restful = true;
    protected        $topic   = null;

    public function getIndex()
    {
        $allTopics = Topic::all();
        $topics = array();

        foreach ($allTopics as $t) {
            $o = new stdClass;

            $o->id = $t->TopicID;
            
            $o->code = $t->Name;
            
            $o->description = $t->translations()
                ->inLocale(App::getLocale())
                ->first()
                ->translation;
            
            $o->narratives = $t->narratives()->count();

            $topics[] = $o;
        }

        return View::make('admin.topic.index')->with('topics', $topics);
    }
}
