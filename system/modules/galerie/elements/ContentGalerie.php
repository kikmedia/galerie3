<?php

/**
 * Galerie
 * Professional pictures galleries for the web and mobile devices.
 *
 * @author    Lionel Maccaud
 * @copyright Lionel Maccaud
 * @package   galerie
 * @license   MIT (http://lionel-m.mit-license.org/)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Galleria;

/**
 * Class ContentGalerie 
 *
 * @copyright  Lionel Maccaud 
 * @author     Lionel Maccaud
 * @package    Controller
 */
class ContentGalerie extends \ContentElement {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_galerie';

    public function generate() {

        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile() {

        $this->Template = new \FrontendTemplate('ce_galerie');
        $this->import('Database');
        $galleria = new Galleria();

        $galleria->getOptions($this->galerie, $this->Template);
        $galleria->getPictures($this->Database, $this->galerie, $this->Template, $this->imagesFolder, $this->sortBy, $this->size, $this->orderSRC);
        $galleria->getGalleriaTheme($this->galerie);

        // Use specific CSS and JS when the CTE is loaded
        if (TL_MODE == 'FE') {

            // From the extension - Galleria script
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/galerie/html/external/galleria/galleria-1.2.9.min.js';

            // Flickr Plugin
            if($galleria->isFlickrEnabled($this->galerie, $this->Template))
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/galerie/html/external/plugins/flickr/galleria.flickr.min.js';

            // History Plugin
            if($galleria->isHistoryEnabled($this->galerie))
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/galerie/html/external/plugins/history/galleria.history.min.js';

            // Picasa Plugin
            if($galleria->isPicasaEnabled($this->galerie, $this->Template))
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/galerie/html/external/plugins/picasa/galleria.picasa.min.js';
        }
    }
}
?>