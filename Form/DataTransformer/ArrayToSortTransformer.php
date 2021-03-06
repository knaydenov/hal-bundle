<?php
namespace Kna\HalBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArrayToSortTransformer implements DataTransformerInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($sortArray): ?string
    {
        if (null === $sortArray) {
            return '';
        }
        $sortFields = array_map(function ($direction, $field) {
            return (($direction === 'DESC') ? '-' : null) . $field;
        }, $sortArray, array_keys($sortArray));

        return join(',', $sortFields);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($sortString): ?array
    {
        if (null === $sortString || '' === $sortString) {
            return null;
        }

        $sortFields = array_map('trim', explode(',', $sortString));

        $return = [];

        foreach ($sortFields as $sortField) {
            if (preg_match('/(-)?(\w+)/', $sortField, $matches)) {
                $return[$matches[2]] = ($matches[1] === '-') ? 'DESC' : 'ASC';
            } else {
                throw new TransformationFailedException('Unable to parse sort string');
            }
        }
        return $return;
    }
}