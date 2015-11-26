<?php

namespace MainApp\Pages\Entities;

use System\AppLauncher\Admin\ExtendsClass\BaseApp;

class Page
{
    protected $id;
    protected $pageName;
    protected $pageUrl;
    protected $pageDescription;
    protected $pageKeywords;
    protected $pageStructJson;
    protected $views;
    protected $disabled;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of pageName.
     *
     * @return mixed
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Sets the value of pageName.
     *
     * @param mixed $pageName the page name
     *
     * @return self
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Gets the value of pageUrl.
     *
     * @return mixed
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Sets the value of pageUrl.
     *
     * @param mixed $pageUrl the page url
     *
     * @return self
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * Gets the value of pageDescription.
     *
     * @return mixed
     */
    public function getPageDescription()
    {
        return $this->pageDescription;
    }

    /**
     * Sets the value of pageDescription.
     *
     * @param mixed $pageDescription the page description
     *
     * @return self
     */
    public function setPageDescription($pageDescription)
    {
        $this->pageDescription = $pageDescription;

        return $this;
    }

    /**
     * Gets the value of pageKeywords.
     *
     * @return mixed
     */
    public function getPageKeywords()
    {
        return $this->pageKeywords;
    }

    /**
     * Sets the value of pageKeywords.
     *
     * @param mixed $pageKeywords the page keywords
     *
     * @return self
     */
    public function setPageKeywords($pageKeywords)
    {
        $this->pageKeywords = $pageKeywords;

        return $this;
    }

    /**
     * Gets the value of pageStructJson.
     *
     * @return mixed
     */
    public function getPageStructJson()
    {
        return $this->pageStructJson;
    }

    /**
     * Sets the value of pageStructJson.
     *
     * @param mixed $pageStructJson the page struct json
     *
     * @return self
     */
    public function setPageStructJson($pageStructJson)
    {
        $this->pageStructJson = $pageStructJson;

        return $this;
    }

    /**
     * Gets the value of views.
     *
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Sets the value of views.
     *
     * @param mixed $views the views
     *
     * @return self
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Gets the value of disabled.
     *
     * @return mixed
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Sets the value of disabled.
     *
     * @param mixed $disabled the disabled
     *
     * @return self
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }
}