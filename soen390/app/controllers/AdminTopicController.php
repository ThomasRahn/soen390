<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controllers
 */
class AdminTopicController extends \BaseController
{
    protected static $restful = true;
    protected        $topic   = null;

    /**
     * @return Response
     */
    public function getIndex()
    {
        $allTopics = Topic::all();
        $topics = array();

        foreach ($allTopics as $t) {
            $o = new stdClass;

            $o->id          = $t->TopicID;
            $o->code        = $t->Name;
            $o->narratives  = $t->narratives()->count();
            $o->description = $t->translations()
                ->inLocale(App::getLocale())
                ->first()
                ->translation;
            $o->published   = $t->Published;

            $topics[] = $o;
        }

        return View::make('admin.topic.index')->with('topics', $topics);
    }

    /**
     * @return Response
     */
    public function postAdd()
    {
        $validator = Validator::make(
            Input::all(),
            array(
                'code' => 'required|alpha_dash|max:255',
                'descEn' => 'required',
                'descFr' => 'required',
            )
        );

        if ($validator->fails()) {
            return Response::json(
                array(
                    'success' => false,
                    'return' => array(
                        'validator' => $validator->errors()->toArray(),
                    ),
                ),
                400
            );
        }

        // Create the Topic, which simply requires the "codename", and get its reference.
        $topic = Topic::create(array(
            'Name'      => Input::get('code'),
            'Published' => true,
        ));

        $saveSuccess = $topic instanceof Topic;

        // Save the description translations for this topic.
        $saveSuccess = $saveSuccess && $topic->translations()->save(
            new TopicTranslation(array(
                'language_id' => Language::where('Code', 'en')->first()->LanguageID,
                'translation' => Input::get('descEn'),
            ))
        );

        $saveSuccess = $saveSuccess && $topic->translations()->save(
            new TopicTranslation(array(
                'language_id' => Language::where('Code', 'fr')->first()->LanguageID,
                'translation' => Input::get('descFr'),
            ))
        );

        if ($saveSuccess === true) {
            return Response::json(array(
                'success' => true,
                'return'  => $topic->toResponseArray()
            ));
        } else {
            return Response::json(array(
                'success' => false,
                'return'  => trans('admin.topic.add.saveFailed'),
            ), 500);
        }
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function deleteIndex($id)
    {
        $topic = Topic::find($id);

        $topicCode = $topic->Name;

        if (! $topic) {
            App::abort(404, 'Unable to find specified topic.');
        }

        // If there is only 1 remaining topic, enforce the rule that there
        // always has to be at least one topic remaining.
        if (Topic::count() < 2) {
            return Response::json(
                array(
                    'success' => false,
                    'return'  => Lang::get('admin.topic.delete.atleastOne'),
                ),
                400
            );
        }
        
        $first = Topic::first();

        // Delete topic and its association translations within a transaction.
        DB::transaction(function() use ($topic, $first)
        {
            // Move all associated narratives into the first topic.
            $topic->narratives()->update(
                array('TopicID' => $first->TopicID)
            );

            $topic->translations()->delete();
            $topic->delete();
        });

        $deleteSuccess = (! Topic::find($id));

        if ($deleteSuccess) {
            return Response::json(array(
                'success' => true,
                'return'  => Lang::get(
                    'admin.topic.delete.success',
                    array(
                        'code'  => $topicCode,
                        'first' => $first->Name,
                    )
                ),
            ));
        } else {
            return Response::json(
                array(
                    'success' => false,
                    'return'  => Lang::get('admin.topic.delete.failure', array('code' => $topicCode)),
                ),
                500
            );
        }
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function putTogglePublish($id)
    {
        $topic = Topic::find($id);

        if (! $topic) {
            App::abort(404, 'The requested Topic instance could not be found.');
        }

        $topic->Published = ! $topic->Published;

        if ($topic->save()) {
            return Response::json(
                array(
                    'success' => true,
                    'return'  => $topic->toResponseArray(),
                )
            );
        } else {
            return Response::json(
                array(
                    'success' => false,
                    'return'  => Lang::get('admin.topic.togglePublish.failure', array('code' => $topic->Name)),
                ),
                500
            );
        }
    }
}
