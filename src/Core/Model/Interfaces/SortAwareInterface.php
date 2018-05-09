<?php namespace Icover\Core\Model\Interfaces;

interface SortAwareInterface
{
    public function moveAfter( $entity );

    public function moveBefore( $entity );
}
