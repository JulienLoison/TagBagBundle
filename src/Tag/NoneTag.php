<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

final class NoneTag extends TypedTag
{
    public function __construct(string $content)
    {
        parent::__construct($content, TagInterface::TYPE_NONE);
    }
}