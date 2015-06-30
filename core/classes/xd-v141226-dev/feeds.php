<?php
/**
 * Feeds.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Feeds.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class feeds extends framework
	{
		/**
		 * Gets RSS/ATOM feed items (with feed type auto-detection).
		 *
		 * @param string  $url A remote feed URL (to retrieve items from).
		 *
		 * @param integer $max_items Maximum items to return (when/if available).
		 *    Note that ALL feed items are cached, but we only return up to `$max_items` (when/if available).
		 *
		 * @param integer $cache_expiration We automatically cache ALL items, for faster access on repeat calls.
		 *    Feed items are cached for 12 hours by default, but this can be overridden here.
		 *
		 * @return array Array of feed items, else an empty array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$url`, `$max_items`, or `$cache_expiration` are empty.
		 *
		 * @see http://www.sitepoint.com/parsing-xml-with-simplexml/
		 */
		public function items($url, $max_items = 3, $cache_expiration = 43200)
		{
			$this->check_arg_types('string:!empty', 'integer:!empty', 'integer:!empty', func_get_args());

			// First check cache for feed items we've already parsed before.
			if(is_array($feed_items = $this->©db_utils->get_transient(($transient = md5($url.'_feed_items')))))
				return array_slice($feed_items, 0, abs($max_items));

			$feed_items = array(); // Initialize.

			// Get remote XML feed data (if possible).
			$xml = $this->©url->remote($url, NULL, array('return_xml_object' => TRUE));

			// Is this an RSS feed? If so, parse each `item`.
			if($xml && isset($xml->channel->item) && $xml->channel->item instanceof \SimpleXMLElement)
			{
				$xmlns = $xml->getNamespaces(TRUE); // XML namespaces.
				foreach($xml->channel->item as $_item/** @var $_item \SimpleXMLElement */)
					if($this->©objects->are_not_ass_empty($_item->link, $_item->title, $_item->pubDate))
					{
						if(isset($xmlns['dc']))
							$_item_dc = $_item->children($xmlns['dc']);
						else $_item_dc = NULL;

						$feed_items[] = array(
							'link'     => (string)$_item->link,
							'title'    => (string)$_item->title,
							'time'     => strtotime((string)$_item->pubDate),
							'category' => (($this->©object->is_not_ass_empty($_item->category)) ? (string)$_item->category : ''),
							'content'  => (($this->©object->is_not_ass_empty($_item->description)) ? (string)$_item->description : ''),
							'excerpt'  => (($this->©object->is_not_ass_empty($_item->description)) ? strip_tags((string)$_item->description) : ''),
							'author'   => (($_item_dc && $this->©object->is_not_ass_empty($_item_dc->creator)) ? (string)$_item_dc->creator : '')
						);
					}
				unset($_item, $_item_dc); // A little housekeeping.

				$this->©db_utils->set_transient($transient, $feed_items, abs($cache_expiration)); // Cache feed items.
			}
			// Is this an ATOM feed? If so, parse each `entry`.
			else if($xml && isset($xml->entry) && $xml->entry instanceof \SimpleXMLElement)
			{
				$xmlns = $xml->getNamespaces(TRUE); // XML namespaces.
				foreach($xml->entry as $_entry/** @var $_entry \SimpleXMLElement */)
					if($this->©objects->are_not_ass_empty($_entry->link, $_entry->title, $_entry->updated)
					   && ($_entry_link = $this->atom_link($_entry->link, 'alternate'))
					) // Entry links are parsed via `$this->atom_link()`.
					{
						if(isset($xmlns['dc']))
							$_entry_dc = $_entry->children($xmlns['dc']);
						else $_entry_dc = NULL;

						$feed_items[] = array(
							'link'     => (string)$_entry_link,
							'title'    => (string)$_entry->title,
							'time'     => strtotime((string)$_entry->updated),
							'category' => (($this->©object->is_not_ass_empty($_entry->category)) ? (string)$_entry->category : ''),
							'content'  => (($this->©object->is_not_ass_empty($_entry->content)) ? (string)$_entry->content
								: (($this->©object->is_not_ass_empty($_entry->summary)) ? (string)$_entry->summary : '')),
							'excerpt'  => (($this->©object->is_not_ass_empty($_entry->summary)) ? strip_tags((string)$_entry->summary)
								: (($this->©object->is_not_ass_empty($_entry->content)) ? strip_tags((string)$_entry->content) : '')),
							'author'   => (($_entry_dc && $this->©object->is_not_ass_empty($_entry_dc->creator)) ? (string)$_entry_dc->creator : '')
						);
					}
				unset($_entry, $_entry_dc, $_entry_link); // A little housekeeping.

				$this->©db_utils->set_transient($transient, $feed_items, abs($cache_expiration)); // Cache feed items.
			}
			return array_slice($feed_items, 0, abs($max_items));
		}

		/**
		 * Gets an ATOM feed entry link.
		 *
		 * @param \SimpleXMLElement[] $link An iteration of SimpleXMLElement object instances.
		 *
		 * @param string              $rel The link `rel` type attribute that we're looking for.
		 *
		 * @return string The first link `href` attribute value, matching `$rel` type.
		 *    Else an empty string on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function atom_link($link, $rel = 'alternate')
		{
			$this->check_arg_types('\\SimpleXMLElement', 'string:!empty', func_get_args());

			foreach($link as $_link) // Search/iterate each link element.
			{
				if(($_rel = $this->©xml->attribute($_link, 'rel')) && ($_href = $this->©xml->attribute($_link, 'href')))
					if(strcasecmp($_rel, $rel) === 0) // The link `rel` we're looking for?
						return $_href; // Return link `href` value.
			}
			unset($_link, $_rel, $_href); // Housekeeping.

			return ''; // Default return value.
		}
	}
}