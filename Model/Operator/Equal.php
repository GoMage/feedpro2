<?php
namespace GoMage\Feed\Model\Operator;


class Equal implements OperatorInterface
{

    /**
     * @param  $testable
     * @param  $value
     * @return bool
     */
    public function compare($testable, $value)
    {
        return ($testable == $value);
    }
}