<?php

use PHPUnit\Framework\TestCase;

class PruebaBasicaTest extends TestCase
{
    public function testSiemprePasa()
    {
        // Verificar que true es igual a true.
        $this->assertTrue(true);
    }

    public function testIgualdadSimple()
    {
        // Verificar que 1 es igual a 1.
        $this->assertEquals(1, 1);
    }

    public function testArrayVacio()
    {
        // Verificar que un array vacío realmente está vacío.
        $this->assertEmpty([]);
    }
}
?>
