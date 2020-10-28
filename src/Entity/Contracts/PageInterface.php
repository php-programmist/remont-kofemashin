<?php

namespace App\Entity\Contracts;

use DateTimeInterface;

interface PageInterface
{
    public function getPath():string;

    public function getH1():string;

    public function getCardHeader():string;

    public function getCardImage():string;

    public function getTextComputed():string;

    public function getModifyDate(): ?DateTimeInterface;
}