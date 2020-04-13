<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;


class SelectField extends Field
{
    public string $component = 'SelectField';

    public array $options = [];

    public bool $filterable = false;

    public bool $searchable = false;

    public bool $multiple = false;

    public string $placeholder = '';

    protected array $with = ['options', 'filterable', 'searchable', 'multiple', 'placeholder'];
    /**
     * @var string
     */

    /**
     * Each option must have a 'name', a 'label' and a 'value' like this
     * ['name' => 'foo', 'label' => 'bar', 'value' => 'baz'],
     */
    public function options(array $options)
    {
        $this->options = $this->filterOptions($options);

        return $this;
    }

    /**
     * Filter an array of options to provide consistent data. Therefore
     * remove data that does not provide at least a 'name' and
     * fill 'label' & 'value' with 'name' if they aren't
     * set neither.
     */
    protected function filterOptions(array $options)
    {
        $data = [];
        foreach ($options as $option) {
            if ($name = $option['name'] ?? '') {
                $data[] = [
                    'name' => $name,
                    'label' => $option['label'] ?? $name,
                    'value' => $option['value'] ?? $name
                ];
            }
        }

        return $data;
    }

    public function searchable(){
        $this->searchable = true;

        return $this;
    }

    public function filterable(){
        $this->filterable = true;

        return $this;
    }

    public function multiple() {
        $this->multiple = true;

        return $this;
    }

    /**
     * Set a custom placeholder
     */
    public function placeholder(string $placeholder) {
        $this->placeholder = $placeholder;

        return $this;
    }

}
