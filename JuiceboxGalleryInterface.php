<?php


/**
 * @file
 * Interface definition for a Juicebox gallery.
 */


/**
 * Interface definition for a Juicebox gallery.
 */
interface JuiceboxGalleryInterface {

  /**
   * Setter method for the gallery ID (in case it was not passed in
   * constructor).
   *
   * @param string $value
   *   The gallery id value to set.
   * @param boolean $reset
   *   Whether-or-not to reset the current value if it is already set.
   * @return boolean
   *   Returns TRUE on successful update and FALSE if update not performed.
   */
  public function setId($value, $reset = TRUE);

  /**
   * Getter method for the gallery ID.
   *
   * @return string
   *   Returns the id value set for the gallery.
   */
  public function getId();

  /**
   * Add a new image to the gallery.
   *
   * @param array $src_data
   *   Associative array containing all the source data for a gallery image,
   *   including the:
   *   - image_url: URL to the full image to display.
   *   - thumb_url: URL to the thumbnail to display for the image.
   *   - link_url: The Juicebox "link URL" value for the image.
   *   - link_target: The browser target value to use when following a link URL.
   * @param string $title
   *   The title markup to display for the image.
   * @param string $caption
   *   The caption markup to display for the image.
   * @param boolean $filter
   *   Optional. Whether-or-not to filter the $title and $caption values for
   *   syntactic compatibility with Juicebox.
   * @param int $override_id
   *   Optional. The id of an existing image, already added to the gallery, to
   *   override with new data. If NULL the image will simply be added. This id
   *   should match the index for the image as returned by getImages(). Not
   *   compatible with $offset.
   * @param int $offset
   *   Optional. If offset is positive then the image is inserted at that offset
   *   from the beginning of the existing image list. If offset is negative then
   *   the image is inserted that far from the end of the image list. Not
   *   compatible with $override_id.
   * @return boolean
   *   Returns TRUE on successful addition and FALSE on failure.
   */
  public function addImage($src_data = array(), $title = '', $caption = '', $filter = TRUE, $override_id = NULL, $offset = NULL);

  /**
   * Update an existing image in the gallery. This duplicates the functionality
   * of addImage() with an $override_id but is included as a separate method for
   * convienence.
   *
   * @param int $image_id
   *   The id of an existing image, already added to the gallery, to update
   *   with new data. This id should match the index for the image as returned
   *   by getImages().
   * @param array $src_data
   *   Associative array containing all the source data for a gallery image,
   *   including the:
   *   - image_url: URL to the full image to display.
   *   - thumb_url: URL to the thumbnail to display for the image.
   *   - link_url: The Juicebox "link URL" value for the image.
   *   - link_target: The browser target value to use when following a link URL.
   * @param string $title
   *   The title markup to display for the image.
   * @param string $caption
   *   The caption markup to display for the image.
   * @param boolean $filter
   *   Optional. Whether-or-not to filter the $title and $caption values for
   *   syntactic compatibility with Juicebox.
   *
   * @return boolean
   *   Returns TRUE on successful update and FALSE on failure.
   */
  public function updateImage($image_id, $src_data = array(), $title = '', $caption = '', $filter = TRUE);

  /**
   * Getter method for the gallery images.
   *
   * @return array
   *   Returns an array of images currently in the gallery.
   */
  public function getImages();

  /**
   * Remove an image from the gallery.
   *
   * @param int $id
   *   The id of an existing image that was already added to the gallery. This
   *   id should match the index for the image as returned by getImages().
   * @return boolean
   *   Returns TRUE on successful removal and FALSE on failure.
   */
  public function removeImage($id);

  /**
   * Add a new Juicebox configuration option to the gallery.
   *
   * @param string $option_name
   *   The option name/key to add.
   * @param string $option_value
   *   The option value to add.
   * @param boolean $override
   *   Whether-or-not to override any values that already exist for the passed
   *   name/key.
   * @return boolean
   *   Returns TRUE on successful addition and FALSE on failure.
   */
  public function addOption($option_name, $option_value, $override = TRUE);

  /**
   * Getter method for the gallery options.
   *
   * @return array
   *   Returns an array of options set on the gallery.
   */
  public function getOptions();

  /**
   * Remove an option from the gallery.
   *
   * @param string $option_name
   *   The name of an existing option that was already added to the gallery.
   *   This name should match the index for the option as returned by
   *   getOptions().
   * @return boolean
   *   Returns TRUE on successful removal and FALSE on failure.
   */
  public function removeOption($option_name);

  /**
   * Get a gallery checksum.
   *
   * @return string
   *   An md5 hash of the image and option data that can be used to validate
   *   the uniqueness of this gallery's data and settings.
   */
  public function getChecksum();

  /**
   * Get the XML for a Juicebox gallery once images and options have been
   * added.
   *
   * @param string $script_wrap_id
   *   If a value is passed the XML will be wrapped inside <script> tags with
   *   this id. If no value is passed, no <script> wrapper will be used and the
   *   raw XML will be returned. This is useful if the XML will be embedded
   *   inside normal HTML.
   * @return string
   *   Structured Juicebox XML describing a gallery. Note that no header data
   *   is set or returned here.
   */
  public function renderXml($script_wrap_id = NULL);

  /**
   * Get the embed code for a Juicebox gallery once images and options have been
   * added.
   *
   * @return string
   *   Embed code markup describing a gallery.
   */
  public function renderEmbed();

  /**
   * Get the javascript code for a Juicebox gallery once images and options have
   * been added.
   *
   * @param string $xml_url
   *   The URL to the Juicebox XML for this gallery.
   * @param boolean $add_script_tags
   *   Whether-or-not to add <script> tags to wrap the output.
   * @param boolean $jquery_defer
   *   Whether-or-not to defer the execution of the javascript until after the
   *   DOM is ready using jQuery(document).ready. This can be useful if the
   *   code will be included inline before the main Juicebox library. Requires
   *   that the jQuery library is already included.
   * @return string
   *   Javascript code describing a gallery.
   */
  public function renderJavascript($xml_url, $add_script_tags = FALSE, $jquery_defer = FALSE);

  /**
   * Get the variables needed to instantiate a new JS Juicebox. These values
   * can be used as direct constructor inputs for a new juicebox object.
   *
   * @param string $xml_url
   *   The URL to the Juicebox XML for this gallery.
   * @return array
   *   An associative array of properties that can be used as direct constructor
   *   inputs for a new JS Juicebox object.
   */
  public function getJavascriptVars($xml_url);

}
