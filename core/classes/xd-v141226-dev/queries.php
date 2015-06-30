<?php
/**
 * Project: core-test
 * File: query_formater.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 21/12/2014
 * Time: 10:36 μμ
 * Since: TODO ${VERSION}
 * Copyright: 2014 Panagiotis Vagenas
 */

namespace xd_v141226_dev {

	if (!defined('WPINC')) {
		exit('Do NOT access this file directly: ' . basename(__FILE__));
	}

	/**
	 * Query Builder.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class queries extends framework {
		/**
		 * @var array
		 */
		protected $arguments = array();
		/**
		 * @var int use author id
		 */
		protected $author = 0;
		/**
		 * @var string use 'user_nicename' (NOT name)
		 */
		protected $author_name = '';
		/**
		 * @var array use author id (available with Version 3.7)
		 */
		protected $author__in = array();
		/**
		 * @var array use author id (available with Version 3.7)
		 */
		protected $author__not_in = array();
		/**
		 * @var int use category id
		 */
		protected $cat = 0;
		/**
		 * @var string use category slug (NOT name).
		 */
		protected $category_name = '';
		/**
		 * @var array use category ids
		 */
		protected $category__and = array();
		/**
		 * @var array use category ids
		 */
		protected $category__in = array();
		/**
		 * @var array use category ids
		 */
		protected $category__not_in = array();
		/**
		 * @var string use tag slug
		 */
		protected $tag = '';
		/**
		 * @var int use tag id
		 */
		protected $tag_id = 0;
		/**
		 * @var array use tag ids
		 */
		protected $tag__and = array();
		/**
		 * @var array use tag ids
		 */
		protected $tag__in = array();
		/**
		 * @var array use tag ids
		 */
		protected $tag__not_in = array();
		/**
		 * @var array use tag slugs
		 */
		protected $tag_slug__and = array();
		/**
		 * @var array use tag slugs
		 */
		protected $tag_slug__in = array();
		/**
		 * @var int use post id
		 */
		protected $p = 0;
		/**
		 * @var string use post slug
		 */
		protected $name = '';
		/**
		 * @var int use page id
		 */
		protected $page_id = 0;
		/**
		 * @var string use page slug
		 */
		protected $pagename = '';
		/**
		 * @var int use page id to return only child pages. Set to 0 to return only top-level entries
		 */
		protected $post_parent = 0;
		/**
		 * @var array use post ids. Specify posts whose parent is in an array. NOTE: Introduced in 3.6
		 */
		protected $post_parent__in = array();
		/**
		 * @var array use post ids. Specify posts whose parent is not in an array
		 */
		protected $post_parent__not_in = array();
		/**
		 * @var array use post ids.
		 * Specify posts to retrieve.
		 * ATTENTION If you use sticky posts, they will be included (prepended!) in the posts you
		 * retrieve whether you want it or not. To suppress this behaviour use ignore_sticky_posts.
		 */
		protected $post__in = array();
		/**
		 * @var array use post ids. Specify post NOT to retrieve
		 */
		protected $post__not_in = array();
		/**
		 * @var string|array use post types. Retrieves posts by Post Types, default value is 'post'.
		 * If 'tax_query' is set for a query, the default value becomes 'any'
		 */
		protected $post_type = '';
		/**
		 * @var array Custom post types are valid options too
		 */
		protected $_postTypeValidOptions = array( 'post', 'page', 'revision', 'attachment', 'nav_menu_item', 'any' );
		/**
		 * @var string|array use post status.
		 * Retrieves posts by Post Status. Default value is 'publish', but if the user is logged in, 'private' is added.
		 * And if the query is run in an admin context (administration area or AJAX call),
		 * protected statuses are added too. By default protected statuses are 'future', 'draft' and 'pending'.
		 */
		protected $post_status = '';
		/**
		 * @var array
		 */
		protected $_postStatusValidOptions = array(
			'publish',
			'pending',
			'draft',
			'auto-draft',
			'future',
			'private',
			'inherit',
			'trash',
			'any'
		);
		/**
		 * @var bool show all posts or use pagination. Default value is 'false', use paging
		 */
		protected $nopaging = false;
		/**
		 * @var int number of post to show per page (available with Version 2.1, replaced showposts parameter).
		 * Use 'posts_per_page'=>-1 to show all posts (the 'offset' parameter is ignored with a -1 value).
		 * Set the 'paged' parameter if pagination is off after using this parameter.
		 * Note: if the query is in a feed, wordpress overwrites this parameter with the stored 'posts_per_rss' option.
		 * To reimpose the limit, try using the 'post_limits' filter, or filter 'pre_option_posts_per_rss' and return -1
		 */
		protected $posts_per_page = 10;
		/**
		 * @var int number of posts to show per page - on archive pages only.
		 * Over-rides posts_per_page and showposts on pages where is_archive() or is_search() would be true.
		 */
		protected $posts_per_archive_page = 0;
		/**
		 * @var int number of post to displace or pass over. Warning: Setting the offset parameter overrides/ignores
		 * the paged parameter and breaks pagination.
		 * The 'offset' parameter is ignored when 'posts_per_page'=>-1 (show all posts) is used
		 */
		protected $offset;
		/**
		 * @var int
		 */
		protected $limit;
		/**
		 * @var int number of page. Show the posts that would normally show up just on page X when using the "Older Entries" link
		 */
		protected $paged = 0;
		/**
		 * @var int number of page for a static front page.
		 * Show the posts that would normally show up just on page X of a Static Front Page.
		 */
		protected $page = 0;
		/**
		 * @var bool ignore post stickiness (available with Version 3.1, replaced caller_get_posts parameter).
		 * false (default): move sticky posts to the start of the set. true: do not move sticky posts to the start of the set
		 */
		protected $ignore_sticky_posts = false;
		/**
		 * @var string|array Designates the ascending or descending order of the 'orderby' parameter.
		 * Defaults to 'DESC'. An array can be used for multiple order/orderby sets.
		 */
		protected $order = '';
		/**
		 * @var array
		 */
		protected $_orderValidOptions = array( 'ASC', 'DESC' );
		/**
		 * @var string|array Sort retrieved posts by parameter. Defaults to 'date (post_date)'.
		 * One or more options can be passed
		 */
		protected $orderby = '';
		/**
		 * @var array
		 */
		protected $_orderbyValidOptions = array(
			'none',
			'ID',
			'author',
			'title',
			'type',
			'date',
			'modified',
			'parent',
			'rand',
			'comment_count',
			'menu_order',
			'meta_value',
			'meta_value_num',
			'post__in'
		);
		/**
		 * @var int 4 digit year (e.g. 2011).
		 */
		protected $year = 0;
		/**
		 * @var int Month number (from 1 to 12)
		 */
		protected $monthnum = 0;
		/**
		 * @var int Week of the year (from 0 to 53). Uses MySQL WEEK command. The mode is dependent on the "start_of_week" option
		 */
		protected $w = null;
		/**
		 * @var int Day of the month (from 1 to 31).
		 */
		protected $day = 0;
		/**
		 * @var int Hour (from 0 to 23)
		 */
		protected $hour = null;
		/**
		 * @var int Minute (from 0 to 60).
		 */
		protected $minute = null;
		/**
		 * @var int Second (0 to 60).
		 */
		protected $second = null;
		/**
		 * @var int YearMonth (For e.g.: 201307)
		 */
		protected $m = 0;
		/**
		 * @var array Date parameters (available with Version 3.7)
		 */
		protected $date_query = array(
			'year'      => 0, //4 digit year (e.g. 2011)
			'month'     => 0, //Month number (from 1 to 12)
			'week'      => null, // Week of the year (from 0 to 53).
			'day'       => 0, // Day of the month (from 1 to 31)
			'hour'      => null, // Hour (from 0 to 23)
			'minute'    => null, // Minute (from 0 to 59)
			'second'    => null, // Second (0 to 59)
			'after'     => array( // (string/array) Date to retrieve posts after. Accepts strtotime()-compatible string, or array of 'year', 'month', 'day' values
				'year'  => '', // Accepts any four-digit year. Default is empty
				'month' => '', // The month of the year. Accepts numbers 1-12. Default: 12
				'day'   => '', // The day of the month. Accepts numbers 1-31. Default: last day of month
			),
			'before'    => array( // (string/array) - Date to retrieve posts before. Accepts strtotime()-compatible string, or array of 'year', 'month', 'day'
				'year'  => '',// Accepts any four-digit year. Default is empty
				'month' => '', // The month of the year. Accepts numbers 1-12. Default: 12
				'day'   => '', // The day of the month. Accepts numbers 1-31. Default: last day of month
			),
			'inclusive' => false,//For after/before, whether exact value should be matched or not
			'compare'   => '', //See WP_Date_Query::get_compare()
			'column'    => '', //Column to query against. Default: 'post_date'
			'relation'  => '',//OR or AND, how the sub-arrays should be compared. Default: AND
		);
		/**
		 * @var string Custom field key
		 */
		protected $meta_key = '';
		/**
		 * @var string Custom field value
		 */
		protected $meta_value = '';
		/**
		 * @var number Custom field value
		 */
		protected $meta_value_num = null;
		/**
		 * @var string Operator to test the 'meta_value'.
		 * Possible values are '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN',
		 * 'BETWEEN', 'NOT BETWEEN', 'NOT EXISTS', 'REGEXP', 'NOT REGEXP' or 'RLIKE'. Default value is '='
		 */
		protected $meta_compare = '';
		/**
		 * @var array
		 */
		protected $_metaCompareValidValues = array(
			'=',
			'!=',
			'>',
			'>=',
			'<',
			'<=',
			'LIKE',
			'NOT LIKE',
			'IN',
			'NOT IN',
			'BETWEEN',
			'NOT BETWEEN',
			'NOT EXISTS',
			'REGEXP',
			'NOT REGEXP',
			'RLIKE'
		);
		/**
		 * @var bool If set to true a fatal error is triggered
		 * when invalid params are given in any function that sets query params
		 */
		public $_forceValidValues = false;
		protected $_defaults = array();

