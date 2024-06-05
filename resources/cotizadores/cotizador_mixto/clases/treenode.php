<?php

    class TreeNode {
        public $value;
        public $children = [];
    
        public function __construct($value) {
            $this->value = $value;
        }
    
        public function addChild(TreeNode $child) {
            $this->children[] = $child;
        }
    }

?>