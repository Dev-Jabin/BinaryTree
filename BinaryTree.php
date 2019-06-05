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
	 * 先序遍历，非递归方式
	 */
	public function preOrder1($node)
	{
		if (is_null($node)) {
			return;
		}
		$stack = array();
		while (!empty($stack) || !is_null($node)) {
			//遍历打印同时，将节点入栈，后续会使用这个节点进入右子树
			while (!is_null($node)) {
				echo $node->data."**";
				array_push($stack, $node);
				$node = $node->lChild;
			}
			//当node为空时，说明根和左子树遍历完成，进入右子树
			if (!empty($stack)) {
				$node = array_pop($stack);
				$node = $node->rChild;
			}
		}
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
	 * 中序遍历，非递归方式
	 */
	public function inOrder1($node)
	{
		if (is_null($node)) {
			return;
		}
		$stack = array();
		while (!empty($stack) || !is_null($node)) {
			// 一直遍历到左子树最下边，遍历的同时将根节点保存到栈中
			while (!is_null($node)) {
				array_push($stack, $node);
				$node = $node->lChild;
			}
			// 当node为空时，说明已经到达左子树最下边，执行出栈
			if (!empty($stack)) {
				$node = array_pop($stack);
				echo $node->data."**";
				// 左子树和数据节点遍历完毕，进入右子树，开始新一轮左子树遍历
				$node=$node->rChild;
			}
		}
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
	 * 后序遍历，非递归方式
	 */
	public function postOrder1($node)
	{
		// $node:当前访问节点
		// lastVisitNode:上次访问节点
		$lastVistNode=null;
		if (is_null($node)) {
			return;
		}
		$stack = array();
		//先把node移动到左子树最下边
		while (!is_null($node)) {
			array_push($stack, $node);
			$node = $node->lChild;
		}
		//已经走到左子树最底端
		while (!empty($stack)) {
			$node = array_pop($stack);
			//一个根节点被访问有两种情况
			// 1. 无右子树
			// 2. 右子树已经被访问
			if ($node->rChild == null || $node->rChild == $lastVistNode) {
				echo $node->data."**";
				// 访问过一个节点后更新lastVisitNode
				$lastVistNode = $node;
			}else{//此时左子树刚被访问过，下一步需要进入右子树，此时根节点需要再次入栈。因为上一次弹出后，但是因为没有满足条件而根节点没有被访问。
				array_push($stack, $node);
				// 进入右子树，可以确定右子树此时一定不为空
				$node = $node->rChild;
				while ($node) {
					array_push($stack, $node);
					$node = $node->lChild;
				}
			}
		}
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

	/**
	 * 只打印叶子结点
	 */
	public function preLeafNode($node)
	{
		if (is_null($node)) {
			return;
		}
		if ($node->lChild == NULL && $node->rChild == NULL) {
			echo $node->data."**";
		}
		$this->preLeafNode($node->lChild);
		$this->preLeafNode($node->rChild);
	}

	/**
	 * 后序求树的高度
	 */
	public function postTreeHigh($node)
	{
		$lh=$rh=$max=0;
		if (is_null($node)) {
			return 0;
		}
		$lh = $this->postTreeHigh($node->lChild);
		$rh = $this->postTreeHigh($node->rChild);
		$max = max($lh,$rh)+1;
		return $max;
	}

	/**
	 * 节点个数
	 */
	public function treeNodes($node)
	{
		$lc=$rc=$count=0;
		if (is_null($node)) {
			return 0;
		}
		$lc = $this->treeNodes($node->lChild);
		$rc = $this->treeNodes($node->rChild);
		$count = $lc+$rc+1;
		return $count;
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
echo "preOrder1::";
$tree->preOrder1($tree->root);
echo "\n";
echo "inOrder::";
$tree->inOrder($tree->root);
echo "\n";
echo "inOrder1::";
$tree->inOrder1($tree->root);
echo "\n";
echo "postOrder::";
$tree->postOrder($tree->root);
echo "\n";
echo "postOrder1::";
$tree->postOrder1($tree->root);
echo "\n";
echo "breadth::";
$tree->breadth($tree->root);
echo "\n";
echo "print leaf node::";
$tree->preLeafNode($tree->root);
echo "\n";
echo "print tree high::".$tree->postTreeHigh($tree->root);
echo "\n";
echo "print tree count::".$tree->treeNodes($tree->root);
echo "\n";