<?php

/**
 * @Author: Jabin
 * @Date:   2019-06-04
 * @Email:  jpyan2906@gmail.com
 */
include_once "Node.php";

class BinaryTree
{
	public $root;

	public function __construct($root=null)
	{
		$this->root = $root;
	}

	public function add($data)
	{
		$node = new Node($data);
		//若根节点为空，对根节点赋值
		if (is_null($this->root)) {
			$this->root = $node;
			return;
		}
		$queue = [];
		array_push($queue, $this->root);
		//对已有节点进行层次遍历
		while ($queue) {
			//出队
			$cur = array_shift($queue);
			//left child
			if (is_null($cur->lChild)) {
				$cur->lChild = $node;
				return;
			}else{
				array_push($queue, $cur->lChild);
			}
			//right child
			if (is_null($cur->rChild)) {
				$cur->rChild = $node;
				return;
			}else{
				array_push($queue, $cur->rChild);
			}
		}
	}

	/**
	 * 先序遍历
	 * 根节点->左子树->右子树（DLR）
	 */
	public function preOrder($node)
	{
		if (is_null($node)) {
			return;
		}
		echo $node->data."**";
		$this->preOrder($node->lChild);
		$this->preOrder($node->rChild);
	}

	/**
	 * 中序遍历
	 * 左子树->根节点->右子树（LDR）
	 */
	public function inOrder($node)
	{
		if (is_null($node)) {
			return;
		}
		$this->inOrder($node->lChild);
		echo $node->data."**";
		$this->inOrder($node->rChild);
	}

	/**
	 * 后序遍历
	 * 左子树->右子树->根节点（LRD）
	 */
	public function postOrder($node)
	{
		if (is_null($node)) {
			return;
		}
		$this->postOrder($node->lChild);
		$this->postOrder($node->rChild);
		echo $node->data."**";
	}

	/**
	 * 层次遍历
	 * 从根开始，从上到下，从左到右遍历整个树的节点
	 */
	public function breadth($node)
	{
		if (is_null($node)) {
			return;
		}
		$queue = [$node];
		while ($queue) {
			$cur = array_shift($queue);
			echo $cur->data."**";
			if (!is_null($cur->lChild)) {
				array_push($queue, $cur->lChild);
			}
			if (!is_null($cur->rChild)) {
				array_push($queue, $cur->rChild);
			}
		}
	}
}

$tree = new BinaryTree();
$tree->add(0);
$tree->add(1);
$tree->add(2);
$tree->add(3);
$tree->add(4);
$tree->add(5);
echo "preOrder::";
$tree->preOrder($tree->root);
echo "\n";
echo "inOrder::";
$tree->inOrder($tree->root);
echo "\n";
echo "postOrder::";
$tree->postOrder($tree->root);
echo "\n";
echo "breadth::";
$tree->breadth($tree->root);
echo "\n";