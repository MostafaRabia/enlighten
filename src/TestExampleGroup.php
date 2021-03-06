<?php

namespace Styde\Enlighten;

use Styde\Enlighten\Facades\Enlighten;
use Styde\Enlighten\Models\ExampleGroup;

class TestExampleGroup
{
    /**
     * @var TestRun
     */
    private $testRun;

    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $texts;

    /**
     * @var ExampleGroup|null
     */
    protected $exampleGroup = null;

    public function __construct(string $className, array $texts = [])
    {
        $this->testRun = TestRun::getInstance();
        $this->className = $className;
        $this->texts = $texts;
    }

    public function is(string $name): bool
    {
        return $this->className === $name;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function save(): ExampleGroup
    {
        if ($this->exampleGroup != null) {
            return $this->exampleGroup;
        }

        $run = $this->testRun->save();

        return $this->exampleGroup = ExampleGroup::create([
            'run_id' => $run->id,
            'class_name' => $this->getClassName(),
            'title' => $this->texts['title'] ?? Enlighten::generateTitleFromClassName($this->getClassName()),
            'description' => $this->texts['description'] ?? null,
            'area' => Enlighten::getAreaSlug($this->getClassName()),
            'slug' => Enlighten::generateSlugFromClassName($this->getClassName())
        ]);
    }
}
