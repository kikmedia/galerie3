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
 * Class Galleria
 *
 * @copyright  Lionel Maccaud
 * @author     Lionel Maccaud
 * @package    Controller
 */
class Galleria extends \Frontend {

    /**
     * Files object
     * @var \FilesModel
     */
    protected $objFiles;

    /**
     * Get gallery options and build JS function for the template
     *
     * @access public
     * @return null
     */
    public function getOptions($galerie, $template) {

        // Retrieve the current gallery options
        $objOptions = GalerieModel::findPublishedById($galerie, array('*'));

        if ($objOptions !== null) {

                $arrOptions = $objOptions->row();

            /* Standard options *
             ********************/

            $options = array();

            // type: Number or String
            if (is_numeric($arrOptions['width']) && $arrOptions['width'] > 0)
                $options[0] = 'width: ' . $arrOptions['width'];
            elseif(!is_numeric($arrOptions['width']) && $arrOptions['width'] != NULL)
                $options[0] = 'width: ' . "'" . $arrOptions['width'] . "'";

            // type: Number
            if($arrOptions['height'] > 0)
            $options[1] = 'height: ' . $arrOptions['height'];

            // type: String
            if($arrOptions['transition'] != NULL)
                $options[2] = 'transition: ' . "'" . $arrOptions['transition'] . "'";

            // type: String
            if($arrOptions['initialTransition'] != NULL)
                $options[3] = 'initialTransition: ' . "'" . $arrOptions['initialTransition'] . "'";

            // type: Boolean
            ($arrOptions['clicknext'] == '' ? $options[4] = 'clicknext: false' : $options[4] = 'clicknext: true');

            // type: Boolean
            ($arrOptions['showImagenav'] == '' ? $options[5] = 'showImagenav: false' : $options[5] = 'showImagenav: true');

            // type: Boolean
            ($arrOptions['showCounter'] == '' ? $options[6] = 'showCounter: false' : $options[6] = 'showCounter: true');

            // type: Boolean
            ($arrOptions['lightbox'] == '' ? $options[7] = 'lightbox: false' : $options[7] = 'lightbox: true');

            // type: String
            if ($arrOptions['lightbox'] == '1')
                $options[8] = 'overlayBackground: ' . "'#" . $arrOptions['overlayBackground'] . "'";

            // type: Number
            if ($arrOptions['lightbox'] == '1')
                $options[9] = 'overlayOpacity: ' . $arrOptions['overlayOpacity'];

            // type: Boolean or String
            if($arrOptions['imageCrop'] != NULL) {
                if (($arrOptions['imageCrop'] == 'false') || ($arrOptions['imageCrop'] == 'true'))
                    $options[10] = 'imageCrop: ' . $arrOptions['imageCrop'];
                else
                    $options[10] = 'imageCrop: ' . "'" . $arrOptions['imageCrop'] . "'";
            }

            // type: Number
            $options[11] = 'imageMargin: ' . $arrOptions['imageMargin'];

            // type: Boolean
            ($arrOptions['imagePan'] == '' ? $options[12] = 'imagePan: false' : $options[12] = 'imagePan: true');

            // type: Boolean or Number
            if ($arrOptions['autoplay'] == '1') {
                if(is_numeric($arrOptions['autoplayInterval']))
                    $options[13] = 'autoplay: ' . $arrOptions['autoplayInterval'];
            }

            // type: Boolean
            ($arrOptions['carousel'] == '' ? $options[14] = 'carousel: false' : $options[14] = 'carousel: true');

            // type: Number
            $options[16] = 'carouselSpeed: ' . $arrOptions['carouselSpeed'];

            // type: Number or String
            if (is_numeric($arrOptions['carouselSteps']))
                $options[17] = 'carouselSteps: ' . $arrOptions['carouselSteps'];
            else
                $options[17] = 'carouselSteps: ' . "'" . $arrOptions['carouselSteps'] ."'";

            // type: Number
            if ($arrOptions['lightbox'] == '1')
                $options[18] = 'lightboxFadeSpeed: ' . $arrOptions['lightboxFadeSpeed'];

            // type: Number
            if ($arrOptions['lightbox'] == '1')
                $options[19] = 'lightboxTransitionSpeed: ' . $arrOptions['lightboxTransitionSpeed'];

            // type: Boolean
            ($arrOptions['pauseOnInteraction'] == '' ? $options[20] = 'pauseOnInteraction: false' : $options[20] = 'pauseOnInteraction: true');

            // type: Number
            $options[21] = 'show: ' . $arrOptions['gShow'];

            // type: Boolean
            ($arrOptions['showInfo'] == '' ? $options[22] = 'showInfo: false' : $options[22] = 'showInfo: true');

            // type: Boolean or String
            if ($arrOptions['thumbnails'] != NULL) {
                if (($arrOptions['thumbnails'] == 'true') || ($arrOptions['thumbnails'] == 'false'))
                    $options[23] = 'thumbnails: ' . $arrOptions['thumbnails'];
                else
                    $options[23] = 'thumbnails: ' . "'" . $arrOptions['thumbnails'] . "'";
            }

            // type: Boolean or String
            if ($arrOptions['thumbCrop'] != NULL) {
                if (($arrOptions['thumbCrop'] == 'true') || ($arrOptions['thumbCrop'] == 'false'))
                    $options[24] = 'thumbCrop: ' . $arrOptions['thumbCrop'];
                else
                    $options[24] = 'thumbCrop: ' . "'" . $arrOptions['thumbCrop'] . "'";
            }

            // type: Number
            $options[25] = 'thumbMargin: ' . $arrOptions['thumbMargin'];

            // type: Boolean or String
            if ($arrOptions['thumbQuality'] != NULL) {
                if (($arrOptions['thumbQuality'] == 'true') || ($arrOptions['thumbQuality'] == 'false'))
                    $options[27] = 'thumbQuality: ' . $arrOptions['thumbQuality'];
                else
                    $options[27] = 'thumbQuality: ' . "'" . $arrOptions['thumbQuality'] . "'";
            }

            // type: Number
            // Only works if "image_pan" is set to true
            if ($arrOptions['imagePan'] == '1')
                $options[28] = 'imagePanSmoothness: ' . $arrOptions['imagePanSmoothness'];

            // type: String
            if ($arrOptions['easing'] != NULL)
                $options[29] = 'easing: ' . "'" . $arrOptions['easing'] . "'";

            // type: Number
            $options[30] = 'transitionSpeed: ' . $arrOptions['transitionSpeed'];

            // type: Boolean
            ($arrOptions['popupLinks'] == '' ? $options[31] = 'popupLinks: false' : $options[31] = 'popupLinks: true');

            // type: String or Number
            if (is_numeric($arrOptions['preload']))
                $options[32] = 'preload: ' . $arrOptions['preload'];
            else
                $options[32] = 'preload: ' . "'" . $arrOptions['preload'] . "'";

            // type: Function
            if ($arrOptions['extend'] != NULL)
                $options[33] = $arrOptions['extend'];

            // type: Boolean
            ($arrOptions['debug'] == '' ? $options[34] = 'debug: false' : $options[34] = 'debug: true');

            // type: Boolean
            ($arrOptions['queue'] == '' ? $options[35] = 'queue: false' : $options[35] = 'queue: true');

            // type: String
            if ($arrOptions['imagePosition'] != NULL)
                $options[36] = 'imagePosition: ' . "'" . $arrOptions['imagePosition'] . "'";

            // type: Number
            $options[38] = 'maxScaleRatio: ' . $arrOptions['maxScaleRatio'];

            // type: Boolean
            ($arrOptions['swipe'] == '' ? $options[39] = 'swipe: false' : $options[39] = 'swipe: true');

            // type: Boolean
            ($arrOptions['fullscreenDoubleTap'] == '' ? $options[40] = 'fullscreenDoubleTap: false' : $options[40] = 'fullscreenDoubleTap: true');

            // type: Boolean
            ($arrOptions['layerFollow'] == '' ? $options[41] = 'layerFollow: false' : $options[41] = 'layerFollow: true');

            // type: String
            $dummy = deserialize($arrOptions['dummy']);
            $objDummy = \FilesModel::findByPk($dummy);
            if ($arrOptions['dummy'] != NULL)
                $options[42] = 'dummy: ' . "'" . $objDummy->path . "'";

            // type: Number
            $options[43] = 'imageTimeout: ' . $arrOptions['imageTimeout'];

            // type: Boolean or String
            if ($arrOptions['fullscreenCrop'] != NULL) {
                if (($arrOptions['fullscreenCrop'] == 'false') || ($arrOptions['fullscreenCrop'] == 'true'))
                    $options[44] = 'fullscreenCrop: ' . $arrOptions['fullscreenCrop'];
                else
                    $options[44] = 'fullscreenCrop: ' . "'" . $arrOptions['fullscreenCrop'] . "'";
            }

            // type: String
            if ($arrOptions['fullscreenTransition'] != NULL)
                $options[45] = 'fullscreenTransition: ' . "'" . $arrOptions['fullscreenTransition'] . "'";

            // type: String
            if ($arrOptions['touchTransition'] != NULL)
                $options[46] = 'touchTransition: ' . "'" . $arrOptions['touchTransition'] . "'";

            // type: String or Array
            if ($arrOptions['dataSource'] != NULL)
                $options[47] = 'dataSource: ' . $arrOptions['dataSource'];

            // type: String
            if ($arrOptions['dataSelector'] != NULL)
                $options[48] = 'dataSelector: ' . $arrOptions['dataSelector'];

            // type: Boolean
            if ($arrOptions['keepSource'] == '' ? $options[49] = 'keepSource: false' : $options[49] = 'keepSource: true');

            // type: Function
            if ($arrOptions['dataConfig'] != NULL)
                $options[50] = $arrOptions['dataConfig'];

            // type: Boolean
            ($arrOptions['trueFullscreen'] == '' ? $options[51] = 'trueFullscreen: false' : $options[51] = 'trueFullscreen: true');

            // type: Boolean
            ($arrOptions['responsive'] == '' ? $options[52] = 'responsive: false' : $options[52] = 'responsive: true');

            // type: Number or Boolean
            if ($arrOptions['wait'] != NULL) {
                if (is_numeric($arrOptions['wait']))
                    $options[53] = 'wait: ' . $arrOptions['wait'];
                else
                    $options[53] = 'wait: ' . "'" . $arrOptions['wait'] . "'";
            }

            // type: Object
            if ($arrOptions['dailymotion'] != NULL)
                $options[54] = 'dailymotion: ' . $arrOptions['dailymotion'];

            // type: Object
            if ($arrOptions['vimeo'] != NULL)
                $options[55] = 'vimeo: ' . $arrOptions['vimeo'];

            // type: Object
            if ($arrOptions['youtube'] != NULL)
                $options[56] = 'youtube: ' . $arrOptions['youtube'];

            // type: Boolean or String
            if ($arrOptions['idleMode'] != NULL) {
                if (($arrOptions['idleMode'] == 'false') || ($arrOptions['idleMode'] == 'true'))
                    $options[57] = 'idleMode: ' . $arrOptions['idleMode'];
                else
                    $options[57] = 'idleMode: ' . "'" . $arrOptions['idleMode'] . "'";
            }

            // type: Number
            $options[58] = 'idleTime: ' . $arrOptions['idleTime'];

            // type: Number
            $options[59] = 'idleSpeed: ' . $arrOptions['idleSpeed'];

            // type: Boolean
            ($arrOptions['thumbDisplayOrder'] == '' ? $options[60] = 'thumbDisplayOrder: false' : $options[60] = 'thumbDisplayOrder: true');

            // type: Function or String
            if ($arrOptions['dataSort'] != NULL)
                $options[61] = $arrOptions['dataSort'];

            // type: Number
            if ($arrOptions['maxVideoSize'] == 0)
                $options[62] = 'maxVideoSize: ' . "'undefined'";
            else
                $options[62] = 'maxVideoSize: ' . $arrOptions['maxVideoSize'];

            // Reindex the array
            $options = array_values($options);
            $totalOptions = count($options);

            // Add commas
            for ($i = 0; $i < $totalOptions-1; $i++) {
                $options[$i] = $options[$i] . ",\n\t";
            }

            // Create the list of options as a String
            for ($i = 0; $i < $totalOptions; $i++) {
                $strOptions .= ($options[$i]);
            }

            // add the options in the template
            $template->options = $strOptions;

            // Add JSON if exist
            ($arrOptions['json'] != NULL ? ($template->json = $arrOptions['json']) : ($template->json = ""));

            /* Flickr options *
             ******************/

            // If the tested values ​​are not the default values, then it saves.
            $flickrOptions = array();

            if ($arrOptions['flickrOptMax'] != 30)
                $flickrOptions[0] = 'max: ' . $arrOptions['flickrOptMax'];

            if ($arrOptions['flickrOptImageSize'] != 'medium')
                $flickrOptions[1] = 'imageSize: ' . "'" . $arrOptions['flickrOptImageSize'] . "'";

            if ($arrOptions['flickrOptThumbSize'] != 'thumb')
                $flickrOptions[2] = 'thumbSize: ' . "'" . $arrOptions['flickrOptThumbSize'] . "'";

            if ($arrOptions['flickrOptSort'] != 'interestingness-desc')
                $flickrOptions[3] = 'sort: ' . "'" . $arrOptions['flickrOptSort'] . "'";

            if ($arrOptions['flickrOptDescription'] == '1')
                $flickrOptions[4] = 'description: true';

            // Reindex the array
            $flickrOptions = array_values($flickrOptions);
            $totalFlickrOptions = count($flickrOptions);

            // Add commas
            for ($i = 0; $i < $totalFlickrOptions-1; $i++) {
                $flickrOptions[$i] = $flickrOptions[$i] . ",\n";
            }


            /* Picasa options *
             ******************/

            // If the tested values ​​are not the default values, then it saves.
            $picasaOptions = array();

            if ($arrOptions['picasaOptMax'] != 30)
                $picasaOptions[0] = 'max: ' . $arrOptions['picasaOptMax'];

            if ($arrOptions['picasaOptImageSize'] != 'medium')
                $picasaOptions[1] = 'imageSize: ' . "'" . $arrOptions['picasaOptImageSize'] . "'";

            if ($arrOptions['picasaOptThumbSize'] != 'thumb')
                $picasaOptions[2] = 'thumbSize: ' . "'" . $arrOptions['picasaOptThumbSize'] . "'";

            // Reindex the array
            $picasaOptions = array_values($picasaOptions);
            $totalPicasaOptions = count($picasaOptions);

            // Add commas
            for ($i = 0; $i < $totalPicasaOptions-1; $i++) {
                $picasaOptions[$i] = $picasaOptions[$i] . ",\n";
            }
        }

        // Build Flickr JS function
        $flickrFunction = 'flickr: \''.$arrOptions['flickrMethods'].':'.$arrOptions['flickrMethodsValue'].'\'' . "\n";

        if (!empty($flickrOptions)) {
            $flickrFunction .= ",\n";
            $flickrFunction .= "flickrOptions: { \n";

            for ($i = 0; $i < $totalFlickrOptions; $i++) {
                $flickrFunction .= ($flickrOptions[$i]);
            }

            $flickrFunction .= ' }';
        }

        $template->flickrFunction = $flickrFunction;


        // Build Picasa JS function
        $picasaFunction = 'picasa: \''.$arrOptions['picasaMethods'].':'.$arrOptions['picasaMethodsValue'].'\'' . "\n";

        if (!empty($picasaOptions)) {
            $picasaFunction .= ",\n";
            $picasaFunction .= "picasaOptions: { \n";

            for ($i = 0; $i < $totalPicasaOptions; $i++) {
                $picasaFunction .= ($picasaOptions[$i]);
            }

            $picasaFunction .= ' }';
        }

        $template->picasaFunction = $picasaFunction;


        // Path of the JavaScript file for the function loadTheme() included in the template
        $theme = $this->getGalleriaTheme($galerie);

        if($arrOptions['minifiedJS'] != '1')
            $pathJS = $theme[0] . '/galleria' . '.' . $theme[1] . '.js';
        else
            $pathJS = $theme[0] . '/galleria' . '.' . $theme[1] . '.min.js';

        $template->pathJS = $pathJS;

        // Use alias and module ID for the ID container (id="{alias}-{moduleID}")
        $template->alias = $objOptions->alias;
        $template->moduleID = $galerie;
    }

