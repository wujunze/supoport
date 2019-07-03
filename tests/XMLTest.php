<?php

namespace winwin\support;

class XMLTest extends TestCase
{
    public function testBuild()
    {
        $content = XML::build([
            'charset' => 'UTF-8',
            'version' => '1.0.0',
            'name' => 'hello <world>',
        ]);
        // echo $content;
        $this->assertEquals('<xml><charset>UTF-8</charset><version>1.0.0</version><name><![CDATA[hello <world>]]></name></xml>', trim($content));
    }
}