		public function __construct($instance){
			parent::__construct($instance);
			$customPostTypes = get_post_types( array('_builtin' => false), 'names', 'and' );
			$this->_postTypeValidOptions = array_merge($this->_postTypeValidOptions, (array)$customPostTypes);
			$this->setDefaults();

		}

		protected function setDefaults(){
			foreach ( get_object_vars( $this ) as $k => $v ) {
				if(property_exists(get_parent_class($this), $k) || $k == 'arguments' || $k == 'instance' || preg_match('/^_/', $k)) continue;
				$this->_defaults[$k] = $v;
			}
		}

		public function authorId($id){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->author = $id;
			return $this;
		}

		public function authorName($name){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->author_name = $name;
			return $this;
		}

		public function authorIn($authorIds){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->author__in = array_merge($this->author__in, $authorIds);
			return $this;
		}

		public function authorNotIn($authorIds){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->author__not_in = array_merge($this->author__not_in, $authorIds);
			return $this;
		}

		public function categoryId($id){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->cat = $id;
			return $this;
		}

		public function categoryName($name){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->category_name = $name;
			return $this;
		}

		public function categoriesAnd($categories){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->category__($categories, 'and');
			return $this;
		}

		public function categoriesIn($categories){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->category__($categories, 'in');
			return $this;
		}