    /**
     * Test if the Flickr plugin is enabled or not
     *
     * @access public
     * @return boolean
     */
    public function isFlickrEnabled($galerie, $template) {

        $objFlickr = GalerieModel::findPublishedById($galerie, array('flickr'));

        if ($objFlickr->flickr == NULL)
            $isFlickrEnabled = FALSE;
        else
            $isFlickrEnabled = TRUE;

        // Boolean : Does the Flickr plugin is enabled ?
        $template->flickr = $isFlickrEnabled;

        return $isFlickrEnabled;
    }

    /**
     * Test if the Picasa plugin is enabled or not
     *
     * @access public
     * @return boolean
     */
    public function isPicasaEnabled($galerie, $template) {

        $objPicasa = GalerieModel::findPublishedById($galerie, array('picasa'));

        if ($objPicasa->picasa == NULL)
            $isPicasaEnabled = FALSE;
        else
            $isPicasaEnabled = TRUE;

        // Boolean : Does the Picasa plugin is enabled ?
        $template->picasa = $isPicasaEnabled;

        return $isPicasaEnabled;
    }

    /**
     * Test if the History plugin is enabled or not
     *
     * @access public
     * @return boolean
     */
    public function isHistoryEnabled($galerie) {

        $objHistory = GalerieModel::findPublishedById($galerie, array('history'));

        if ($objHistory->history == NULL)
            $isHistoryEnabled = FALSE;
        else
            $isHistoryEnabled = TRUE;

        return $isHistoryEnabled;
    }

