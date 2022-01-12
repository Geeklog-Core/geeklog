<?php

namespace Geeklog;

class HtmlDocument
{
    // Document types
    const DOC_TYPES = [
        'html401transitional' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
        'html401strict'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
        'xhtml10transitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        'xhtml10strict'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
        'html5'               => '<!DOCTYPE html>',
        'xhtml5'              => '<!DOCTYPE html>',
        'fallback'            => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">',
    ];

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * @var array
     */
    private $responseHeaders = [];

    /**
     * @var string
     */
    private $docType = 'html5';

    /**
     * @var array
     */
    private $templateFiles = [];

    /**
     * @var bool
     */
    private $headersSent = false;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $information;

    /**
     * @var string
     */
    private $renderedDocument = '';

    /**
     * HtmlDocument constructor
     *
     * @param  string  $content
     * @param  array   $information
     */
    public function __construct($content, array $information = [])
    {
        global $_CONF;

        $this->content = $content;
        $this->information = $information;

        // Add HTML response headers
        $this->addResponseHeader('Content-Type: text/html; charset=' . COM_getCharset())
            ->addResponseHeader('X-XSS-Protection: 1; mode=block')
            ->addResponseHeader('X-Content-Type-Options: nosniff');

        if (!empty($_CONF['frame_options'])) {
            $this->addResponseHeader('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
        }
    }

    /**
     * Add an HTTP response header
     *
     * @param  string  $header
     * @return HtmlDocument
     */
    public function addResponseHeader($header)
    {
        $this->responseHeaders[] = $header;

        return $this;
    }

    /**
     * @param  array  $templateFiles
     */
    public function setTemplateFiles(array $templateFiles)
    {
        $this->templateFiles = $templateFiles;
    }

    /**
     * Render the document
     *
     * @return string
     */
    public function render()
    {
        $retval = '';




        return $retval;
    }

    /**
     * Return the rendered document
     *
     * @return string
     */
    public function __toString()
    {
        if (empty($this->renderedDocument)) {
            $this->renderedDocument = $this->render();
        }

        return $this->renderedDocument;
    }

    /**
     * Send HTTP response headers
     *
     * @return HtmlDocument
     */
    public function sendHttpResponseHeaders()
    {
        if (!$this->headersSent) {
            foreach ($this->responseHeaders as $header) {
                header($header);
            }

            $this->headersSent = true;
        }

        return $this;
    }

    /**
     * Display the rendered document
     *
     * @return void
     */
    public function display()
    {
        $this->sendHttpResponseHeaders();
        echo $this->__toString();
    }
}