		public function categoriesNotIn($categories){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->category__($categories, 'not_in');
			return $this;
		}

		public function category__($categories, $operator){
			$this->query_check_arg_types('array:!empty', 'string:!empty', func_get_args());

			$refers = 'category__' . strtolower((string)$operator);
			if(isset($this->$refers)){
				$this->$refers = (array)$categories;
			}
			return $this;
		}

		public function tag($tagSlug){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->tag = $tagSlug;
			return $this;
		}

		public function tagId($id){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->tag_id = $id;
			return $this;
		}

		public function tagsAnd($tags){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->tag__($tags, 'and');
			return $this;
		}

		public function tagsIn($tags){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->tag__($tags, 'in');
			return $this;
		}

		public function tagsNotIn($tags){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->tag__($tags, 'not_in');
			return $this;
		}

		public function tagsSlugsAnd($tags){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->tag__($tags, 'and', true);
			return $this;
		}

		public function tagsSlugsIn($tags){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->tag__($tags, 'in', true);
			return $this;
		}

		public function tag__($tags, $operator, $slugs = false){
			$this->query_check_arg_types('array:!empty', 'string:!empty', 'boolean', func_get_args());

			$refers = ($slugs ? 'tag__' : 'tag_slug__' ) . strtolower((string)$operator);
			if(isset($this->$refers)){
				$this->$refers = (array)$tags;
			}
			return $this;
		}

