CPU 资源是有限，任务的处理速度与线程个数并不是现行正相关。相反，过多的线程反而会导致 CPU 频繁切换，处理性能下降。

所以，线程池的大小一般都是综合考虑要处理任务的特点和硬件环境，来实现设置的。


当我们想固定大小的线程池中请求一个线程时，如果线程是中没有空闲资源了，这时候线程池如何处理这个请求？是拒绝请求还是排队请求？各种处理策略又是怎么实现的呢？


### 如何理解“队列”？

队列这个概念非常好理解。你可以把它想象成排队买票，先来的先买，后来的人只能站末尾，不允许插队。**先进者先出，这就是典型的“队列”。**

![Stack-and-Queue](./images/stack-and-queue.jpg)


栈只支持两个基本操作：入栈**push()** 和 出栈**pop()**。

队列跟栈非常相似，支持的操作也很有限，最基本的操作也是两个：入队 **enqueue()**，放一个数据到队列尾部；出队 **dequeue()**，从队列头部取一个元素。

所以，队列跟栈一样，也是一种操作受限的线性表数据结构。


作为一种非常基础的数据结构，队列的应用也非常广泛，特别一些具有某些额外特性的队列，比如**循环队列、阻塞队列、并发队列。**

比如高性能队列 Disruptor、Linux 环形缓存，都用到了循环并发队列；Java concurrent 并发包利用 ArrayBlockingQueue 来实现公平锁等。


### 顺序队列和链式队列

队列跟栈一样，也是一种抽象的数据结构。它具有先进先出的特性，支持在队尾插入元素，在队头删除元素。

与栈一样，队列可以用数组来实现，也可以用链表来实现。用数组实现的栈叫作顺序栈，用链表实现的栈叫作链式栈。

同样，用数组实现的队列叫作顺序队列，用链表实现的队列叫作链式队列。


基于数组的实现：顺序队列。

```
public class ArrayQueue {
	
	// 数组：items，数组大小：n
	private String[] items;
	private int n = 0;
	
	// head 表示队头下标，tail 表示队尾下标
	private int head = 0;
	private int tail = 0;
	
	// constructor
	public ArrayQueue(int capacity) {
		items = new String[capacity];
		n = capacity;
	}
	
	// enqueue
	public boolean enqueueue(String item) {
		// tail == n replace the queue is fulled
		if (tail == n) return false;
		item[tail] = item;
		++tail;
		return true;
	}
	
	// dequeue
	public boolean dequeue() {
		// head == tail replace the queue is empty
		if (head == tail) return null;
		String ret = items[head];
		++head;
		return ret;
	}
}

```

对于栈来说，只需要一个栈顶指针就可以了。

**但是队列需要两个指针：一个是 head 指针，指向队头；一个是 tail 指针，指向队尾。**


如下图例说明，当 a、b、c、d 依次入列之后，队列中的 head 指针指向下标为 0 的位置，tail 指针指向下标为 4 的位置。


![queue-exm](./images/queue-exm.jpg)


当调用两次出队操作之后，队列中 head 指针指向下标为 2 的位置，tail 指针仍然指向下标为 4 的位置。

![queue-exm](./images/dequeue-exm.jpg)

**随着不停地进行入队、出队操作**，head 和 tail 都会持续往后移动。

当 tail 移动到最右边，即使数组中还有空闲空间，也无法继续往队列中添加数据了。

**这个问题该如何解决呢？（有空闲空间，也无法添加数据了）**


数组的删除操作会导致数组中的数据不连续（指内存空间中的不连续）。如何解决该问题的？**用数据搬移**。

但是，每次进行出队操作都相当于删除数组下标为 0 的数据，加上要搬移整个队列中的数据，这样出队的时间复杂度就会从原来的 O(1) 变为 O(n)。
能不能优化一下呢？

---

实际上，在出队时可以不用搬移数据。如果没有空闲空间了，**只需在入队时，再集中触发一次数据的搬移操作。**

稍微改造一下入队函数**enqueue()** 的实现，解决数组还有空闲空间，却无法添加数据，如果做数据搬移，时间复杂度都会由 O(1) 变为 O(n)。

下面是具体代码：

```

// 入队操作，将item 放入队尾
public boolean enqueue(String item)
{
	// tail = n 表示队尾没有空间了
	// 还不知道队首是否有空间
	if (tail == n) {
		// tail == n && head == 0 表示整个队列都占满了
		if (head == 0) return false;
		// 数据搬移
		for (int i = head; i < tail; ++i) {
			items[i-head] = items[i]
		}
		// 办完之后重新更新 head 和 tail 
		tail -= head;
		head = 0;
	}
	items[tail] = item;
	++tail;
	return true;
}

```

![move-data](./images/data-move.jpg)

这种实现思路中，出队的时间复杂度仍然是 O(1)，但入队操作的时间复杂度还是 O(1)吗？


### 基于链表的队列实现方法（链式队列）

基于链表的实现，同样需要两个指针： head 指针和 tail 指针。

head 指针和 tail 指针，它们分别指向链表的第一个结点和最后一个结点。

如图所示，入队是，tail->next = new_node, tail = tail->next; 出队时，head = head->next。


![base-linked-list-queue](./images/link-list-queue.jpg)

---

### 循环队列

