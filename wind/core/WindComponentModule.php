<?php
Wind::import('WIND:core.WindModule');
/**
 * 框架核心组件基类
 * the last known user to change this file in the repository  <$LastChangedBy: yishuo $>
 * @author Qiong Wu <papa0924@gmail.com>
 * @version $Id: WindComponent.php 809 2010-12-22 11:28:28Z yishuo $
 * @package
 */
abstract class WindComponentModule extends WindModule {
	private $_attribute = array();
	private $_config = null;
	/**
	 * @var WindHttpRequest
	 */
	protected $request;
	/**
	 * @var WindHttpResponse
	 */
	protected $response;
	/**
	 * @var WindSystemConfig
	 */
	protected $windSystemConfig;
	/**
	 * @var WindFactory
	 */
	protected $windFactory;

	/**
	 * Enter description here ...
	 */
	protected function getAutoSetProperty() {
		return array(
			'request' => 'IWindRequest', 
			'response' => 'IWindResponse', 
			'windSystemConfig' => 'WindSystemConfig', 
			'windFactory' => 'WindFactory');
	}

	/**
	 * Enter description here ...
	 */
	public function getAttribute($alias = '') {
		if ($alias === '')
			return $this->_attribute;
		else
			return isset($this->_attribute[$alias]) ? $this->_attribute[$alias] : null;
	}

	/**
	 * @param string $alias
	 * @param object $object
	 */
	public function setAttribute($alias, $object = null) {
		if (is_array($alias))
			$this->_attribute += $alias;
		elseif (is_string($alias))
			$this->_attribute[$alias] = $object;
	}

	/**
	 * 根据配置名取得相应的配置
	 * 
	 * @param string $configName 键名
	 * @param string $subConfigName 二级键名
	 * @param array $default 缺省的数组格式
	 * @return string|array
	 */
	public function getConfig($configName = '', $subConfigName = '', $default = array()) {
		if (null === $this->_config) return '';
		return $this->_config->getConfig($configName, $subConfigName, array(), $default);
	}

	/**
	 * @param string|array|windConfig $config
	 */
	public function setConfig($config) {
		if (is_object($config)) {
			$this->_config = $config;
		} elseif (is_array($config)) {
			$this->_config = new WindConfig($config);
		} elseif (is_string($config)) {
			Wind::import('WIND:core.config.parser.WindConfigParser');
			$configParser = new WindConfigParser();
			$this->_config = new WindConfig($config, $configParser, get_class($this), CONFIG_CACHE);
		}
	}
	
	/**
	 * 更改现有的config 或是合并
	 * @param array $config
	 * @param boolean 是否合并现有
	 * @return true
	 */
	public function updateConfig($config, $merge = false) {
		if (null === $this->_config) return false;
		$this->_config->setConfig($config, $merge);
		return true;
	}
}