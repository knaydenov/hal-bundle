<?php
namespace Kna\HalBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class BooleanToStringTransformer implements DataTransformerInterface
{
    const MODE_1_0 = 0;
    const MODE_TRUE_FALSE = 1;
    const MODE_YES_NO = 2;
    const MODE_Y_N = 3;

    protected static $true = ['1', 'true', 'yes', 'y'];
    protected static $false = ['0', 'false', 'no', 'n'];

    /**
     * @var integer
     */
    protected $mode;

    public function __construct($mode = self::MODE_1_0)
    {
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value): ?string
    {
        if (true === $value) {
            return static::$true[$this->mode];
        } elseif (false === $value) {
            return static::$false[$this->mode];
        } elseif (null === $value || '' === $value) {
            return null;
        }
        throw new TransformationFailedException();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value): ?bool
    {
        if (in_array($value, static::$true)) {
            return true;
        } elseif (in_array($value, static::$false)) {
            return false;
        } elseif (null === $value || '' === $value) {
            return null;
        }
        throw new TransformationFailedException();
    }
}