<?php

/**
 * @author Alan Ly <me@alanly.ca>
 * @package Controller
 */
class AdminNarrativeController extends BaseController {

    public function getIndex()
    {
        return View::make('admin.narratives.index');
    }

    public function getUpload()
    {
        $categories = Category::all();
        $categoryArray = array();

        foreach($categories as $c)
            $categoryArray[$c->CategoryID] = $c->Description;

        return View::make('admin.narratives.upload')->with('categoryArray', $categoryArray);
    }
    /**
     * remove a particular narrative
     *
     * @author Thomas Rahn <thomas@rahn.ca>
     * @param int $id (Narrative id)
     */
    public function destroy($id)
    {
        $narrative = Narrative::find($id);

        if (! $narrative)
            return App::abort(404);

        $narrative->flags()->delete();
        $narrative->media()->delete();
        $narrative->delete();
    }
    
}
