<?php

namespace Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\Fixture;

class SkipReferenced
{
    public function run()
    {
        $value = [];
        $this->process($value);
    }

    private function process(array &$value)
    {
    }
}
