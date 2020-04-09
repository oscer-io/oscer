<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

trait HasRules
{
    protected array $rules = [];

    protected array $rulesOnCreate = [];

    protected array $rulesOnUpdate = [];

    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function rulesOnCreate(array $rules)
    {
        $this->rulesOnCreate = $rules;

        return $this;
    }

    public function rulesOnUpdate(array $rules)
    {
        $this->rulesOnUpdate = $rules;

        return $this;
    }

    public function getRules(bool $forCreate): array
    {
        if ($forCreate === true && ! empty($this->rulesOnCreate)) {
            return $this->rulesOnCreate;
        }
        if ($forCreate === false && ! empty($this->rulesOnUpdate)) {
            return $this->rulesOnUpdate;
        }

        return $this->rules;
    }
}
