<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2012 EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 2.0
 * @filesource	
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Memcached Caching Class 
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		ExpressionEngine Dev Team
 * @link		
 */

class CI_Cache_memcached extends CI_Driver {

	private $_memcached;	// Holds the memcached object

	protected $_memcache_conf 	= array(
					'default' => array(
						'default_host'		=> '127.0.0.1',
						'default_port'		=> 11211,
						'default_weight'	=> 1
					)
				);

	public $_default_options;
	// ------------------------------------------------------------------------	

	/**
	 * Fetch from cache
	 *
	 * @param 	mixed		unique key id
	 * @return 	mixed		data on success/false on failure
	 */	
	public function get($id)
	{	
		$data = $this->_memcached->get($id);
		
		return (is_array($data)) ? $data[0] : FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Save
	 *
	 * @param 	string		unique identifier
	 * @param 	mixed		data being cached
	 * @param 	int			time to live
	 * @return 	boolean 	true on success, false on failure
	 */
	public function save($id, $data, $ttl = 60)
	{
		if (get_class($this->_memcached) == 'Memcached')
		{
			return $this->_memcached->set($id, array($data, time(), $ttl), $ttl);
		}
		else if (get_class($this->_memcached) == 'Memcache')
		{
			return $this->_memcached->set($id, array($data, time(), $ttl), 0, $ttl);
		}
		
		return FALSE;
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Delete from Cache
	 *
	 * @param 	mixed		key to be deleted.
	 * @return 	boolean 	true on success, false on failure
	 */
	public function delete($id)
	{
		return $this->_memcached->delete($id);
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Clean the Cache
	 *
	 * @return 	boolean		false on failure/true on success
	 */
	public function clean()
	{
		return $this->_memcached->flush();
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Info
	 *
	 * @param 	null		type not supported in memcached
	 * @return 	mixed 		array on success, false on failure
	 */
	public function cache_info($type = NULL)
	{
		return $this->_memcached->getStats();
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Get Cache Metadata
	 *
	 * @param 	mixed		key to get cache metadata on
	 * @return 	mixed		FALSE on failure, array on success.
	 */
	public function get_metadata($id)
	{
		$stored = $this->_memcached->get($id);

		if (count($stored) !== 3)
		{
			return FALSE;
		}

		list($data, $time, $ttl) = $stored;

		return array(
			'expire'	=> $time + $ttl,
			'mtime'		=> $time,
			'data'		=> $data
		);
	}

	// ------------------------------------------------------------------------

	/**
	 * Setup memcached.
	 */
	private function _setup_memcached()
	{
		// Try to load memcached server info from the config file.
		$CI =& get_instance();
		if ($CI->config->load('memcached', TRUE, TRUE))
		{
			if (is_array($CI->config->config['memcached']))
			{
				$this->_memcache_conf = NULL;

				foreach ($CI->config->config['memcached'] as $name => $conf)
				{
					$this->_memcache_conf[$name] = $conf;
				}				
			}			
		}
		
		//$this->_memcached = new Memcached();

		/******************* ADD BY LP CI不支持memcache扩展，只支持memcahed 扩展，修改成支持memcache  **********/

		if (extension_loaded('memcached')){
			$this->_memcached = new Memcached();
	  }else{
			$this->_memcached = new Memcache(); 
	  }
	  //有bug，以前没有_default_options这个变量
	  $this->_default_options = $this->_memcache_conf['default'];

	  /****************** ADD BY LP END ************/


		foreach ($this->_memcache_conf as $name => $cache_server)
		{
			if ( ! array_key_exists('hostname', $cache_server))
			{
				$cache_server['hostname'] = $this->_default_options['default_host'];
			}
	
			if ( ! array_key_exists('port', $cache_server))
			{
				$cache_server['port'] = $this->_default_options['default_port'];
			}
	
			if ( ! array_key_exists('weight', $cache_server))
			{
				$cache_server['weight'] = $this->_default_options['default_weight'];
			}
	
			// $this->_memcached->addServer(
			// 		$cache_server['hostname'], $cache_server['port'], $cache_server['weight']
			// );

			/******************* ADD BY LP CI不支持memcache扩展，只支持memcahed 扩展，修改成支持memcache  **********/
			if (extension_loaded('memcached')){
	      $this->_memcached->addServer($cache_server['hostname'], $cache_server['port'], $cache_server['weight']);
			}
			else{
				// memcache,如果需要使用memcache，需要在config下面创建memcache.php文件
				// bool Memcache::addServer ( string $host, int $port = 11211, bool $persistent, int $weight, int $timeout )
				// persistent  控制是否使用持久化连接。默认TRUE
				// weight 用来控制此服务器被选中的权重,最好不要改变,对于期望提高某台服务器权重的需求，请使用weight参数
				$this->_memcached->addServer($cache_server['hostname'],$cache_server['port'],TRUE, $cache_server['weight']);
			}

			/****************** ADD BY LP END ************/
		}
	}

	// ------------------------------------------------------------------------


	/**
	 * Is supported
	 *
	 * Returns FALSE if memcached is not supported on the system.
	 * If it is, we setup the memcached object & return TRUE
	 */
	public function is_supported()
	{
		// if ( ! extension_loaded('memcached'))
		// {
		// 	log_message('error', 'The Memcached Extension must be loaded to use Memcached Cache.');
			
		// 	return FALSE;
		// }
		
		/******************* ADD BY LP CI不支持memcache扩展，只支持memcahed 扩展，修改成支持memcache  **********/
		if ( ! extension_loaded('memcached') && ! extension_loaded('memcache') )
		{
			log_message('error', 'The Memcached Extension must be loaded to use Memcached Cache.');
			
			return FALSE;
		}
		/****************** ADD BY LP END ************/
		$this->_setup_memcached();
		return TRUE;
	}

	// ------------------------------------------------------------------------

}
// End Class

/* End of file Cache_memcached.php */
/* Location: ./system/libraries/Cache/drivers/Cache_memcached.php */