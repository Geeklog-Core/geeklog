<?php

/**
 * Class Template
 */
class MicroTemplate
{
    const DEFAULT_FILE_EXTENSION = '.thtml';

    /**
     * @var string
     */
    private $root;

    /**
     * @var string
     */
    private $encoding = 'utf-8';

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $data = array();

    /**
     * Render content quickly
     *
     * @param  string $root
     * @param  string $template
     * @param  array  $env
     * @return string
     */
    public static function quick($root, $template, array $env = array())
    {
        $T = new self($root);
        $T->set($env);
        ob_start();
        $T->display($template);

        return ob_get_clean();
    }

    /**
     * MicroTemplate constructor.
     *
     * @param string $root
     */
    public function __construct($root)
    {
        $this->root = rtrim($root, '/\\') . DIRECTORY_SEPARATOR;

        if (!file_exists($this->root) || !is_dir($this->root)) {
            throw new InvalidArgumentException('Unknown directory');
        }
    }

    /**
     * Set character set encoding
     *
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Parse a template var name
     *
     * @param  string $s
     * @return string
     */
    private function parseVarName($s)
    {
        $parts = explode('.', $s);
        $retval = '$' . array_shift($parts);

        while (($part = array_shift($parts)) !== null) {
            if (preg_match('/^[0-9]+$/', $part)) {
                $retval .= '[' . $part . ']';
            } else {
                $retval .= '[\'' . $part . '\']';
            }
        }

        return $retval;
    }

    /**
     * Evaluate the content of a template
     */
    private function evaluate()
    {
        extract($this->data, EXTR_SKIP);
        eval('?>' . $this->content);
    }

    /**
     * Parse the template
     */
    private function parse()
    {
        // Replace statements
        $pattern = '/\{%\s*([a-zA-Z_]+)\s*(.*?)\s%\}/';

        while (preg_match($pattern, $this->content, $m)) {
            switch (strtolower($m[1])) {
                case 'for': // {% for $a in $array %}
                    $parts = explode(' ', $m[2], 3);
                    $replace = '<?php foreach (' . $this->parseVarName($parts[2])
                        . ' as ' . $this->parseVarName($parts[0]) . '): ?>';
                    break;

                case 'endfor':
                    $replace = '<?php endforeach; ?>';
                    break;

                case 'include':
                    $replace = @file_get_contents($this->root . trim($m[2]));
                    break;

                case 'if':
                    $replace = '<?php if (' . $this->parseVarName($m[2]) . '): ?>';
                    break;

                case 'else':
                    $replace = '<?php else: ?>';
                    break;

                case 'elseif':
                    $replace = '<?php elseif (' . $this->parseVarName($m[2]) . '): ?>';
                    break;

                case 'endif':
                    $replace = '<?php endif; ?>';
                    break;

                default:
                    $replace = '<!-- Error ' . $m[1] . ' ' . @$m[2] . ' -->';
                    break;
            }

            $this->content = str_replace($m[0], $replace, $this->content);
        }

        // Replace vars which don't need to be escaped {{ var_name }}
        $pattern = '/\{\{\s*([a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z0-9_]+)*)\s*\}\}/';

        if (preg_match_all($pattern, $this->content, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                $this->content = str_replace(
                    $m[0],
                    '<?php echo ' . $this->parseVarName($m[1]) . '; ?>',
                    $this->content
                );
            }
        }

        // Replace vars which need to be escaped {! var_name !}
        $pattern = '/\{!\s*([a-zA-Z_][a-zA-Z0-9_]*(\.[a-zA-Z0-9_]+)*)\s*!\}/';

        if (preg_match_all($pattern, $this->content, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                $this->content = str_replace(
                    $m[0],
                    '<?php echo $this->esc(' . $this->parseVarName($m[1]) . '); ?>',
                    $this->content
                );
            }
        }
    }

    /**
     * Append file extension if necessary
     *
     * @param  string $fileName
     * @return string
     */
    private function fixFileExtension($fileName)
    {
        $parts = pathinfo($fileName);

        if (!isset($parts['extension'])) {
            $fileName .= self::DEFAULT_FILE_EXTENSION;
        }

        return $fileName;
    }

    /**
     * Display content with the template file given
     *
     * @param  string $templateFile
     */
    public function display($templateFile)
    {
        $templateFile = $this->fixFileExtension($templateFile);
        $this->content = @file_get_contents($this->root . $templateFile);
        $this->parse();
        header('Content-Type: text/html; charset=' . $this->encoding);
        $this->evaluate();
    }

    /**
     * Escape a string so it can safely be displayed
     *
     * @param  array|string $value
     * @return array|string
     */
    public function esc($value)
    {
        return is_array($value)
            ? array_map(array($this, __FUNCTION__), $value)
            : htmlspecialchars($value, ENT_QUOTES, $this->encoding);
    }

    /**
     * Set a template variable / variables
     *
     * @param string|array $name
     * @param mixed|null   $value
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->data[$k] = $v;
            }
        } else {
            $this->data[$name] = $value;
        }
    }
}
