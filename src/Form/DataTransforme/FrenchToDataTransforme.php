<?php
namespace App\Form\DataTransforme;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDataTransforme implements DataTransformerInterface
{
    public function transform($date)
    {
        if ($date === null) return '';
        return $date->format('d/m/Y');
    }

    public function reverseTransform($frenchDate)
    {
        if($frenchDate === null){
            throw new TransformationFailedException('Vous devez fournire un date');
        }

        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

        if ($date === false){
            throw new TransformationFailedException("le format de la date n'est pas le bon !");
        }

        return $date;
    }

}