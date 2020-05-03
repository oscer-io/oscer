<?php

namespace Oscer\Cms\Frontend\Contracts;

interface Theme
{
    /**
     * Declare which menus are available and which templates these use.
     * [
     *  'main_menu' => [
     *      'template' => 'cms:menus.main'
     *  ]
     * ].
     */
    public function getMenus(): array;

    /**
     * Declare which template will be used for the front page.
     */
    public function getFrontPageTemplate(): string;

    /**
     * Declare which template will be used for pages.
     */
    public function getPageTemplate(): string;

    /**
     * Declare which template will be used for the post index page.
     */
    public function getPostIndexTemplate(): string;

    /**
     * Declare which template will be used for a single post page.
     */
    public function getPostShowTemplate(): string;

    /**
     * Declare which additional theme options should be available in the system.
     */
    public function getOptions(): array;
}
