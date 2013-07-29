<?php
namespace janrain\jump;

/**
 * The feature stack.  Essentially a priority queue, to define the set of features that are
 * active at any time.  Iterable and countable. Uses feature->getPriority to set stack order
 * non-destructive, however, only one of each feature type can exist at a time so adding a
 * second feature of the same class-type overwrites the previous feature for that name.
 */
class FeatureStack implements \IteratorAggregate, \Countable
{
    protected $names;
    protected $features;

    /**
     * Create a new FeatureStack
     */
    public function __construct()
    {
        $this->names = array();
        $this->features = new \ArrayObject();
    }

    /**
     * Add a feature to the stack.
     *
     * @param AbstractFeature
     *   The feature to add to the stack.  Will overwrite previously added features of the same name.
     */
    public function pushFeature(AbstractFeature $f)
    {
        $this->features[$f->getPriority()] = $f;
        $this->names[$f->getName()] = $f;
    }

    /**
     * Get a feature by it's short name.  For example, to get the Engage feature use $stack->getFeature('Engage')
     * as opposed to $stack->getFeature('janrain\plex\engage\Engage').  This is mostly use for easy access to widgets.
     * i.e. $widgetMarkup = $stack->getFeature('Engage')->getHtml();
     *
     * @param string $name
     *   The short classname of the feature you wish to grab.
     *
     * @return AbstractFeature|null
     *   The feature mapped to this shortname. Or null if the feature does not exist
     */
    public function getFeature($name)
    {
        if (isset($this->names[$name])) {
            return $this->names[$name];
        }
        return null;
    }

    /**
     * implements \IteratorAggregate
     */
    public function getIterator()
    {
        $this->features->ksort();
        return $this->features->getIterator();
    }

    /**
     * implements \Countable
     */
    public function count()
    {
        return count($this->features);
    }
}