		public function postId($id){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->p = $id;
			return $this;
		}

		public function postName($name){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->name = $name;
			return $this;
		}

		public function pageId($id){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->page_id = $id;
			return $this;
		}

		public function pageName($name){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->pagename = $name;
			return $this;
		}

		public function postParent($id){
			$this->query_check_arg_types('integer', func_get_args());
			$this->post_parent= $id;
			return $this;
		}

		public function postParentIn($ids){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->post_parent__in = $ids;
			return $this;
		}

		public function postParentNotIn($ids){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->post_parent__not_in = $ids;
			return $this;
		}

		public function postIn($ids){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->post__in = $ids;
			return $this;
		}

		public function postNotIn($ids){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->post__not_in = $ids;
			return $this;
		}

		public function postType($postType){
			if(is_string($postType)){
				if(in_array($postType, $this->_postTypeValidOptions)){
					$this->post_type = $postType;
				}
			} elseif(is_array($postType)){
				$dif = array_diff($postType, $this->_postTypeValidOptions);
				if(empty($dif)){
					$this->post_type = $postType;
				}
			}
			return $this;
		}

		public function postStatus($status){
			if(is_string($status)){
				if(in_array($status, $this->_postStatusValidOptions)){
					$this->post_status = $status;
				}
			} elseif(is_array($status)){
				$dif = array_diff($status, $this->_postStatusValidOptions);
				if(empty($dif)){
					$this->post_status = $status;
				}
			}
			return $this;
		}

		public function noPaging($bool){
			$this->query_check_arg_types('boolean', func_get_args());
			$this->nopaging = (bool)$bool;
			return $this;
		}

		public function postsPerPage($int){
			$this->query_check_arg_types('integer', func_get_args());
			$this->posts_per_page = (int)$int;
			return $this;
		}

		public function postsPerArchivePage($int){
			$this->query_check_arg_types('integer', func_get_args());
			$this->posts_per_archive_page = (int)$int;
			return $this;
		}

		public function offset($offset){
			$this->query_check_arg_types('integer', func_get_args());
			$this->offset = (int)$offset;
			return $this;
		}

		public function limit( $limit = null ) {
			$this->limit = $limit === null ? $limit : (int) $limit;

			return $this;
		}

		public function paged($paged){
			$this->query_check_arg_types('integer', func_get_args());
			$this->paged = (int)$paged;
			return $this;
		}

		public function page($page){
			$this->query_check_arg_types('integer', func_get_args());
			$this->page = (int)$page;
			return $this;
		}

		public function ignoreStickyPosts($ignore){
			$this->query_check_arg_types('boolean', func_get_args());
			$this->ignore_sticky_posts = (bool)$ignore;
			return $this;
		}

