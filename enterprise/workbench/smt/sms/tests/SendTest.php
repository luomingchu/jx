<?php

class SendTest extends TestCase
{

    /**
     * 测试发送短信
     *
     * @author Latrell Chan
     */
    public function testSend()
    {
        // 这里是我的手机号，测试的时候要改掉.
        $code = Sms::send('13625001531', '测试短信');
        $this->assertTrue($code);
    }
}
