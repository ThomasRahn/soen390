<?php

class AdminNarrativeController extends BaseController {

    public function getIndex()
    {
        return View::make('admin.narratives.index');
    }

    public function getUpload()
    {
        $categories = Category::all();
        $categoryArray = [];

        foreach($categories as $c)
            $categoryArray[$c->CategoryID] = $c->Description;

        return View::make('admin.narratives.upload')->with('categoryArray', $categoryArray);
    }
    /**
    *   remove a particular narrative
    *
    *   @para int $id (Narrative id)
    */
    public function destroy($id)
    {
        $narrative = Narrative::find($id);
        $narrative->first()->delete();
    }
    
}
