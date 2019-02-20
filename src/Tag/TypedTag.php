<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

class TypedTag implements TagInterface, ContentAwareInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $type = self::TYPE_NONE;

    public function __construct(string $content, string $type)
    {
        $this->content = $content;
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
