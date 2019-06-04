<?php

/**
 * @Author: Jabin
 * @Date:   2019-06-04
 * @Email:  jpyan2906@gmail.com
 */

class Node
{
	public $data;
	public $lChild;
	public $rChild;

	public function __construct($data = -1, $lChild=null,$rChild=null)
	{
		$this->data = $data;
		$this->lChild = $lChild;
		$this->rChild = $rChild;
	}
}