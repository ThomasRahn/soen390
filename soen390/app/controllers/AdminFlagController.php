<?php

class AdminFlagController extends BaseController {

    public function getIndex()
    {
        return View::make('admin.narratives.flag');
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
