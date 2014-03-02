<?php

class BaseControllerTest extends TestCase
{

    /**
     * Tests the `alertAction` function to ensure that it properly flashes the
     * session values and returns the correct RedirectResponse instance.
     *
     * @covers BaseController::alertAction
     */
    public function testAlertAction()
    {
        $hasFailed  = false;
        $message    = "testAlertAction";
        $redirector = Redirect::to('/');

        $baseController = new BaseController;

        $result = $baseController->alertAction(
                $hasFailed,
                $message,
                $redirector
            );

        $this->assertEquals(Session::get('action.failed'), $hasFailed);
        $this->assertEquals(Session::get('action.message'), $message);
        $this->assertSame($result, $redirector);
    }

}
