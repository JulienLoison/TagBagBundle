<?php

namespace spec\Setono\TagBagBundle\TagBag;

use Setono\TagBagBundle\Renderer\CompositeRenderer;
use Setono\TagBagBundle\Renderer\NoneRenderer;
use Setono\TagBagBundle\Renderer\ScriptRenderer;
use Setono\TagBagBundle\Renderer\StyleRenderer;
use Setono\TagBagBundle\Tag\HtmlTag;
use Setono\TagBagBundle\TagBag\TagBag;
use PhpSpec\ObjectBehavior;

class TagBagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $renderer = new CompositeRenderer(new ScriptRenderer(), new StyleRenderer(), new NoneRenderer());
        $this->beConstructedWith($renderer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBag::class);
    }

    public function it_gets_storage_key(): void
    {
        $this->getStorageKey()->shouldReturn(TagBag::NAME);
    }

    public function it_gets_name(): void
    {
        $this->getName()->shouldReturn(TagBag::NAME);
    }

    public function it_can_initialize_array(): void
    {
        $arr = ['test'];
        $this->getWrappedObject()->initialize($arr);

        $this->all()->shouldReturn(['test']);
    }

    public function it_clears(): void
    {
        $this->add(new HtmlTag('test'), 'section');

        $this->clear()->shouldReturn([
            'section' => [
                'test'
            ]
        ]);

        $this->all()->shouldReturn([]);
    }

    public function it_gets_section(): void
    {
        $this->add(new HtmlTag('tag1'), 'section1');
        $this->add(new HtmlTag('tag2'), 'section2');

        $this->getSection('section2')->shouldReturn([
            'tag2'
        ]);

        $this->getSection('section2')->shouldReturn([]);
    }

    public function it_returns_default_if_section_does_not_exist(): void
    {
        $this->add(new HtmlTag('tag1'), 'section1');
        $this->add(new HtmlTag('tag2'), 'section2');

        $this->getSection('section3', [])->shouldReturn([]);
    }
}
