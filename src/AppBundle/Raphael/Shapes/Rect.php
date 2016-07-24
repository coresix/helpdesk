<?php

namespace AppBundle\Raphael\Shapes;


class Rect implements Shape
{
    /** @var  string */
    protected $canvasReference;

    protected $x = 0;
    protected $y = 0;
    protected $r = 0;
    protected $height = 0;
    protected $width = 0;
    protected $fill = '';
    protected $stroke = 'none';
    protected $strokeWidth = 0;

    /**
     * Rect constructor.
     * @param string $canvasReference
     */
    public function __construct($canvasReference)
    {
        $this->canvasReference = $canvasReference;
    }

    /**
     * @param $x
     * @param $y
     */
    public function setCoordinates($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $height
     * @param $width
     */
    public function setDimensions($height, $width)
    {
        $this->height = $height;
        $this->width  = $width;
    }

    /**
     * @param $radius
     */
    public function setRadius($radius)
    {
        $this->r = $radius;
    }

    /**
     * @param $fill
     * @param $stroke
     * @param $strokeWidth
     */
    public function setAttributes($fill, $stroke, $strokeWidth)
    {
        $this->fill = $fill;
        $this->stroke = $stroke;
        $this->strokeWidth = $strokeWidth;
    }

    /**
     * @return string
     */
    public function build()
    {
        $rect =  sprintf('rect(%d, %d, %s, %s)',
            $this->x,
            $this->y,
            $this->width,
            $this->height,
            $this->r
        );

        $attrs = sprintf('attr({fill: \'%s\', stroke: \'%s\', \'stroke-width\': %d})',
            $this->fill,
            $this->stroke,
            $this->strokeWidth
        );

        return sprintf('(%s.%s).%s; ',
            $this->canvasReference,
            $rect,
            $attrs
        );
    }
}