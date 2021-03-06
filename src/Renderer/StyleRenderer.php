<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;
use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use Setono\TagBagBundle\Tag\ContentAwareInterface;
use Setono\TagBagBundle\Tag\TagInterface;

final class StyleRenderer extends Renderer
{
    public function supports(TagInterface $tag): bool
    {
        return TagInterface::TYPE_STYLE === $tag->getType() && $tag instanceof ContentAwareInterface;
    }

    /**
     * @throws PcreException
     * @throws StringsException
     */
    public function render(TagInterface $tag): string
    {
        if (!$tag instanceof ContentAwareInterface) {
            throw new UnexpectedTypeException($tag, ContentAwareInterface::class);
        }

        return $this->renderWithWrapper($tag->getContent(), '<style>');
    }
}
