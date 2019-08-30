数组

在大部分编程语言中，数组都是从 0 开始编号的，但你是否下意识地想过，**为什么数组要从 0 开始编号，而不是从 1 开始呢？**
***从 1 开始不是更符合人类的思维习惯吗？**



数组（Array）是一种线性表数据结构。它用一组连续的内存空间，来存储一组具有相同类型的数据。

抓住关键词

> 第一是**线性表（Linear List）**。

顾名思义，线性表就是数据排成像一条线一样的结构。每个线性表上的数据最多只有前和后两个方向。

其实除了数组，链表、队列、栈等也是线性表结构。


![LINEAR-LIST](./images/linear-list.jpg)


而与它相对立的概念是**非线性表**，比如二叉树、堆、图等。之所以叫**非线性**，是因为，在非线性表中，数据之间并不是简单的前后关系。


![NON-LINEARE-LIST](./images/nonlinear-list.jpg)


> 第二是连续的内存空间和相同类型的数据。

正是因为这两个限制，数组才有了一个堪称“撒手锏”的特性：“随机访问”。

这两个限制也让数组的很多操作变得非常低效，比如要想在数组中删除、插入一个数据，为了保证连续性，就需要做大量的数据搬移工作。


说到数据的访问，那你知道**数组是如何实现根据下标随机访问数组元素的吗？**


拿一个长度为 10 的 int 类型的数组 int[] a = new int[10] 来举列。如下图，计算机给数组 a[10]，分配了一块连续内存空间 1000~1039。
其中，内存块的首地址为 base_address = 1000。


![Array-Exm](array-exm.jpg)

我们知道，计算机会给每个内存单元分配一个地址，计算机通过地址来访问内存中的数据。当计算机需要随机访问数组中的某个元素时，它会首先通过下面的寻址公式，计算出该元素存储的内存地址：


```
a[i]_address = base_address + i * data_type_size 
```

其中 data_type_size 表示数组中每个元素的大小。我们举的这个例子里，数组中存储的是 int 类型数据，所以 data_type_size 就是 4 个字节。


### 纠正一个“错误”

面试时，**常常会问数组和链表的区别。**

> 很多人都会打说，“链表适合插入、删除，时间复杂度O(1)；数组适合查找，查找时间复杂度为 O(1)”

实际上，这种表述是不准确的。数组是适合查找操作，但是查找的时间复杂度并不为 O(1)。
即便是排好序的数组，你用二分查找，时间复杂度也是 O(logn)。所以，正确的表述应该是，数组支持随机访问，根据下标随机访问的时间复杂度为 O(1).


### 低效的“插入”和“删除”

数组为了保持内存数据的连续性，会导致插入、删除操作比较低效。现在就来详细说一下，究竟为什么会导致低效？又有哪些改进方法呢？

### 先来看插入操作

假设数组的长度为 n，现在，我们需要将一个数据插入到数组中的第 k 个位置。

为了把第 k 个位置腾出来，给新来的数据，我们需要将第 k~n 这部分的元素都顺序地往后挪一位。

那插入操作的时间复杂度是多少呢？

如果在数组的末尾插入元素，那就不需要异动数据了，这时的时间复杂度为 O(1)。
但如果在数组的开头插入元素，那所有的数据都需要依次往后异动一位，所以最坏时间复杂度是 O(n)。
因为我们在每个位置插入元素的概率是一样的，所以平均情况时间复杂度为 (1+2+...n)/n = O(n)。


如果数组中的数据是有序的，我们在某个位置插入一个新的元素时，就必须按照刚才的方法搬移 k 之后的数据。
但是，如果数组中存储的数据并没有任何规律，数组只是被当作一个存储数据的集合。
在这种情况下，如果要将某个数组插入到第 k 个位置，为了避免大规模的数据搬移，有一个简单的办法就是，直接将第 k 位的数据搬移到数组元素的最后，把心的元素直接放入第 k 个位置。


为更好地理解，举一个例子。假设数组 a[10] 中存储了如下 5 个元素：a, b, c, d, e。

现在我们需要将元素 x 插入到第 3 个位置。我们只需要将 c 放入到 a[5]，将 a[2] 赋值为 x 即可。

最后，数组中的元素如下图：


![Array-insert-Exm](./images/array-insert-exm.jpg)

利用这种处理技巧，在特定场景下，在第 k 个位置插入一个元素的时间复杂度就会降为 O(1)。

### 再看删除操作


与插入数据类似，如果我们需要删除第 k 个位置的数据，为了内存的连续性，也需要搬移数据，不然中间就会出现空洞，内存就不连续了。

