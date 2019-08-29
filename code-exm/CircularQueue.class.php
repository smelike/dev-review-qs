<?php

	class CircularQueue {
	
		public $queue;
		private $head = 0;
		private $tail = 0;
		public $cap = 0;
		
		public function __construct($capacity)
		{
			$this->queue = new SplFixedArray($capacity);
			$this->cap = $capacity;
		}
		
		// 入队
		public function enqueue ($item) {
			// 队列满了，则不能入
			if (($this->tail + 1) % $this->cap == $this->head) return false;
			$this->queue[$this->tail] = $item;
			$this->tail = ($this->tail + 1) % $this->cap;
			
			return true;
		}
		
		// 出队
		public function dequeue () {
			// 空队列 返回 null
			if ($this->head == $this->tail) return null;
			$ret = $this->queue[$this->head];
			$this->head = ($this->head + 1) % $this->cap;
			return $ret;
		}
	}
	
	$cq = new CircularQueue(5);
	//var_dump($cq->queue);
	//echo $cq->cap;
	//echo $cq->queue->getSize();
	$cq->enqueue(time());
	$cq->enqueue(time());
	$cq->enqueue(time());
	$cq->enqueue(time());
	$cq->enqueue(time());
	$ret = $cq->dequeue();
	$cq->enqueue(time());
	echo date('Y-m-d', $ret);
	echo '<hr/>';
	//$cq->enqueue(time());
	var_dump($cq->queue);

	