		public function order($order){
			$this->order = $order;
			return $this;
		}

		public function orderBy($order){
			if(is_string($order)){
				if(in_array($order, $this->_orderbyValidOptions)){
					$this->orderby = $order;
				}
			} elseif(is_array($order)){
				$dif = array_diff($order, $this->_orderbyValidOptions);
				if(empty($dif)){
					$this->orderby = $order;
				}
			}
			return $this;
		}

		public function year($year){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->year = (int)$year;
			return $this;
		}

		public function monthNum($monthNum){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->monthnum = (int)$monthNum;
			return $this;
		}

		public function week($week){
			$this->query_check_arg_types('integer', func_get_args());
			$this->w = (int)$week;
			return $this;
		}

		public function hour($hour){
			$this->query_check_arg_types('integer', func_get_args());
			$this->hour = (int)$hour;
			return $this;
		}

		public function minute($minute){
			$this->query_check_arg_types('integer', func_get_args());
			$this->minute = (int)$minute;
			return $this;
		}

		public function second($second){
			$this->query_check_arg_types('integer', func_get_args());
			$this->second = (int)$second;
			return $this;
		}

		public function yearMonth($yearMonth){
			$this->query_check_arg_types('integer:!empty', func_get_args());
			$this->m = (int)$yearMonth;
			return $this;
		}

		public function dateQuery($dateQuery){
			$this->query_check_arg_types('array:!empty', func_get_args());
			$this->date_query = (array)$dateQuery;
			return $this;
		}

		public function metaKey($key){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->meta_key = (string)$key;
			return $this;
		}

		public function metaValue($value){
			$this->query_check_arg_types('string:!empty', func_get_args());
			$this->meta_value = (string)$value;
			return $this;
		}

		public function metaValueNum($value){
			$this->query_check_arg_types('integer', func_get_args());
			$this->meta_value_num = (int)$value;
			return $this;
		}

		public function metaCompare($compare){
			$this->query_check_arg_types('string:!empty', func_get_args());
			if(in_array($compare, $this->_metaCompareValidValues)){
				$this->meta_compare = (string)$compare;
			}
			return $this;
		}

		public function resetQuery(){
			foreach ( $this->_defaults as $k => $v ) {
				$this->$k = $v;
			}
			return $this;
		}

		public function getWpQuery(){
			$this->getArgumentsArray();

			if ( !has_filter('post_limits', array ( $this,  'limitAndOffset' )) ) {
				$this->add_filter( 'post_limits', '©queries.limitAndOffset' );
			}

			$wpQuery = new \WP_Query($this->arguments);

			$this->remove_filter('post_limits', '©queries.limitAndOffset');

			return $wpQuery;
		}

		public function getArgumentsArray(){
			$this->arguments = array();
			foreach ( $this->_defaults as $k => $v ) {
				if($this->$k != $v){
					$this->arguments[$k] = $this->$k;
				}
			}
			return $this->arguments;
		}

		public function sortWPQuery(Array $postIDs, \WP_Query &$query) {
			if ( !isset($query->posts) || empty( $query->posts ) || empty( $postIDs ) ) {
				return new \WP_Error('error', (string)$query . ' is not WP_Query instance or includes no posts', $query);
			}

			usort( $query->posts, function ( $a, $b ) use($postIDs ) {
				$apos = array_search( $a->ID, $postIDs );
				$bpos = array_search( $b->ID, $postIDs );

				return ( $apos < $bpos ) ? -1 : 1;
			} );
			return $query;
		}

		protected function limitAndOffset($limit){
			if ( $this->limit !== null ) {
				$offset = $this->offset > 0 ? $this->offset : 0;
				$limit = $this->limit;
				return 'LIMIT ' . $offset . ', ' . $limit;
			}
			return $limit;
		}

		protected function query_check_arg_types(){
			if($this->_forceValidValues){
				$this->check_arg_types(func_get_args());
			}
		}
	}
}