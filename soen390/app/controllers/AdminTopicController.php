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
    public function putTogglePublish($id)
    {
        $topic = Topic::find($id);

        if (! $topic) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested Topic could not be found.',
            ), 404);
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

    /**
     * @param  int  $id
     * @return Response
     */
    public function getSingle($id)
    {
        $topic = Topic::find($id);

        if (! $topic) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested Topic could not be found.',
            ), 404);
        }

        return Response::json(array(
            'success' => true,
            'return'  => $topic->toResponseArray(),
        ));
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function putSingle($id)
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

        $topic = Topic::find($id);

        if (! $topic) {
            return Response::json(array(
                'success' => false,
                'return'  => 'The requested Topic [' . $id . '] could not be found.',
            ), 404);
        }

        $updateSuccess = true;

        $updateSuccess = $updateSuccess && $topic->update(array('Name' => Input::get('code')));

        $updateSuccess = $updateSuccess && $topic->translations()->inLocale('en')->first()
            ->update(array('translation' => Input::get('descEn')));

        $updateSuccess = $updateSuccess && $topic->translations()->inLocale('fr')->first()
            ->update(array('translation' => Input::get('descFr')));

        if ($updateSuccess) {
            return Response::json(array(
                'success' => true,
                'return'  => $topic->toResponseArray(),
            ));
        } else {
            return Response::json(array(
                'success' => false,
                'return'  => 'Unable to save changes to Topic due to server side error.',
            ), 500);
        }
    }
}