和插入类似，如果删除数组末尾的数据，则最好情况时间复杂度为 O(1)；

如果删除开头的数据，则最坏情况时间复杂度为 O(n)；平均情况时间复杂度也为 O(n)。


在某些特殊场景下，并不一定非得追求数组中数据的连续性。如果将多次删除操作集中在一起执行，删除的效率是不是会提高很多呢？

看例子，数组 a[10] 存储了 8 个元素：a, b, c, d, e, f, g, h。现在，我们要依次删除 a, b, c 三个元素。


![Array-Delete-Exm](./images/array-delete-exm.jpg)

为了避免 d, e, f, g, h 这几个数据会被搬移 3 次，可以先记录下已经删除的数据。每次的删除操作并不是真正地搬移数据，只是记录数据已经被删除。

当数组没有更多空间存储数据时，再触发执行一次真正的删除操作，这样就大大减少了删除操作导致的数据搬移。


JVM 标记清除垃圾回收算法的核心思想。

**很多时候并不是要去死记硬背某个数据结构或者算法，而是要学习它背后的思想和处理技巧。这些东西是最有价值的。**



### 数组访问越界

```
int main(int args, char* argv[]) {
	int i = 0;
	int arr[3] = {0};
	for (; i <= 3; i++) {
		arr[i] = 0;
		printf("hello world\n");
	}
	return 0;
}
```

二维数组的寻址算法：
> arr[m][n]_address = base_address + type_size(hLen*m + n)




https://hackernoon.com/what-does-the-time-complexity-o-log-n-actually-mean-45f94bb5bfbf

The most common attributes of logarithmic running-time function are that:

    the choice of the next element on which to perform some action is one of several possibilities, and
    only one will need to be chosen.

or

    the elements on which the action is performed are digits of n

This is why, for example, looking up people in a phone book is O(log n). You don't need to check every person in the phone book to find the right one; instead, you can simply divide-and-conquer by looking based on where their name is alphabetically, and in every section you only need to explore a subset of each section before you eventually find someone's phone number.

Of course, a bigger phone book will still take you a longer time, but it won't grow as quickly as the proportional increase in the additional size.

We can expand the phone book example to compare other kinds of operations and their running time. We will assume our phone book has businesses (the "Yellow Pages") which have unique names and people (the "White Pages") which may not have unique names. A phone number is assigned to at most one person or business. We will also assume that it takes constant time to flip to a specific page.

Here are the running times of some operations we might perform on the phone book, from best to worst:

    O(1) (best case): Given the page that a business's name is on and the business name, find the phone number.

    O(1) (average case): Given the page that a person's name is on and their name, find the phone number.

    O(log n): Given a person's name, find the phone number by picking a random point about halfway through the part of the book you haven't searched yet, then checking to see whether the person's name is at that point. Then repeat the process about halfway through the part of the book where the person's name lies. (This is a binary search for a person's name.)

    O(n): Find all people whose phone numbers contain the digit "5".

    O(n): Given a phone number, find the person or business with that number.

    O(n log n): There was a mix-up at the printer's office, and our phone book had all its pages inserted in a random order. Fix the ordering so that it's correct by looking at the first name on each page and then putting that page in the appropriate spot in a new, empty phone book.

For the below examples, we're now at the printer's office. Phone books are waiting to be mailed to each resident or business, and there's a sticker on each phone book identifying where it should be mailed to. Every person or business gets one phone book.

    O(n log n): We want to personalize the phone book, so we're going to find each person or business's name in their designated copy, then circle their name in the book and write a short thank-you note for their patronage.

    O(n2): A mistake occurred at the office, and every entry in each of the phone books has an extra "0" at the end of the phone number. Take some white-out and remove each zero.

    O(n · n!): We're ready to load the phonebooks onto the shipping dock. Unfortunately, the robot that was supposed to load the books has gone haywire: it's putting the books onto the truck in a random order! Even worse, it loads all the books onto the truck, then checks to see if they're in the right order, and if not, it unloads them and starts over. (This is the dreaded bogo sort.)

    O(nn): You fix the robot so that it's loading things correctly. The next day, one of your co-workers plays a prank on you and wires the loading dock robot to the automated printing systems. Every time the robot goes to load an original book, the factory printer makes a duplicate run of all the phonebooks! Fortunately, the robot's bug-detection systems are sophisticated enough that the robot doesn't try printing even more copies when it encounters a duplicate book for loading, but it still has to load every original and duplicate book that's been printed.

For more mathematical explanation you can checkout how the time complexity arrives to log n here. https://hackernoon.com/what-does-the-time-complexity-o-log-n-actually-mean-45f94bb5bfbf