    /**
     * Get gallery images
     *
     * @access public
     * @return null
     */
    public function getPictures($database, $galerie, $template, $imagesFolder, $sortBy, $size, $orderSRC) {

        // Adds a group of images from a folder
        $imagesFolder = deserialize($imagesFolder);
        $objFiles = \FilesModel::findMultipleByIds($imagesFolder);

        $size = deserialize($size);

        global $objPage;
        $images = array();
        $auxDate = array();
        $auxId = array();

        if ($objFiles !== null) {

            // Get all images
            while ($objFiles->next())
            {
                // Continue if the files has been processed or does not exist
                if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
                {
                    continue;
                }

                // Single files
                if ($objFiles->type == 'file')
                {
                    $objFile = new \File($objFiles->path);

                    if (!$objFile->isGdImage)
                    {
                        continue;
                    }

                    $arrMeta = $this->getMetaData($objFiles->meta, $objPage->language);

                    // Use the file name as title if none is given
                    if ($arrMeta['title'] == '')
                    {
                        $arrMeta['title'] = specialchars(str_replace('_', ' ', preg_replace('/^[0-9]+_/', '', $objFile->filename)));
                    }

                    // Add the image
                    $images[$objFiles->path] = array
                    (
                        'id'           => $objFiles->id,
                        'name'         => $objFile->basename,
                        'imageSRC'     => (($size[0] == NULL && $size[1] == NULL) ? $objFiles->path : (\Image::get($this->urlEncode($objFiles->path), $size[0], $size[1], $size[2]))),
                        'thumbnailSRC' => \Image::get($this->urlEncode($objFiles->path), '100px', NULL, 'center_center'),
                        'title'        => $arrMeta['title'],
                        'imageUrl'     => $arrMeta['link'],
                        'alt'          => $arrMeta['caption']
                    );

                    $auxDate[] = $objFile->mtime;
                    $auxId[] = $objFiles->id;
                }

                // Folders
                else
                {
                    $objSubfiles = \FilesModel::findByPid($objFiles->id);

                    if ($objSubfiles === null)
                    {
                        continue;
                    }

                    while ($objSubfiles->next())
                    {
                        // Skip subfolders
                        if ($objSubfiles->type == 'folder')
                        {
                            continue;
                        }

                        $objFile = new \File($objSubfiles->path);

                        if (!$objFile->isGdImage)
                        {
                            continue;
                        }

                        $arrMeta = $this->getMetaData($objSubfiles->meta, $objPage->language);

                        // Use the file name as title if none is given
                        if ($arrMeta['title'] == '')
                        {
                            $arrMeta['title'] = specialchars(str_replace('_', ' ', preg_replace('/^[0-9]+_/', '', $objFile->filename)));
                        }

                        // Add the image
                        $images[$objSubfiles->path] = array
                        (
                            'id'           => $objSubfiles->id,
                            'name'         => $objFile->basename,
                            'imageSRC'     => (($size[0] == NULL && $size[1] == NULL) ? $objSubfiles->path : (\Image::get($this->urlEncode($objSubfiles->path), $size[0], $size[1], $size[2]))),
                            'thumbnailSRC' => \Image::get($this->urlEncode($objSubfiles->path), '100px', NULL, 'center_center'),
                            'title'        => $arrMeta['title'],
                            'imageUrl'     => $arrMeta['link'],
                            'alt'          => $arrMeta['caption']
                        );

                        $auxDate[] = $objFile->mtime;
                        $auxId[] = $objSubfiles->id;
                    }
                }
            }

            // Sort array
            switch ($sortBy)
            {
                default:
                case 'name_asc':
                        uksort($images, 'basename_natcasecmp');
                        break;

                case 'name_desc':
                        uksort($images, 'basename_natcasercmp');
                        break;

                case 'date_asc':
                        array_multisort($images, SORT_NUMERIC, $auxDate, SORT_ASC);
                        break;

                case 'date_desc':
                        array_multisort($images, SORT_NUMERIC, $auxDate, SORT_DESC);
                        break;

                case 'meta': // Backwards compatibility
                case 'custom':
                        if ($orderSRC != '')
                        {
                            // Turn the order string into an array and remove all values
                            $arrOrder = explode(',', $orderSRC);
                            $arrOrder = array_flip(array_map('intval', $arrOrder));
                            $arrOrder = array_map(function(){}, $arrOrder);

                            // Move the matching elements to their position in $arrOrder
                            foreach ($images as $k=>$v)
                            {
                                if (array_key_exists($v['id'], $arrOrder))
                                {
                                    $arrOrder[$v['id']] = $v;
                                    unset($images[$k]);
                                }
                            }

                            // Append the left-over images at the end
                            if (!empty($images))
                            {
                                $arrOrder = array_merge($arrOrder, array_values($images));
                            }

                            // Remove empty (unreplaced) entries
                            $images = array_filter($arrOrder);
                            unset($arrOrder);
                        }
                        break;

                case 'random':
                        shuffle($images);
                        break;
            }

            $images = array_values($images);
            $total = count($images);
        }
        else {
            $total = 0;
        }

        // Retrieve the current gallery images
        $objPictures = $database->prepare("SELECT * FROM tl_galerie_pictures WHERE pid=? AND published=1 ORDER BY sorting")
                ->execute($galerie);

        if ($objPictures->numRows > 0) {

            while ($objPictures->next()) {

                // Standard image
                $imgSize = deserialize($objPictures->size);
                $objImg = \FilesModel::findByPk($objPictures->singleSRC);
                $imageSRC = \Image::get($this->urlEncode($objImg->path), $imgSize[0], $imgSize[1], $imgSize[2]);

                // Fullscreen image
                $objFullscreenImgSRC = \FilesModel::findByPk($objPictures->fullscreenSingleSRC);

                // Thumbnails are created separately.
                $thumbSize = deserialize($objPictures->thumbSize);
                $objThumb = \FilesModel::findByPk($objPictures->thumbSRC);

                // Is there an alternative thumbnail ? If not, we create the thumbnail from the main image.
                ($objPictures->thumbSRC ? ($thumbnail = $objThumb->path) : ($thumbnail = $objImg->path));

                if($thumbSize[0] == NULL && $thumbSize[1] == NULL)
                    $thumbnailSRC = \Image::get($this->urlEncode($thumbnail), '100px', NULL, 'center_center');
                else
                    $thumbnailSRC = \Image::get($this->urlEncode($thumbnail), $thumbSize[0], $thumbSize[1], $thumbSize[2]);

                $arrPictures[$objPictures->id] = array(
                    'alt'                   => $objPictures->alt,
                    'title'                 => $objPictures->title,
                    'imageUrl'              => $objPictures->imageUrl,
                    'imageSRC'              => $imageSRC,
                    'thumbnailSRC'          => $thumbnailSRC,
                    'imageFullscreenSRC'    => $this->urlEncode($objFullscreenImgSRC->path),
                    'video'                 => self::urlVerification($objPictures->video),
                    'videoThumb'            => $objPictures->videoThumb,
                    'iframe'                => $objPictures->iframe,
                    'iframeThumb'           => $objPictures->iframeThumb,
                    'layer'                 => htmlentities($objPictures->layerHTML, ENT_COMPAT, 'UTF-8'),
                    'dataConfig'            => $objPictures->dataConfigHTML
                );
            }

            $pictures = array_values($arrPictures);

            // Add a group of images
            if($total > 0)
                $pictures = array_merge($pictures, $images);

            $template->pictures = $pictures;
        }
        else if($total > 0) {
            $template->pictures = $images;
        }
        else {
            $template->pictures = array();
            $template->noImages = $GLOBALS['TL_LANG']['MSC']['noImages'];
        }
    }

    /**
     * Return the URL and the name of the theme
     *
     * @access public
     * @return array
     */
    public function getGalleriaTheme($galerie) {

        $theme = array();

        $objThemesSRC = GalerieModel::findPublishedById($galerie, array('themesSRC'));

        $objThemes = \FilesModel::findByPk($objThemesSRC->themesSRC);

        // Retrieve the name of the theme
        $themeName = substr(strrchr($objThemes->path, '/'), 1);

        $theme[0] = $objThemes->path;
        $theme[1] = $themeName;
        
        /* Example of results with the default theme
         *
         * The path :
         * $theme[0] = files/galleria/themes/classic
         *
         * The name of the theme
         * $theme[1] = classic
         */
        return $theme;
    }

    /**
     * Check if there is the prefix "http://" and if not, add it.
     *
     * @access public
     * @param String
     * @return String
     */
    public static function urlVerification($url) {

        if(!empty($url)) {
            $urlPrefix = strpos($url, "http://");

            if($urlPrefix === false) {
                $url = "http://" . $url;
            }
            return $url;
        }
        else
            return '';
    }
}
?>