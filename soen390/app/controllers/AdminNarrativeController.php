<?php

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
    *   remove a particular narrative
    *
    *   @para int $id (Narrative id)
    */
    public function destroy($id)
    {
        //When removing narrative, we need to remove all Content, Flags and Comments related to it.
        DB::table('Narrative')->where('NarrativeID',$id)->delete();
        DB::table('Content')->where('NarrativeID',$id)->delete();
        DB::table('Flag')->where('NarrativeID',$id)->delete();
        DB::table('Comment')->where('NarrativeID',$id)->delete();
    }
    
}
