<?php

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

require_once XOOPS_ROOT_PATH . '/class/tree.php';

if (!class_exists('aboutTree')) {
    /**
     * Class aboutTree
     */
    class aboutTree extends XoopsObjectTree
    {
        /**
         * aboutTree constructor.
         * @param array $objectArr
         * @param null  $rootId
         */
        public function __construct(&$objectArr, $rootId = null)
        {
            parent::__construct($objectArr, 'page_id', 'page_pid', $rootId);
        }

        /**
         * @param        $key
         * @param        $ret
         * @param        $prefix_orig
         * @param string $prefix_curr
         * @param null   $tags
         */
        public function _makeTreeItems($key, &$ret, $prefix_orig, $prefix_curr = '', $tags = null)
        {
            if ($key > 0) {
                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $ret[$key][$tag] = $this->_tree[$key]['obj']->getVar($tag);
                    }
                } else {
                    $ret[$key]['page_title'] = $this->_tree[$key]['obj']->getVar('page_title');
                }
                $ret[$key]['prefix'] = $prefix_curr;
                $prefix_curr .= $prefix_orig;
            }
            if (isset($this->_tree[$key]['child']) && !empty($this->_tree[$key]['child'])) {
                foreach ($this->_tree[$key]['child'] as $childkey) {
                    $this->_makeTreeItems($childkey, $ret, $prefix_orig, $prefix_curr, $tags);
                }
            }
        }

        /**
         * @param  string $prefix
         * @param  int    $key
         * @param  null   $tags
         * @return array
         */
        public function &makeTree($prefix = '-', $key = 0, $tags = null)
        {
            $ret = array();
            $this->_makeTreeItems($key, $ret, $prefix, '', $tags);

            return $ret;
        }

        /**
         * @param  string $name
         * @param string  $fieldName
         * @param  string $prefix
         * @param  string $selected
         * @param bool    $addEmptyOption
         * @param  int    $key
         * @param string  $extra
         * @return string
         */
        public function makeSelBox($name, $fieldName, $prefix = '-', $selected = '', $addEmptyOption = false, $key = 0, $extra = '') 
        {
            $ret = '<select name=' . $name . '>';
            if (!empty($addEmptyOption)) {
                $ret .= '<option value="0">' . (is_string($EmptyOption) ? $EmptyOption : '') . '</option>';
            }
            $this->_makeSelBoxOptions('page_title', $selected, $key, $ret, $prefix);
            $ret .= '</select>';

            return $ret;
        }

        /**
         * @param       $key
         * @param       $ret
         * @param array $tags
         * @param int   $depth
         */
        public function getAllChild_array($key, &$ret, $tags = array(), $depth = 0)
        {
            if (--$depth == 0) {
                return;
            }

            if (isset($this->_tree[$key]['child'])) {
                foreach ($this->_tree[$key]['child'] as $childkey) {
                    if (isset($this->_tree[$childkey]['obj'])):
                        if (count($tags) > 0) {
                            foreach ($tags as $tag) {
                                $ret['child'][$childkey][$tag] = $this->_tree[$childkey]['obj']->getVar($tag);
                            }
                        } else {
                            $ret['child'][$childkey]['page_title'] = $this->_tree[$childkey]['obj']->getVar('page_title');
                        }
                    endif;

                    $this->getAllChild_array($childkey, $ret['child'][$childkey], $tags, $depth);
                }
            }
        }

        /**
         * @param  int  $key
         * @param  null $tags
         * @param  int  $depth
         * @return array
         */
        public function &makeArrayTree($key = 0, $tags = null, $depth = 0)
        {
            $ret = array();
            if ($depth > 0) {
                $depth++;
            }
            $this->getAllChild_array($key, $ret, $tags, $depth);

            return $ret;
        }
    }
}
