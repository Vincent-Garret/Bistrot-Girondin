<?php


namespace App\Form\Type;


use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;

class CustomTypeClass extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}