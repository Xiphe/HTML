<?php

namespace Xiphe\HTML\demo;

class TestCase
{
    public $name;
    public $section;
    public $tags;
    public $description;
    public $code;
    public $prediction;

    private $_tested = false;
    private $_result;
    private $_success;
    private $_runtime;
    private $_runtimes = array();
    private $_error = false;

    public function __construct($initArgs)
    {
        foreach ($initArgs as $k => $v) {
            $this->$k = $v;
        }
        $this->tags = preg_split('/(,)+( )?/', $this->tags);

        $this->ID = preg_replace('/[^a-z0-9_-]/', '', strtolower("test_{$this->section}_{$this->name}"));
        @session_start();

        $this->prediction = preg_replace('/\r\n|\r/', "\n", $this->prediction);

        if (isset($_SESSION['Xiphe\HTML\demo\tests\\'.$this->section.'_'.$this->name.'::runtimes'])) {
            $this->_runtimes = $_SESSION['Xiphe\HTML\demo\tests\\'.$this->section.'_'.$this->name.'::runtimes'];
        }
    }

    public function test()
    {
        if ($this->_tested == false) {
            global $DemoHTML;
            $HTML = clone $DemoHTML;

            global $test;
            $test = true;

            ob_start();
            $s_mt = explode(" ",microtime());

            try {
                eval($this->code);
            } catch (\Exception $e) {
                $error = $e;
            }

            $e_mt = explode(" ",microtime());
            $this->_runtime = (($e_mt[1] + $e_mt[0]) - ($s_mt[1] + $s_mt[0]))*1000;

            $this->_result = preg_replace('/\r\n|\r/', "\n", ob_get_clean());

            if (isset($error)) {
                $this->_error = $error;
            }

            if (!$this->_error && $this->_result == $this->prediction) {
                $this->_success = 'successfull';
            } elseif ($this->_error) {
                $this->_success = 'error';
            } else {
                $this->_success = 'failed';
            }

            unset($HTML);
            $this->_tested = true;
        }
    }

    public function wasSuccessfull()
    {
        $this->test();

        return ($this->_success == 'successfull');
    }

    public function get_result()
    {
        $this->test();

        return $this->_result;
    }

    public function __tostring()
    {
        global $HTML;
        $this->test();

        $HTML->s_div('#'.$this->ID.'|.test test_'.$this->_success)
            ->h3($this->name, '.toggle')
            ->span(sprintf(
                'Section: %s | Tags: %s | Completed in: %sms',
                $this->section,
                implode(', ', $this->tags),
                $this->round($this->_runtime)
            ), '.info toggle');
            $this->avarageRuntime();
            $HTML->s_div('.collapsable')
            ->m_div($this->description, 'description')
            ->p('Code', '.label')
            ->pre(htmlentities($this->code), '.code sh_php');
            if ($this->_error) {
                $HTML->p('Error', '.label')
                ->p(sprintf(
                    'Exception: %s | File: %s | Line: %s',
                    $this->_error->getMessage(),
                    $this->_error->getFile(),
                    $this->_error->getLine()
                ), '.error');
            }
            $this->diff();
            $HTML->p(sprintf('Result (%s Chars)', strlen($this->_result)), '.label')
            ->pre(htmlentities($this->_result), '.result sh_html');
            if (!$this->wasSuccessfull()) {
                $HTML->p(sprintf('Prediction (%s Chars)', strlen($this->prediction)), '.label')
                ->pre(htmlentities($this->prediction), '.prediction sh_html');
            }
            $HTML->end(2);

        return '';
    }

    public function diff()
    {
        $this->test();
        if ($this->wasSuccessfull()) {
            return;
        }

        global $HTML;
        $HTML->p('Diff', '.label');

        $a = explode("\n", $this->prediction);
        $b = explode("\n", $this->_result);

        $options = array(
            //'ignoreWhitespace' => true,
            //'ignoreCase' => true,
        );

        // Initialize the diff class
        $diff = new \Diff($a, $b, $options);

        $renderer = new \Diff_Renderer_Html_Inline;
        echo $diff->render($renderer);
    }

    public function round($f)
    {
        return round($f*10000000)/10000000;
    }

    public function avarageRuntime()
    {
        if (count($this->_runtimes) <= 1) {
            return;
        }

        $runtime = 0;
        foreach ($this->_runtimes as $rt) {
            $runtime += $rt;
        }

        $runtime /= count($this->_runtimes);

        global $HTML;
        $HTML->span(
            sprintf('Avarage runtime of %sms in the last %s calls', $this->round($runtime), count($this->_runtimes)),
            '.info toggle'
        );

    }

    public function __get($key)
    {
        $key = '_'.$key;
        $this->test();
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

    public function __destruct()
    {
        while (count($this->_runtimes) >= 20) {
            reset($this->_runtimes);
            unset($this->_runtimes[key($this->_runtimes)]);
        }
        $this->_runtimes[] = $this->_runtime;
        $_SESSION['Xiphe\HTML\demo\tests\\'.$this->section.'_'.$this->name.'::runtimes'] = $this->_runtimes;
    }
}
