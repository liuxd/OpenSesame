<?php
class GravatarTest extends PHPUnit_Framework_TestCase
{
    public function testgetGravatarURL()
    {
        $email = 'liuxidong1984@gmail.com';
        $size = 30;

        $ret = Gravatar::getGravatarURL($email, $size);
        $this->assertEquals('http://www.gravatar.com/avatar/05cdbb54576585408d487d5e8aca534d?s=30&d=&r=G', $ret);
    }
}

# end of this file
