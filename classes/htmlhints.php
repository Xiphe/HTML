<?php class HTML {
	
	/** echo a &lt;a&gt; tag - single attr = href
	 *
	 * If the a element has an href attribute, then it represents
	 * a hyperlink (a hypertext anchor).
	 * 
	 * If the a element has no href attribute, then the element
	 * represents a placeholder for where a link might otherwise
	 * have been placed, if it had been relevant.
	 * 
	 * The target, download, ping, rel, media, hreflang, and type
	 * attributes must be omitted if the href attribute is not
	 * present.
	 * 
	 * If the itemprop is specified on an a element, then the
	 * href attribute must also be specified.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function a($inner, $attrs) {
	}
	
	/** echo a &lt;abbr&gt; tag - single attr = title
	 *  
	 * The abbr element represents an abbreviation or acronym,
	 * optionally with its expansion. The title attribute may
	 * be used to provide an expansion of the abbreviation. The
	 * attribute, if specified, must contain an expansion of the
	 * abbreviation, and nothing else.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function abbr($inner, $attrs) {
	}
	
	/** echo a &lt;address&gt; tag - single attr = class
	 *  
	 * The address element represents the contact information for
	 * its nearest article or body element ancestor. If that is
	 * the body element, then the contact information applies to
	 * the document as a whole.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function address($inner, $attrs) {
	}
	
	
	
	
	
	/** builds a hidden input field
	 *
	 *  
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function hidden($inner, $attrs) {
	}
	
	
	
	
	/** echo a &lt;div&gt; tag
	 *
	 * The div element has no special meaning at all. It represents
	 * its children. It can be used with the class, lang, and title
	 * attributes to mark up semantics common to a group of
	 * consecutive elements.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function div($inner, $attrs) {
	}
	
	/** echo a &lt;span&gt; tag
	 *
	 * The span element doesn't mean anything on its own, but can
	 * be useful when used together with the global attributes, e.g.
	 * class, lang, or dir. It represents its children.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function span($inner, $attrs) {
	}
	
	/** echo a &lt;h1&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h1($inner, $attrs) {
	}
	
	/** echo a &lt;h2&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h2($inner, $attrs) {
	}
	
	/** echo a &lt;h3&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h3($inner, $attrs) {
	}
	
	/** echo a &lt;h4&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h4($inner, $attrs) {
	}
	
	/** echo a &lt;h5&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h5($inner, $attrs) {
	}
	
	/** echo a &lt;h6&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function h6($inner, $attrs) {
	}
	
	/** echo a &lt;p&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function p($inner, $attrs) {
	}
	
	/** echo a &lt;strong&gt; tag
	 *
	 * The strong element represents strong importance for its contents.
	 * 
	 * The relative level of importance of a piece of content is given
	 * by its number of ancestor strong elements; each strong element
	 * increases the importance of its contents.
	 * 
	 * Changing the importance of a piece of text with the strong element
	 * does not change the meaning of the sentence.
	 * 
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function strong($inner, $attrs) {
	}
	
	
	
	/** echo a &lt;h1&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function html($inner, $attrs) {
	}
	
	/** echo a &lt;head&gt; tag
	 *
	 * @param string $inner the inner content
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function head($inner, $attrs) {
	}
	
	
	
	
	/** echo a &lt;br /&gt; tag
	 *
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @access public
	 * @date Feb 14th 2012
	 */
	public function br($attrs) {
	}
	
	
	
	
} ?>