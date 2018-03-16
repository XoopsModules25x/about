<?php namespace XoopsModules\About;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

require_once XOOPS_ROOT_PATH . '/class/tree.php';

if (!class_exists('AboutTree')) {
    /**
     * Class AboutTree
     */
    class AboutTree extends \XoopsObjectTree
    {
        /**
         * AboutTree constructor.
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
         * @param null|array   $tags
         */
        public function makeTreeItems($key, &$ret, $prefix_orig, $prefix_curr = '', $tags = null)
        {
            if ($key > 0) {
                if (is_array($tags) && count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $ret[$key][$tag] = $this->tree[$key]['obj']->getVar($tag);
                    }
                } else {
                    $ret[$key]['page_title'] = $this->tree[$key]['obj']->getVar('page_title');
                }
                $ret[$key]['prefix'] = $prefix_curr;
                $prefix_curr         .= $prefix_orig;
            }
            if (isset($this->tree[$key]['child']) && !empty($this->tree[$key]['child'])) {
                foreach ($this->tree[$key]['child'] as $childkey) {
                    $this->makeTreeItems($childkey, $ret, $prefix_orig, $prefix_curr, $tags);
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
            $ret = [];
            $this->makeTreeItems($key, $ret, $prefix, '', $tags);

            return $ret;
        }

        /**
         * @param  string $name
         * @param  string $fieldName
         * @param  string $prefix
         * @param  string $selected
         * @param  bool   $addEmptyOption
         * @param  int    $key
         * @param  string $extra
         * @return string
         */
        public function makeSelBox(
            $name,
            $fieldName,
            $prefix = '-',
            $selected = '',
            $addEmptyOption = false,
            $key = 0,
            $extra = ''
        ) {
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
        public function getAllChildArray($key, &$ret, $tags = [], $depth = 0)
        {
            if (0 == --$depth) {
                return;
            }

            if (isset($this->tree[$key]['child'])) {
                foreach ($this->tree[$key]['child'] as $childkey) {
                    if (isset($this->tree[$childkey]['obj'])):
                        if (is_array($tags) && count($tags) > 0) {
                            foreach ($tags as $tag) {
                                $ret['child'][$childkey][$tag] = $this->tree[$childkey]['obj']->getVar($tag);
                            }
                        } else {
                            $ret['child'][$childkey]['page_title'] = $this->tree[$childkey]['obj']->getVar('page_title');
                        }
                    endif;

                    $this->getAllChildArray($childkey, $ret['child'][$childkey], $tags, $depth);
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
            $ret = [];
            if ($depth > 0) {
                $depth++;
            }
            $this->getAllChildArray($key, $ret, $tags, $depth);

            return $ret;
        }
    }
}
