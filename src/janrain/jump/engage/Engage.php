<?php
namespace janrain\jump\engage;

use janrain\jump\AbstractFeature;

class Engage extends AbstractFeature
{
    protected $config;

    public function __construct(EngageConfig $c)
    {
        $this->config = $c;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadJsSrcs()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getStartHeadJs()
    {
        $out = "opts.packages.push('login');\n";
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsHeadJs()
    {
        if (in_array('Capture', $this->config['features'])) {
            return '';
        }
        $opts = array(
            "opts.tokenUrl = opts.plex.jumpUrl;",
            "opts.appId = '{$this->config['appId']}';",
            "opts.plex.loadJsUrl = '{$this->config['loadJsUrl']}';",
            "opts.appUrl = '{$this->config['appUrl']}';",
            "opts.noReturnExperience = true;",
            );
        return implode("\n", $opts) . "\n";
    }

    /**
     * {@inheritdoc}
     */
    public function getEndHeadJs()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getCssHrefs()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getCss()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml()
    {
        return "<a class='janrainEngage' href='#'>Sign-In</a>";
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 10;
    }
}
