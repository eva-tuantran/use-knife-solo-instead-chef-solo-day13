<?php

/**
 *
 * @group App
 */

class Test_Model_User extends TestCase
{
    public function test_foo()
    {
        $this->assertTrue(true);
    }

    public function test_getActiveUsers() {

        var_dump(Model_User::getActiveUsers());
    }
}
