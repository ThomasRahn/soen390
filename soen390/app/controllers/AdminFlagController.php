<?php

class AdminFlagController extends BaseController {

    public function getIndex($id)
    {

        return View::make('admin.narratives.flag')->with('NarrativeID',$id);
    }

    /**
	*	remove a particular flag
	*
	*	@para int $id (flag id)
	*/
	public function destroy($id)
	{
		$flag = Flag::find($id);
		$flag->first()->delete();
	}
}
