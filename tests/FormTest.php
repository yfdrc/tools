<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Tests {

    use Drc\Crypt\Crypt;
    use PHPUnit\Framework\TestCase;

    final class FormTest extends TestCase
    {
        public function test01()
        {
            $nr = random_bytes(32);
            $en = Crypt::encrypt($nr);
            $de = Crypt::decrypt($en);
            $this->assertTrue($nr === $de);
            return ;
        }

        /**
         * @depends test01
         */
        public function test02()
        {
            $stack[] = null;
            array_push($stack, 'foo');
            $this->assertEquals('foo', $stack[count($stack) - 1]);
            $this->assertNotEmpty($stack);
            return $stack;
        }
    }
}