上面用数组实现队列时，在** tail == n **时，会有数据搬移操作，***这样入队操作性能就会受到影响。***
那有没有办法能够避免数据搬移呢？我们来看看循环队列的解决思路。

循环队列，顾名思义，长得像一个环。原本数组是有头有尾的，是一条直线。现在我们把首尾相连，扳成了一个环。你可以直观感受一下，如下图。


![LOOP-QUEUE](./images/loop-queue.jpg)


图中这个队列的大小为 8，当前 head = 4，tail =7。

当有一个新的元素 a 入队时，我们放入下标为 7 的位置。但这时候，并不把 tail 更新为 8 ，而是将其在环中后移一位，到下标为 0 的位置。

当再有一个元素 b 入队时，我们将 b 放入下标为 0 的位置，然后 tail 加 1 更新为 1。所以，在 a, b 依次入队之后，循环队列中的元素就变成了下面的样子：

![LOOP-QUEUE-CHANGED](./images/loop-queue-change.jpg)

通过这样的方法，成功避免了数据搬移操作。看起来不难理解，但循环队列的代码实现难度，要比前面的非循环队列难多了。

要想写出没有 bug 的循环队列的实现代码，要找好关键点。（个人觉得，最关键的是，***确定好队空和队满的判定条件***）


在使用数组实现的非循环队列中，队满的判断条件是 tail == n，队空的判断条件是 head == tail。那针对循环队列，**如何判断队空和队满呢？**


队列为空的判断条件仍然是 head == tail。但队列满的判断条件就稍微有点复杂了。花了一张队列满的图，如下，试着总结一下规律。


![full-loop-queue](./images/full-loop-queue.jpg)


如上图，就是队满的情况，tail = 3, head = 4, n = 8。所以总结一下规律，就是：**(3+1)%8=4**。

多画几张队满的图，你就会发现，当队满时，**(tail+1)%n=head**


经观察发现，当队列满时，图中的 tail 指向的位置实际上没有存储数据的。所以，循环队列会浪费一个数组的存储空间。


### 循环队列代码

```
public class CircularQueue {
	
	// 数组：items，数组大小：n
	private String[] items;
	private int n = 0;
	// head 代表队头下标，tail 代表队尾下标
	private int head = 0;
	private int tail = 0;
	
	public CircularQueue(int capacity)
	{
		items = new String[capacity];
		n = capacity;
	}
	
	// enqueue
	public boolean enqueue(String item) {
		if ((tail+1) % n == head) return false;
		items[tail] = item;
		tail = (tail + 1) % n;
		return true;
	}
	
	// dequeue
	public String dequeue() {
		if (head == tail) return null;
		String ret = items[head];
		head = (head + 1) % n; // 为什么不是 head = (tail + 1) % n
		return ret;
	}
}

```

---

### 阻塞队列和并发队列

队列这种数据结构很基础，平时的业务开发不大可能从零实现一个队列，甚至都不会直接用到。

而一些具有特殊性的队列应用却比较广泛，比如阻塞队列和并发队列。

阻塞队列，其实就是在队列基础上增加了阻塞操作。简单来说，就是在队列为空的时候，从队头取数据会被阻塞。因为此时还没有数据可取，直到队列中有了数据数据才能返回；如果队列已经满了，那么插入数据的操作就会被阻塞，直到队列中有空闲位置后再插入舒，然后再返回。


![Bloking-Queue](./images/blocking-queue.jpg)

上述的定义就是一个“生产者-消费者模型”。是的，我们可以使用阻塞队列，轻松实现一个“生产者-消费者模型”！


这种基于阻塞队列实现的“生产者-消费者模型”，可以有效地协调生产和消费的速度。
当“生产者”生产数据的速度过快，“消费者”来不及消费时，存储数据的队列很快就满了。
这个时候，生产者就阻塞等待，直到“消费者”消费了数据，“生产者”才会被唤醒继续“生产”。


基于阻塞队列，我们可以通过协调“生产者” 和 “消费者”的个数，来提高数据的处理效率。如下图，多配置几个“消费者”，来应对一个“生产者”。

![Producer-Consumer-Model](./images/producer-consumer-model.jpg)


---

在多线程情况下，会有多个线程同时操作队列，这个时候就会存在线程安全问题，那如何实现一个线程安全的队列呢？
（使用锁？）

线程安全的队列，我们叫作并发队列。最简单直接的实现方式是直接在 enqueue()、dequeue() 方法上加锁。

**但是锁粒度大并发度会比较低，同一时刻仅允许一个存或者去操作。**

实际上，基于数组的循环队列，利用 CAS 原子操作，可以实现非常高效的并发队列。这也是循环队列比链式队列应用更佳广泛的原因。


---

### THE-END

线程池没有空闲线程时，新的任务请求线程资源时，线程该如何处理？各种处理策略又是如何实现的呢？

一般有两种处理策略。
第一种是非阻塞的处理方式，直接拒绝任务请求；
另一种是阻塞的处理方式，将请求排队，等到有空闲线程时，取出排队的请求继续处理。那如何存储排队的请求呢？


> [CAS-REFERENCE-INFO]

```

(CAS, Compare And Set)

Wikipedia: https://zh.wikipedia.org/wiki/%E6%AF%94%E8%BE%83%E5%B9%B6%E4%BA%A4%E6%8D%A2

CoolShell: https://coolshell.cn/articles/8239.html

```


