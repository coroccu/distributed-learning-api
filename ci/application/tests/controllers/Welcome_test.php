<?php

class Welcome_Test extends TestCase
{
    public function testIndex()
    {
        $output = $this->request('GET', ['Welcome', 'index']);
        $this->assertContains('<title>Welcome to Distributed Learning App</title>', $output);
    }
}   

?>