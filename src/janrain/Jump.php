<?php
namespace janrain;

use janrain\jump\Renderable;

final class Jump implements Renderable
{
    private $features;

    private $api;

    /**
     * Convenience method to render the entire header content in one big batch.
     */
    public function raw_render()
    {
        $out = "<!-- START Janrain JUMP -->\n";
        foreach ($this->getCssHrefs() as $href) {
            $out .= "<link type='text/css' rel='stylesheet' href='{$href}'/>\n";
        }
        $out .= "<style type='text/css'>\n{$this->getCss()}\n</style>\n";
        foreach ($this->getHeadJsSrcs() as $src) {
            $out .= "<script type='text/javascript' src='{$src}'></script>\n";
        }
        $out .= "<script type='text/javascript'>
            //<![CDATA[
            {$this->getStartheadJs()}
            {$this->getSettingsHeadJs()}
            {$this->getEndHeadJs()}
            //]]>
            </script>
            <!-- END Janrain JUMP -->\n";
        return $out;
    }

    /**
     * Get the full FeatureStack for bulk operations or manual manipulation
     *
     * @return FeatureStack
     *   Returns the current feature stack
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Convenience method for getting a specific feature by short-name
     *
     * @param string
     *   The short class name of the target feature.
     */
    public function getFeature($shortName)
    {
        return $this->features->getFeature($shortName);
    }

    /**
     * Initialize this Jump object from configuration data.
     *
     * @param ArrayAccess
     *   An array accessible set of configuration data.  Likely janrain\plex\Config
     */
    public function init(\ArrayAccess $data)
    {
        #validate $data
        if (empty($data) || !isset($data['features'])) {
            throw new \InvalidArgumentException();
        }
        foreach ($data['features'] as $fName) {
            $fClass = '\\janrain\\jump\\' . strtolower($fName) . "\\$fName";
            $fConfig = jump\ConfigBuilder::build($fClass, $data);
            $feature = new $fClass($fConfig, $this->features);
            $this->features->pushFeature($feature);
        }
    }



    /**
     * {@inheritdoc}
     */
    public function getHeadJsSrcs()
    {
        $out = array();
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out = array_merge($out, $f->getHeadJsSrcs());
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartHeadJs() {
        $out = '';
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out .= $f->getStartheadJs();
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsHeadJs() {
        $out = '';
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out .= $f->getSettingsHeadJs();
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndHeadJs() {
        $out = '';
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out .= $f->getEndHeadJs();
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getCssHrefs() {
        $out = array();
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out = array_merge($out, $f->getCssHrefs());
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getCss() {
        $out = '';
        foreach ($this->features as $f) {
            if ($f instanceof Renderable) {
                $out .= $f->getCss();
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml() {
        return '';
    }


    /**
     * Get an instance of jump.  Best if followed up by init() as soon as possible.
     *
     * @return Jump
     *   Returns an uninitialized Jump instance
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private static $instance;
    private function __construct()
    {
        $this->features = new jump\FeatureStack();
    }
}
